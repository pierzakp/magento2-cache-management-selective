<?php
declare(strict_types=1);

namespace Pierzakp\CacheManagementSelective\Controller\Adminhtml\Index;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Pierzakp\CacheManagementSelective\Service\CacheManagement;

/**
 * Controller object responsible for handling invalidated cache flush action.
 */
class FlushInvalidated extends Action
{
    /**
     * Authorization level of a basic admin session.
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Pierzakp_CacheManagementSelective::flush_invalidated_cache';

    /**
     * @var CacheManagement
     */
    private $cacheManagement;

    /**
     * @param Context $context
     * @param CacheManagement $cacheManagement
     */
    public function __construct(
        Context $context,
        CacheManagement $cacheManagement
    ) {
        parent::__construct($context);

        $this->cacheManagement = $cacheManagement;
    }

    /**
     * Action which clean invalidated cache types only.
     *
     * @return Redirect
     */
    public function execute()
    {
        try {
            $invalidatedTypes = $this->cacheManagement->getInvalidatedTypes();

            if ($invalidatedTypes) {
                $this->cacheManagement->flushInvalidatedTypes();

                $this->messageManager->addSuccessMessage(
                    \__(
                        'Following invalidated cache types has been flushed: %1.',
                        \implode(', ', $invalidatedTypes)
                    )
                );
            } else {
                $this->messageManager->addNoticeMessage(
                    \__('There are no invalidated cache types to be flushed.')
                );
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (Exception $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                \__('An error occurred while refreshing cache.')
            );
        }

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('adminhtml/cache/index');
    }
}
