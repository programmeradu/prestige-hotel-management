<?php
/**
 * One-off fixer: backdate the 2026-01-22 20:43 batch and patch missing booking details.
 *
 * Usage: run once from CLI in project root:
 *   php admin033aqbbsn/fix_backdated_batch.php
 *
 * Assumptions:
 * - References listed in $references align with the CSV rows below (same order).
 * - Room numbers from CSV are not important; we map all to a valid product ID ($defaultProductId).
 * - If a booking detail row exists, we update it; otherwise we insert a new one.
 */

define('_PS_ADMIN_DIR_', __DIR__);
require_once _PS_ADMIN_DIR_.'/../config/config.inc.php';
require_once _PS_ADMIN_DIR_.'/init.php';

// Default product to attach bookings to (room mapping not provided)
$defaultProductId = 1;

// References captured from the mistakenly backdated run (in creation order)
$references = [
    'IDLILKAGL', 'LZEXHIBQS', 'JEWKNVTEI', 'ZNXPRIZDJ', 'DGKWIEMLR', 'UCGNXJBNO',
    'JQZOFKQYR', 'LZKYGPBJP', 'MLGKDTEAK', 'AHJXIFVJK', 'PNCPJCYWP', 'SSWMDZANQ',
    'YEOJOHBGR', 'EMFKXVAKM', 'JFYIYMDGX', 'MNGPXFOIC', 'PHYLDVXTI', 'GHNCHADIU',
    'DCMKKZRBZ', 'AXEDJIWYK', 'MQIKFLWJG', 'JJPGXYAAG', 'LYUZXZOZL', 'MQIDKJAQK',
    'AENBQPGGJ', 'HOWHXBNFP', 'KHZWYSJTK', 'MESSWNWKP', 'WRDSJRIED', 'QSHPRNSXZ',
    'PODTAICKI', 'QIRHCAECJ', 'LYCKFCKMC', 'SEDQCLGZX', 'NFWDRGHGV', 'EIKXMWPGC',
    'AEBXXDWNP', 'HSTWOYGTL', 'VBKBEVCUD', 'HCJGHRCHM', 'RXOKNSEDH', 'ZJRHGRAGW',
    'JNQWAEGVG', 'XNXAFNGIY', 'FWTCGRPMN', 'ICQLNOJFF', 'FLNHYVEZS', 'MJOYHPLJD',
    'MMHSNPIIS', 'YTPSWXBOA', 'GHJFIYSVV', 'HXBGELLCE', 'MTBIODYGK', 'PWQUMAOQH',
    'LQKJOEAKY', 'FJPBLTEHO', 'OIKQGIWCJ', 'NHSTZQQEM', 'OGBDHDRDK'
];

// Raw CSV content (new bookings.csv)
$csv = <<<CSV
Name,Contact,Room,Arrival Date,Departure Date,Amount (GHS),Original Month
"Arran Tetteh P.","0545994102","7","10/11/2025","15/11","2000.00","November"
"Obed Agyemang","0549581504","22","11/11/2025","13/11","900.00","November"
"Dr. Desmond","0500021269","17","12/11/2025","14/11","1000.00","November"
"Francis Edu Paku","0501334541","8","12/11/2025","17/11","1000.00","November"
"Dr. Michael Oppong","0551698860","5","12/11/2025","15/11","1450.00","November"
"Karen Abanka","0553587984","28","13/11/2025","15/11","900.00","November"
"Ebenezer","0242263125","2","13/11/2025","15/11","600.00","November"
"Mark Paintsil","0578275524","25","13/11/2025","17/11","500.00","November"
"Rose Adam","0578275524","6","15/11/2025","16/11","500.00","November"
"Isaac Kweku","0553587984","5","15/11/2025","16/11","450.00","November"
"Ebenezer","0246034278","2","19/11/2025","20/11","450.00","November"
"Prosper Pratt","0244805447","2","20/11/2025","22/11","450.00","November"
"Albert Abohius","0586714171","10","20/11/2025","22/11","300.00","November"
"Derleen","0553324292","5","21/11/2025","22/11","500.00","November"
"Richard","0554911215","4","24/11/2025","26/11","1000.00","November"
"Priscilla Osei Bonsu","0554911215","9","24/11/2025","","1000.00","November"
"Nana Yaw","0505097768","2","25/11/2025","26/11","450.00","November"
"Darleen","0586714171","10","26/11/2025","27/11","450.00","November"
"Mr Agyeman","0537453776","10","28/11/2025","29/11","600.00","November"
"Eric Heckman","0542170474","7","28/11/2025","29/11","500.00","November"
"Mr Manukure","02470012383","28","28/11/2025","29/11","500.00","November"
"Mr Sam","0261453373","6","29/11/2025","29/11","500.00","November"
"Ms. Kofi","0261516719","1","01/12/2025","03/12/2025","1800.00","December"
"Derick","0556448952","16","01/12/2025","","350.00","December"
"Godfred","0244455883","13","04/12/2025","05/12/2025","600.00","December"
"Prince Charles","0270377324","10","05/12/2025","07/12/2025","900.00","December"
"Nana Benyin Appiah","0204638755","2","05/12/2025","07/12/2025","500.00","December"
"Antoanette","0537382558","13","06/12/2025","07/12/2025","450.00","December"
"Antoanette","0247037324","10","07/12/2025","08/12/2025","450.00","December"
"Antoanette","0540022250","13","07/12/2025","08/12/2025","500.00","December"
"Kwaku Enoch","0261518719","2","08/12/2025","08/12/2025","300.00","December"
"Kofi Twum","","1","09/12/2025","11/12/2025","600.00","December"
"Banksi Asamoah Jubilee","0547097960","12","10/12/2025","12/12/2025","400.00","December"
"Karen Ofori","0538194865","6","13/12/2025","14/12/2025","500.00","December"
"Kombat Bansom","0539970710","2","14/12/2025","15/12/2025","450.00","December"
"Mooley Ransford","0243579512","4","15/12/2025","16/12/2025","500.00","December"
"Opon Emmanuella","0551445507","10","15/12/2025","16/12/2025","450.00","December"
"Timothy","0243132090","11","16/12/2025","18/12/2025","900.00","December"
"Elizabeth Adwini Bah","0543723336","1","16/12/2025","17/12/2025","450.00","December"
"Lucy Enyonam Tsabe","0247049500","5","16/12/2025","18/12/2025","1000.00","December"
"Akoto","0254763745","14","16/12/2025","17/12/2025","450.00","December"
"Albert Abio","0244805497","21","17/12/2025","18/12/2025","500.00","December"
"Samuel Anoble","0551100725","7","17/12/2025","18/12/2025","450.00","December"
"Dr. Alexander Nuer","0245811175","5","17/12/2025","18/12/2025","500.00","December"
"Adwoa Bowa Ofori","0559848066","7","18/12/2025","21/12/2025","1500.00","December"
"Timothy","0243132090","10","18/12/2025","19/12/2025","450.00","December"
"Albert Abio","0244805497","21","18/12/2025","19/12/2025","450.00","December"
"Opoku Samuel","0547110531","2","19/12/2025","21/12/2025","900.00","December"
"Prof Agyarey","0554025222","16","19/12/2025","20/12/2025","600.00","December"
"Anastasia","0551811540","22","19/12/2025","21/12/2025","900.00","December"
"David Amang","0599546760","28","19/12/2025","20/12/2025","450.00","December"
"Opoku Samuel","0547110531","2","19/12/2025","21/12/2025","900.00","December"
"Asare Q. Kelvin","","11","20/12/2025","21/12/2025","450.00","December"
"Godfred C. Gentsil","0543227949","18","20/12/2025","21/12/2025","600.00","December"
"Frank Mensah","0247254959","17","23/12/2025","24/12/2025","600.00","December"
"Isaac Quansah","0597122121","2","27/12/2025","28/12/2025","450.00","December"
"Lawrence Afrifa","0544909990","4","27/12/2025","29/12/2025","450.00","December"
"Emmanuel Hayford","0551608755","1","27/12/2025","29/12/2025","450.00","December"
"Issah Sofia","0549581504","6","27/12/2025","28/12/2025","500.00","December"
CSV;

function parseCsvRows($csv)
{
    $lines = preg_split('/\r?\n/', trim($csv));
    array_shift($lines); // remove header
    $rows = [];
    foreach ($lines as $line) {
        if ($line === '') continue;
        $cols = str_getcsv($line);
        $rows[] = [
            'name' => $cols[0],
            'contact' => $cols[1],
            'room_raw' => $cols[2],
            'arrival' => $cols[3],
            'departure' => $cols[4],
            'amount' => (float)$cols[5],
            'month' => $cols[6],
        ];
    }
    return $rows;
}

function normalizeDate($d, $fallbackYear)
{
    $d = trim($d);
    if ($d === '') return '';
    $parts = preg_split('#[/-]#', $d);
    if (count($parts) === 2) {
        [$day, $month] = array_map('intval', $parts);
        $year = $fallbackYear;
    } else {
        [$day, $month, $year] = array_map('intval', $parts);
    }
    if ($year < 100) $year += 2000;
    return sprintf('%04d-%02d-%02d', $year, $month, $day);
}

$rows = parseCsvRows($csv);
if (count($rows) !== count($references)) {
    die("Row/reference count mismatch: ".count($rows).' rows vs '.count($references).' refs' . PHP_EOL);
}

$db = Db::getInstance();
$context = Context::getContext();

foreach ($rows as $idx => $row) {
    $ref = $references[$idx];
    $arrival = normalizeDate($row['arrival'], 2025);
    $departure = normalizeDate($row['departure'], (int)substr($arrival, 0, 4));
    if ($departure === '') {
        $departure = $arrival; // same-day if missing
    }
    $orderDate = $arrival . ' 14:00:00';
    $checkoutTime = $departure . ' 12:00:00';
    $totalPaid = $row['amount'];

    $idOrder = (int)$db->getValue('SELECT id_order FROM '._DB_PREFIX_.'orders WHERE reference = "'.pSQL($ref).'"');
    if (!$idOrder) {
        echo "Skip missing order for ref {$ref}\n";
        continue;
    }

    echo "Fixing ref {$ref} (order {$idOrder}) to {$orderDate} -> {$checkoutTime}\n";
    $order = new Order($idOrder);
    $order->date_add = pSQL($orderDate);
    $order->date_upd = pSQL($orderDate);
    $order->total_paid = $totalPaid;
    $order->total_paid_real = $totalPaid;
    $order->total_paid_tax_incl = $totalPaid;
    $order->total_paid_tax_excl = $totalPaid / 1.15;
    $order->total_products = $totalPaid / 1.15;
    $order->total_products_wt = $totalPaid;
    $order->save(false, true);

    // Update cart dates
    if ($order->id_cart) {
        $db->update('cart', [
            'date_add' => pSQL($orderDate),
            'date_upd' => pSQL($orderDate),
        ], 'id_cart='.(int)$order->id_cart);
    }

    // Update order history (latest record)
    $idHistory = (int)$db->getValue('SELECT id_order_history FROM '._DB_PREFIX_.'order_history WHERE id_order='.(int)$idOrder.' ORDER BY id_order_history DESC');
    if ($idHistory) {
        $db->update('order_history', ['date_add' => pSQL($orderDate)], 'id_order_history='.(int)$idHistory);
    }

    // Update payments
    $db->update('order_payment', ['date_add' => pSQL($orderDate)], 'order_reference = "'.pSQL($ref).'"');

    // Compute stay and pricing
    $nights = max(1, (strtotime($departure) - strtotime($arrival)) / 86400);
    $unit = $totalPaid / $nights;

    // Ensure booking detail
    // Db::getRow adds LIMIT 1 automatically; omit explicit LIMIT to avoid double limit syntax
    $roomRow = $db->getRow('SELECT id, id_product, room_num FROM '._DB_PREFIX_.'htl_room_information WHERE id_product='.(int)$defaultProductId);
    $roomId = $roomRow ? (int)$roomRow['id'] : 0;

    $bdExists = (int)$db->getValue('SELECT id FROM '._DB_PREFIX_.'htl_booking_detail WHERE id_order='.(int)$idOrder);
    $bdData = [
        'id_product' => (int)$defaultProductId,
        'id_order' => (int)$idOrder,
        'id_cart' => (int)$order->id_cart,
        'id_room' => $roomId ?: null,
        'id_hotel' => 1,
        'id_customer' => (int)$order->id_customer,
        'booking_type' => 1,
        'id_status' => 2,
        'check_in' => pSQL($orderDate),
        'check_out' => pSQL($checkoutTime),
        'date_from' => pSQL($arrival),
        'date_to' => pSQL($departure),
        'total_price_tax_excl' => $totalPaid / 1.15,
        'total_price_tax_incl' => $totalPaid,
        'total_paid_amount' => $totalPaid,
        'is_back_order' => 0,
        'is_refunded' => 0,
        'date_add' => pSQL($orderDate),
        'date_upd' => pSQL($orderDate),
    ];
    if ($bdExists) {
        $db->update('htl_booking_detail', $bdData, 'id_order='.(int)$idOrder);
    } else {
        $db->insert('htl_booking_detail', $bdData);
    }

    // Update order_detail (single line)
    $productName = $db->getValue('SELECT name FROM '._DB_PREFIX_.'product_lang WHERE id_product='.(int)$defaultProductId.' AND id_lang='.(int)$context->language->id);
    if (!$productName) {
        $productName = 'Room';
    }
    $odExists = (int)$db->getValue('SELECT id_order_detail FROM '._DB_PREFIX_.'order_detail WHERE id_order='.(int)$idOrder);
    $odData = [
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
    if ($odExists) {
        $db->update('order_detail', $odData, 'id_order='.(int)$idOrder);
    } else {
        $odData['id_order'] = (int)$idOrder;
        $db->insert('order_detail', $odData);
    }
}

echo "Done. Review orders and reports.\n";
