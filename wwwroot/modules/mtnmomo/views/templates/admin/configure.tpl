{* filepath: c:\xampp\htdocs\modules\mtnmomo\views\templates\admin\configure.tpl *}
<div class="panel">
    <div class="panel-heading">
        <img src="{$module_dir|escape:'html':'UTF-8'}views/img/mtnmomo.png" alt="MTN MoMo" height="25"/>
        &nbsp;
        {l s='MTN Mobile Money (Ghana)' mod='mtnmomo'}
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <h4>{l s='About MTN Mobile Money' mod='mtnmomo'}</h4>
                <p>
                    {l s='This module allows you to accept payments using MTN Mobile Money, a popular mobile payment service in Ghana.' mod='mtnmomo'}
                </p>
                <p>
                    {l s='Your customers will be able to pay with their MTN MoMo accounts directly from your checkout page.' mod='mtnmomo'}
                </p>
            </div>
            
            <div class="col-md-6">
                <h4>{l s='Configuration Instructions' mod='mtnmomo'}</h4>
                <ol>
                    <li>{l s='Sign up for an MTN MoMo developer account at' mod='mtnmomo'} <a href="https://momodeveloper.mtn.com/" target="_blank">momodeveloper.mtn.com</a></li>
                    <li>{l s='Create a new app in the developer portal' mod='mtnmomo'}</li>
                    <li>{l s='Subscribe to the Collection API' mod='mtnmomo'}</li>
                    <li>{l s='Copy your Primary and Secondary Keys' mod='mtnmomo'}</li>
                    <li>{l s='Generate your API User ID and API Key' mod='mtnmomo'}</li>
                    <li>{l s='Enter these details in the settings below' mod='mtnmomo'}</li>
                </ol>
            </div>
        </div>
        
        <hr/>
        
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <p><strong>{l s='Test Mode Information' mod='mtnmomo'}</strong></p>
                    <p>{l s='In sandbox/test mode, you can use the following test credentials:' mod='mtnmomo'}</p>
                    <ul>
                        <li>{l s='Test Phone Number: 233241234567' mod='mtnmomo'}</li>
                        <li>{l s='The MTN MoMo sandbox will automatically approve these test payments' mod='mtnmomo'}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>