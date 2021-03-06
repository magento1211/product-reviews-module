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
 * @copyright  Copyright (c) 2022 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/terms
 */
declare(strict_types=1);

namespace Lof\ProductReviews\Model\Data;

use Lof\ProductReviews\Api\Data\ImageInterface;
use Magento\Framework\Api\AbstractSimpleObject;

/**
 * @inheritdoc
 */
class Image extends AbstractSimpleObject implements ImageInterface
{
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getFullPath()
    {
        return $this->_get(self::FULL_PATH);
    }

    /**
     * @inheritdoc
     *
     * @param string $full_path
     *
     * @return $this
     */
    public function setFullPath($full_path)
    {
        return $this->setData(self::FULL_PATH, $full_path);
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getResizedPath()
    {
        return $this->_get(self::RESIZED_PATH);
    }

    /**
     * @inheritdoc
     *
     * @param string $resized_path
     *
     * @return $this
     */
    public function setResizedPath($resized_path)
    {
        return $this->setData(self::RESIZED_PATH, $resized_path);
    }

}
