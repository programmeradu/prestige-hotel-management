<?php
/**
 * Add extra bookings for duplicate real-world stays that were missing.
 * Run from project root:
 *   php admin033aqbbsn/add_extra_bookings.php
 *
 * This creates new orders (even if a reference already exists). If a reference
 * is already present, a new unique reference will be generated and logged.
 */

define('_PS_ADMIN_DIR_', __DIR__);
require_once _PS_ADMIN_DIR_.'/../config/config.inc.php';
require_once _PS_ADMIN_DIR_.'/init.php';

$context = Context::getContext();
$db = Db::getInstance();
$defaultProductId = 1; // reuse the same room mapping used previously

$entries = [
    [
        'reference' => 'LYUZXZOZL',
        'name' => 'Ms. Kofi',
        'phone' => '0261516719',
        'arrival' => '2025-12-01',
        'departure' => '2025-12-03',
        'amount' => 1800.00,
    ],
    [
        'reference' => 'QIRHCAECJ',
        'name' => 'Kofi Twum',
        'phone' => '',
        'arrival' => '2025-12-09',
        'departure' => '2025-12-11',
        'amount' => 600.00,
    ],
    [
        'reference' => 'SEDQCLGZX',
        'name' => 'Karen Ofori',
        'phone' => '0538194865',
        'arrival' => '2025-12-13',
        'departure' => '2025-12-14',
        'amount' => 500.00,
    ],
    [
        'reference' => 'HSTWOYGTL',
        'name' => 'Timothy',
        'phone' => '0243132090',
        'arrival' => '2025-12-16',
        'departure' => '2025-12-18',
        'amount' => 900.00,
    ],
    [
        'reference' => 'HCJGHRCHM',
        'name' => 'Lucy Enyonam Tsabe',
        'phone' => '0247049500',
        'arrival' => '2025-12-16',
        'departure' => '2025-12-18',
        'amount' => 1000.00,
    ],
    [
        'reference' => 'ICQLNOJFF',
        'name' => 'Timothy',
        'phone' => '0243132090',
        'arrival' => '2025-12-18',
        'departure' => '2025-12-19',
        'amount' => 450.00,
    ],
];

function findOrCreateCustomer($name, $phone, $context)
{
    $name = trim($name);
    $parts = preg_split('/\s+/', $name, 2);
    $firstname = $parts[0] ?: 'Guest';
    $lastname = isset($parts[1]) ? $parts[1] : 'Guest';

    // Try to find by firstname/lastname and phone
    $row = Db::getInstance()->getRow('SELECT c.id_customer FROM '._DB_PREFIX_.'customer c
        LEFT JOIN '._DB_PREFIX_.'address a ON a.id_customer = c.id_customer AND a.deleted = 0
        WHERE c.firstname = "'.pSQL($firstname).'" AND c.lastname = "'.pSQL($lastname).'"'
        .($phone ? ' AND (a.phone = "'.pSQL($phone).'" OR a.phone_mobile = "'.pSQL($phone).'")' : '')
        .' ORDER BY c.id_customer DESC');
    if ($row && !empty($row['id_customer'])) {
        return (int)$row['id_customer'];
    }

    $customer = new Customer();
    $customer->firstname = pSQL($firstname);
    $customer->lastname = pSQL($lastname);
    $customer->email = strtolower(pSQL(str_replace(' ', '', $firstname))).'.'.uniqid().'@guest.prestigehotel.com';
    $customer->passwd = Tools::encrypt(Tools::passwdGen(8));
    $customer->active = 1;
    $customer->is_guest = 1;
    $customer->id_default_group = 1;
    $customer->id_lang = $context->language->id;
    if (!$customer->add()) {
        throw new Exception('Failed to create customer');
    }
    return (int)$customer->id;
}

function ensureAddress($customerId, $firstname, $lastname, $phone)
{
    $db = Db::getInstance();
    $addressId = (int)$db->getValue('SELECT id_address FROM '._DB_PREFIX_.'address WHERE id_customer='.(int)$customerId.' AND deleted=0 ORDER BY id_address DESC');
    if ($addressId) {
        return $addressId;
    }
    $addr = new Address();
    $addr->id_customer = $customerId;
    $addr->id_country = (int)Configuration::get('PS_COUNTRY_DEFAULT');
    $addr->alias = 'Backdated';
    $addr->firstname = pSQL($firstname ?: 'Guest');
    $addr->lastname = pSQL($lastname ?: 'Guest');
    $addr->address1 = 'Backdated booking address';
    $addr->city = 'Accra';
    if ($phone) {
        $addr->phone = pSQL($phone);
        $addr->phone_mobile = pSQL($phone);
    }
    if (!$addr->add()) {
        throw new Exception('Failed to create address');
    }
    return (int)$addr->id;
}

function createBooking($entry, $context, $defaultProductId)
{
    $db = Db::getInstance();
    $db->execute('START TRANSACTION');
    try {
        $nameParts = preg_split('/\s+/', trim($entry['name']), 2);
        $firstname = $nameParts[0] ?: 'Guest';
        $lastname = isset($nameParts[1]) ? $nameParts[1] : 'Guest';
        $phone = $entry['phone'];
        $customerId = findOrCreateCustomer($entry['name'], $phone, $context);
        $addressId = ensureAddress($customerId, $firstname, $lastname, $phone);

        // Cart
        $cart = new Cart();
        $cart->id_customer = $customerId;
        $cart->id_currency = $context->currency->id;
        $cart->id_lang = $context->language->id;
        $cart->id_address_delivery = $addressId;
        $cart->id_address_invoice = $addressId;
        $cart->id_shop = $context->shop->id;
        $cart->id_shop_group = $context->shop->id_shop_group;
        $cart->secure_key = md5(uniqid(rand(), true));
        $cart->date_add = pSQL($entry['arrival'].' 14:00:00');
        $cart->date_upd = pSQL($entry['arrival'].' 14:00:00');
        if (!$cart->add(false)) {
            throw new Exception('Failed to create cart');
        }

        // Order
        $refToUse = $entry['reference'];
        $existing = (int)$db->getValue('SELECT id_order FROM '._DB_PREFIX_.'orders WHERE reference = "'.pSQL($refToUse).'"');
        if ($existing) {
            $refToUse = $entry['reference'].'-D'.substr(md5(uniqid()), 0, 4);
        }
        $totalPaid = (float)$entry['amount'];
        $order = new Order();
        $order->id_customer = $customerId;
        $order->id_cart = $cart->id;
        $order->id_currency = $context->currency->id;
        $order->id_lang = $context->language->id;
        $order->id_shop = $context->shop->id;
        $order->id_shop_group = $context->shop->id_shop_group;
        $order->id_address_delivery = $addressId;
        $order->id_address_invoice = $addressId;
        $order->id_address_tax = $addressId;
        $order->id_carrier = 0;
        $order->current_state = 2;
        $order->payment = 'Cash';
        $order->module = 'ps_cashondelivery';
        $order->total_paid = $totalPaid;
        $order->total_paid_real = $totalPaid;
        $order->total_paid_tax_incl = $totalPaid;
        $order->total_paid_tax_excl = $totalPaid / 1.15;
        $order->total_products = $totalPaid / 1.15;
        $order->total_products_wt = $totalPaid;
        $order->total_shipping = 0;
        $order->total_shipping_tax_incl = 0;
        $order->total_shipping_tax_excl = 0;
        $order->total_discounts = 0;
        $order->total_discounts_tax_incl = 0;
        $order->total_discounts_tax_excl = 0;
        $order->conversion_rate = 1;
        $order->reference = pSQL($refToUse);
        $order->secure_key = $cart->secure_key;
        $order->date_add = pSQL($entry['arrival'].' 14:00:00');
        $order->date_upd = pSQL($entry['arrival'].' 14:00:00');
        $order->valid = 1;
        if (!$order->add(false)) {
            throw new Exception('Failed to create order');
        }

        // History
        $history = new OrderHistory();
        $history->id_order = $order->id;
        $history->id_employee = (int)$context->employee->id;
        $history->id_order_state = 2;
        $history->date_add = pSQL($entry['arrival'].' 14:00:00');
        $history->add(false);

        // Room mapping (use default product id, any room)
        $roomRow = $db->getRow('SELECT id FROM '._DB_PREFIX_.'htl_room_information WHERE id_product='.(int)$defaultProductId);
        $roomId = $roomRow ? (int)$roomRow['id'] : 0;

        $nights = max(1, (strtotime($entry['departure']) - strtotime($entry['arrival'])) / 86400);
        $unit = $totalPaid / $nights;

        $bdData = [
            'id_product' => (int)$defaultProductId,
            'id_order' => (int)$order->id,
            'id_cart' => (int)$cart->id,
            'id_room' => $roomId ?: null,
            'id_hotel' => 1,
            'id_customer' => (int)$order->id_customer,
            'booking_type' => 1,
            'id_status' => 2,
            'check_in' => pSQL($entry['arrival'].' 14:00:00'),
            'check_out' => pSQL($entry['departure'].' 12:00:00'),
            'date_from' => pSQL($entry['arrival']),
            'date_to' => pSQL($entry['departure']),
            'total_price_tax_excl' => $totalPaid / 1.15,
            'total_price_tax_incl' => $totalPaid,
            'total_paid_amount' => $totalPaid,
            'is_back_order' => 0,
            'is_refunded' => 0,
            'date_add' => pSQL($entry['arrival'].' 14:00:00'),
            'date_upd' => pSQL($entry['arrival'].' 14:00:00'),
        ];
        $db->insert('htl_booking_detail', $bdData);

        // Order detail line
        $productName = $db->getValue('SELECT name FROM '._DB_PREFIX_.'product_lang WHERE id_product='.(int)$defaultProductId.' AND id_lang='.(int)$context->language->id);
        if (!$productName) {
            $productName = 'Room';
        }
        $odData = [
            'id_order' => (int)$order->id,
            'id_shop' => (int)$order->id_shop,
            'product_id' => (int)$defaultProductId,
            'product_name' => pSQL($productName),
            'product_quantity' => $nights,
            'product_price' => $unit / 1.15,
            'unit_price_tax_incl' => $unit,
            'unit_price_tax_excl' => $unit / 1.15,
            'total_price_tax_incl' => $totalPaid,
            'total_price_tax_excl' => $totalPaid / 1.15,
            'original_product_price' => $unit / 1.15,
            'tax_rate' => 15,
            'tax_name' => 'VAT 15%',
        ];
        $db->insert('order_detail', $odData);

        $db->execute('COMMIT');
        echo "Created order {$order->reference} for {$entry['name']} ({$entry['arrival']} -> {$entry['departure']})\n";
    } catch (Exception $e) {
        $db->execute('ROLLBACK');
        echo "Failed for {$entry['reference']} - {$entry['name']}: ".$e->getMessage()."\n";
    }
}

foreach ($entries as $entry) {
    createBooking($entry, $context, $defaultProductId);
}

echo "Done. Review the newly created orders.\n";
