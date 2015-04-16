<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 05.06.14
 * Time: 11:21
 * To change this template use File | Settings | File Templates.
 */
class Etheme_Megatronconfig_Helper_ColorswatchProductList_Data extends SMDesign_ColorswatchProductList_Helper_Data
{
    public function showSwatches($_product, $_colorswatch)
    {
        $html = array();
        if (Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE == $_product->getTypeId()) {
            $attributeCollection = $_product->getTypeInstance(true)->getConfigurableAttributes($_product);

            $_attribute = $attributeCollection->getFirstItem();
            $html[] = '<div class="product-options-outer">';
            $html[] = '<div class="product-options">';
            foreach ($attributeCollection as $_attribute) { // to do in next verion to support more attributes.


                $html[] = "<ul class=\"colorswatch-attribute colorswatch-attribute-list-{$_attribute->getAttributeId()}-{$_product->getId()}\">";
                $swatchCounter = 0;
                if($_attribute->getSwatches())
				{
					foreach ($_attribute->getSwatches() as $swatch) {
						if ($this->config['max_swatches'] <= $swatchCounter) {
							break;
						}

						if ($swatch->getInStock()) {
							$html[] = "<li class=\"colorswatch-{$_attribute->getAttributeId()}-{$swatch->getOptionId()} colorswatch-swatch-container\" >";
							$html[] = "<span class=\"swatch\">";
							$swatchImages = Mage::helper('colorswatch/images')->init($swatch);
							if ($swatch->getImageBase()) {
								$html[] = "<img class=\"{$swatchImages->getClassName()}\" width='17' height='17' src=\"{$swatchImages->resize()}\" alt='' />";
							} else {
								$html[] = $swatch->getStoreLabel();
							}
							$html[] = "</span></li>";
							$swatchCounter++;
						}

					}
				}
				
                $html[] = "</ul>";
                $html[] = '<div class="clearfix"></div>';

                //$html[] = '<input type="hidden" " class="required-entry hidden-super-attribute-select" />';

            }
            $html[] = "</div>";
            $html[] = "</div>";
        }
        $html = implode("\n", $html);
        return $html;
    }
}