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

namespace Lof\ProductReviews\Model\Review\Command;

use Lof\ProductReviews\Api\Data\ReplySearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Find Reviews by SearchCriteria command (Service Provider Interface - SPI)
 *
 * Separate command interface to which Repository proxies initial GetList call, could be considered as SPI - Interfaces
 * that you should extend and implement to customize current behaviour, but NOT expected to be used (called) in the code
 * of business logic directly
 *
 * @see \Lof\ProductReviews\Api\ReviewRepositoryInterface
 * @api
 */
interface GetListReplyInterface
{
    /**
     * Find Sources by given SearchCriteria. SearchCriteria is not required because load all sources is useful case
     *
     * @param int $reviewId
     * @param SearchCriteriaInterface|null $searchCriteria
     *
     * @return ReplySearchResultInterface
     */
    public function execute(int $reviewId, SearchCriteriaInterface $searchCriteria = null): ReplySearchResultInterface;

    /**
     * Find Sources by given SearchCriteria. SearchCriteria is not required because load all sources is useful case for logged in customer
     *
     * @param int $customerId
     * @param int $reviewId
     * @param SearchCriteriaInterface|null $searchCriteria
     *
     * @return ReplySearchResultInterface
     */
    public function executeByCustomer(int $customerId, int $reviewId, SearchCriteriaInterface $searchCriteria = null): ReplySearchResultInterface;
}
