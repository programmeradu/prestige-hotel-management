{*
* 2024-2025 Prestige Hotel.
*
* @author    Prestige Hotel <info@prestigehotel.com>
* @copyright 2024-2025 Prestige Hotel
* @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
*}

{block name='events_feed_block'}
<div id="eventsFeedBlock" class="row home_block_container">
    <div class="col-xs-12 col-sm-12">
        <div class="row home_block_desc_wrapper">
            <div class="col-md-offset-1 col-md-10 col-lg-offset-2 col-lg-8">
                <p class="home_block_heading">{l s='Local Events & Experiences' mod='eventsfeed'}</p>
                <p class="home_block_description">{l s='Discover what\'s happening in Cape Coast during your stay' mod='eventsfeed'}</p>
                <hr class="home_block_desc_line"/>
            </div>
        </div>

        <div id="eventsGrid" class="events-feed-grid" data-feed-url="{$events_feed_url|escape:'htmlall':'UTF-8'}">
            {if isset($events) && $events}
                {foreach from=$events item=event name=eventLoop}
                    <div class="event-card" data-event-id="{$event.id|escape:'htmlall':'UTF-8'}">
                        <div class="event-image">
                            {if $event.image}
                                <img src="{$event.image|escape:'htmlall':'UTF-8'}" alt="{$event.title|escape:'htmlall':'UTF-8'}" loading="lazy">
                            {else}
                                <div class="event-image-placeholder">
                                    <i class="icon-calendar"></i>
                                </div>
                            {/if}
                            <div class="event-date-badge">
                                <span class="event-month">
                                    {$event.start|date_format:"%b"|escape:'htmlall':'UTF-8'}
                                </span>
                                <span class="event-day">
                                    {$event.start|date_format:"%d"|escape:'htmlall':'UTF-8'}
                                </span>
                            </div>
                            {if $event.source == 'demo'}
                                <span class="event-source-badge">{l s='Sample' mod='eventsfeed'}</span>
                            {/if}
                        </div>
                        <div class="event-content">
                            <span class="event-category">{$event.category|escape:'htmlall':'UTF-8'}</span>
                            <h3 class="event-title">{$event.title|escape:'htmlall':'UTF-8'}</h3>
                            <p class="event-description">{$event.description|escape:'htmlall':'UTF-8'}</p>
                            <div class="event-meta">
                                {if $event.venue.name}
                                    <span class="event-venue">
                                        <i class="icon-map-marker"></i>
                                        {$event.venue.name|escape:'htmlall':'UTF-8'}
                                    </span>
                                {/if}
                            </div>
                            {if $event.url && $event.url != '#'}
                                <a href="{$event.url|escape:'htmlall':'UTF-8'}" class="event-link" target="_blank" rel="noopener">
                                    {l s='Learn More' mod='eventsfeed'}
                                    <i class="icon-angle-right"></i>
                                </a>
                            {/if}
                        </div>
                    </div>
                {/foreach}
            {else}
                {* Skeleton loading cards *}
                {for $i=1 to 4}
                    <div class="event-card event-skeleton">
                        <div class="event-image skeleton-img"></div>
                        <div class="event-content">
                            <div class="skeleton-text skeleton-category"></div>
                            <div class="skeleton-text skeleton-title"></div>
                            <div class="skeleton-text skeleton-desc"></div>
                            <div class="skeleton-text skeleton-meta"></div>
                        </div>
                    </div>
                {/for}
            {/if}
        </div>
    </div>
    <hr class="home_block_seperator"/>
</div>
{/block}



