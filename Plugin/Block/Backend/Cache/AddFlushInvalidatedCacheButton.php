<?php
declare(strict_types=1);

namespace Pierzakp\CacheManagementSelective\Plugin\Block\Backend\Cache;

use Magento\Backend\Block\Cache as Subject;
use Magento\Framework\AuthorizationInterface;
use Pierzakp\CacheManagementSelective\Service\FlushInvalidatedUrl;

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
     * @var FlushInvalidatedUrl
     */
    private $urlService;

    /**
     * @param AuthorizationInterface $authorization
     * @param FlushInvalidatedUrl $urlService
     */
    public function __construct(
        AuthorizationInterface $authorization,
        FlushInvalidatedUrl $urlService
    ) {
        $this->authorization = $authorization;
        $this->urlService = $urlService;
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
                    'onclick' => 'setLocation(\'' . $this->urlService->getUrl() . '\')',
                    'class' => 'primary flush-cache-magento',
                ]
            );
        }
    }
}
