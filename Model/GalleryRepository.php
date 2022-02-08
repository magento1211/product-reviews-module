<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/terms
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_ProductReviews
 * @copyright  Copyright (c) 2021 Landofcoder (https://www.landofcoder.com/)
 * @license    https://landofcoder.com/terms
 */

namespace Lof\ProductReviews\Model;

use Lof\ProductReviews\Api\GalleryRepositoryInterface;
use Lof\ProductReviews\Api\Data;
use Lof\ProductReviews\Model\ResourceModel\Gallery as ResourceGallery;
use Lof\ProductReviews\Model\ResourceModel\Gallery\CollectionFactory as GalleryCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class GalleryRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class GalleryRepository implements GalleryRepositoryInterface
{
    /**
     * @var ResourceGallery
     */
    protected $resource;

    /**
     * @var GalleryFactory
     */
    protected $galleryFactory;

    /**
     * @var GalleryCollectionFactory
     */
    protected $galleryCollectionFactory;

    /**
     * @var Data\GallerySearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var Data\GalleryInterfaceFactory
     */
    protected $dataGalleryFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CollectionProcessorInterface|null
     */
    private $collectionProcessor;

    /**
     * GalleryRepository constructor.
     * @param ResourceGallery $resource
     * @param GalleryFactory $galleryFactory
     * @param Data\GalleryInterfaceFactory $dataGalleryFactory
     * @param GalleryCollectionFactory $galleryCollectionFactory
     * @param Data\GallerySearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface|null $collectionProcessor
     */
    public function __construct(
        ResourceGallery $resource,
        GalleryFactory $galleryFactory,
        \Lof\ProductReviews\Api\Data\GalleryInterfaceFactory $dataGalleryFactory,
        GalleryCollectionFactory $galleryCollectionFactory,
        Data\GallerySearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor = null
    ) {
        $this->resource = $resource;
        $this->galleryFactory = $galleryFactory;
        $this->galleryCollectionFactory = $galleryCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataGalleryFactory = $dataGalleryFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
    }

    /**
     * Save Gallery data
     *
     * @param \Lof\ProductReviews\Api\Data\GalleryInterface $gallery
     * @return Gallery
     * @throws CouldNotSaveException
     */
    public function save(Data\GalleryInterface $gallery)
    {
        try {
            $this->resource->save($gallery);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $gallery;
    }

    /**
     * Load Gallery data by given Gallery Identity
     *
     * @param string $galleryId
     * @return Gallery
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($galleryId)
    {
        $gallery = $this->galleryFactory->create();
        $this->resource->load($gallery, $galleryId);
        if (!$gallery->getId()) {
            throw new NoSuchEntityException(__('Gallery with id "%1" does not exist.', $galleryId));
        }
        return $gallery;
    }

    /**
     * Load Gallery data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Lof\ProductReviews\Api\Data\GallerySearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var \Lof\ProductReviews\Model\ResourceModel\Gallery\Collection $collection */
        $collection = $this->galleryCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var Data\GallerySearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritdoc
     */
    public function getListByReview($reviewId, \Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var \Lof\ProductReviews\Model\ResourceModel\Gallery\Collection $collection */
        $collection = $this->galleryCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $collection->addFieldToFilter("review_id", $reviewId);

        /** @var Data\GallerySearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete Gallery
     *
     * @param \Lof\ProductReviews\Api\Data\GalleryInterface $gallery
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\GalleryInterface $gallery)
    {
        try {
            $this->resource->delete($gallery);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete Gallery by given Gallery Identity
     *
     * @param string $galleryId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($galleryId)
    {
        return $this->delete($this->getById($galleryId));
    }

    /**
     * Retrieve collection processor
     *
     * @return CollectionProcessorInterface
     * @deprecated 101.1.0
     */
    private function getCollectionProcessor()
    {
        if (!$this->collectionProcessor) {
            $this->collectionProcessor = \Magento\Framework\App\ObjectManager::getInstance()->get(
                'Lof\ProductReviews\Model\Api\SearchCriteria\GalleryCollectionProcessor'
            );
        }
        return $this->collectionProcessor;
    }
}
