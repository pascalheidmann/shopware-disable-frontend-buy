{extends file="parent:frontend/listing/product-box/box-basic.tpl"}
{block name="frontend_listing_box_article_buy"}
    {if !$sArticle.pheid_disable_buying}
        {$smarty.block.parent}
    {/if}
{/block}
