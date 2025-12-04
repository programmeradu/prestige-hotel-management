{* Basic HTML structure for receipt - Keep it simple! *}
    <!DOCTYPE html>
    <html>
    <head>
        <title>{l s='Guest Folio' mod='epsonreceiptprinter'} {$order_reference|escape:'html':'UTF-8'}</title>
        <meta charset="UTF-8">
        <style>
            body {
                font-family: 'Courier New', Courier, monospace; /* Monospaced font often looks better on receipts */
                font-size: 10pt; /* Adjust as needed */
                /* IMPORTANT: Adjust width based on the configured paper width */
                width: {if $paper_width == '58'}200px{else}280px{/if}; /* Width based on configuration */
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
    {* Optional: Trigger print dialog automatically when the window loads *}
    {* Remove or comment out if you prefer manual printing via Ctrl+P *}
    <body onload="window.print(); window.onafterprint = function(){ window.close(); };">

        <div class="header center">
            {if isset($shop_logo) && $shop_logo}
                {* Display the shop logo if available *}
                <img src="{$shop_logo|escape:'html':'UTF-8'}" alt="{$shop_name|escape:'html':'UTF-8'}" class="shop-logo" />
                <br/> {* Add a line break after logo *}
                <h3>{$shop_name|escape:'html':'UTF-8'}</h3> {* Add hotel name under logo *}
            {else}
                {* Display shop name if no logo *}
                <h2>{$shop_name|escape:'html':'UTF-8'}</h2>
            {/if}
            <p>{$shop_address1|escape:'html':'UTF-8'}</p>
            {if $shop_address2}<p>{$shop_address2|escape:'html':'UTF-8'}</p>{/if}
            <p>{$shop_zipcode|escape:'html':'UTF-8'} {$shop_city|escape:'html':'UTF-8'}</p>
            <p>{$shop_country|escape:'html':'UTF-8'}</p>
            {if $shop_phone}<p>{l s='Tel:' mod='epsonreceiptprinter'} {$shop_phone|escape:'html':'UTF-8'}</p>{/if}
            {* Removing shop email display *}
            <hr>
            <p><strong>{l s='Booking Ref:' mod='epsonreceiptprinter'} {$order_reference|escape:'html':'UTF-8'}</strong></p>
            <p>{l s='Date:' mod='epsonreceiptprinter'} {$order_date|escape:'html':'UTF-8'}</p>
            <p class="guest-name">{l s='Guest:' mod='epsonreceiptprinter'} {$customer_name|escape:'html':'UTF-8'}</p>
            
            {* Display Room Number prominently *}
            {if isset($room_number) && $room_number}
                <p class="room-number">{l s='Room:' mod='epsonreceiptprinter'} {$room_number|escape:'html':'UTF-8'}</p>
            {/if}

            {* Display check-in and check-out dates *}
            {if isset($check_in_date) && $check_in_date && isset($check_out_date) && $check_out_date}
                <p class="check-in-out">
                    {l s='Check-in:' mod='epsonreceiptprinter'} {$check_in_date|escape:'html':'UTF-8'} - 
                    {l s='Check-out:' mod='epsonreceiptprinter'} {$check_out_date|escape:'html':'UTF-8'}
                </p>
            {/if}
            
            {* Display Employee Name *}
            {if isset($employee_name) && $employee_name != 'N/A'}
                <p>{l s='Served by:' mod='epsonreceiptprinter'} {$employee_name|escape:'html':'UTF-8'}</p>
            {/if}
            
            <hr>
        </div>

        <table>
            <thead>
                <tr>
                    <th class="product-name left">{l s='Room/Service' mod='epsonreceiptprinter'}</th>
                    <th class="product-qty center">{l s='Nights/Qty' mod='epsonreceiptprinter'}</th>
                    {* <th class="product-unit-price right">{l s='Rate' mod='epsonreceiptprinter'}</th> *} {* Uncomment if you want unit price/rate *}
                    <th class="product-total right">{l s='Total' mod='epsonreceiptprinter'}</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$products item=product}
                <tr>
                    <td class="product-name left">{$product.name|escape:'html':'UTF-8'}</td>
                    <td class="product-qty center">{$product.quantity|intval}</td> {* Keep variable name, change label only *}
                    {* <td class="product-unit-price right">{$product.price_unit}</td> *} {* Uncomment if you want unit price/rate *}
                    <td class="product-total right">{$product.total_wt}</td> {* Already formatted with currency *}
                </tr>
                {/foreach}
            </tbody>
        </table>

        <hr>

        <table class="totals">
             <tr>
                 <td>{l s='Subtotal (Net)' mod='epsonreceiptprinter'}</td>
                 <td>{$total_tax_excl}</td>
             </tr>
             {if $total_discounts != 0.00}
             <tr>
                 <td>{l s='Discounts' mod='epsonreceiptprinter'}</td>
                 <td>-{$total_discounts}</td>
             </tr>
             {/if}
             <tr>
                 <td>{l s='Taxes' mod='epsonreceiptprinter'}</td>
                 <td>{$total_tax}</td>
             </tr>
             <tr class="total-line">
                 <td><strong>{l s='TOTAL AMOUNT' mod='epsonreceiptprinter'}</strong></td>
                 <td><strong>{$total_paid}</strong></td>
             </tr>
             
             {* Handle both partial and full payments *}
             {if $has_balance_due}
             <tr>
                 <td>{l s='AMOUNT PAID' mod='epsonreceiptprinter'}</td>
                 <td>{$amount_paid}</td>
             </tr>
             <tr>
                 <td colspan="2" class="center amount-due">{l s='BALANCE DUE:' mod='epsonreceiptprinter'} {$amount_due}</td>
             </tr>
             {else}
             <tr>
                 <td>{l s='PAYMENT STATUS' mod='epsonreceiptprinter'}</td>
                 <td>{l s='PAID IN FULL' mod='epsonreceiptprinter'}</td>
             </tr>
             {/if}
        </table>

        <hr>

        <div class="footer center">
            <p>{l s='Payment Method:' mod='epsonreceiptprinter'} {$payment_method|escape:'html':'UTF-8'}</p>
            <p>{if isset($footer_text) && $footer_text}{$footer_text|escape:'html':'UTF-8'}{else}{l s='Thank you for staying with us!' mod='epsonreceiptprinter'}{/if}</p>
            <hr style="margin-top:10px;">
            <p>https://prestigehotel.org</p>
            <p>Tel: 0332150754 / 0205328339</p>
            
            {* Add barcode for booking reference - force display for debugging *}
            <p style="margin-top:10px;">{l s='Booking Reference:' mod='epsonreceiptprinter'} {$order_reference|escape:'html':'UTF-8'}</p>
            <div id="barcode-container" style="width:100%; text-align:center; margin:10px 0;">
                <svg id="barcode"></svg>
            </div>
        </div>

        {* Include local JsBarcode library for barcode generation (offline use) *}
        <script src="{$modules_dir}epsonreceiptprinter/views/js/JsBarcode.all.min.js"></script>
        <script type="text/javascript">
            // Wait for document to be fully loaded
            window.onload = function() {
                try {
                    // Debug info
                    console.log("Generating barcode for: {$order_reference|escape:'html':'UTF-8'}");
                    
                    // Generate the barcode
                    JsBarcode("#barcode", "{$order_reference|escape:'html':'UTF-8'}", {
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
        </script>

    </body>
    </html>
