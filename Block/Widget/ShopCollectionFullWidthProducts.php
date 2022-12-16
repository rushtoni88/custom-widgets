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

class ShopCollectionFullWidthProducts extends Template implements BlockInterface
{

    protected $_template = "widget/shop-collection-full-width-products.phtml";
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

    public function getAdditionalColourCount($product) {
        $coloursArray = [];
        if($product->getTypeId() === "configurable") {
            $children = $product->getTypeInstance()->getUsedProducts($product);
            foreach ($children as $child) {
                if( $colour = $child->getColor() ) {
                    array_push($coloursArray, $colour);
                }
            }
            return count(array_unique($coloursArray)) - 1;
        }
        return false;
    }

}
