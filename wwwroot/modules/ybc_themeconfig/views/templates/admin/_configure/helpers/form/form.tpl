{*
* Copyright: YourBestCode.Com
* Email: support@yourbestcode.com
*}
{extends file="helpers/form/form.tpl"}
{block name="field"}
    {if $input.type != 'backgroundimg'}
        {$smarty.block.parent}
    {elseif $input.type == 'backgroundimg'}
        <div class="col-lg-9">
            <input type="hidden" id="YBC_TC_BG_IMG" name="{$input.name}" value="{$fields_value.YBC_TC_BG_IMG}" />
            <ul style="float: left; padding: 0; margin-top: 5px;">
                {if $input.bgs}
                    {foreach from=$input.bgs item='bg'}
                        <li style="list-style: none; cursor: pointer; display: inline-block; margin: 0 2px;"><span class="ybc-img-span" rel={$bg} style="width: 50px; height: 50px; display: inline-block; background: url('{$base_url}modules/ybc_themeconfig/bgs/{$bg}.png'); border: 1px solid {if $fields_value.YBC_TC_BG_IMG==$bg}#0176B5{else}#eee{/if};"></span></li>
                    {/foreach}
                {/if}
            </ul>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.ybc-img-span').click(function(){
                    $('#YBC_TC_BG_IMG').val($(this).attr('rel'));
                    $('.ybc-img-span').css('border-color','#eee');
                    $(this).css('border-color','#0176B5');
                });
            });
        </script>
    {/if}
{/block}

{block name="footer"}
    {capture name='form_submit_btn'}{counter name='form_submit_btn'}{/capture}
	{if isset($fieldset['form']['submit']) || isset($fieldset['form']['buttons'])}
		<div class="panel-footer">
            {if isset($reset_url) && $reset_url}
                <a title="{l s='Reset to default parameters'}" onclick="return confirm('{l s='You are going to reset all parameters to default. Do you confirm?'}');" class="btn btn-default" href="{$reset_url}"><i class="process-icon-refresh"></i>Reset</a>
            {/if}
            {if isset($fieldset['form']['submit']) && !empty($fieldset['form']['submit'])}
			<button type="submit" value="1"	id="{if isset($fieldset['form']['submit']['id'])}{$fieldset['form']['submit']['id']}{else}{$table}_form_submit_btn{/if}{if $smarty.capture.form_submit_btn > 1}_{($smarty.capture.form_submit_btn - 1)|intval}{/if}" name="{if isset($fieldset['form']['submit']['name'])}{$fieldset['form']['submit']['name']}{else}{$submit_action}{/if}{if isset($fieldset['form']['submit']['stay']) && $fieldset['form']['submit']['stay']}AndStay{/if}" class="{if isset($fieldset['form']['submit']['class'])}{$fieldset['form']['submit']['class']}{else}btn btn-default pull-right{/if}">
				<i class="{if isset($fieldset['form']['submit']['icon'])}{$fieldset['form']['submit']['icon']}{else}process-icon-save{/if}"></i> {$fieldset['form']['submit']['title']}
			</button>
			{/if}
            
		</div>
	{/if}
{/block}