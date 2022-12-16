<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Develo\Widgets\Helper;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Data\Collection\AbstractDb;

class Product extends AbstractHelper
{

    /**
     * @var CollectionFactory
     */
    protected $_productCollection;

    /**
     * @param Context $context
     * @param CollectionFactory $productCollection
     */
    public function __construct(
        Context    $context,
        CollectionFactory $productCollection
    ) {

        $this->_productCollection = $productCollection;
        parent::__construct($context);

    }

    /**
     * Returns a product collection that is filtered by product SKUs.
     *
     * @param $skus
     */
    public function getProductCollectionBySkus($skus)
    {

        $skusString = $skus;
        if( !is_array($skus) ) {
            $skus = explode(',', $skus);
            if( !is_array($skus) || !count($skus) ) {
                return false;
            }
        }

        $skusString = "'";

        $numItems = count($skus);
        $i = 0;

        foreach( $skus as $sku ) {
            $skusString .= $sku;
            if(++$i === $numItems) {
                // Last iteration
                $skusString .= "'";
            } else {
                $skusString .= "','";
            }
        }

        /** @var $collection \Magento\Catalog\Model\ResourceModel\Product\Collection */
        $collection = $this->_productCollection->create();
        $collection->setVisibility([\Magento\Catalog\Model\Product\Visibility::VISIBILITY_IN_CATALOG, \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH]);

        $collection->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addUrlRewrite()
            ->addAttributeToSelect('*');

        $collection->addStoreFilter();

        $collection->addAttributeToFilter('sku', ['in' => $skus]);

        $collection->getSelect()->order(new \Zend_Db_Expr("FIELD(sku, " . $skusString . ")"));
        $collection->setPageSize(
            24
        )->setCurPage(
            1
        );

        return $collection;

    }


}

