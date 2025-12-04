<?php
/* Smarty version 3.1.39, created on 2025-05-07 15:58:01
  from '/www/wwwroot/prestigehotel.org/modules/statsforecast/views/templates/conversion.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_681b83094d25a9_99166451',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4fec2afed004659d13bea8c6e5e2828454a552e1' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/statsforecast/views/templates/conversion.tpl',
      1 => 1741272728,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_681b83094d25a9_99166451 (Smarty_Internal_Template $_smarty_tpl) {
?>
 <div class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-1 col-md-10 col-lg-offset-3 col-lg-6">
 <div class="col-xs-12 graph-level">
     <div class="stat-boxes">
         <div class="stat-box" id="graph-visitors" data-connection-to='["stat-visitors-registered", "stat-visitors-unregistered"]'>
             <p class="text-center"><b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Visitors','mod'=>'statsforecast'),$_smarty_tpl ) );?>
</b></p>
             <p class="text-center"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['conversion_graph_data']->value['values']['visitors'], ENT_QUOTES, 'UTF-8', true);?>
</p>
         </div>
     </div>
 </div>
 <div class="col-xs-12 graph-level">
     <div class="stat-box" id="stat-visitors-registered" data-connection-to="stat-carts-registered">
         <p class="text-center"><b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Registered','mod'=>'statsforecast'),$_smarty_tpl ) );?>
</b></p>
         <p class="text-center"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['conversion_graph_data']->value['values']['visitors_registered'], ENT_QUOTES, 'UTF-8', true);?>
 (<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['conversion_graph_data']->value['percentages']['visitors_registered'], ENT_QUOTES, 'UTF-8', true);?>
%)</p>
     </div>
     <div class="stat-box" id="stat-visitors-unregistered" data-connection-to="stat-carts-unregistered">
         <p class="text-center"><b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Unregistered','mod'=>'statsforecast'),$_smarty_tpl ) );?>
</b></p>
         <p class="text-center"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['conversion_graph_data']->value['values']['visitors_unregistered'], ENT_QUOTES, 'UTF-8', true);?>
 (<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['conversion_graph_data']->value['percentages']['visitors_unregistered'], ENT_QUOTES, 'UTF-8', true);?>
%)</p>
     </div>
 </div>
 <div class="col-xs-12 graph-level">
     <div class="stat-box" id="stat-carts-registered" data-connection-to="stat-orders" data-percentage="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['conversion_graph_data']->value['percentages']['orders_top_registered'], ENT_QUOTES, 'UTF-8', true);?>
">
         <p class="text-center"><b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Carts','mod'=>'statsforecast'),$_smarty_tpl ) );?>
</b></p>
         <p class="text-center"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['conversion_graph_data']->value['values']['carts_registered'], ENT_QUOTES, 'UTF-8', true);?>
</p>
     </div>
     <div class="stat-box" id="stat-carts-unregistered" data-connection-to="stat-orders" data-percentage="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['conversion_graph_data']->value['percentages']['orders_top_unregistered'], ENT_QUOTES, 'UTF-8', true);?>
">
         <p class="text-center"><b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Carts','mod'=>'statsforecast'),$_smarty_tpl ) );?>
</b></p>
         <p class="text-center"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['conversion_graph_data']->value['values']['carts_unregistered'], ENT_QUOTES, 'UTF-8', true);?>
</p>
     </div>
 </div>
 <div class="col-xs-12 graph-level">
     <div class="stat-boxes">
         <div class="stat-box" id="stat-orders" data-connection-to='["stat-orders-registered", "stat-orders-unregistered"]'>
             <p class="text-center"><b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Orders','mod'=>'statsforecast'),$_smarty_tpl ) );?>
</b></p>
             <p class="text-center"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['conversion_graph_data']->value['values']['orders'], ENT_QUOTES, 'UTF-8', true);?>
</p>
         </div>
     </div>
 </div>
 <div class="col-xs-12 graph-level">
     <div class="stat-box" id="stat-orders-registered">
         <p class="text-center"><b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Registered','mod'=>'statsforecast'),$_smarty_tpl ) );?>
</b></p>
         <p class="text-center"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['conversion_graph_data']->value['values']['orders_registered'], ENT_QUOTES, 'UTF-8', true);?>
 (<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['conversion_graph_data']->value['percentages']['orders_bottom_registered'], ENT_QUOTES, 'UTF-8', true);?>
%)</p>
     </div>
     <div class="stat-box" id="stat-orders-unregistered">
         <p class="text-center"><b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Unregistered','mod'=>'statsforecast'),$_smarty_tpl ) );?>
</b></p>
         <p class="text-center"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['conversion_graph_data']->value['values']['orders_unregistered'], ENT_QUOTES, 'UTF-8', true);?>
 (<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['conversion_graph_data']->value['percentages']['orders_bottom_unregistered'], ENT_QUOTES, 'UTF-8', true);?>
%)</p>
     </div>
 </div>
</div>
<?php }
}
