<?php
/* Smarty version 3.1.39, created on 2025-03-12 12:40:57
  from '/home/site/wwwroot/modules/qlochannelmanagerconnector/views/templates/admin/qloapps_channel_manager_connector/channel_manager_connect_info.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d180d9b3d863_40407134',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1ee634f8e9dbc063aea1d08ea021aeb361a05f45' => 
    array (
      0 => '/home/site/wwwroot/modules/qlochannelmanagerconnector/views/templates/admin/qloapps_channel_manager_connector/channel_manager_connect_info.tpl',
      1 => 1741272716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67d180d9b3d863_40407134 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="qcm_content_wrapper">
    <div class="row">
        <div class="col-md-12 qcm_block_wrapper">
            <div class="qcm_info_block">
                <div class="row">
                    <div class="col-sm-6 margin-bottom-10">
                        <span class="connect_status_heading"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Connection status','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
 :</span> <span class="not_connect_txt"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Not Connected','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
</span>
                    </div>
                    <div class="col-sm-6 channel_connection_info margin-bottom-10">
                        <span class="channel_info_type"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Last updated','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
 :</span> <span><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['current_datetime']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
                    </div>

                    <div class="connect_info_txt col-sm-12 margin-bottom-10">
                        **<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Connection status with channel manager is showing according to the bookings fetched from QloApps Channel Manager.','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row flex-display">
        <div class="col-md-6 qcm_block_wrapper padding-left-10 flex-display">
            <div class="qcm_info_block">
                <div class="row flex-display">
                    <div class="col-md-2 qcm_info_img_container">
                        <img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getMediaLink(((string)$_smarty_tpl->tpl_vars['module_dir']->value)."/qlochannelmanagerconnector/views/img/channel_manager_connect.png"), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" class="img-responsive">
                    </div>
                    <div class="col-md-10 qcm_info_wrapper">
                        <div class="qcm_info_block_head">
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'How to connect with channel manager?','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>

                        </div>
                        <div class="qcm_info_block_content">
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'You can connect with channel manager through few simple steps','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
 :
                            <ul>
                                <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Enable QloApps webservice from Webservice tab.','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
 <a target="blank" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminWebservice');?>
"><i class="icon-external-link"></i></a></li>
                                <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Create your webservice key and enable all the APIs from Webservice tab.','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
 <a target="blank" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminWebservice');?>
"><i class="icon-external-link"></i></a></li>
                                <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Create account on Channel Manager','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
 <a target="blank" class="qcm-link" href="https://channels.qloapps.com/"><i class="icon-external-link"></i></a>. <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' Then enter QloApps webservice credentials under PMS settings of channel manager .','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
</li>
                                <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Synchronize and map QloApps hotels and room types in channel manager.','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
</li>
                            </ul>

                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'To read the connection process in detail, visit','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
 <a class="qcm-link" href="https://qloapps.com/qloapps-channel-manager/#section-24"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Connection with PMS','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
</a>
                        </div>
                        <div class="qcm_info_explore">
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'If you are still not connected with channel manager','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
 <a class="qcm-link" href="https://channels.qloapps.com/"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Connect It Now','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 qcm_block_wrapper padding-right-10 flex-display">
            <div class="qcm_info_block">
                <div class="row flex-display">
                    <div class="col-md-2 qcm_info_img_container">
                        <img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getMediaLink(((string)$_smarty_tpl->tpl_vars['module_dir']->value)."/qlochannelmanagerconnector/views/img/channel_manager.png"), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" class="img-responsive">
                    </div>
                    <div class="col-md-10 qcm_info_wrapper">
                        <div class="qcm_info_block_head">
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'What is channel manager?','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>

                        </div>
                        <div class="qcm_info_block_content">
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'A channel manager is a centralized software that synchronizes availabilities and details of the property across all platforms i.e. online travel agencies (OTA) and other online distribution channels.','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>

                            <br>
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'QloApps channel manager synchronizes inventory, rates, restrictions with all connected OTA channels and automated bookings sync connected OTAs and QloApps PMS.','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>

                        </div>
                        <div class="qcm_info_explore">
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'For channel manager information in detail','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
 <a class="qcm-link" href="https://qloapps.com/channel-manager/"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Explore Channel Manager','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 qcm_block_wrapper">
            <div class="qcm_info_block">
                <div class="row flex-display">
                    <div class="col-md-1 qcm_info_img_container">
                        <img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getMediaLink(((string)$_smarty_tpl->tpl_vars['module_dir']->value)."/qlochannelmanagerconnector/views/img/channel_manager_advantage.png"), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" class="img-responsive">
                    </div>
                    <div class="col-md-11 qcm_info_wrapper">
                        <div class="qcm_info_block_head">
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Advantages of Channel Manager','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>

                        </div>
                        <div class="qcm_info_block_content">
                            <ul>
                                <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Hoteliers need not to worry about problems like over-bookings, inconsistent inventory management, and missed opportunities.','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
</li>
                                <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Real-time sync with the world\'s most popular OTA channels like Booking, MakeMyTrip, Expedia, Airbnb, Agoda, Google Hotels, and many more.','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
</li>
                                <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Provides an intuitive & analytical dashboard that brings useful data and stats.','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
</li>
                                <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'With the one-click rate and inventory updates, directly push availability and rates on the connected OTA channels.','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
</li>
                                <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Already integrated with QloApps PMS that auto-synchronize inventories for the bookings created on QloApps PMS and connected OTA channels.','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
</li>
                                <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Getting more property impressions by travellers on the world’s leading Online Travel Agencies as well as on the QloApps Hotel booking website will boost your online brand visibility and returns you more reservations.','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
</li>
                            </ul>
                        </div>
                        <div class="qcm_info_explore">
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'To know channel manager freatures and work-flow in details','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
 <a class="qcm-link" href="https://qloapps.com/qloapps-channel-manager/"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Visit Documentation','mod'=>'qlochannelmanagerconnector'),$_smarty_tpl ) );?>
</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }
}
