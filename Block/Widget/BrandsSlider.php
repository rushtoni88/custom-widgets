<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Develo\Widgets\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class BrandsSlider extends Template implements BlockInterface
{

    protected $_template = "widget/brands-slider.phtml";

    public function getBrandLink($brandName): string
    {
        switch ($brandName) {
            case 'weatherbeeta':
                $brandLink = $this->getBaseUrl() . 'new-arrivals';
                break;
            case 'weatherbeetadog':
                $brandLink = $this->getBaseUrl() . 'weatherbeeta-dog';
                break;
            default:
                $brandLink = $this->getBaseUrl() . $brandName;
        }
        return $brandLink;
    }

}
