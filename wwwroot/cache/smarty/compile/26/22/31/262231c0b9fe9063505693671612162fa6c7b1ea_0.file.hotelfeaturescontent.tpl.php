<?php
/* Smarty version 3.1.39, created on 2025-07-07 18:18:53
  from '/www/wwwroot/prestigehotel.org/modules/wkhotelfeaturesblock/views/templates/hook/hotelfeaturescontent.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686c0f8daa6da8_37940273',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '262231c0b9fe9063505693671612162fa6c7b1ea' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/wkhotelfeaturesblock/views/templates/hook/hotelfeaturescontent.tpl',
      1 => 1741272738,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686c0f8daa6da8_37940273 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_382493177686c0f8da50912_19876516', 'hotel_features_block');
?>

<?php }
/* {block 'hotel_features_block_heading'} */
class Block_768932670686c0f8da549c4_67979378 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                                <p class="home_block_heading"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['HOTEL_AMENITIES_HEADING']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</p>
                            <?php
}
}
/* {/block 'hotel_features_block_heading'} */
/* {block 'hotel_features_block_description'} */
class Block_172956824686c0f8da58814_20766522 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                                <p class="home_block_description"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['HOTEL_AMENITIES_DESCRIPTION']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</p>
                            <?php
}
}
/* {/block 'hotel_features_block_description'} */
/* {block 'hotel_features_images'} */
class Block_464101562686c0f8da5c126_96731945 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                    <div class="homeAmenitiesBlock home_block_content">
                        <?php $_smarty_tpl->_assignInScope('amenityPosition', 0);?>
                        <?php $_smarty_tpl->_assignInScope('amenityIteration', 0);?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['hotelAmenities']->value, 'amenity', false, NULL, 'amenityBlock', array (
  'iteration' => true,
));
$_smarty_tpl->tpl_vars['amenity']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['amenity']->value) {
$_smarty_tpl->tpl_vars['amenity']->do_else = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_amenityBlock']->value['iteration']++;
?>

                            <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_amenityBlock']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_amenityBlock']->value['iteration'] : null)%2 != 0) {?>
                                <div class="row margin-lr-0">
                                <?php if ($_smarty_tpl->tpl_vars['amenityPosition']->value) {?>
                                    <?php $_smarty_tpl->_assignInScope('amenityPosition', 0);?>
                                <?php } else { ?>
                                    <?php $_smarty_tpl->_assignInScope('amenityPosition', 1);?>
                                <?php }?>
                            <?php }?>
                                    <div class="col-md-6 padding-lr-0 hidden-xs hidden-sm">
                                        <div class="row margin-lr-0 amenity_content">
                                            <?php if ($_smarty_tpl->tpl_vars['amenityPosition']->value) {?>
                                                <div class="col-md-6 padding-lr-0">
                                                    <div class="amenity_img_primary">

                                                        <div class="amenity_img_secondary" style="background-image: url('<?php echo $_smarty_tpl->tpl_vars['link']->value->getMediaLink(((string)(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8')))."views/img/hotels_features_img/".((string)(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['amenity']->value['id_features_block'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'))).".jpg");?>
')">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 padding-lr-0 amenity_desc_cont">
                                                    <div class="amenity_desc_primary">
                                                        <div class="amenity_desc_secondary">
                                                            <p class="amenity_heading"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['amenity']->value['feature_title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</p>
                                                            <p class="amenity_description"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['amenity']->value['feature_description'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</p>
                                                            <hr class="amenity_desc_hr" />
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="col-md-6 padding-lr-0 amenity_desc_cont">
                                                    <div class="amenity_desc_primary">
                                                        <div class="amenity_desc_secondary">
                                                            <p class="amenity_heading"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['amenity']->value['feature_title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</p>
                                                            <p class="amenity_description"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['amenity']->value['feature_description'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</p>
                                                            <hr class="amenity_desc_hr" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 padding-lr-0">
                                                    <div class="amenity_img_primary">
                                                        <div class="amenity_img_secondary" style="background-image: url('<?php echo $_smarty_tpl->tpl_vars['link']->value->getMediaLink(((string)(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8')))."views/img/hotels_features_img/".((string)(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['amenity']->value['id_features_block'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'))).".jpg");?>
')">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 padding-lr-0 visible-sm">
                                        <div class="row margin-lr-0 amenity_content">
                                            <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_amenityBlock']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_amenityBlock']->value['iteration'] : null)%2 != 0) {?>
                                                <div class="col-sm-6 padding-lr-0">
                                                    <div class="amenity_img_primary">
                                                        <div class="amenity_img_secondary" style="background-image: url('<?php echo $_smarty_tpl->tpl_vars['link']->value->getMediaLink(((string)(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8')))."views/img/hotels_features_img/".((string)(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['amenity']->value['id_features_block'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'))).".jpg");?>
')">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 padding-lr-0 amenity_desc_cont">
                                                    <div class="amenity_desc_primary">
                                                        <div class="amenity_desc_secondary">
                                                            <p class="amenity_heading"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['amenity']->value['feature_title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</p>
                                                            <p class="amenity_description"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['amenity']->value['feature_description'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</p>
                                                            <hr class="amenity_desc_hr" />
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="col-sm-6 padding-lr-0 amenity_desc_cont">
                                                    <div class="amenity_desc_primary">
                                                        <div class="amenity_desc_secondary">
                                                            <p class="amenity_heading"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['amenity']->value['feature_title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</p>
                                                            <p class="amenity_description"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['amenity']->value['feature_description'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</p>
                                                            <hr class="amenity_desc_hr" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 padding-lr-0">
                                                    <div class="amenity_img_primary">
                                                        <div class="amenity_img_secondary" style="background-image: url('<?php echo $_smarty_tpl->tpl_vars['link']->value->getMediaLink(((string)(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8')))."views/img/hotels_features_img/".((string)(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['amenity']->value['id_features_block'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'))).".jpg");?>
')">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 padding-lr-0 visible-xs">
                                        <div class="row margin-lr-0 amenity_content">
                                            <div class="col-xs-12 padding-lr-0">
                                                <div class="amenity_img_primary">
                                                    <div class="amenity_img_secondary" style="background-image: url('<?php echo $_smarty_tpl->tpl_vars['link']->value->getMediaLink(((string)(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8')))."views/img/hotels_features_img/".((string)(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['amenity']->value['id_features_block'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'))).".jpg");?>
')">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 padding-lr-0 amenity_desc_cont">
                                                <div class="amenity_desc_primary">
                                                    <div class="amenity_desc_secondary">
                                                        <p class="amenity_heading"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['amenity']->value['feature_title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</p>
                                                        <p class="amenity_description"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['amenity']->value['feature_description'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</p>
                                                        <hr class="amenity_desc_hr" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_amenityBlock']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_amenityBlock']->value['iteration'] : null)%2 == 0) {?>
                                </div>
                            <?php }?>
                            <?php $_smarty_tpl->_assignInScope('amenityIteration', (isset($_smarty_tpl->tpl_vars['__smarty_foreach_amenityBlock']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_amenityBlock']->value['iteration'] : null));?>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        <?php if ($_smarty_tpl->tpl_vars['amenityIteration']->value%2) {?>
                            </div>
                        <?php }?>
                    </div>
                <?php
}
}
/* {/block 'hotel_features_images'} */
/* {block 'hotel_features_block'} */
class Block_382493177686c0f8da50912_19876516 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hotel_features_block' => 
  array (
    0 => 'Block_382493177686c0f8da50912_19876516',
  ),
  'hotel_features_block_heading' => 
  array (
    0 => 'Block_768932670686c0f8da549c4_67979378',
  ),
  'hotel_features_block_description' => 
  array (
    0 => 'Block_172956824686c0f8da58814_20766522',
  ),
  'hotel_features_images' => 
  array (
    0 => 'Block_464101562686c0f8da5c126_96731945',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php if ((isset($_smarty_tpl->tpl_vars['hotelAmenities']->value)) && $_smarty_tpl->tpl_vars['hotelAmenities']->value) {?>
        <div id="hotelAmenitiesBlock" class="row home_block_container">
            <div class="col-xs-12 col-sm-12 home_amenities_wrapper">
                <?php if ($_smarty_tpl->tpl_vars['HOTEL_AMENITIES_HEADING']->value && $_smarty_tpl->tpl_vars['HOTEL_AMENITIES_DESCRIPTION']->value) {?>
                    <div class="row home_block_desc_wrapper">
                        <div class="col-md-offset-1 col-md-10 col-lg-offset-2 col-lg-8">
                            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_768932670686c0f8da549c4_67979378', 'hotel_features_block_heading', $this->tplIndex);
?>

                            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_172956824686c0f8da58814_20766522', 'hotel_features_block_description', $this->tplIndex);
?>

                            <hr class="home_block_desc_line"/>
                        </div>
                    </div>
                <?php }?>
                <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_464101562686c0f8da5c126_96731945', 'hotel_features_images', $this->tplIndex);
?>

            </div>
            <hr class="home_block_seperator"/>
        </div>
    <?php }
}
}
/* {/block 'hotel_features_block'} */
}
