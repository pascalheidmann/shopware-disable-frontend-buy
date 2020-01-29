<?php declare(strict_types=1);

namespace PheidDisableFrontendBuy\Subscriber;

use Doctrine\DBAL\Connection;
use Enlight\Event\SubscriberInterface;
use Enlight_Event_EventArgs;
use Enlight_Template_Manager;

class Frontend implements SubscriberInterface
{
    /**
     * @var Connection
     */
    private $connection;
    /**
     * @var Enlight_Template_Manager
     */
    private $template;
    /**
     * @var string
     */
    private $pluginDir;

    public function __construct(Connection $connection, Enlight_Template_Manager $template, string $pluginDir)
    {
        $this->connection = $connection;
        $this->template = $template;
        $this->pluginDir = $pluginDir;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'Shopware_Modules_Basket_AddArticle_Start' => 'onArticleAdd',
            'Enlight_Controller_Action_PreDispatch' => 'onAddTemplateDir',
        ];
    }

    public function onArticleAdd(Enlight_Event_EventArgs $args): bool
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->from('s_articles_details', 'details')
            ->leftJoin('details', 's_articles_attributes', 'attr', 'attr.detailId = details.id')
            ->select('attr.pheid_disable_buying')
            ->where('details.ordernumber = :number')
            ->setParameter('number', $args->get('id'))
            ->setMaxResults(1);

        $result = $qb->execute()->fetchColumn();

        return (bool) $result;
    }

    public function onAddTemplateDir(): void
    {
        $this->template->addTemplateDir($this->pluginDir . '/Resources/views/');
    }
}
