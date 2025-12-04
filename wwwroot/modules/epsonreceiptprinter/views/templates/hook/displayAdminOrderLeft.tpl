{* Button added to the Order View (left column in PS 1.6) *}
<div class="panel">
    <div class="panel-heading">
        <i class="icon-print"></i> {l s='Print Folio' mod='epsonreceiptprinter'}
    </div>
    <a href="{$print_receipt_url|escape:'html':'UTF-8'}" target="_blank" class="btn btn-default btn-block">
        <i class="icon-print"></i> {l s='Print Guest Folio' mod='epsonreceiptprinter'}
    </a>
    <p class="help-block">{l s='Opens the folio in a new tab for printing.' mod='epsonreceiptprinter'}</p>
</div>
