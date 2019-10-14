<?php
declare(strict_types=1);

namespace Pierzakp\CacheManagementSelective\Test\Unit\Service;

use Magento\Backend\Model\UrlInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Pierzakp\CacheManagementSelective\Service\FlushInvalidatedUrl;

/**
 * Test case for service which exposes method to get url to flush invalidated
 * cache action.
 */
class FlushInvalidatedUrlTest extends TestCase
{
    /**
     * @var FlushInvalidatedUrl
     */
    private $object;

    /**
     * @var UrlInterface|MockObject
     */
    private $urlBuilder;

    protected function setUp(): void
    {
        $this->urlBuilder = $this->getMockBuilder(UrlInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = new FlushInvalidatedUrl($this->urlBuilder);
    }

    public function testGetUrl(): void
    {
        $url = 'https://example.com/admin/pierzakp_cache/index/flushInvalidated';
        $this->urlBuilder->expects($this->once())
            ->method('getUrl')
            ->with('pierzakp_cache/index/flushInvalidated')
            ->willReturn($url);

        $this->assertSame(
            $url,
            $this->object->getUrl()
        );
    }
}
