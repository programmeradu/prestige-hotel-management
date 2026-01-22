<?php
/**
 * Backdate Bookings Tool - Prestige Hotel
 * Inject offline bookings into the system with backdated dates
 * Generate official tax reports
 */

// Load QloApps configuration
define('_PS_ADMIN_DIR_', dirname(__FILE__));
include(_PS_ADMIN_DIR_.'/../config/config.inc.php');
include(_PS_ADMIN_DIR_.'/init.php');

// Security check - must be logged in as admin
if (!Context::getContext()->employee || !Context::getContext()->employee->id) {
    header('Location: login.php');
    exit;
}

$context = Context::getContext();
$errors = [];
$success = [];
$injectedBookings = [];

// Get existing customers for auto-complete (phone stored on address table in PS 1.6)
$customers = Db::getInstance()->executeS('
    SELECT 
        c.id_customer, 
        c.firstname, 
        c.lastname, 
        c.email, 
        MAX(COALESCE(a.phone_mobile, a.phone)) AS phone
    FROM '._DB_PREFIX_.'customer c 
    LEFT JOIN '._DB_PREFIX_.'address a 
        ON a.id_customer = c.id_customer 
        AND a.deleted = 0
    WHERE c.active = 1 
      AND c.deleted = 0 
    GROUP BY c.id_customer, c.firstname, c.lastname, c.email
    ORDER BY c.lastname, c.firstname 
    LIMIT 500
');

// Get available room types
$roomTypes = Db::getInstance()->executeS('
    SELECT p.id_product, pl.name, p.price 
    FROM '._DB_PREFIX_.'product p 
    JOIN '._DB_PREFIX_.'product_lang pl ON p.id_product = pl.id_product AND pl.id_lang = '.(int)$context->language->id.'
    WHERE p.active = 1 
    ORDER BY pl.name
');

// Get payment methods
$paymentMethods = ['Cash', 'Ghana Mobile Money', 'Bank Transfer', 'Card Payment'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    if ($_POST['action'] === 'inject_bookings') {
        $bookings = json_decode($_POST['bookings_data'], true);
        
        if (!empty($bookings)) {
            foreach ($bookings as $booking) {
                try {
                    $result = injectBooking($booking, $context);
                    if ($result['success']) {
                        $success[] = "Booking created: {$result['reference']} - {$booking['customer_name']}";
                        $injectedBookings[] = $result;
                    } else {
                        $errors[] = "Failed to create booking for {$booking['customer_name']}: {$result['error']}";
                    }
                } catch (Exception $e) {
                    $errors[] = "Error processing {$booking['customer_name']}: " . $e->getMessage();
                }
            }
        }
    }
    
    if ($_POST['action'] === 'generate_report') {
        $month = (int)$_POST['report_month'];
        $year = (int)$_POST['report_year'];
        
        // Fetch bookings for this period
        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = date('Y-m-t', strtotime($startDate));
        
        $reportBookings = Db::getInstance()->executeS('
            SELECT 
                o.id_order,
                o.reference,
                CONCAT(c.firstname, " ", c.lastname) as customer,
                o.total_paid as total,
                o.payment as payment_method,
                o.date_add as order_date,
                hbd.date_from as checkin,
                hbd.date_to as checkout
            FROM '._DB_PREFIX_.'orders o
            JOIN '._DB_PREFIX_.'customer c ON o.id_customer = c.id_customer
            LEFT JOIN '._DB_PREFIX_.'htl_booking_detail hbd ON o.id_order = hbd.id_order
            WHERE o.date_add >= "'.pSQL($startDate).' 00:00:00"
            AND o.date_add <= "'.pSQL($endDate).' 23:59:59"
            AND o.current_state NOT IN (6, 7)
            ORDER BY o.date_add DESC
        ');
        
        // Store for PDF generation
        $_SESSION['report_data'] = [
            'bookings' => $reportBookings,
            'month' => $month,
            'year' => $year,
            'start_date' => $startDate,
            'end_date' => $endDate
        ];
    }
}

/**
 * Inject a booking into the database
 */
function injectBooking($booking, $context) {
    $db = Db::getInstance();
    
    // Start transaction
    $db->execute('START TRANSACTION');
    
    try {
        // 1. Get or create customer
        $customerId = null;
        if (!empty($booking['customer_id'])) {
            $customerId = (int)$booking['customer_id'];
        } else {
            // Create new customer
            $customer = new Customer();
            $customer->firstname = pSQL($booking['firstname']);
            $customer->lastname = pSQL($booking['lastname']);
            $customer->email = !empty($booking['email']) ? pSQL($booking['email']) : strtolower(str_replace(' ', '', $booking['firstname'])) . '.' . time() . '@guest.prestigehotel.com';
            $customer->passwd = Tools::hash(Tools::passwdGen(8));
            $customer->active = 1;
            $customer->is_guest = 1;
            $customer->id_default_group = 1;
            $customer->id_lang = $context->language->id;
            
            if (!$customer->add()) {
                throw new Exception('Failed to create customer');
            }
            $customerId = $customer->id;
            
            // Add phone if provided
            if (!empty($booking['phone'])) {
                $address = new Address();
                $address->id_customer = $customerId;
                $address->id_country = (int)Configuration::get('PS_COUNTRY_DEFAULT');
                $address->alias = 'Default';
                $address->firstname = $customer->firstname;
                $address->lastname = $customer->lastname;
                $address->address1 = 'Guest Address';
                $address->city = 'Accra';
                $address->phone = pSQL($booking['phone']);
                $address->add();
            }
        }
        
        // 2. Create cart
        $cart = new Cart();
        $cart->id_customer = $customerId;
        $cart->id_currency = $context->currency->id;
        $cart->id_lang = $context->language->id;
        $cart->id_address_delivery = 0;
        $cart->id_address_invoice = 0;
        $cart->id_shop = $context->shop->id;
        $cart->id_shop_group = $context->shop->id_shop_group;
        $cart->secure_key = md5(uniqid(rand(), true));
        $cart->date_add = pSQL($booking['order_date']);
        $cart->date_upd = pSQL($booking['order_date']);
        
        if (!$cart->add()) {
            throw new Exception('Failed to create cart');
        }
        
        // 3. Create order
        $reference = Order::generateReference();
        $totalPaid = (float)$booking['total_amount'];
        
        $order = new Order();
        $order->id_customer = $customerId;
        $order->id_cart = $cart->id;
        $order->id_currency = $context->currency->id;
        $order->id_lang = $context->language->id;
        $order->id_shop = $context->shop->id;
        $order->id_shop_group = $context->shop->id_shop_group;
        $order->id_address_delivery = 0;
        $order->id_address_invoice = 0;
        $order->id_carrier = 0;
        $order->current_state = 2; // Payment accepted
        $order->payment = pSQL($booking['payment_method']);
        $order->module = 'ps_cashondelivery';
        $order->total_paid = $totalPaid;
        $order->total_paid_real = $totalPaid;
        $order->total_paid_tax_incl = $totalPaid;
        $order->total_paid_tax_excl = $totalPaid / 1.15; // Remove VAT
        $order->total_products = $totalPaid / 1.15;
        $order->total_products_wt = $totalPaid;
        $order->total_shipping = 0;
        $order->total_shipping_tax_incl = 0;
        $order->total_shipping_tax_excl = 0;
        $order->total_discounts = 0;
        $order->total_discounts_tax_incl = 0;
        $order->total_discounts_tax_excl = 0;
        $order->conversion_rate = 1;
        $order->reference = $reference;
        $order->secure_key = $cart->secure_key;
        $order->date_add = pSQL($booking['order_date']);
        $order->date_upd = pSQL($booking['order_date']);
        $order->valid = 1;
        
        if (!$order->add()) {
            throw new Exception('Failed to create order');
        }
        
        // 4. Create order history
        $history = new OrderHistory();
        $history->id_order = $order->id;
        $history->id_employee = $context->employee->id;
        $history->id_order_state = 2;
        $history->date_add = pSQL($booking['order_date']);
        $history->add();
        
        // 5. Create hotel booking detail
        $roomTypeId = (int)$booking['room_type_id'];
        $checkin = pSQL($booking['checkin_date']);
        $checkout = pSQL($booking['checkout_date']);
        
        // Find an available room
        $room = $db->getRow('
            SELECT hri.id, hri.id_product, hri.room_num 
            FROM '._DB_PREFIX_.'htl_room_information hri
            WHERE hri.id_product = '.$roomTypeId.'
            AND hri.id_status = 1
            LIMIT 1
        ');
        
        if ($room) {
            $db->insert('htl_booking_detail', [
                'id_product' => $roomTypeId,
                'id_order' => $order->id,
                'id_cart' => $cart->id,
                'id_room' => $room['id'],
                'id_hotel' => 1,
                'id_customer' => $customerId,
                'booking_type' => 1,
                'id_status' => 2, // Checked out
                'check_in' => $checkin . ' 14:00:00',
                'check_out' => $checkout . ' 12:00:00',
                'date_from' => $checkin,
                'date_to' => $checkout,
                'total_price_tax_excl' => $totalPaid / 1.15,
                'total_price_tax_incl' => $totalPaid,
                'total_paid_amount' => $totalPaid,
                'is_back_order' => 0,
                'is_refunded' => 0,
                'date_add' => $booking['order_date'],
                'date_upd' => $booking['order_date']
            ]);
        }
        
        // 6. Create order detail (product line)
        $roomTypeName = $db->getValue('
            SELECT name FROM '._DB_PREFIX_.'product_lang 
            WHERE id_product = '.$roomTypeId.' AND id_lang = '.(int)$context->language->id
        );
        
        $nights = max(1, (strtotime($checkout) - strtotime($checkin)) / 86400);
        $unitPrice = $totalPaid / $nights;
        
        $db->insert('order_detail', [
            'id_order' => $order->id,
            'id_shop' => $context->shop->id,
            'product_id' => $roomTypeId,
            'product_name' => pSQL($roomTypeName),
            'product_quantity' => $nights,
            'product_price' => $unitPrice / 1.15,
            'unit_price_tax_incl' => $unitPrice,
            'unit_price_tax_excl' => $unitPrice / 1.15,
            'total_price_tax_incl' => $totalPaid,
            'total_price_tax_excl' => $totalPaid / 1.15,
            'original_product_price' => $unitPrice / 1.15,
            'tax_rate' => 15,
            'tax_name' => 'VAT 15%'
        ]);
        
        // 7. Add payment record
        $db->insert('order_payment', [
            'order_reference' => $reference,
            'id_currency' => $context->currency->id,
            'amount' => $totalPaid,
            'payment_method' => pSQL($booking['payment_method']),
            'date_add' => $booking['order_date']
        ]);
        
        $db->execute('COMMIT');
        
        return [
            'success' => true,
            'reference' => $reference,
            'order_id' => $order->id,
            'customer_id' => $customerId,
            'total' => $totalPaid
        ];
        
    } catch (Exception $e) {
        $db->execute('ROLLBACK');
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backdate Bookings - Prestige Hotel</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
    <style>
        :root {
            --primary: #005a9e;
            --primary-dark: #003d6b;
            --primary-light: #e8f4fc;
            --text-dark: #1a1a2e;
            --text-muted: #666;
            --border: #ddd;
            --bg-light: #f8f9fa;
            --white: #fff;
            --success: #2e7d32;
            --warning: #f57f17;
            --danger: #c62828;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header {
            text-align: center;
            background: var(--primary);
            color: var(--white);
            padding: 25px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
        }
        .header h1 { margin: 0 0 5px 0; font-size: 1.8em; }
        .header p { margin: 0; opacity: 0.9; }
        
        .card {
            background: var(--white);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            border: 1px solid var(--border);
        }
        .card h2 { 
            margin: 0 0 20px 0; 
            color: var(--primary); 
            font-size: 1.3em;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--primary);
        }
        
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid var(--border);
            padding-bottom: 10px;
        }
        .tab-btn {
            padding: 10px 25px;
            border: none;
            background: var(--bg-light);
            color: var(--text-muted);
            cursor: pointer;
            border-radius: 8px 8px 0 0;
            font-weight: 600;
            transition: all 0.2s;
        }
        .tab-btn.active {
            background: var(--primary);
            color: var(--white);
        }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }
        .form-group { margin-bottom: 15px; }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.9em;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
        }
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: var(--primary);
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
        }
        .btn-primary { background: var(--primary); color: var(--white); }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-success { background: var(--success); color: var(--white); }
        .btn-danger { background: var(--danger); color: var(--white); }
        .btn-outline { background: var(--white); color: var(--primary); border: 2px solid var(--primary); }
        
        .booking-list {
            border: 1px solid var(--border);
            border-radius: 8px;
            max-height: 400px;
            overflow-y: auto;
        }
        .booking-item {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .booking-item:last-child { border-bottom: none; }
        .booking-item:hover { background: var(--primary-light); }
        .booking-info strong { color: var(--primary); }
        
        .alert {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        .alert-success { background: #e8f5e9; border: 1px solid var(--success); color: var(--success); }
        .alert-error { background: #ffebee; border: 1px solid var(--danger); color: var(--danger); }
        
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border); }
        th { background: var(--primary); color: var(--white); font-weight: 600; }
        tr:hover { background: var(--primary-light); }
        
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        .stat-box {
            background: var(--primary-light);
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
        .stat-box .value { font-size: 1.5em; font-weight: 700; color: var(--primary); }
        .stat-box .label { color: var(--text-muted); font-size: 0.85em; }
        
        .customer-autocomplete {
            position: relative;
        }
        .autocomplete-list {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 0 0 6px 6px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 100;
            display: none;
        }
        .autocomplete-item {
            padding: 10px 12px;
            cursor: pointer;
            border-bottom: 1px solid var(--border);
        }
        .autocomplete-item:hover { background: var(--primary-light); }
        
        .action-buttons { display: flex; gap: 10px; margin-top: 20px; }
        
        @media (max-width: 768px) {
            .form-row { grid-template-columns: 1fr; }
            .stats-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Prestige Hotel</h1>
            <p>Backdate Bookings & Tax Report Generator</p>
        </div>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error): ?>
                    <div><?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <?php foreach ($success as $msg): ?>
                    <div><?php echo htmlspecialchars($msg); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="tabs">
            <button class="tab-btn active" onclick="showTab('manual')">Manual Entry</button>
            <button class="tab-btn" onclick="showTab('auto')">Auto Generate</button>
            <button class="tab-btn" onclick="showTab('report')">Generate Report</button>
        </div>
        
        <!-- Manual Entry Tab -->
        <div id="tab-manual" class="tab-content active">
            <div class="card">
                <h2>Add Offline Booking</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Target Month</label>
                        <select id="target_month">
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?php echo $m; ?>" <?php echo $m == date('n') ? 'selected' : ''; ?>>
                                    <?php echo date('F', mktime(0, 0, 0, $m, 1)); ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Target Year</label>
                        <select id="target_year">
                            <?php for ($y = date('Y'); $y >= date('Y') - 2; $y--): ?>
                                <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                
                <hr style="border: 0; border-top: 1px solid var(--border); margin: 20px 0;">
                
                <div class="form-row">
                    <div class="form-group customer-autocomplete">
                        <label>Customer Name (or select existing)</label>
                        <input type="text" id="customer_name" placeholder="Start typing to search...">
                        <div class="autocomplete-list" id="customer_list"></div>
                        <input type="hidden" id="customer_id">
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" id="customer_phone" placeholder="e.g., 0241234567">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Room Type</label>
                        <select id="room_type">
                            <?php foreach ($roomTypes as $room): ?>
                                <option value="<?php echo $room['id_product']; ?>" data-price="<?php echo $room['price']; ?>">
                                    <?php echo htmlspecialchars($room['name']); ?> (GHS <?php echo number_format($room['price'], 2); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Payment Method</label>
                        <select id="payment_method">
                            <?php foreach ($paymentMethods as $method): ?>
                                <option value="<?php echo $method; ?>"><?php echo $method; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Check-in Date</label>
                        <input type="date" id="checkin_date">
                    </div>
                    <div class="form-group">
                        <label>Check-out Date</label>
                        <input type="date" id="checkout_date">
                    </div>
                    <div class="form-group">
                        <label>Total Amount (GHS)</label>
                        <input type="number" id="total_amount" step="0.01" placeholder="e.g., 450.00">
                    </div>
                </div>
                
                <button class="btn btn-primary" onclick="addBookingToQueue()">Add to Queue</button>
            </div>
            
            <div class="card">
                <h2>Booking Queue</h2>
                <div class="booking-list" id="booking_queue">
                    <div class="booking-item" style="color: var(--text-muted); justify-content: center;">
                        No bookings in queue. Add bookings above.
                    </div>
                </div>
                
                <div class="stats-row" style="margin-top: 20px;">
                    <div class="stat-box">
                        <div class="value" id="queue_count">0</div>
                        <div class="label">Bookings in Queue</div>
                    </div>
                    <div class="stat-box">
                        <div class="value" id="queue_total">GHS 0.00</div>
                        <div class="label">Total Revenue</div>
                    </div>
                    <div class="stat-box">
                        <div class="value" id="queue_tax">GHS 0.00</div>
                        <div class="label">Est. Total Taxes</div>
                    </div>
                </div>
                
                <div class="action-buttons">
                    <button class="btn btn-success" onclick="injectAllBookings()">Inject All to Database</button>
                    <button class="btn btn-outline" onclick="clearQueue()">Clear Queue</button>
                </div>
            </div>
        </div>
        
        <!-- Auto Generate Tab -->
        <div id="tab-auto" class="tab-content">
            <div class="card">
                <h2>Auto-Generate Backdated Bookings</h2>
                <p style="color: var(--text-muted);">Generate random bookings for a specific month using existing customer data and room types.</p>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Target Month</label>
                        <select id="auto_month">
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?php echo $m; ?>" <?php echo $m == 12 ? 'selected' : ''; ?>>
                                    <?php echo date('F', mktime(0, 0, 0, $m, 1)); ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Target Year</label>
                        <select id="auto_year">
                            <?php for ($y = date('Y'); $y >= date('Y') - 2; $y--): ?>
                                <option value="<?php echo $y; ?>" <?php echo $y == 2025 ? 'selected' : ''; ?>><?php echo $y; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Number of Bookings to Generate</label>
                        <input type="number" id="auto_count" value="10" min="1" max="50">
                    </div>
                    <div class="form-group">
                        <label>Min Amount (GHS)</label>
                        <input type="number" id="auto_min" value="300" step="50">
                    </div>
                    <div class="form-group">
                        <label>Max Amount (GHS)</label>
                        <input type="number" id="auto_max" value="2000" step="50">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Primary Payment Method</label>
                    <select id="auto_payment">
                        <?php foreach ($paymentMethods as $method): ?>
                            <option value="<?php echo $method; ?>"><?php echo $method; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <button class="btn btn-primary" onclick="autoGenerateBookings()">Generate Bookings</button>
            </div>
        </div>
        
        <!-- Generate Report Tab -->
        <div id="tab-report" class="tab-content">
            <div class="card">
                <h2>Generate Official Tax Report</h2>
                
                <form method="post">
                    <input type="hidden" name="action" value="generate_report">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Report Month</label>
                            <select name="report_month" id="report_month">
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?php echo $m; ?>"><?php echo date('F', mktime(0, 0, 0, $m, 1)); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Report Year</label>
                            <select name="report_year" id="report_year">
                                <?php for ($y = date('Y'); $y >= date('Y') - 3; $y--): ?>
                                    <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Load Report Data</button>
                </form>
                
                <?php if (isset($_SESSION['report_data']) && !empty($_SESSION['report_data']['bookings'])): ?>
                    <?php 
                    $reportData = $_SESSION['report_data'];
                    $totalRevenue = array_sum(array_column($reportData['bookings'], 'total'));
                    $taxableRevenue = $totalRevenue * (100 / 115);
                    $vat = $taxableRevenue * 0.15;
                    $baseForLevies = $taxableRevenue / 1.06;
                    $nhil = $baseForLevies * 0.025;
                    $getFund = $baseForLevies * 0.025;
                    $covidLevy = $baseForLevies * 0.01;
                    $totalTaxes = $vat + $nhil + $getFund + $covidLevy;
                    ?>
                    
                    <hr style="margin: 25px 0; border: 0; border-top: 1px solid var(--border);">
                    
                    <h3 style="color: var(--primary);">
                        Report: <?php echo date('F', mktime(0, 0, 0, $reportData['month'], 1)) . ' ' . $reportData['year']; ?>
                    </h3>
                    
                    <div class="stats-row">
                        <div class="stat-box">
                            <div class="value"><?php echo count($reportData['bookings']); ?></div>
                            <div class="label">Total Bookings</div>
                        </div>
                        <div class="stat-box">
                            <div class="value">GHS <?php echo number_format($totalRevenue, 2); ?></div>
                            <div class="label">Total Revenue</div>
                        </div>
                        <div class="stat-box">
                            <div class="value">GHS <?php echo number_format($totalTaxes, 2); ?></div>
                            <div class="label">Total Taxes & Levies</div>
                        </div>
                    </div>
                    
                    <div style="max-height: 300px; overflow-y: auto; border: 1px solid var(--border); border-radius: 8px;">
                        <table>
                            <thead>
                                <tr>
                                    <th>Reference</th>
                                    <th>Customer</th>
                                    <th>Check-in</th>
                                    <th>Payment</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reportData['bookings'] as $booking): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($booking['reference']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['customer']); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($booking['checkin'] ?? $booking['order_date'])); ?></td>
                                        <td><?php echo htmlspecialchars($booking['payment_method']); ?></td>
                                        <td>GHS <?php echo number_format($booking['total'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="action-buttons">
                        <button class="btn btn-primary" onclick="downloadReportPDF()">Download PDF Report</button>
                    </div>
                    
                    <script>
                        const reportBookings = <?php echo json_encode($reportData['bookings']); ?>;
                        const reportMonth = <?php echo $reportData['month']; ?>;
                        const reportYear = <?php echo $reportData['year']; ?>;
                    </script>
                <?php endif; ?>
            </div>
        </div>
    </div>

<script>
// Customer data from PHP
const customers = <?php echo json_encode($customers); ?>;
const roomTypes = <?php echo json_encode($roomTypes); ?>;

// Booking queue
let bookingQueue = [];

// Tab switching
function showTab(tabName) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
    
    document.querySelector(`[onclick="showTab('${tabName}')"]`).classList.add('active');
    document.getElementById(`tab-${tabName}`).classList.add('active');
}

// Customer autocomplete
const customerInput = document.getElementById('customer_name');
const customerList = document.getElementById('customer_list');
const customerIdInput = document.getElementById('customer_id');

customerInput.addEventListener('input', function() {
    const query = this.value.toLowerCase();
    customerIdInput.value = '';
    
    if (query.length < 2) {
        customerList.style.display = 'none';
        return;
    }
    
    const matches = customers.filter(c => 
        (c.firstname + ' ' + c.lastname).toLowerCase().includes(query) ||
        (c.email && c.email.toLowerCase().includes(query))
    ).slice(0, 10);
    
    if (matches.length > 0) {
        customerList.innerHTML = matches.map(c => `
            <div class="autocomplete-item" onclick="selectCustomer(${c.id_customer}, '${c.firstname} ${c.lastname}', '${c.phone || ''}')">
                <strong>${c.firstname} ${c.lastname}</strong><br>
                <small>${c.email || 'No email'} | ${c.phone || 'No phone'}</small>
            </div>
        `).join('');
        customerList.style.display = 'block';
    } else {
        customerList.style.display = 'none';
    }
});

function selectCustomer(id, name, phone) {
    customerInput.value = name;
    customerIdInput.value = id;
    document.getElementById('customer_phone').value = phone;
    customerList.style.display = 'none';
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.customer-autocomplete')) {
        customerList.style.display = 'none';
    }
});

// Set default dates based on selected month
function updateDatesForMonth() {
    const month = document.getElementById('target_month').value;
    const year = document.getElementById('target_year').value;
    const daysInMonth = new Date(year, month, 0).getDate();
    
    // Random day in month for check-in
    const day = Math.floor(Math.random() * (daysInMonth - 3)) + 1;
    const checkin = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    const checkout = `${year}-${String(month).padStart(2, '0')}-${String(Math.min(day + 1 + Math.floor(Math.random() * 3), daysInMonth)).padStart(2, '0')}`;
    
    document.getElementById('checkin_date').value = checkin;
    document.getElementById('checkout_date').value = checkout;
}

document.getElementById('target_month').addEventListener('change', updateDatesForMonth);
document.getElementById('target_year').addEventListener('change', updateDatesForMonth);

// Add booking to queue
function addBookingToQueue() {
    const customerName = document.getElementById('customer_name').value.trim();
    const customerId = document.getElementById('customer_id').value;
    const phone = document.getElementById('customer_phone').value.trim();
    const roomType = document.getElementById('room_type');
    const roomTypeName = roomType.options[roomType.selectedIndex].text;
    const payment = document.getElementById('payment_method').value;
    const checkin = document.getElementById('checkin_date').value;
    const checkout = document.getElementById('checkout_date').value;
    const total = parseFloat(document.getElementById('total_amount').value) || 0;
    
    if (!customerName) {
        alert('Please enter customer name');
        return;
    }
    if (!checkin || !checkout) {
        alert('Please select check-in and check-out dates');
        return;
    }
    if (total <= 0) {
        alert('Please enter a valid amount');
        return;
    }
    
    // Parse name into first/last
    const nameParts = customerName.split(' ');
    const firstname = nameParts[0] || 'Guest';
    const lastname = nameParts.slice(1).join(' ') || 'Guest';
    
    const booking = {
        customer_id: customerId,
        customer_name: customerName,
        firstname: firstname,
        lastname: lastname,
        phone: phone,
        room_type_id: roomType.value,
        room_type_name: roomTypeName,
        payment_method: payment,
        checkin_date: checkin,
        checkout_date: checkout,
        total_amount: total,
        order_date: checkin + ' 14:00:00'
    };
    
    bookingQueue.push(booking);
    renderQueue();
    
    // Clear form
    document.getElementById('customer_name').value = '';
    document.getElementById('customer_id').value = '';
    document.getElementById('customer_phone').value = '';
    document.getElementById('total_amount').value = '';
    updateDatesForMonth();
}

function renderQueue() {
    const container = document.getElementById('booking_queue');
    
    if (bookingQueue.length === 0) {
        container.innerHTML = '<div class="booking-item" style="color: var(--text-muted); justify-content: center;">No bookings in queue. Add bookings above.</div>';
    } else {
        container.innerHTML = bookingQueue.map((b, i) => `
            <div class="booking-item">
                <div class="booking-info">
                    <strong>${b.customer_name}</strong> - ${b.room_type_name}<br>
                    <small>${b.checkin_date} to ${b.checkout_date} | ${b.payment_method} | GHS ${b.total_amount.toFixed(2)}</small>
                </div>
                <button class="btn btn-danger" onclick="removeFromQueue(${i})" style="padding: 5px 10px;">×</button>
            </div>
        `).join('');
    }
    
    // Update stats
    const total = bookingQueue.reduce((s, b) => s + b.total_amount, 0);
    const taxable = total * (100 / 115);
    const vat = taxable * 0.15;
    const levyBase = taxable / 1.06;
    const taxes = vat + (levyBase * 0.06);
    
    document.getElementById('queue_count').textContent = bookingQueue.length;
    document.getElementById('queue_total').textContent = 'GHS ' + total.toFixed(2);
    document.getElementById('queue_tax').textContent = 'GHS ' + taxes.toFixed(2);
}

function removeFromQueue(index) {
    bookingQueue.splice(index, 1);
    renderQueue();
}

function clearQueue() {
    if (confirm('Clear all bookings from queue?')) {
        bookingQueue = [];
        renderQueue();
    }
}

// Inject all bookings
function injectAllBookings() {
    if (bookingQueue.length === 0) {
        alert('No bookings in queue');
        return;
    }
    
    if (!confirm(`Inject ${bookingQueue.length} bookings into the database? This cannot be undone.`)) {
        return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.innerHTML = `
        <input type="hidden" name="action" value="inject_bookings">
        <input type="hidden" name="bookings_data" value='${JSON.stringify(bookingQueue)}'>
    `;
    document.body.appendChild(form);
    form.submit();
}

// Auto-generate bookings
function autoGenerateBookings() {
    const month = parseInt(document.getElementById('auto_month').value);
    const year = parseInt(document.getElementById('auto_year').value);
    const count = parseInt(document.getElementById('auto_count').value);
    const minAmount = parseFloat(document.getElementById('auto_min').value);
    const maxAmount = parseFloat(document.getElementById('auto_max').value);
    const payment = document.getElementById('auto_payment').value;
    
    const daysInMonth = new Date(year, month, 0).getDate();
    
    // Sample Ghanaian names if no customers exist
    const sampleNames = [
        'Kwame Asante', 'Ama Mensah', 'Kofi Owusu', 'Akua Boateng', 'Yaw Adjei',
        'Abena Darko', 'Kwesi Amponsah', 'Adwoa Frimpong', 'Kojo Tetteh', 'Afua Sarpong',
        'Kwabena Osei', 'Efua Antwi', 'Fiifi Agyeman', 'Esi Quansah', 'Papa Nkrumah'
    ];
    
    for (let i = 0; i < count; i++) {
        // Random customer
        let customerName, customerId = '', phone = '';
        if (customers.length > 0 && Math.random() > 0.3) {
            const c = customers[Math.floor(Math.random() * customers.length)];
            customerName = c.firstname + ' ' + c.lastname;
            customerId = c.id_customer;
            phone = c.phone || '';
        } else {
            customerName = sampleNames[Math.floor(Math.random() * sampleNames.length)];
            phone = '024' + Math.floor(1000000 + Math.random() * 9000000);
        }
        
        // Random dates in month
        const checkinDay = Math.floor(Math.random() * (daysInMonth - 3)) + 1;
        const nights = Math.floor(Math.random() * 4) + 1;
        const checkoutDay = Math.min(checkinDay + nights, daysInMonth);
        
        const checkin = `${year}-${String(month).padStart(2, '0')}-${String(checkinDay).padStart(2, '0')}`;
        const checkout = `${year}-${String(month).padStart(2, '0')}-${String(checkoutDay).padStart(2, '0')}`;
        
        // Random room type
        const room = roomTypes[Math.floor(Math.random() * roomTypes.length)];
        
        // Random amount in range
        const amount = Math.round((minAmount + Math.random() * (maxAmount - minAmount)) / 50) * 50;
        
        // Parse name
        const nameParts = customerName.split(' ');
        
        bookingQueue.push({
            customer_id: customerId,
            customer_name: customerName,
            firstname: nameParts[0],
            lastname: nameParts.slice(1).join(' ') || 'Guest',
            phone: phone,
            room_type_id: room.id_product,
            room_type_name: room.name,
            payment_method: payment,
            checkin_date: checkin,
            checkout_date: checkout,
            total_amount: amount,
            order_date: checkin + ' 14:00:00'
        });
    }
    
    renderQueue();
    showTab('manual'); // Switch to manual tab to see queue
    alert(`Generated ${count} bookings. Review them in the queue before injecting.`);
}

// Download PDF Report
function downloadReportPDF() {
    if (typeof reportBookings === 'undefined' || reportBookings.length === 0) {
        alert('No report data available');
        return;
    }
    
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    const totalRevenue = reportBookings.reduce((s, b) => s + parseFloat(b.total), 0);
    const formatCurrency = (num) => `GHS ${parseFloat(num).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    const monthName = new Date(reportYear, reportMonth - 1).toLocaleString('en-US', { month: 'long' });
    
    // Header
    doc.setFontSize(22);
    doc.setFont("helvetica", "bold");
    doc.setTextColor('#005a9e');
    doc.text("Prestige Hotel", 105, 20, { align: 'center' });
    doc.setFontSize(14);
    doc.setFont("helvetica", "normal");
    doc.setTextColor('#333333');
    doc.text("Official Tax & Revenue Report", 105, 28, { align: 'center' });
    
    // Summary
    const kpiY = 40;
    doc.setFontSize(12);
    doc.setFont("helvetica", "bold");
    doc.setTextColor('#000000');
    doc.text("Summary", 14, kpiY);
    doc.setLineWidth(0.5);
    doc.line(14, kpiY + 2, 196, kpiY + 2);
    
    doc.setFontSize(11);
    doc.setFont("helvetica", "normal");
    doc.text(`Total Bookings: ${reportBookings.length}`, 14, kpiY + 10);
    doc.text(`Total Revenue: ${formatCurrency(totalRevenue)}`, 14, kpiY + 17);
    
    // Tax Breakdown
    const taxY = kpiY + 27;
    const taxableRevenue = totalRevenue * (100 / 115);
    const vat = taxableRevenue * 0.15;
    const baseForLevies = taxableRevenue / 1.06;
    const nhil = baseForLevies * 0.025;
    const getFund = baseForLevies * 0.025;
    const covidLevy = baseForLevies * 0.01;
    const totalTaxes = vat + nhil + getFund + covidLevy;
    
    doc.setFontSize(12);
    doc.setFont("helvetica", "bold");
    doc.text("Tax & Levy Breakdown", 14, taxY);
    doc.line(14, taxY + 2, 196, taxY + 2);
    
    let currentY = taxY + 10;
    doc.setFontSize(11);
    doc.setFont("helvetica", "normal");
    
    const addRow = (label, value, bold = false) => {
        if (bold) doc.setFont("helvetica", "bold");
        doc.text(label, 14, currentY);
        doc.text(value, 120, currentY);
        if (bold) doc.setFont("helvetica", "normal");
        currentY += 7;
    };
    
    addRow('Taxable Revenue:', formatCurrency(taxableRevenue));
    addRow('VAT (15%):', formatCurrency(vat));
    addRow('NHIL (2.5%):', formatCurrency(nhil));
    addRow('GetFund (2.5%):', formatCurrency(getFund));
    addRow('Covid Levy (1%):', formatCurrency(covidLevy));
    currentY += 2;
    addRow('Total Taxes & Levies:', formatCurrency(totalTaxes), true);
    
    // Table
    currentY += 8;
    const head = [['Reference', 'Customer', 'Rooms', 'Stay Period', 'Total Amount', 'Payment Method', 'Order Date']];
    const body = reportBookings.map(b => [
        b.reference,
        b.customer,
        '1',
        b.checkin ? b.checkin.substring(0, 10) : 'N/A',
        formatCurrency(b.total),
        b.payment_method || 'N/A',
        b.order_date ? b.order_date.substring(0, 10) : 'N/A'
    ]);
    
    doc.autoTable({
        startY: currentY,
        head: head,
        body: body,
        theme: 'grid',
        headStyles: {
            fillColor: [0, 90, 158],
            textColor: 255,
            fontStyle: 'bold',
            fontSize: 8
        },
        styles: { fontSize: 8, cellPadding: 3 }
    });
    
    doc.save(`Tax_Report_${monthName}_${reportYear}.pdf`);
}

// Initialize
updateDatesForMonth();
</script>
</body>
</html>
