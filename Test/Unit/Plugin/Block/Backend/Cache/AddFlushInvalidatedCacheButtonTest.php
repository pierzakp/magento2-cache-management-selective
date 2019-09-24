<?php
declare(strict_types=1);

namespace Pierzakp\CacheManagementSelective\Test\Unit\Plugin\Block\Backend\Cache;

use Magento\Backend\Block\Cache as Subject;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\UrlInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Pierzakp\CacheManagementSelective\Plugin\Block\Backend\Cache\AddFlushInvalidatedCacheButton;

/**
 * Test case for plugin which adds flush invalidated cache button to admin
 * cache management page.
 */
class AddFlushInvalidatedCacheButtonTest extends TestCase
{
    /**
     * @var AddFlushInvalidatedCacheButton
     */
    private $object;

    /**
     * @var AuthorizationInterface|MockObject
     */
    private $authorization;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var Subject|MockObject
     */
    private $subject;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->authorization = $this->getMockBuilder(AuthorizationInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->urlBuilder = $this->getMockBuilder(UrlInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->urlBuilder->method('getUrl')
            ->willReturn('string');

        $this->subject = $this->getMockBuilder(Subject::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = new AddFlushInvalidatedCacheButton(
            $this->authorization,
            $this->urlBuilder
        );
    }

    public function testBeforeSetLayoutWhenAllowed(): void
    {
        $this->authorization->method('isAllowed')
            ->willReturn(\true);

        $this->subject->expects($this->once())
            ->method('addButton');

        $this->object->beforeSetLayout($this->subject);
    }

    public function testBeforeSetLayoutWhenDisallowed(): void
    {
        $this->authorization->method('isAllowed')
            ->willReturn(\false);

        $this->subject->expects($this->never())
            ->method('addButton');

        $this->object->beforeSetLayout($this->subject);
    }
}
