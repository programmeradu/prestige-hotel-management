<?php
/* Smarty version 3.1.39, created on 2025-07-09 08:49:58
  from '/www/wwwroot/prestigehotel.org/modules/psaddonsconnect/views/templates/hook/dashboard_zone_one.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686e2d363013d3_87760130',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7debf99ef48efd4c67afe23ebda15b115098c0bf' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/psaddonsconnect/views/templates/hook/dashboard_zone_one.tpl',
      1 => 1751908664,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686e2d363013d3_87760130 (Smarty_Internal_Template $_smarty_tpl) {
?>
<section id="psaddonsconnect" class="panel widget">
	<div class="panel-heading">
		<i class="icon-puzzle-piece"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'TIPS & UPDATES','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>

	</div>

    <?php if ($_smarty_tpl->tpl_vars['logged_on_addons17']->value == 0 && $_smarty_tpl->tpl_vars['logged_on_addons']->value == 0) {?>
    	<span> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Connect to your account right now to enjoy updates (security and features) on all of your modules.','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
 </span>  <p><br>
		<span> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Once you are connected, you will also enjoy weekly tips directly from your back office.','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
 </span> <p><br>

		<!-- Check PS VERSION TO SHOW OR NOT THE MODAL-->
	    <?php if ($_smarty_tpl->tpl_vars['ps_version']->value == 1) {?>
			<!-- PS17 MODAL-->
		    <div align="center">
		        <a class="btn btn-info" style="white-space: unset;" href="#" data-toggle="modal" data-target="#ps-module-modal-addons-connect">
		            <i class="icon-unlock"> </i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'CONNECT TO PRESTASHOP MARKETPLACE','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>

		        </a>
		    </div>
		    <div id="ps-module-modal-addons-connect" class="modal  modal-vcenter fade" role="dialog">
		        <div class="modal-dialog">
		            <!-- Modal content-->
		            <div class="modal-content">
		                <div class="modal-header">
		                    <button type="button" class="close" data-dismiss="modal">&times;</button>
		                    <h2 class="modal-title module-modal-title"> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Connect to PrestaShop marketplace','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
 </h2>
		                </div>
		                <div class="modal-body">
		                    <div class="row">
		                        <div class="col-md-12">
		                            <p>
		                                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Link your shop to your Addons account to automatically receive important updates for the modules you purchased. Don\'t have an account yet ?','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>

		                                <a href="http://addons.prestashop.com/authentication.php" target="_blank"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Sign up now','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
</a>
		                            </p><br>
		                            <form id="ps-addons-connect-form"  action="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['url_connexion']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" method="POST">
		                                <div class="form-group">
		                                    <label for="ps-module-addons-connect-email"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Email address','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
</label>
		                                    <input name="username_addons" type="email" class="form-control" id="ps-module-addons-connect-email" placeholder="Email">
		                                </div><br>
		                                <div class="form-group">
		                                    <label for="ps-module-addons-connect-password"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Password','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
</label>
		                                    <input name="password_addons" type="password" class="form-control" id="ps-module-addons-connect-password" placeholder="Password">
		                                </div><br>
		                                <div class="checkbox">
		                                    <label>
		                                        <input name="addons_remember_me" type="checkbox"> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Remember me','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>

		                                    </label>
		                                </div>
		                                <button type="submit" class="btn btn-primary"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'LET\'S GO !','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
</button>
		                                <button id="ps-addons_login_btn" class="btn btn-primary-reverse btn-lg onclick" style="display:none;"></button>
		                            </form>
		                            <p>
		                                <a href="http://addons.prestashop.com/password.php" target="_blank"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Forgot your password?','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
</a>
		                            </p>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
	    <?php } else { ?>
	    	<!-- SHOW 1.6 MODAL -->
			<div align="center">
				<a class="btn btn-info" style="white-space: unset;" href="#" onclick="psGetModal();">
					<i class="icon-unlock"> </i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'CONNECT TO PRESTASHOP MARKETPLACE','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>

				</a>
			</div>
		<?php }?>
    <?php } else { ?>
    	<!-- CONNECTED TO ADDONS -->
		<header>
			<h4> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Tip of the moment','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
 </h4><p><br>
		</header>
		<img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['img_path']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
lamp-selection-moment.jpg" alt="lamp" class="pull-left">

		<div class="row">
			<div class="col-md-10">
				<p>
					<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['advice']->value);?>

				</p>
			</div>
		</div>

		<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link_advice']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" target="_blank" class="pull-right"> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'See the entire selection','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
 > </a> <p><br>
		<h4> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Practical links','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
 </h4>

		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Modules to','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
 <a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['practical_links']->value['traffic'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" target="_blank"> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'increase your traffic','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
 ></a><br>
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Modules to','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
 <a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['practical_links']->value['conversion'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" target="_blank"> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'boost your conversions','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
 ></a><br>
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Modules to','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
 <a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['practical_links']->value['averageCart'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" target="_blank"> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'increase your clients\' average cart','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
 ></a><br>
        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Selection of modules recommended for','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
 <a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['practical_links']->value['businessSector'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" target="_blank"> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'your business sector','mod'=>'psaddonsconnect'),$_smarty_tpl ) );?>
 ></a><br>

    <?php }?>
</section><?php }
}
