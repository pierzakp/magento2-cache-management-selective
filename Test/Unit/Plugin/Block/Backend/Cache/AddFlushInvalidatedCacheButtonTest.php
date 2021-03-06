<?php
declare(strict_types=1);

namespace Pierzakp\CacheManagementSelective\Test\Unit\Plugin\Block\Backend\Cache;

use Magento\Backend\Block\Cache as Subject;
use Magento\Framework\AuthorizationInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Pierzakp\CacheManagementSelective\Plugin\Block\Backend\Cache\AddFlushInvalidatedCacheButton;
use Pierzakp\CacheManagementSelective\Service\FlushInvalidatedUrl;

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
     * @var FlushInvalidatedUrl|MockObject
     */
    private $urlService;

    /**
     * @var Subject|MockObject
     */
    private $subject;

    protected function setUp(): void
    {
        $this->authorization = $this->getMockBuilder(AuthorizationInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->urlService = $this->getMockBuilder(FlushInvalidatedUrl::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subject = $this->getMockBuilder(Subject::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = new AddFlushInvalidatedCacheButton(
            $this->authorization,
            $this->urlService
        );
    }

    public function testBeforeSetLayoutWhenAllowed(): void
    {
        $this->authorization->expects($this->once())
            ->method('isAllowed')
            ->willReturn(\true);

        $url = 'https://example.com/admin/pierzakp_cache/index/flushInvalidated';
        $this->urlService->expects($this->once())
            ->method('getUrl')
            ->willReturn($url);

        $this->subject->expects($this->once())
            ->method('addButton')
            ->with(
                'flush_invalidated_cache',
                [
                    'label' => __('Flush Invalidated Cache'),
                    'onclick' => 'setLocation(\'' . $url . '\')',
                    'class' => 'primary flush-cache-magento',
                ]
            );

        $this->object->beforeSetLayout($this->subject);
    }

    public function testBeforeSetLayoutWhenDisallowed(): void
    {
        $this->authorization->expects($this->once())
            ->method('isAllowed')
            ->willReturn(\false);

        $this->subject->expects($this->never())
            ->method('addButton');

        $this->object->beforeSetLayout($this->subject);
    }
}
