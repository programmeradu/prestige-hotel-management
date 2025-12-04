{extends file='page.tpl'}
{block name='stylesheets'}
    {include file="_partials/stylesheets.tpl" stylesheets=$stylesheets}
        <link rel="stylesheet" href="/modules/tpvtienda/plugins/enlacePagoTPV/styles.css" type="text/css" media="all">

{/block}
{block name='page_title'}
    {l s='Ticket' mod='tpvtienda'}
{/block}

{block name='page_content'}
{$ticket|escape:'htmlall':'UTF-8'}{/block}