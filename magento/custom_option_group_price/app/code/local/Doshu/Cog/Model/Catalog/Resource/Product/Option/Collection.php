<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Catalog product options collection
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Doshu_Cog_Model_Catalog_Resource_Product_Option_Collection extends Mage_Catalog_Model_Resource_Product_Option_Collection
{
    /**
     * Resource initialization
     */
    protected function _construct()
    {
        $this->_init('catalog/product_option');
    }

    /**
     * Adds title, price & price_type attributes to result
     *
     * @param int $storeId
     * @return Mage_Catalog_Model_Resource_Product_Option_Collection
     */
    public function getOptions($storeId)
    {
        $this->addPriceToResult($storeId)
             ->addTitleToResult($storeId);

        return $this;
    }

    /**
     * Add title to result
     *
     * @param int $storeId
     * @return Mage_Catalog_Model_Resource_Product_Option_Collection
     */
    public function addTitleToResult($storeId)
    {
        $productOptionTitleTable = $this->getTable('catalog/product_option_title');
        $adapter        = $this->getConnection();
        $titleExpr      = $adapter->getCheckSql(
            'store_option_title.title IS NULL',
            'default_option_title.title',
            'store_option_title.title'
        );

        $this->getSelect()
            ->join(array('default_option_title' => $productOptionTitleTable),
                'default_option_title.option_id = main_table.option_id',
                array('default_title' => 'title'))
            ->joinLeft(
                array('store_option_title' => $productOptionTitleTable),
                'store_option_title.option_id = main_table.option_id AND '
                    . $adapter->quoteInto('store_option_title.store_id = ?', $storeId),
                array(
                    'store_title'   => 'title',
                    'title'         => $titleExpr
                ))
            ->where('default_option_title.store_id = ?', Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID);

        return $this;
    }

    /**
     * Add price to result
     *
     * @param int $storeId
     * @return Mage_Catalog_Model_Resource_Product_Option_Collection
     */
    public function addPriceToResult($storeId)
    {
        $productOptionPriceTable = $this->getTable('catalog/product_option_price');
        $adapter        = $this->getConnection();
        $priceExpr      = $adapter->getCheckSql(
            'store_option_price.price IS NULL',
            'default_option_price.price',
            'store_option_price.price'
        );
        $priceTypeExpr  = $adapter->getCheckSql(
            'store_option_price.price_type IS NULL',
            'default_option_price.price_type',
            'store_option_price.price_type'
        );

        $this->getSelect()
            ->joinLeft(
                array('default_option_price' => $productOptionPriceTable),
                'default_option_price.option_id = main_table.option_id AND '
                    . $adapter->quoteInto(
                        'default_option_price.store_id = ?',
                        Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID
                    ),
                array(
                    'default_price' => 'price',
                    'default_price_type' => 'price_type'
                ))
            ->joinLeft(
                array('store_option_price' => $productOptionPriceTable),
                'store_option_price.option_id = main_table.option_id AND '
                    . $adapter->quoteInto('store_option_price.store_id = ?', $storeId),
                array(
                    'store_price'       => 'price',
                    'store_price_type'  => 'price_type',
                    'price'             => $priceExpr,
                    'price_type'        => $priceTypeExpr
                ));

        return $this;
    }

    /**
     * Add value to result
     *
     * @param int $storeId
     * @return Mage_Catalog_Model_Resource_Product_Option_Collection
     */
    public function addValuesToResult($storeId = null)
    {
    	
        if ($storeId === null) {
            $storeId = Mage::app()->getStore()->getId();
        }
        $optionIds = array();
        foreach ($this as $option) {
            $optionIds[] = $option->getId();
        }
        if (!empty($optionIds)) {
            /** @var $values Mage_Catalog_Model_Option_Value_Collection */
            $c = Mage::getModel('catalog/product_option_value')->getCollection();
			
	        /*
			$c->getSelect()->joinLeft(
				array('self' => 'catalog_product_option_type_value'), 
				'self.option_id=main_table.option_id AND self.option_type_id<>main_table.option_type_id',
				array('self.option_id' => 'self_option_id')
			);
			*/
			//die((string)$c->getSelect());
            $values = $c->addTitleToResult($storeId)
                ->addPriceToResult($storeId)
                ->addOptionToFilter($optionIds)
                ->setOrder('sort_order', self::SORT_ORDER_ASC)
                ->setOrder('title', self::SORT_ORDER_ASC);
			
			$buf = array();
			$groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
          
			           
            if(Mage::app()->getStore()->isAdmin()) {
		        foreach ($values as $value) {
		            $optionId = $value->getOptionId();
		            if($this->getItemById($optionId)) {
		            	$this->getItemById($optionId)->addValue($value);
			        	$value->setOption($this->getItemById($optionId));
		            }
		        }
		    }
		    else {
		    	
		        foreach ($values as $value) {
		        	/*
		        	$optionId = $value->getOptionId();
		        	$this->getItemById($optionId)->addValue($value);
			        $value->setOption($this->getItemById($optionId));
			        */
			        /*
			        foreach($buf as $option_id => $values) {
		        	foreach($values as $value) {
	        			$this->getItemById($option_id)->addValue($value);
		        		$value->setOption($this->getItemById($option_id));
		        	}
		    	}
		    	*/
			        
		            $optionId = $value->getOptionId();
		            
		            if(!array_key_exists($optionId, $buf)) {
		            	$buf[$optionId] = array();
		            }
		            
		            if($this->getItemById($optionId)) {
		            	$_title = $value->getTitle();
		            	if($value->getGroup() == $groupId || $value->getGroup() === null || $value->getGroup() == '') {
				        	if(!array_key_exists($_title, $buf[$optionId])) {
				        		$buf[$optionId][$_title] = $value;
				        	}
				        	else {
				        		if($buf[$optionId][$_title]->getGroup() === null || $buf[$optionId][$_title]->getGroup() == '') {
				        			$buf[$optionId][$_title] = $value;
				        		}
				        	}
		            	}
		            }
		            
		        }
		        foreach($buf as $option_id => $values) {
			    	foreach($values as $value) {
		    			$this->getItemById($option_id)->addValue($value);
			    		$value->setOption($this->getItemById($option_id));
			    	}
			    }
    	    }
    	    
        }

        return $this;
    }

    /**
     * Add product_id filter to select
     *
     * @param array|Mage_Catalog_Model_Product|int $product
     * @return Mage_Catalog_Model_Resource_Product_Option_Collection
     */
    public function addProductToFilter($product)
    {
        if (empty($product)) {
            $this->addFieldToFilter('product_id', '');
        } elseif (is_array($product)) {
            $this->addFieldToFilter('product_id', array('in' => $product));
        } elseif ($product instanceof Mage_Catalog_Model_Product) {
            $this->addFieldToFilter('product_id', $product->getId());
        } else {
            $this->addFieldToFilter('product_id', $product);
        }

        return $this;
    }

    /**
     * Add is_required filter to select
     *
     * @param bool $required
     * @return Mage_Catalog_Model_Resource_Product_Option_Collection
     */
    public function addRequiredFilter($required = true)
    {
        $this->addFieldToFilter('main_table.is_require', (string)$required);
        return $this;
    }

    /**
     * Add filtering by option ids
     *
     * @param mixed $optionIds
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Option_Collection
     */
    public function addIdsToFilter($optionIds)
    {
        $this->addFieldToFilter('main_table.option_id', $optionIds);
        return $this;
    }

    /**
     * Call of protected method reset
     *
     * @return Mage_Catalog_Model_Resource_Product_Option_Collection
     */
    public function reset()
    {
        return $this->_reset();
    }
}
