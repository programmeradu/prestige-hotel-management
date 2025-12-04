{if $advancedCats}
    <ul class="ybc_advancedcats_backend">
        {foreach from=$advancedCats item='cat'}
            {if $cat.category}
                <li class="ybc_ac_item" rel="{$cat.id_category}">
                    <div class="ac-content">
                        <h6>{$cat.title}</h6>
                        {if $cat.description}
                            <div class="ybc_ac_desc">
                                {$cat.description|truncate:45:'...'|escape:'html':'UTF-8'}
                            </div>
                        {/if}                        
                    </div>
                    <div class="ac_button">
                        <ul>
                            <li><a href="{$cat.enabled_link}"> {if !$cat.enabled}<i title="{l s='Disable this item'}" class="icon-remove"></i>{else}<i title="{l s='Enable this item'}" class="icon-check"></i>{/if}</a></li>
                            <li><a href="{$cat.edit_link}"><i class="icon-pencil"></i> {*l s='Edit'*}</a></li>
                            <li><a href="{$cat.delete_link}" onclick="return confirm('{l s='Do you want to delete this item?'}');"><i class="icon-trash"></i> {*l s='Delete'*}</a></li>
                        </ul>
                    </div>
                </li>
            {/if}
        {/foreach}
    </ul>
{/if}