<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Develo\Widgets\Block\Widget;

use Develo\Widgets\Helper\Product;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class ShopCollectionProductsRight extends Template implements BlockInterface
{

    protected $_template = "widget/shop-collection-products-right.phtml";

    /**
     * @var Product
     */
    private $productHelper;

    public function __construct(
        Product $productHelper,
        Template\Context $context,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->productHelper = $productHelper;
    }

    public function getProductsCollection(string $skus) {
        return $this->productHelper->getProductCollectionBySkus($skus);
    }

}
