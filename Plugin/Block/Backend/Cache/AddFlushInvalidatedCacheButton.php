<?php
declare(strict_types=1);

namespace Pierzakp\CacheManagementSelective\Plugin\Block\Backend\Cache;

use Magento\Backend\Block\Cache as Subject;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\UrlInterface;

/**
 * Plugin object which adds flush invalidated cache button.
 */
class AddFlushInvalidatedCacheButton
{
    /**
     * @var AuthorizationInterface
     */
    private $authorization;
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @param AuthorizationInterface $authorization
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        AuthorizationInterface $authorization,
        UrlInterface $urlBuilder
    ) {
        $this->authorization = $authorization;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @param Subject $subject
     *
     * @return void
     */
    public function beforeSetLayout(Subject $subject): void
    {
        if ($this->authorization->isAllowed('Pierzakp_CacheManagementSelective::flush_invalidated_cache')) {
            $subject->addButton(
                'flush_invalidated_cache',
                [
                    'label' => __('Flush Invalidated Cache'),
                    'onclick' => 'setLocation(\'' . $this->getFlushInvalidatedUrl() . '\')',
                    'class' => 'primary flush-cache-magento',
                ]
            );
        }
    }

    /**
     * Get url for clean invalidated cache.
     *
     * @return string
     */
    private function getFlushInvalidatedUrl(): string
    {
        return $this->urlBuilder->getUrl('pierzakp_cache/index/flushInvalidated');
    }
}
