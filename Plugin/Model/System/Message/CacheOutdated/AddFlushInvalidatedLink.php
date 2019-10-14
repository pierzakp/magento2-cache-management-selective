<?php
declare(strict_types=1);

namespace Pierzakp\CacheManagementSelective\Plugin\Model\System\Message\CacheOutdated;

use Magento\AdminNotification\Model\System\Message\CacheOutdated as Subject;
use Magento\Framework\AuthorizationInterface;
use Pierzakp\CacheManagementSelective\Service\FlushInvalidatedUrl;

/**
 * Plugin object which adds flush invalidated cache link.
 */
class AddFlushInvalidatedLink
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
     * @param string $result
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetText(Subject $subject, string $result): string
    {
        if ($this->authorization->isAllowed('Pierzakp_CacheManagementSelective::flush_invalidated_cache')) {
            $result = \sprintf(
                '%s %s',
                $result,
                \__(
                    'You can also <a href="%1">click here to flush invalidated cache</a> quickly.',
                    $this->urlService->getUrl()
                )
            );
        }

        return $result;
    }
}
