<?php
/* Smarty version 3.1.39, created on 2025-05-05 20:16:42
  from '/www/wwwroot/prestigehotel.org/themes/hotel-reservation-theme/password.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_68191caa5d5301_95698187',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '689dc61cd42b599f318bb50443d0c971d1f4bedd' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/themes/hotel-reservation-theme/password.tpl',
      1 => 1741272751,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68191caa5d5301_95698187 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_74237082068191caa595861_78162851', 'password');
?>

<?php }
/* {block 'password_heading'} */
class Block_19099496268191caa5a7132_99400544 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<h1 class="page-subheading"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Forgot your password?'),$_smarty_tpl ) );?>
</h1>
	<?php
}
}
/* {/block 'password_heading'} */
/* {block 'errors'} */
class Block_15097797968191caa5a96f9_70171427 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
	<?php
}
}
/* {/block 'errors'} */
/* {block 'displayForgotPasswordFormFieldsAfter'} */
class Block_187331851568191caa5cae77_30763688 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

					<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayForgotPasswordFormFieldsAfter'),$_smarty_tpl ) );?>

				<?php
}
}
/* {/block 'displayForgotPasswordFormFieldsAfter'} */
/* {block 'password_form_action'} */
class Block_200065823768191caa5cd246_35332685 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

					<p class="submit">
						<button type="submit" class="btn button button-medium"><span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Retrieve Password'),$_smarty_tpl ) );?>
&nbsp;<i class="icon-chevron-right right"></i></span></button>
					</p>
				<?php
}
}
/* {/block 'password_form_action'} */
/* {block 'password_form'} */
class Block_135079598068191caa5c14b9_94853062 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['request_uri']->value, ENT_QUOTES, 'UTF-8', true);?>
" method="post" class="std" id="form_forgotpassword">
			<fieldset>
				<div class="form-group">
					<label for="email"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Email address'),$_smarty_tpl ) );?>
</label>
					<input class="form-control" type="email" id="email" name="email" value="<?php if ((isset($_POST['email']))) {
echo stripslashes(htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8', true));
}?>" />
				</div>
				<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_187331851568191caa5cae77_30763688', 'displayForgotPasswordFormFieldsAfter', $this->tplIndex);
?>

				<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_200065823768191caa5cd246_35332685', 'password_form_action', $this->tplIndex);
?>

			</fieldset>
		</form>
	<?php
}
}
/* {/block 'password_form'} */
/* {block 'password'} */
class Block_74237082068191caa595861_78162851 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'password' => 
  array (
    0 => 'Block_74237082068191caa595861_78162851',
  ),
  'password_heading' => 
  array (
    0 => 'Block_19099496268191caa5a7132_99400544',
  ),
  'errors' => 
  array (
    0 => 'Block_15097797968191caa5a96f9_70171427',
  ),
  'password_form' => 
  array (
    0 => 'Block_135079598068191caa5c14b9_94853062',
  ),
  'displayForgotPasswordFormFieldsAfter' => 
  array (
    0 => 'Block_187331851568191caa5cae77_30763688',
  ),
  'password_form_action' => 
  array (
    0 => 'Block_200065823768191caa5cd246_35332685',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'path', null, null);?><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('authentication',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Authentication'),$_smarty_tpl ) );?>
" rel="nofollow"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Authentication'),$_smarty_tpl ) );?>
</a><span class="navigation-pipe"><?php echo $_smarty_tpl->tpl_vars['navigationPipe']->value;?>
</span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Forgot your password'),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
	<div class="box">
	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19099496268191caa5a7132_99400544', 'password_heading', $this->tplIndex);
?>


	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15097797968191caa5a96f9_70171427', 'errors', $this->tplIndex);
?>


	<?php if ((isset($_smarty_tpl->tpl_vars['confirmation']->value)) && $_smarty_tpl->tpl_vars['confirmation']->value == 1) {?>
	<p class="alert alert-success"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Your password has been successfully reset and a confirmation has been sent to your email address:'),$_smarty_tpl ) );?>
 <?php if ((isset($_smarty_tpl->tpl_vars['customer_email']->value))) {
echo stripslashes(htmlspecialchars($_smarty_tpl->tpl_vars['customer_email']->value, ENT_QUOTES, 'UTF-8', true));
}?></p>
	<?php } elseif ((isset($_smarty_tpl->tpl_vars['confirmation']->value)) && $_smarty_tpl->tpl_vars['confirmation']->value == 2) {?>
	<p class="alert alert-success"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'A confirmation email has been sent to your address:'),$_smarty_tpl ) );?>
 <?php if ((isset($_smarty_tpl->tpl_vars['customer_email']->value))) {
echo stripslashes(htmlspecialchars($_smarty_tpl->tpl_vars['customer_email']->value, ENT_QUOTES, 'UTF-8', true));
}?></p>
	<?php } else { ?>
	<p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please enter the email address you used to register. We will then send you a new password. '),$_smarty_tpl ) );?>
</p>
	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_135079598068191caa5c14b9_94853062', 'password_form', $this->tplIndex);
?>

	<?php }?>
	</div>
	<ul class="clearfix footer_links">
		<li><a class="btn button button-small" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('authentication'), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Back to Login'),$_smarty_tpl ) );?>
" rel="nofollow"><span><i class="icon-chevron-left"></i>&nbsp;<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Back to Login'),$_smarty_tpl ) );?>
</span></a></li>
	</ul>
<?php
}
}
/* {/block 'password'} */
}
