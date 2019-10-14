<?php
declare(strict_types=1);

namespace Pierzakp\CacheManagementSelective\Test\Unit\Service;

use Magento\Framework\App\Cache\TypeListInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Pierzakp\CacheManagementSelective\Service\CacheManagement;

/**
 * Test case for service which exposes method flush invalidated cache types.
 */
class CacheManagementTest extends TestCase
{
    /**
     * @var CacheManagement
     */
    private $object;

    /**
     * @var TypeListInterface|MockObject
     */
    private $cacheType;

    protected function setUp(): void
    {
        $this->cacheType = $this->getMockBuilder(TypeListInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = new CacheManagement($this->cacheType);
    }

    public function testFlushInvalidatedTypes(): void
    {
        $this->cacheType->expects($this->once())
            ->method('getInvalidated')
            ->willReturn([
                'config' => 'config_object',
                'full_page' => 'full_page_object',
            ]);

        $this->cacheType->expects($this->exactly(2))
            ->method('cleanType');

        $this->object->flushInvalidatedTypes();
    }
}
