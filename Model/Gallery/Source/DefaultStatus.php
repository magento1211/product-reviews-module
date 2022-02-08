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

namespace Lof\ProductReviews\Model\Gallery\Source;

class DefaultStatus implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return mixed|array
     */
    public function toOptionArray()
    {
        $groupList = [];
        $groupList[] = [
            'label' => __('Disabled'),
            'value' => 2
            ];

        $groupList[] = [
            'label' => __('Enabled'),
            'value' => 1
            ];
        return $groupList;
    }
}
