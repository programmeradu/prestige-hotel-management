{if !$ocultarPrecios}
<table id="summary-tab" width="100%">
	<tr>
		<th class="header small" valign="middle">{l s='Total Products' pdf='true'}</th>
		<th class="header small" valign="middle">{l s='Order date' pdf='true'}</th>
		{if isset($carrier)}
			<th class="header small" valign="middle">{l s='Carrier' pdf='true'}</th>
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
{/if}
