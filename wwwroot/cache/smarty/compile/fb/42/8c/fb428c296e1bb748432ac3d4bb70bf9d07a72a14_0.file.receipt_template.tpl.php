<?php
/* Smarty version 3.1.39, created on 2025-07-08 15:16:49
  from '/www/wwwroot/prestigehotel.org/modules/epsonreceiptprinter/views/templates/admin/receipt_template.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686d36615f4c37_10201862',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fb428c296e1bb748432ac3d4bb70bf9d07a72a14' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/epsonreceiptprinter/views/templates/admin/receipt_template.tpl',
      1 => 1746331860,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686d36615f4c37_10201862 (Smarty_Internal_Template $_smarty_tpl) {
?>    <!DOCTYPE html>
    <html>
    <head>
        <title><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Guest Folio','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order_reference']->value, ENT_QUOTES, 'UTF-8', true);?>
</title>
        <meta charset="UTF-8">
        <style>
            body {
                font-family: 'Courier New', Courier, monospace; /* Monospaced font often looks better on receipts */
                font-size: 10pt; /* Adjust as needed */
                /* IMPORTANT: Adjust width based on the configured paper width */
                width: <?php if ($_smarty_tpl->tpl_vars['paper_width']->value == '58') {?>200px<?php } else { ?>280px<?php }?>; /* Width based on configuration */
                margin: 5px;
                padding: 0;
                background-color: #fff; /* Ensure white background for printing */
                color: #000; /* Ensure black text */
            }
            .center { text-align: center; }
            .left { text-align: left; }
            .right { text-align: right; }
            hr {
                border: none;
                border-top: 1px dashed black;
                margin: 5px 0;
                color: #000;
                background-color: transparent;
                height: 1px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 5px 0;
            }
            th, td { padding: 1px 0; vertical-align: top; font-size: 9pt; /* Slightly smaller for table content */}
            .product-name { width: 55%; text-align: left; word-wrap: break-word; /* Wrap long names */ }
            .product-qty { width: 15%; text-align: center; } /* Renamed from qty, maybe wider for 'Nights' */
            .product-unit-price { width: 15%; text-align: right; }
            .product-total { width: 30%; text-align: right; }

            .totals td:first-child { text-align: left; width: 70%; padding-right: 5px;}
            .totals td:last-child { text-align: right; width: 30%;}
            .totals .total-line td { font-weight: bold; border-top: 1px solid black; padding-top: 3px;}

            .header, .footer { margin-bottom: 10px; text-align: center; }
            .header p, .footer p { margin: 2px 0; font-size: 9pt; }
            .header h2 { margin: 5px 0; font-size: 12pt; }

            .header img.shop-logo {
                max-width: 180px; /* Adjust max width as needed */
                max-height: 60px; /* Adjust max height as needed */
                margin-bottom: 5px;
            }
            .room-number {
                font-size: 14pt; /* Larger font size for room number */
                font-weight: bold;
                text-align: center;
                margin: 5px 0;
            }
            .guest-name {
                font-size: 12pt;
                font-weight: bold;
                margin: 5px 0;
            }
            .check-in-out {
                font-weight: bold;
                margin: 4px 0;
            }
            .amount-due {
                font-size: 12pt;
                font-weight: bold;
                margin-top: 5px;
                border-top: 1px solid black;
                padding-top: 5px;
            }
            /* Hide elements not for printing if needed */
            @media print {
                /* Styles specific for printing */
                body { margin: 0; padding: 0; }
                /* You might hide buttons or other screen elements here */
            }
        </style>
    </head>
            <body onload="window.print(); window.onafterprint = function(){ window.close(); };">

        <div class="header center">
            <?php if ((isset($_smarty_tpl->tpl_vars['shop_logo']->value)) && $_smarty_tpl->tpl_vars['shop_logo']->value) {?>
                                <img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_logo']->value, ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="shop-logo" />
                <br/>                 <h3><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true);?>
</h3>             <?php } else { ?>
                                <h2><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true);?>
</h2>
            <?php }?>
            <p><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_address1']->value, ENT_QUOTES, 'UTF-8', true);?>
</p>
            <?php if ($_smarty_tpl->tpl_vars['shop_address2']->value) {?><p><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_address2']->value, ENT_QUOTES, 'UTF-8', true);?>
</p><?php }?>
            <p><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_zipcode']->value, ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_city']->value, ENT_QUOTES, 'UTF-8', true);?>
</p>
            <p><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_country']->value, ENT_QUOTES, 'UTF-8', true);?>
</p>
            <?php if ($_smarty_tpl->tpl_vars['shop_phone']->value) {?><p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Tel:','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_phone']->value, ENT_QUOTES, 'UTF-8', true);?>
</p><?php }?>
                        <hr>
            <p><strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Booking Ref:','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order_reference']->value, ENT_QUOTES, 'UTF-8', true);?>
</strong></p>
            <p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Date:','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order_date']->value, ENT_QUOTES, 'UTF-8', true);?>
</p>
            <p class="guest-name"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Guest:','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customer_name']->value, ENT_QUOTES, 'UTF-8', true);?>
</p>
            
                        <?php if ((isset($_smarty_tpl->tpl_vars['room_number']->value)) && $_smarty_tpl->tpl_vars['room_number']->value) {?>
                <p class="room-number"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room:','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['room_number']->value, ENT_QUOTES, 'UTF-8', true);?>
</p>
            <?php }?>

                        <?php if ((isset($_smarty_tpl->tpl_vars['check_in_date']->value)) && $_smarty_tpl->tpl_vars['check_in_date']->value && (isset($_smarty_tpl->tpl_vars['check_out_date']->value)) && $_smarty_tpl->tpl_vars['check_out_date']->value) {?>
                <p class="check-in-out">
                    <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Check-in:','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['check_in_date']->value, ENT_QUOTES, 'UTF-8', true);?>
 - 
                    <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Check-out:','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['check_out_date']->value, ENT_QUOTES, 'UTF-8', true);?>

                </p>
            <?php }?>
            
                        <?php if ((isset($_smarty_tpl->tpl_vars['employee_name']->value)) && $_smarty_tpl->tpl_vars['employee_name']->value != 'N/A') {?>
                <p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Served by:','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['employee_name']->value, ENT_QUOTES, 'UTF-8', true);?>
</p>
            <?php }?>
            
            <hr>
        </div>

        <table>
            <thead>
                <tr>
                    <th class="product-name left"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room/Service','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
</th>
                    <th class="product-qty center"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Nights/Qty','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
</th>
                                         <th class="product-total right"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
</th>
                </tr>
            </thead>
            <tbody>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['products']->value, 'product');
$_smarty_tpl->tpl_vars['product']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->do_else = false;
?>
                <tr>
                    <td class="product-name left"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</td>
                    <td class="product-qty center"><?php echo intval($_smarty_tpl->tpl_vars['product']->value['quantity']);?>
</td>                                          <td class="product-total right"><?php echo $_smarty_tpl->tpl_vars['product']->value['total_wt'];?>
</td>                 </tr>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </tbody>
        </table>

        <hr>

        <table class="totals">
             <tr>
                 <td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Subtotal (Net)','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
</td>
                 <td><?php echo $_smarty_tpl->tpl_vars['total_tax_excl']->value;?>
</td>
             </tr>
             <?php if ($_smarty_tpl->tpl_vars['total_discounts']->value != 0.00) {?>
             <tr>
                 <td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Discounts','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
</td>
                 <td>-<?php echo $_smarty_tpl->tpl_vars['total_discounts']->value;?>
</td>
             </tr>
             <?php }?>
             <tr>
                 <td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Taxes','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
</td>
                 <td><?php echo $_smarty_tpl->tpl_vars['total_tax']->value;?>
</td>
             </tr>
             <tr class="total-line">
                 <td><strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'TOTAL AMOUNT','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
</strong></td>
                 <td><strong><?php echo $_smarty_tpl->tpl_vars['total_paid']->value;?>
</strong></td>
             </tr>
             
                          <?php if ($_smarty_tpl->tpl_vars['has_balance_due']->value) {?>
             <tr>
                 <td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'AMOUNT PAID','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
</td>
                 <td><?php echo $_smarty_tpl->tpl_vars['amount_paid']->value;?>
</td>
             </tr>
             <tr>
                 <td colspan="2" class="center amount-due"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'BALANCE DUE:','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
 <?php echo $_smarty_tpl->tpl_vars['amount_due']->value;?>
</td>
             </tr>
             <?php } else { ?>
             <tr>
                 <td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'PAYMENT STATUS','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
</td>
                 <td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'PAID IN FULL','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
</td>
             </tr>
             <?php }?>
        </table>

        <hr>

        <div class="footer center">
            <p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Payment Method:','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment_method']->value, ENT_QUOTES, 'UTF-8', true);?>
</p>
            <p><?php if ((isset($_smarty_tpl->tpl_vars['footer_text']->value)) && $_smarty_tpl->tpl_vars['footer_text']->value) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['footer_text']->value, ENT_QUOTES, 'UTF-8', true);
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Thank you for staying with us!','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );
}?></p>
            <hr style="margin-top:10px;">
            <p>https://prestigehotel.org</p>
            <p>Tel: 0332150754 / 0205328339</p>
            
                        <p style="margin-top:10px;"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Booking Reference:','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order_reference']->value, ENT_QUOTES, 'UTF-8', true);?>
</p>
            <div id="barcode-container" style="width:100%; text-align:center; margin:10px 0;">
                <svg id="barcode"></svg>
            </div>
        </div>

                <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['modules_dir']->value;?>
epsonreceiptprinter/views/js/JsBarcode.all.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript">
            // Wait for document to be fully loaded
            window.onload = function() {
                try {
                    // Debug info
                    console.log("Generating barcode for: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order_reference']->value, ENT_QUOTES, 'UTF-8', true);?>
");
                    
                    // Generate the barcode
                    JsBarcode("#barcode", "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order_reference']->value, ENT_QUOTES, 'UTF-8', true);?>
", {
                        format: "CODE128",
                        lineColor: "#000",
                        width: 1.5,
                        height: 40,
                        displayValue: true,
                        fontSize: 10,
                        margin: 10
                    });
                    
                    // Print the receipt automatically
                    window.print();
                    window.onafterprint = function() { 
                        window.close(); 
                    };
                } catch (e) {
                    // Handle error if JsBarcode fails
                    console.error("Barcode generation failed", e);
                    alert("Could not generate barcode. Error: " + e.message);
                }
            }
        <?php echo '</script'; ?>
>

    </body>
    </html>
<?php }
}
