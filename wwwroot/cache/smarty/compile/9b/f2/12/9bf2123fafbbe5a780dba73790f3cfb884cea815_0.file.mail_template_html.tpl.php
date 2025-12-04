<?php
/* Smarty version 3.1.39, created on 2025-05-11 18:00:15
  from '/www/wwwroot/prestigehotel.org/modules/bankwire/views/templates/mail/mail_template_html.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_6820e5af7ef366_33230701',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9bf2123fafbbe5a780dba73790f3cfb884cea815' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/bankwire/views/templates/mail/mail_template_html.tpl',
      1 => 1742139884,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6820e5af7ef366_33230701 (Smarty_Internal_Template $_smarty_tpl) {
?><tr>
	<td class="box" style="border:1px solid #D6D4D4;background-color:#f8f8f8;padding:7px 0">
		<table class="table" style="width:100%">
			<tr>
				<td width="10" style="padding:7px 0">&nbsp;</td>
				<td style="padding:7px 0">
					<font size="2" face="Open-sans, sans-serif" color="#555454">
                        <p style="border-bottom:1px solid #D6D4D4;margin:3px 0 7px;text-transform:uppercase;font-weight:500;font-size:18px;padding-bottom:10px">
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Here are the Mobile Money details for your payment:','mod'=>'bankwire','lang'=>$_smarty_tpl->tpl_vars['lang']->value),$_smarty_tpl ) );?>

                        </p>
                        <span style="color:#777">
                            <span style="color:#333"><strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Amount:','mod'=>'bankwire','lang'=>$_smarty_tpl->tpl_vars['lang']->value),$_smarty_tpl ) );?>
</strong></span> {total_paid}<br />
                            <span style="color:#333"><strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Account Name:','mod'=>'bankwire','lang'=>$_smarty_tpl->tpl_vars['lang']->value),$_smarty_tpl ) );?>
</strong></span> <?php echo $_smarty_tpl->tpl_vars['bankwire_owner']->value;?>
<br />
                            <span style="color:#333"><strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Network Provider:','mod'=>'bankwire','lang'=>$_smarty_tpl->tpl_vars['lang']->value),$_smarty_tpl ) );?>
</strong></span> <?php echo $_smarty_tpl->tpl_vars['bankwire_details']->value;?>
<br />
                            <span style="color:#333"><strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Mobile Money Number:','mod'=>'bankwire','lang'=>$_smarty_tpl->tpl_vars['lang']->value),$_smarty_tpl ) );?>
</strong></span> <?php echo $_smarty_tpl->tpl_vars['bankwire_address']->value;?>

                        </span>
                    </font>
                </td>
                <td width="10" style="padding:7px 0">&nbsp;</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
	<td class="space_footer" style="padding:0!important">&nbsp;</td>
</tr><?php }
}
