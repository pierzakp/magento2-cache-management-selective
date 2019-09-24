<?php
declare(strict_types=1);

namespace Pierzakp\CacheManagementSelective\Test\Unit\Controller\Adminhtml\Index;

use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Pierzakp\CacheManagementSelective\Controller\Adminhtml\Index\FlushInvalidated;
use Pierzakp\CacheManagementSelective\Service\CacheManagement;

/**
 * Test case for contoller responsible for flush invalidated cache action.
 */
class FlushInvalidatedTest extends TestCase
{
    /**
     * @var FlushInvalidated
     */
    private $object;

    /**
     * @var Context|MockObject
     */
    private $context;

    /**
     * @var CacheManagement|MockObject
     */
    private $cacheManagement;

    /**
     * @var Redirect|MockObject
     */
    private $redirect;

    /**
     * @var ManagerInterface|MockObject
     */
    private $messageManager;

    /**
     * @var ResultFactory|MockObject
     */
    private $resultFactory;

    protected function setUp(): void
    {
        $this->messageManager = $this->getMockBuilder(ManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->redirect = $this->getMockBuilder(Redirect::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->redirect->expects($this->once())
            ->method('setPath')
            ->with('adminhtml/cache/index')
            ->willReturnSelf();

        $this->resultFactory = $this->getMockBuilder(ResultFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultFactory->expects($this->once())
            ->method('create')
            ->with(ResultFactory::TYPE_REDIRECT)
            ->willReturn($this->redirect);

        $this->context = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->context->expects($this->once())
            ->method('getMessageManager')
            ->willReturn($this->messageManager);

        $this->context->expects($this->once())
            ->method('getResultFactory')
            ->willReturn($this->resultFactory);

        $this->cacheManagement = $this->getMockBuilder(CacheManagement::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = new FlushInvalidated($this->context, $this->cacheManagement);
    }

    public function testExecuteNoResults(): void
    {
        $this->cacheManagement->method('getInvalidatedTypes')
            ->willReturn([]);

        $this->cacheManagement->expects($this->never())
            ->method('flushInvalidatedTypes');

        $this->messageManager->expects($this->once())
            ->method('addNoticeMessage');

        $this->assertSame(
            $this->redirect,
            $this->object->execute()
        );
    }

    public function testExecuteWithResults(): void
    {
        $this->cacheManagement->method('getInvalidatedTypes')
            ->willReturn(['config', 'full_page']);

        $this->cacheManagement->expects($this->once())
            ->method('flushInvalidatedTypes');

        $this->messageManager->expects($this->once())
            ->method('addSuccessMessage');

        $this->assertSame(
            $this->redirect,
            $this->object->execute()
        );
    }

    public function testExecuteLocalizedExceptionHandling(): void
    {
        $this->cacheManagement->expects($this->once())
            ->method('getInvalidatedTypes')
            ->willReturn(['config', 'full_page']);

        $exception = new LocalizedException(\__('Some localized exception.'));
        $this->cacheManagement->method('flushInvalidatedTypes')
            ->willThrowException($exception);

        $this->messageManager->expects($this->once())
            ->method('addErrorMessage');

        $this->assertSame(
            $this->redirect,
            $this->object->execute()
        );
    }

    public function testExecuteExceptionHandling(): void
    {
        $this->cacheManagement->expects($this->once())
            ->method('getInvalidatedTypes')
            ->willReturn(['config', 'full_page']);

        $exception = new Exception();
        $this->cacheManagement->method('flushInvalidatedTypes')
            ->willThrowException($exception);

        $this->messageManager->expects($this->once())
            ->method('addExceptionMessage')
            ->with(
                $exception,
                \__('An error occurred while flushing invalidated cache.')
            );

        $this->assertSame(
            $this->redirect,
            $this->object->execute()
        );
    }
}
