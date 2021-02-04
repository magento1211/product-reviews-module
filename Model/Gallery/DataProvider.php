<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Lof\ProductReviews\Model\Gallery;

use Lof\ProductReviews\Model\ResourceModel\Gallery\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Lof\ProductReviews\Model\ResourceModel\Gallery\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $galleryCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $galleryCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $galleryCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Lof\ProductReviews\Model\Gallery $gallery */
        foreach ($items as $gallery) {
            $this->loadedData[$gallery->getId()] = $gallery->getData();
        }

        $data = $this->dataPersistor->get('lof_product_reviews_gallery');
        if (!empty($data)) {
            $gallery = $this->collection->getNewEmptyItem();
            $gallery->setData($data);
            $this->loadedData[$gallery->getId()] = $gallery->getData();
            $this->dataPersistor->clear('lof_product_reviews_gallery');
        }

        return $this->loadedData;
    }
}
