<?php
/* Smarty version 3.1.39, created on 2025-05-11 19:09:51
  from '/www/wwwroot/prestigehotel.org/themes/hotel-reservation-theme/my-account.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_6820f5ff8ff048_72639209',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '69f54326daeb0d51f8b4d10cf0f5dfd0b0385b38' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/themes/hotel-reservation-theme/my-account.tpl',
      1 => 1741272750,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6820f5ff8ff048_72639209 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_9145810206820f5ff8c1dd5_81004511', 'my_account');
?>

<?php }
/* {block 'my_account_heading'} */
class Block_18423176556820f5ff8c7419_26725493 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <h1 class="page-heading"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'My account'),$_smarty_tpl ) );?>
</h1>
        <?php if ((isset($_smarty_tpl->tpl_vars['account_created']->value))) {?>
            <p class="alert alert-success">
                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Your account has been created.'),$_smarty_tpl ) );?>

            </p>
        <?php }?>
        <p class="info-account"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Welcome to your account. Here you can manage all of your personal information and orders.'),$_smarty_tpl ) );?>
</p>
    <?php
}
}
/* {/block 'my_account_heading'} */
/* {block 'my_account_tabs'} */
class Block_18921886076820f5ff8cf8f2_10516724 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                <ul class="myaccount-link-list">
                    <li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('address',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Address'),$_smarty_tpl ) );?>
"><i class="icon-building"></i><span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Address'),$_smarty_tpl ) );?>
</span></a></li>
                    <li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('history',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Bookings'),$_smarty_tpl ) );?>
"><i class="icon-list-ol"></i><span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Bookings'),$_smarty_tpl ) );?>
</span></a></li>
                    <?php if ($_smarty_tpl->tpl_vars['refundAllowed']->value) {?>
                        <li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('order-follow',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Booking refund requests'),$_smarty_tpl ) );?>
"><i class="icon-refresh"></i><span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Booking refund requests'),$_smarty_tpl ) );?>
</span></a></li>
                    <?php }?>
                    <li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('order-slip',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Credit slips'),$_smarty_tpl ) );?>
"><i class="icon-file-o"></i><span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Credit slips'),$_smarty_tpl ) );?>
</span></a></li>
                    <li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('identity',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Personal information'),$_smarty_tpl ) );?>
"><i class="icon-user"></i><span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Personal information'),$_smarty_tpl ) );?>
</span></a></li>
                </ul>
            <?php
}
}
/* {/block 'my_account_tabs'} */
/* {block 'displayCustomerAccount'} */
class Block_160376616820f5ff8ed391_73921130 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

            <?php if ($_smarty_tpl->tpl_vars['voucherAllowed']->value || (isset($_smarty_tpl->tpl_vars['HOOK_CUSTOMER_ACCOUNT']->value)) && $_smarty_tpl->tpl_vars['HOOK_CUSTOMER_ACCOUNT']->value != '') {?>
                <div class="col-xs-12 col-sm-6 col-lg-4">
                    <ul class="myaccount-link-list">
                        <?php if ($_smarty_tpl->tpl_vars['voucherAllowed']->value) {?>
                            <li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('discount',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Vouchers'),$_smarty_tpl ) );?>
"><i class="icon-barcode"></i><span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Vouchers'),$_smarty_tpl ) );?>
</span></a></li>
                        <?php }?>
                        <?php echo $_smarty_tpl->tpl_vars['HOOK_CUSTOMER_ACCOUNT']->value;?>

                    </ul>
                </div>
            <?php }?>
        <?php
}
}
/* {/block 'displayCustomerAccount'} */
/* {block 'displayCustomerAccountAfterTabs'} */
class Block_3841547706820f5ff8f6f33_58700711 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayCustomerAccountAfterTabs'),$_smarty_tpl ) );?>

    <?php
}
}
/* {/block 'displayCustomerAccountAfterTabs'} */
/* {block 'my_account_footer_links'} */
class Block_18729748116820f5ff8f9290_70155771 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <ul class="footer_links clearfix">
        <li><a class="btn btn-default button button-small" href="<?php if ((isset($_smarty_tpl->tpl_vars['force_ssl']->value)) && $_smarty_tpl->tpl_vars['force_ssl']->value) {
echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;
} else {
echo $_smarty_tpl->tpl_vars['base_dir']->value;
}?>" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Home'),$_smarty_tpl ) );?>
"><span><i class="icon-chevron-left"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Home'),$_smarty_tpl ) );?>
</span></a></li>
        </ul>
    <?php
}
}
/* {/block 'my_account_footer_links'} */
/* {block 'my_account'} */
class Block_9145810206820f5ff8c1dd5_81004511 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'my_account' => 
  array (
    0 => 'Block_9145810206820f5ff8c1dd5_81004511',
  ),
  'my_account_heading' => 
  array (
    0 => 'Block_18423176556820f5ff8c7419_26725493',
  ),
  'my_account_tabs' => 
  array (
    0 => 'Block_18921886076820f5ff8cf8f2_10516724',
  ),
  'displayCustomerAccount' => 
  array (
    0 => 'Block_160376616820f5ff8ed391_73921130',
  ),
  'displayCustomerAccountAfterTabs' => 
  array (
    0 => 'Block_3841547706820f5ff8f6f33_58700711',
  ),
  'my_account_footer_links' => 
  array (
    0 => 'Block_18729748116820f5ff8f9290_70155771',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'path', null, null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'My account'),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18423176556820f5ff8c7419_26725493', 'my_account_heading', $this->tplIndex);
?>

    <div class="row addresses-lists">
        <div class="col-xs-12 col-sm-6 col-lg-4">
            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18921886076820f5ff8cf8f2_10516724', 'my_account_tabs', $this->tplIndex);
?>

        </div>
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_160376616820f5ff8ed391_73921130', 'displayCustomerAccount', $this->tplIndex);
?>

    </div>

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3841547706820f5ff8f6f33_58700711', 'displayCustomerAccountAfterTabs', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18729748116820f5ff8f9290_70155771', 'my_account_footer_links', $this->tplIndex);
?>


<?php
}
}
/* {/block 'my_account'} */
}
