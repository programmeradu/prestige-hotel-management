{if !$ocultarPrecios}
<table id="summary-tab" width="100%">
    <tr>
        <th class="header small" valign="middle">{l s='Total Productos' mod='tpvtienda'}</th>
        <th class="header small" valign="middle">{l s='Fecha de pedido' mod='tpvtienda'}</th>
        {if isset($carrier)}
            <th class="header small" valign="middle">{l s='Transporte' mod='tpvtienda'}</th>
        {/if}
    </tr>
    <tr>
        <td class="center small white">{$numeroproducts}</td>
        <td class="center small white">{$date}</td>
        {if isset($carrier)}
            <td class="center small white">{$carrier->name}</td>
        {/if}
    </tr>
</table>
{if !empty($note) || !empty($texto)}
<table  width="100%">
    <tr>
        <td colspan="12" height="10">&nbsp;</td>
    </tr>
</table>
{/if}
<table  width="100%">
    {if isset($note) && !empty($note)}
    <tr>
        <td colspan="6" class="left">

            <table style="width: 100%">
                <tr>
                    <td class="grey" style="width: 17%;line-height:6px;"><h3>&nbsp;{l s='Info extra' mod='tpvtienda'}:</h3></td>
                    <td cellpadding="15" style="width:100%">{$note|nl2br}</td>
                </tr>
            </table>
        </td>
        <td colspan="1">&nbsp;</td>
    </tr>
    {/if}
    {if isset($texto) && !empty($texto)}
    <tr>
        <td colspan="6" style="border:0.5px solid #000" class="left bold">
            <table style="width: 100%">
                <tr>
                    <td cellpadding="15" style="width:100%">{$texto|nl2br}</td>
                 </tr>
            </table>
         </td>
    </tr>
    {/if}
{/if}
</table>