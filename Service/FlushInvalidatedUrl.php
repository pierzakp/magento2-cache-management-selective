<?php
declare(strict_types=1);

namespace Pierzakp\CacheManagementSelective\Service;

use Magento\Framework\UrlInterface;

/**
 * Flush invalidated url service object which exposes methods to get flush
 * invalidated cache url.
 */
class FlushInvalidatedUrl
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @param UrlInterface $urlBuilder
     */
    public function __construct(UrlInterface $urlBuilder)
    {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Get url for clean invalidated cache action.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->urlBuilder->getUrl('pierzakp_cache/index/flushInvalidated');
    }
}
