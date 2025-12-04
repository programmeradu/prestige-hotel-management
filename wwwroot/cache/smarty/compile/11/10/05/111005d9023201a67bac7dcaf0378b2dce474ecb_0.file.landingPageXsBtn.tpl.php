<?php
/* Smarty version 3.1.39, created on 2025-07-07 18:18:53
  from '/www/wwwroot/prestigehotel.org/modules/wkroomsearchblock/views/templates/hook/landingPageXsBtn.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686c0f8de1ac70_46948435',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '111005d9023201a67bac7dcaf0378b2dce474ecb' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/wkroomsearchblock/views/templates/hook/landingPageXsBtn.tpl',
      1 => 1741272742,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686c0f8de1ac70_46948435 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2088628066686c0f8de184e5_06925222', 'landing_page_search_button_mobile');
?>

<?php }
/* {block 'landing_page_search_button_mobile'} */
class Block_2088628066686c0f8de184e5_06925222 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'landing_page_search_button_mobile' => 
  array (
    0 => 'Block_2088628066686c0f8de184e5_06925222',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<div class="row margin-top-20 visible-xs">
		<div class="col-md-offset-1 col-md-10 col-lg-offset-2 col-lg-8">
			<button id="xs_room_search" class="btn button button-medium" href="#xs_room_search_form"><span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Make Booking','mod'=>'wkroomsearchblock'),$_smarty_tpl ) );?>
</span></button>
		</div>
	</div>
<?php
}
}
/* {/block 'landing_page_search_button_mobile'} */
}
