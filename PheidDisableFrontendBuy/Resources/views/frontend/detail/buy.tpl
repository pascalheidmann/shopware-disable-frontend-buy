{extends file="parent:frontend/detail/buy.tpl"}
{block name="frontend_detail_buy"}
    {if !$sArticle.pheid_disable_buying}
        {$smarty.block.parent}
    {else}
        <div class="buybox--button-container block-group">
        {s name="buying_disabled_info" namespace="frontend/pheid_disable_frontend_buy/info"}{/s}
        </div>
    {/if}
{/block}
