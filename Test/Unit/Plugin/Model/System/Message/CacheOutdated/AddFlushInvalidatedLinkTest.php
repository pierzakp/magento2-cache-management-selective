<?php
declare(strict_types=1);

namespace Pierzakp\CacheManagementSelective\Test\Unit\Plugin\Model\System\Message\CacheOutdated;

use Magento\AdminNotification\Model\System\Message\CacheOutdated as Subject;
use Magento\Framework\AuthorizationInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Pierzakp\CacheManagementSelective\Plugin\Model\System\Message\CacheOutdated\AddFlushInvalidatedLink;
use Pierzakp\CacheManagementSelective\Service\FlushInvalidatedUrl;

/**
 * Test case for plugin object which adds flush invalidated cache link.
 */
class AddFlushInvalidatedLinkTest extends TestCase
{
    /**
     * @var AddFlushInvalidatedLink|MockObject
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

        $this->object = new AddFlushInvalidatedLink(
            $this->authorization,
            $this->urlService
        );
    }

    public function testAfterGetTextWhenAllowed(): void
    {
        $this->authorization->expects($this->once())
            ->method('isAllowed')
            ->willReturn(\true);

        $this->urlService->expects($this->once())
            ->method('getUrl');

        $this->assertContains(
            'click here to flush invalidated cache',
            $this->object->afterGetText($this->subject, 'Some text.')
        );
    }

    public function testAfterGetTextWhenDisallowed(): void
    {
        $this->authorization->expects($this->once())
            ->method('isAllowed')
            ->willReturn(\false);

        $this->urlService->expects($this->never())
            ->method('getUrl');

        $this->assertSame(
            'Some text.',
            $this->object->afterGetText($this->subject, 'Some text.')
        );
    }
}
