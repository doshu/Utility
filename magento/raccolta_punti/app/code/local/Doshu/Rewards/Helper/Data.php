<?php

	class Doshu_Rewards_Helper_Data extends Mage_Core_Helper_Abstract {
	
		public function getDiscount() {
			$type = strtolower(Mage::getStoreConfig('customer/rewards/type'));
			$discount = Mage::getStoreConfig('customer/rewards/discount');
			$step = Mage::getStoreConfig('customer/rewards/step');
			$total = ((int)($this->getUserPoints()/$step))*$discount;
			if($type == 'fixed') {
				$baseCurrencyCode = Mage::app()->getStore()->getBaseCurrencyCode(); 
				$currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode(); 
				$baseCurrencyCode = Mage::app()->getStore()->getBaseCurrencyCode();
				return Mage::helper('directory')->currencyConvert($total, $baseCurrencyCode, $currentCurrencyCode);
			}
			else {
				return $total;
			}
		}
		
		public function getUserPoints() {
			return Mage::getSingleton('customer/session')->getCustomer()->getData('points');
		}
		
		
		public function getUsedPoints($total, $type) {
		
			$discount = Mage::getStoreConfig('customer/rewards/discount');
			$step = Mage::getStoreConfig('customer/rewards/step');
		
			if($type == 'fixed') {
				$all = ceil($total/$discount);
			}
			else {
				$all = ceil(100/$discount*$step);
			}
			
			return min($this->getUserPoints(), $all);
		}
	}
