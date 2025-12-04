{* filepath: c:\xampp\htdocs\modules\mtnmomo\views\templates\hook\payment_return.tpl *}
<div class="box">
    <h3>{l s='Your order on %s is complete.' sprintf=$shop_name mod='mtnmomo'}</h3>
    <p>
        {l s='You have chosen MTN Mobile Money payment method.' mod='mtnmomo'}
        <br/>
        {l s='Your order will be shipped as soon as possible.' mod='mtnmomo'}
    </p>
    <p>
        {l s='For any questions or for further information, please contact our' mod='mtnmomo'}
        <a href="{$link->getPageLink('contact', true)|escape:'html'}">{l s='customer support' mod='mtnmomo'}</a>.
    </p>
</div>