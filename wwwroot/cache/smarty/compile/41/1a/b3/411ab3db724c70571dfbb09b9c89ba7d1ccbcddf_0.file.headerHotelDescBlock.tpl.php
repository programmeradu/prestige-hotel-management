<?php
/* Smarty version 3.1.39, created on 2025-07-07 18:18:53
  from '/www/wwwroot/prestigehotel.org/modules/hotelreservationsystem/views/templates/hook/headerHotelDescBlock.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686c0f8de03980_41983657',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '411ab3db724c70571dfbb09b9c89ba7d1ccbcddf' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/hotelreservationsystem/views/templates/hook/headerHotelDescBlock.tpl',
      1 => 1741272629,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686c0f8de03980_41983657 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_621207518686c0f8ddf7489_24558214', 'header_hotel_block');
?>

<?php }
/* {block 'header_hotel_chain_name'} */
class Block_1871483219686c0f8ddf98f0_91022185 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

									<h1 class="header-hotel-name"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['WK_HTL_CHAIN_NAME']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</h1>
								<?php
}
}
/* {/block 'header_hotel_chain_name'} */
/* {block 'header_hotel_description'} */
class Block_1348148045686c0f8ddfd771_55761001 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

									<p class="header-hotel-desc"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['WK_HTL_TAG_LINE']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</p>
								<?php
}
}
/* {/block 'header_hotel_description'} */
/* {block 'displayAfterHeaderHotelDesc'} */
class Block_59390727686c0f8de00bc0_68802072 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>"displayAfterHeaderHotelDesc"),$_smarty_tpl ) );?>

					<?php
}
}
/* {/block 'displayAfterHeaderHotelDesc'} */
/* {block 'header_hotel_block'} */
class Block_621207518686c0f8ddf7489_24558214 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'header_hotel_block' => 
  array (
    0 => 'Block_621207518686c0f8ddf7489_24558214',
  ),
  'header_hotel_chain_name' => 
  array (
    0 => 'Block_1871483219686c0f8ddf98f0_91022185',
  ),
  'header_hotel_description' => 
  array (
    0 => 'Block_1348148045686c0f8ddfd771_55761001',
  ),
  'displayAfterHeaderHotelDesc' => 
  array (
    0 => 'Block_59390727686c0f8de00bc0_68802072',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<div class="header-desc-container">
		<div class="header-desc-wrapper">
			<div class="header-desc-primary">
				<div class="container">
					<div class="row">
						<div class="col-md-offset-1 col-md-10 col-lg-offset-2 col-lg-8">
							<p class="header-desc-welcome"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Welcome To','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</p>
							<hr class="heasder-desc-hr-first"/>
							<div class="header-desc-inner-wrapper">
								<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1871483219686c0f8ddf98f0_91022185', 'header_hotel_chain_name', $this->tplIndex);
?>

								<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1348148045686c0f8ddfd771_55761001', 'header_hotel_description', $this->tplIndex);
?>

								<hr class="heasder-desc-hr-second"/>
							</div>
						</div>
					</div>
					<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_59390727686c0f8de00bc0_68802072', 'displayAfterHeaderHotelDesc', $this->tplIndex);
?>

				</div>
			</div>
		</div>
	</div>
<?php
}
}
/* {/block 'header_hotel_block'} */
}
