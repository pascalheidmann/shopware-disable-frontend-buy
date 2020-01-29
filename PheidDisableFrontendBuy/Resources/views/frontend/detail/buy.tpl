{extends file="parent:frontend/detail/buy.tpl"}
{block name="frontend_detail_buy"}
    {if !$sArticle.pheid_disable_buying}
        {$smarty.block.parent}
    {/if}
{/block}
