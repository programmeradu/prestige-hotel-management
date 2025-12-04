<?php
/* Smarty version 3.1.39, created on 2025-07-07 18:18:54
  from '/www/wwwroot/prestigehotel.org/modules/ybc_nivoslider/views/templates/hook/ybc_nivoslider.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686c0f8e0546f4_67910860',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '52d877adab84fc77c0da5ae6e4d0b6d131c67b8c' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/ybc_nivoslider/views/templates/hook/ybc_nivoslider.tpl',
      1 => 1751908664,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686c0f8e0546f4_67910860 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '1749151373686c0f8e00c711_65744209';
?>

<?php if ($_smarty_tpl->tpl_vars['page_name']->value == 'index') {?>
<!-- Module ybc_nivoslider -->
    <?php if ((isset($_smarty_tpl->tpl_vars['homeslider_slides']->value)) && $_smarty_tpl->tpl_vars['homeslider_slides']->value) {?>
		<div id="ybc-nivo-slider-wrapper" class="theme-default">
			<div id="ybc-nivo-slider"<?php if ((($_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'height') !== null )) && $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'height')) {?> style="max-height:<?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'height');?>
px;"<?php }?>>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['homeslider_slides']->value, 'slide');
$_smarty_tpl->tpl_vars['slide']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['slide']->value) {
$_smarty_tpl->tpl_vars['slide']->do_else = false;
?>
					<?php if ($_smarty_tpl->tpl_vars['slide']->value['active']) {?>
						<a class="ybc-nivo-link" href="<?php if ($_smarty_tpl->tpl_vars['slide']->value['url']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['url'], ENT_QUOTES, 'UTF-8', true);
} else { ?>#<?php }?>" title="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">
						  <img data-caption-skin="<?php if ($_smarty_tpl->tpl_vars['slide']->value['button_type']) {
echo strtolower($_smarty_tpl->tpl_vars['slide']->value['button_type']);
} else { ?>default<?php }?>" data-slide-id="<?php echo $_smarty_tpl->tpl_vars['slide']->value['id_slide'];?>
" data-caption-animate="<?php if ($_smarty_tpl->tpl_vars['slide']->value['caption_animate']) {
echo $_smarty_tpl->tpl_vars['slide']->value['caption_animate'];
} else { ?>random<?php }?>" <?php if ($_smarty_tpl->tpl_vars['slide']->value['slide_effect'] != 'random') {?>data-transition="<?php echo $_smarty_tpl->tpl_vars['slide']->value['slide_effect'];?>
"<?php }?> data-caption1="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-caption2="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['legend'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-caption3="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['legend2'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-text-direction="<?php echo $_smarty_tpl->tpl_vars['slide']->value['caption_text_direction'];?>
" data-caption-top="<?php echo $_smarty_tpl->tpl_vars['slide']->value['caption_top'];?>
" data-caption-left="<?php echo $_smarty_tpl->tpl_vars['slide']->value['caption_left'];?>
" data-caption-right="<?php echo $_smarty_tpl->tpl_vars['slide']->value['caption_right'];?>
" data-caption-width="<?php echo $_smarty_tpl->tpl_vars['slide']->value['caption_width'];?>
" data-caption-position="<?php echo $_smarty_tpl->tpl_vars['slide']->value['caption_position'];?>
"    src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getMediaLink(((string)(defined('_MODULE_DIR_') ? constant('_MODULE_DIR_') : null))."ybc_nivoslider/images/slides/".((string)(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['image'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'))));?>
" alt="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" title="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" style="max-width: <?php echo $_smarty_tpl->tpl_vars['options']->value['max_width'];?>
; max-height: <?php echo $_smarty_tpl->tpl_vars['options']->value['max_height'];?>
;" />						  
                        </a>
                    <?php }?>
				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			</div>
            <div id="ybc-nivo-caption-text-hidden">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['homeslider_slides']->value, 'slide');
$_smarty_tpl->tpl_vars['slide']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['slide']->value) {
$_smarty_tpl->tpl_vars['slide']->do_else = false;
?>
					<?php if ($_smarty_tpl->tpl_vars['slide']->value['active']) {?>
                        <div class="ybc-nivo-description ybc-nivo-description-<?php echo $_smarty_tpl->tpl_vars['slide']->value['id_slide'];?>
"><?php echo $_smarty_tpl->tpl_vars['slide']->value['description'];?>
 <?php if ($_smarty_tpl->tpl_vars['slide']->value['button_text']) {?><p class="ybc_button_slider"><a class="button btn ybc-nivo-button fa-arrow-circle-o-right btn-default" href="<?php if ($_smarty_tpl->tpl_vars['slide']->value['url']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['url'], ENT_QUOTES, 'UTF-8', true);
} else { ?>#<?php }?>"><?php echo $_smarty_tpl->tpl_vars['slide']->value['button_text'];?>
</a></p><?php }?></div>
                    <?php }?>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </div>
            
            <div id="ybc-nivo-slider-loader">
                <div class="ybc-nivo-slider-loader">
                    <div id="ybc-nivo-slider-loader-img">
                        <img src="<?php echo $_smarty_tpl->tpl_vars['ybc_nivo_dir']->value;?>
images/loading.gif" alt=""/>
                    </div>
                </div>
            </div>
		</div>        
	<?php }?>
<!-- /Module ybc_nivoslider -->
<?php }
}
}
