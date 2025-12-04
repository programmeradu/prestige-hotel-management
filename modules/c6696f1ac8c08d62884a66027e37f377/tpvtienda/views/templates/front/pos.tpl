<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="es-es"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7" lang="es-es"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8" lang="es-es"><![endif]-->
<!--[if gt IE 8]> <html class="no-js ie9" lang="es-es"><![endif]-->
<html lang="es-es">
	<head>
		<meta charset="utf-8" />
		<title>POS</title>
		<meta name="generator" content="PrestaShop" />
		<meta name="robots" content="index,follow" />
		<meta name="viewport" content="width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<link rel="icon" type="image/vnd.microsoft.icon" href="/prestashop6/img/favicon.ico" />
		<link rel="shortcut icon" type="image/x-icon" href="/prestashop6/img/favicon.ico" />
		{foreach from=$css_files key=css_uri item=media}
			<link rel="stylesheet" href="{$css_uri|escape:'html':'UTF-8'}" type="text/css" media="{$media|escape:'html':'UTF-8'}" />
		{/foreach}
		{foreach from=$js_files item=js_uri}
			<script type="text/javascript" src="{$js_uri|escape:'html':'UTF-8'}"></script>
		{/foreach}
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,600&amp;subset=latin,latin-ext" type="text/css" media="all" />
	</head>
	<body id="module-tpvtienda-pos" class="module-tpvtienda-pos lang_es"><div id="TPVTienda" data-role="page" class="v16 ui-page ui-page-theme-a ui-page-active" data-url="TPVTienda" tabindex="0" style="min-height: 995px;">
		<div id="advertencia">
			<div id="nohayresultados" style="display:none" class="module_error alert alert-danger error">No hay resultados</div>
			<div style="display:none" class="notificationGood module_confirmation alert alert-success conf confirm">Se inserto el cliente correctamente </div>
			<div style="display:none" class="notificationBad module_error alert alert-danger error">Hubo un error al insertar al cliente</div>
			<div id="minimunQuantity" style="display:none" class="module_error alert alert-danger error">La cantidad minima del producto elegido es: <strong></strong></div>
			<div id="customizedFielsReq" style="display:none" class="module_error alert alert-danger error">Queda al menos 1 campo de customización sin rellenar</div>
			<div id="confAparcado" class="module_confirmation conf confirm alert alert-success">
				<div class="estadoPedidoHecho">{l s='Pedido Realizado!' mod='tpvtienda'}</div>
				<p>{l s='Su id de carrito es el número' mod='tpvtienda'}: <span id="idCarrito"></span>, {l s='indiquelo al empleado' mod='tpvtienda'}.</p>
				<div class="close fancybox-close"></div>
			</div>
		</div>
		<div id="menuBarPos">
			<div id="entradaCodigo">
				<input type="text" id="order_query" data-mini="true" placeholder="{l s='Nombre/Código' mod='tpvtienda'}" autocomplete="off" name="order_query" value="">
				<div class="close" style="display: none;">X</div>
			</div>
			<div id="contCategorias">
				<select id="categorias" name="categorias" data-mini="true">
					{$categorias}
				</select>
			</div>
			<fieldset id="selectorListado" data-role="controlgroup" data-type="horizontal" data-mini="true">
        		<input type="radio" name="listaProd" id="radio-choice-a" value="list" checked="checked">
        		<label for="radio-choice-a">List</label>
        		<input type="radio" name="listaProd" id="radio-choice-b" value="grid">
        		<label for="radio-choice-b">Grid</label>
			</fieldset>
			<div id="nombreTienda">{$nombreTienda}</div>	
		</div>
		<div id="subTPVTienda" class="bomenu1 v16 languagees">
			<div id="cabecera" class="row">
				<div class="sevencol">
					<div id="contSlide">
						<div id="productos" class="list-products swiper-free-mode">
							<div id="contProductos" class="swiper-wrapper grid" style="display:none">
							</div>
							<div id="contProductos2" class="swiper-wrapper list">
								<table>
									<thead>
										<th style="width: 5%"></th>
										<th style="width: 70%">{l s='Nombre' mod='tpvtienda'}</th>
										<th style="width: 10%">{l s='Ref.' mod='tpvtienda'}</th>
										<th style="width: 5%">{l s='Stock' mod='tpvtienda'}</th>
										<th style="width: 10%">{l s='Precio unid.' mod='tpvtienda'}</th>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div id="contColDer" class="fivecol last">
					<div id="contCompra" class="twelvecol">
						<div id="compraVacia">{l s='Lista de Compra Vacía' mod='tpvtienda'}</div><table id="compra" style="display: none;">
							<thead>
								<th class="foto" style="width: 5%"></th>
								<th class="nombre" style="width: 32%">{l s='Nombre' mod='tpvtienda'}</th>
								<th class="cantidad" style="width: 5%">{l s='Ctd' mod='tpvtienda'}</th>
								<th class="precio" style="width: 7%">{l s='Precio unid.' mod='tpvtienda'}</th>
								<th class="total" style="width: 7%">{l s='Total' mod='tpvtienda'}</th>
								<th class="accion" style="width: 2%"></th></tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
					<div id="parteAbajo" class="cambio twelvecol">
						<div id="totalesCont" class="sixcol">
							<div class="sixcol">
								<label>{l s='Total' mod='tpvtienda'} ({$sign}):</label>
							</div>
							<div class="sixcol last">
								<div id="totalButton" class="alterado ui-btn ui-corner-all"><span style="display: inline;">0.00</span></div>
							</div>
							<div class="sixcol taxTpv">
								<label>{l s='IVA' mod='tpvtienda'} ({$sign}):</label>
							</div>
							<div class="sixcol last taxTpv">
								<div id="ivaButton" class="ui-btn ui-corner-all"><span style="display: inline;">0.00</span></div>
							</div>
						</div>
						<div id="pedido" class="sixcol last">
							<input type="hidden" id="id_cart" name="id_cart" value="{$id_cart}">
							<input type="hidden" id="id_currency" name="id_currency" value="{$id_currency}">
							<input type="hidden" id="id_customer" name="id_customer" value="{$id_customer}">
							<input type="hidden" id="id_shop" value="{$id_shop}">
							<input type="hidden" id="id_lang" value="{$id_lang}">
							<div id="contCheckout">
								<div class="row">
									<div class="fourcol">				
										<label>{l s='Nota:' mod='tpvtienda'}</label>
									</div>
									<div class="eightcol last ">
										<textarea id="messageOrder" name="messageOrder" style="width: 100%; height: 52px;" class="messageOrder ui-input-text ui-shadow-inset ui-body-inherit ui-corner-all ui-textinput-autogrow"></textarea>
									</div>
									<div class="sixcol" style="display: block;">
										<label>{l s='Descuentos' mod='tpvtienda'}: </label>
									</div>
									<div class="sixcol last" style="display: block;">
										<div id="descuentosButton" class="ui-btn ui-corner-all"><span style="display: inline;">0.00</span></div>
									</div>
								</div>
							</div>
						</div>
						<button onclick="aparcar()" class="checkoutButton alterado ui-btn ui-shadow ui-corner-all">
							{l s='CONFIRMAR COMPRA' mod='tpvtienda'}
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
			
			
		</div></div></div>
		{$variablesJavascript}
</body></html>