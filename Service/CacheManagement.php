<?php
declare(strict_types=1);

namespace Pierzakp\CacheManagementSelective\Service;

use Magento\Framework\App\Cache\TypeListInterface;

/**
 * Cache management service object which exposes methods to get and flush
 * invalidated cache types.
 */
class CacheManagement
{
    /**
     * @var TypeListInterface
     */
    private $cacheType;

    /**
     * @param TypeListInterface $cacheType
     */
    public function __construct(TypeListInterface $cacheType)
    {
        $this->cacheType = $cacheType;
    }

    /**
     * @return array
     */
    public function getInvalidatedTypes(): array
    {
        return \array_keys($this->cacheType->getInvalidated());
    }

    /**
     * @return void
     */
    public function flushInvalidatedTypes(): void
    {
        foreach ($this->getInvalidatedTypes() as $type) {
            $this->cacheType->cleanType($type);
        }
    }
}
