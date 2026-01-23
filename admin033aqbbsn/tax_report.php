<?php
/**
 * Monthly Revenue & Tax Report (Server-side)
 * Pulls bookings by check-in date for a selected month/year and computes taxes.
 *
 * Place in admin folder and access via browser when logged in as admin.
 */

define('_PS_ADMIN_DIR_', __DIR__);
require_once _PS_ADMIN_DIR_.'/../config/config.inc.php';
require_once _PS_ADMIN_DIR_.'/init.php';

// Require admin login
if (!Context::getContext()->employee || !Context::getContext()->employee->id) {
    header('Location: login.php');
    exit;
}

$context = Context::getContext();
$errors = [];

// Inputs
$month = isset($_REQUEST['month']) ? (int)$_REQUEST['month'] : (int)date('n');
$year = isset($_REQUEST['year']) ? (int)$_REQUEST['year'] : (int)date('Y');
$export = isset($_GET['export']) && $_GET['export'] === 'csv';
$targetAmount = isset($_REQUEST['target_amount']) ? (float)$_REQUEST['target_amount'] : 0.0;

// Date range based on check-in (date_from)
$startDate = sprintf('%04d-%02d-01', $year, $month);
$endDate = date('Y-m-t', strtotime($startDate));

// Fetch bookings using check-in date
$sql = '
    SELECT 
        o.id_order,
        o.reference,
        CONCAT(c.firstname, " ", c.lastname) AS customer,
        o.total_paid AS total,
        o.payment AS payment_method,
        o.current_state,
        hbd.date_from AS checkin,
        hbd.date_to AS checkout,
        o.date_add AS order_date
    FROM '._DB_PREFIX_.'orders o
    INNER JOIN '._DB_PREFIX_.'customer c ON o.id_customer = c.id_customer
    INNER JOIN '._DB_PREFIX_.'htl_booking_detail hbd ON o.id_order = hbd.id_order
    WHERE hbd.date_from >= "'.pSQL($startDate).'" 
      AND hbd.date_from <= "'.pSQL($endDate).'" 
      AND o.current_state NOT IN (6,7)
    ORDER BY hbd.date_from ASC, o.id_order ASC';

$rows = Db::getInstance()->executeS($sql);
$bookings = $rows ?: [];

// Sort by check-in date, then reference
usort($bookings, function($a, $b) {
    $ad = strtotime($a['checkin'] ?? '');
    $bd = strtotime($b['checkin'] ?? '');
    if ($ad === $bd) {
        return strcmp($a['reference'], $b['reference']);
    }
    return $ad <=> $bd;
});

// If a target amount is provided, keep only bookings that build up toward the target
if ($targetAmount > 0 && !empty($bookings)) {
    $selected = [];
    $running = 0.0;
    foreach ($bookings as $b) {
        if ($running >= $targetAmount) {
            break;
        }
        $selected[] = $b;
        $running += (float)$b['total'];
    }
    $bookings = $selected;
}

// Totals
$totalRevenue = 0.0;
foreach ($bookings as $row) {
    $totalRevenue += (float)$row['total'];
}
$taxableRevenue = $totalRevenue * (100 / 115);
$vat = $taxableRevenue * 0.15;
$baseForLevies = $taxableRevenue / 1.06;
$nhil = $baseForLevies * 0.025;
$getFund = $baseForLevies * 0.025;
$covidLevy = $baseForLevies * 0.01;
$totalTaxes = $vat + $nhil + $getFund + $covidLevy;
$variance = 0.0; // Variance no longer shown in report
$displayRevenue = $targetAmount > 0 ? $targetAmount : $totalRevenue;

if ($export) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="tax_report_'.$year.'_'.$month.'.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['Reference','Customer','Check-in','Check-out','Payment','Amount']);
    foreach ($bookings as $b) {
        fputcsv($out, [
            $b['reference'],
            $b['customer'],
            $b['checkin'],
            $b['checkout'],
            $b['payment_method'],
            number_format((float)$b['total'], 2, '.', '')
        ]);
    }
    fputcsv($out, ['', '', '', '', 'TOTAL', number_format($totalRevenue, 2, '.', '')]);
    fclose($out);
    exit;
}

function h($str) { return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); }
function moneyGhs($num) { return 'GHS '.number_format((float)$num, 2); }
function dateOnly($dt) { return $dt ? substr($dt, 0, 10) : ''; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Tax Report - Prestige Hotel</title>
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
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            margin: 0;
            padding: 20px;
        }
        .container { max-width: 1100px; margin: 0 auto; }
        .header {
            text-align: center;
            background: var(--primary);
            color: var(--white);
            padding: 24px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
        }
        .header h1 { margin: 0 0 6px 0; font-size: 1.8em; }
        .card {
            background: var(--white);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .card h2 {
            margin: 0 0 14px 0;
            color: var(--primary);
            font-size: 1.2em;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary);
        }
        label { display: block; margin-bottom: 6px; font-weight: 600; color: var(--text-dark); }
        select, button {
            padding: 10px 12px;
            border: 2px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
        }
        button { background: var(--primary); color: var(--white); cursor: pointer; border: none; }
        button:hover { background: var(--primary-dark); }
        .form-row { display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap; }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            margin-top: 10px;
        }
        .stat-box { background: var(--primary-light); padding: 14px; border-radius: 8px; border: 1px solid rgba(0,90,158,0.15); }
        .stat-title { color: var(--text-muted); font-size: 0.9em; margin-bottom: 4px; }
        .stat-value { color: var(--primary); font-size: 1.4em; font-weight: 700; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px 10px; border-bottom: 1px solid var(--border); text-align: left; white-space: nowrap; }
        th { background: var(--primary); color: var(--white); font-weight: 600; }
        tr:hover { background: var(--primary-light); }
        .amount { font-family: 'Courier New', monospace; font-weight: 600; }
        .actions { display: flex; gap: 10px; margin-top: 10px; flex-wrap: wrap; }
        .secondary { background: var(--white); color: var(--primary); border: 2px solid var(--primary); }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Prestige Hotel</h1>
        <p>Monthly Revenue & Tax Report (by Check-in Date)</p>
    </div>

    <div class="card">
        <h2>Select Period</h2>
        <form method="get" class="form-row">
            <div>
                <label for="month">Month</label>
                <select name="month" id="month">
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?php echo $m; ?>" <?php echo $m == $month ? 'selected' : ''; ?>>
                            <?php echo date('F', mktime(0,0,0,$m,1)); ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div>
                <label for="year">Year</label>
                <select name="year" id="year">
                    <?php for ($y = date('Y'); $y >= date('Y') - 4; $y--): ?>
                        <option value="<?php echo $y; ?>" <?php echo $y == $year ? 'selected' : ''; ?>><?php echo $y; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div>
                <label for="target_amount">Target Amount (GHS)</label>
                <input type="number" step="0.01" name="target_amount" id="target_amount" value="<?php echo h($targetAmount ?: ''); ?>" placeholder="e.g., 25000">
            </div>
            <div>
                <button type="submit">Load Report</button>
            </div>
        </form>
        <div class="actions">
            <a href="?month=<?php echo $month; ?>&year=<?php echo $year; ?>&export=csv" style="text-decoration:none;"><button class="secondary" type="button">Export CSV</button></a>
            <button type="button" onclick="exportPDF();" class="secondary">Export PDF</button>
            <button type="button" onclick="window.print();" class="secondary">Print</button>
        </div>
    </div>

    <div class="card">
        <h2>Summary</h2>
        <div class="stats">
            <div class="stat-box"><div class="stat-title">Period</div><div class="stat-value"><?php echo h(date('F Y', strtotime($startDate))); ?></div></div>
            <div class="stat-box"><div class="stat-title">Bookings</div><div class="stat-value"><?php echo count($bookings); ?></div></div>
            <div class="stat-box"><div class="stat-title">Revenue</div><div class="stat-value"><?php echo moneyGhs($displayRevenue); ?></div></div>
            <div class="stat-box"><div class="stat-title">Taxes & Levies</div><div class="stat-value"><?php echo moneyGhs($totalTaxes); ?></div></div>
        </div>
        <div class="stats" style="margin-top:12px;">
            <div class="stat-box"><div class="stat-title">Taxable Revenue</div><div class="stat-value"><?php echo moneyGhs($taxableRevenue); ?></div></div>
            <div class="stat-box"><div class="stat-title">VAT (15%)</div><div class="stat-value"><?php echo moneyGhs($vat); ?></div></div>
            <div class="stat-box"><div class="stat-title">NHIL (2.5%)</div><div class="stat-value"><?php echo moneyGhs($nhil); ?></div></div>
            <div class="stat-box"><div class="stat-title">GetFund (2.5%)</div><div class="stat-value"><?php echo moneyGhs($getFund); ?></div></div>
            <div class="stat-box"><div class="stat-title">Covid Levy (1%)</div><div class="stat-value"><?php echo moneyGhs($covidLevy); ?></div></div>
        </div>
    </div>

    <div class="card">
        <h2>Bookings (Check-in within period)</h2>
        <div style="max-height:500px; overflow:auto;">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reference</th>
                        <th>Customer</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Payment</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($bookings)): ?>
                    <tr><td colspan="7" style="text-align:center; color: var(--text-muted);">No bookings found for this period.</td></tr>
                <?php else: ?>
                    <?php foreach ($bookings as $i => $b): ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo h($b['reference']); ?></td>
                            <td><?php echo h($b['customer']); ?></td>
                            <td><?php echo h(dateOnly($b['checkin'])); ?></td>
                            <td><?php echo h(dateOnly($b['checkout'])); ?></td>
                            <td><?php echo h($b['payment_method']); ?></td>
                            <td class="amount"><?php echo moneyGhs($b['total']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
                <?php if (!empty($bookings)): ?>
                <tfoot>
                    <tr>
                        <th colspan="6" style="text-align:right;">TOTAL</th>
                        <th class="amount"><?php echo moneyGhs($totalRevenue); ?></th>
                    </tr>
                </tfoot>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
<script>
// Embed server data for PDF export
const reportData = <?php
    $payload = [
        'period' => date('F Y', strtotime($startDate)),
        'bookings' => array_map(function ($b) {
            return [
                'reference' => $b['reference'],
                'customer' => $b['customer'],
                'checkin' => dateOnly($b['checkin']),
                'checkout' => dateOnly($b['checkout']),
                'payment' => $b['payment_method'],
                'total' => (float)$b['total'],
            ];
        }, $bookings),
        'totals' => [
            'count' => count($bookings),
            'revenue' => (float)$totalRevenue,
            'displayRevenue' => (float)$displayRevenue,
            'taxable' => (float)$taxableRevenue,
            'vat' => (float)$vat,
            'nhil' => (float)$nhil,
            'getFund' => (float)$getFund,
            'covidLevy' => (float)$covidLevy,
            'taxes' => (float)$totalTaxes,
            'target' => (float)$targetAmount,
        ],
    ];
    echo json_encode($payload, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
?>;

function formatCurrency(num) {
    return 'GHS ' + Number(num).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function exportPDF() {
    if (!reportData.bookings || !reportData.bookings.length) {
        alert('No bookings to export.');
        return;
    }

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    const totals = reportData.totals;
    const bookings = [...reportData.bookings];

    // Sort by check-in date to keep stays in order
    bookings.sort((a, b) => new Date(a.checkin || 0) - new Date(b.checkin || 0));

    // Header
    doc.setFontSize(22);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor('#005a9e');
    doc.text('Prestige Hotel', 105, 20, { align: 'center' });
    doc.setFontSize(14);
    doc.setFont('helvetica', 'normal');
    doc.setTextColor('#333333');
    doc.text('Monthly Revenue & Tax Report', 105, 28, { align: 'center' });
    doc.text(`Period: ${reportData.period}`, 105, 34, { align: 'center' });

    // Summary block
    const kpiY = 44;
    doc.setFontSize(12);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor('#000000');
    doc.text('Summary', 14, kpiY);
    doc.setLineWidth(0.5);
    doc.setDrawColor('#000000');
    doc.line(14, kpiY + 2, 196, kpiY + 2);

    doc.setFontSize(11);
    doc.setFont('helvetica', 'normal');
    doc.text(`Total Bookings: ${totals.count}`, 14, kpiY + 10);
    doc.text(`Total Revenue: ${formatCurrency(totals.displayRevenue)}`, 14, kpiY + 17);

    // Tax breakdown
    const taxY = kpiY + 27;
    doc.setFontSize(12);
    doc.setFont('helvetica', 'bold');
    doc.text('Tax & Levy Breakdown', 14, taxY);
    doc.line(14, taxY + 2, 196, taxY + 2);

    const taxCol1 = 14;
    const taxCol2 = 120;
    let currentY = taxY + 10;
    doc.setFontSize(11);
    doc.setFont('helvetica', 'normal');

    const addTaxRow = (label, value, isTotal = false) => {
        if (isTotal) {
            doc.setFont('helvetica', 'bold');
        }
        doc.text(label, taxCol1, currentY);
        doc.text(value, taxCol2, currentY);
        if (isTotal) {
            doc.setFont('helvetica', 'normal');
        }
        currentY += 7;
    };

    addTaxRow('Taxable Revenue:', formatCurrency(totals.taxable));
    addTaxRow('VAT (15%):', formatCurrency(totals.vat));
    addTaxRow('NHIL (2.5%):', formatCurrency(totals.nhil));
    addTaxRow('GetFund (2.5%):', formatCurrency(totals.getFund));
    addTaxRow('Covid Levy (1%):', formatCurrency(totals.covidLevy));
    currentY += 2;
    addTaxRow('Total Taxes & Levies:', formatCurrency(totals.taxes), true);

    // Table
    currentY += 6;
    const head = [['Reference', 'Customer', 'Stay Period', 'Payment', 'Amount', 'Check-in']];
    const fmtDate = (d) => d ? d.toString().slice(0, 10) : 'N/A';
    const body = bookings.map((o) => [
        o.reference,
        o.customer,
        o.checkin ? `${fmtDate(o.checkin)} - ${fmtDate(o.checkout || o.checkin)}` : 'N/A',
        o.payment || 'N/A',
        formatCurrency(o.total),
        fmtDate(o.checkin)
    ]);

    doc.autoTable({
        startY: currentY,
        head,
        body,
        theme: 'grid',
        headStyles: {
            fillColor: [0, 90, 158],
            textColor: [255, 255, 255],
            halign: 'center'
        },
        styles: {
            fontSize: 10,
            cellPadding: 3,
            textColor: [0, 0, 0]
        },
        columnStyles: {
            0: { cellWidth: 24 },
            1: { cellWidth: 42 },
            2: { cellWidth: 60 },
            3: { cellWidth: 24 },
            4: { cellWidth: 24 },
            5: { cellWidth: 24, halign: 'center' }
        },
        alternateRowStyles: {
            fillColor: [255, 255, 255]
        }
    });

    doc.save(`Tax_Report_${reportData.period.replace(/\s+/g, '_')}.pdf`);
}
</script>
</body>
</html>
