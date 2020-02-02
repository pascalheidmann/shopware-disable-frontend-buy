{extends file="parent:frontend/plugins/index/delivery_informations.tpl"}
{block name='frontend_widgets_delivery_infos'}
    {if !$sArticle.pheid_disable_buying}
        {$smarty.block.parent}
    {/if}
{/block}
