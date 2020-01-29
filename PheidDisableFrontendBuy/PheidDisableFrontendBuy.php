<?php declare(strict_types=1);

namespace PheidDisableFrontendBuy;

use Shopware\Components\Model\ModelManager;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

/**
 * Shopware-Plugin PheidDisableFrontendBuy.
 */
class PheidDisableFrontendBuy extends Plugin
{
    public function install(InstallContext $context)
    {
        $this->createArticleAttribute();
        parent::install($context);
    }

    public function uninstall(UninstallContext $context)
    {
        if (!$context->keepUserData()) {
            $service = $this->container->get('shopware_attribute.crud_service');
            $service->delete('s_articles_attributes', 'pheid_disable_buying');
        }

        parent::uninstall($context);
    }

    protected function createArticleAttribute(): void
    {
        $service = $this->container->get('shopware_attribute.crud_service');
        $service->update(
            's_articles_attributes',
            'pheid_disable_buying',
            'boolean',
            [
                'label' => 'Disable buying product',
            ]
        );

        /** @var ModelManager $em */
        $em = $this->container->get('models');

        // shouldn't be needed but had problems without
        $metaDataCache = $em->getConfiguration()->getMetadataCacheImpl();
        if ($metaDataCache && method_exists($metaDataCache, 'deleteAll')) {
            $metaDataCache->deleteAll();
        }
    }
}
