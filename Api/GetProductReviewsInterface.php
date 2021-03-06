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
declare(strict_types=1);

namespace Lof\ProductReviews\Api;

/**
 * Retrieve product reviews by sku
 *
 * Used fully qualified namespaces in annotations for proper work of WebApi request parser
 *
 * @api
 */
interface GetProductReviewsInterface
{
    /**
     * @inheritdoc
     *
     * @param string $sku
     * @param string $keyword
     * @param int $limit
     * @param int $page
     * @param string $sort_by (helpful, rating, latest, oldest, recommended, verified, default or empty)
     *
     * @return \Lof\ProductReviews\Api\Data\ReviewDataInterface|mixed|array
     */
    public function execute(string $sku, string $keyword = "", int $limit = 0, int $page = 0, string $sort_by = "");
}
