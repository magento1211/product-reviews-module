<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Lof\ProductReviews\Controller\Adminhtml\Reminders;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Lof\ProductReviews\Model\ResourceModel\Reminders\CollectionFactory;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class MassStatus extends \Magento\Backend\App\Action
{
    /**
     * MassActions filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Action\Context $context
     * @param Builder $productBuilder
     * @param \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Update reminders(s) status action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $reminderIds = $collection->getAllIds();
        $status = (int) $this->getRequest()->getParam('status');

        try {
            foreach ($collection as $reminder) {
                $reminder->setStatus($status);
                $reminder->save();
            }
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been updated.', count($reminderIds))
            );
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->_getSession()->addException($e, __('Something went wrong while updating the product(s) status.'));
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Lof_ProductReviews::lof_product_reviews_reminders');
    }
}
