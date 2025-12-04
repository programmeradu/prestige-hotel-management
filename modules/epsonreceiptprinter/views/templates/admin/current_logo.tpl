{if isset($receipt_logo_exists) && $receipt_logo_exists}
<div class="panel">
    <h3>{l s="Current Custom Logo" mod="epsonreceiptprinter"}</h3>
    <div class="row">
        <div class="col-lg-12">
            <img src="{$receipt_logo_path}" alt="Receipt Logo" class="img-thumbnail" style="max-height: 100px;"><br><br>
            <p class="help-block">{l s="This custom logo will appear on your receipts." mod="epsonreceiptprinter"}</p>
        </div>
    </div>
</div>
{/if}
