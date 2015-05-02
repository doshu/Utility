<?php

	class Doshu_Rewards_Block_Rewards extends Mage_Core_Block_Template {
	
		public function getCurrentOrderPoints() {
			$cart = Mage::getModel('checkout/cart')->getQuote();
			$points = 0;
			foreach ($cart->getAllItems() as $item) {
				$point = Mage::getModel('catalog/product')->load($item->getProduct()->getEntityId())->getRewardPoint();
				if($point)
					$points += $point;
			}
			
			return $points;
		}
		
		
		public function getUserPoints() {
			return Mage::getSingleton('customer/session')->getCustomer()->getData('points');
		}
		
		
		public function getPossibleDiscount() {
			$type = strtolower(Mage::getStoreConfig('customer/rewards/type'));
			$discount = Mage::getStoreConfig('customer/rewards/discount');
			$step = Mage::getStoreConfig('customer/rewards/step');
			return ((int)($this->getUserPoints()/$step))*$discount;
		}
	}

?>
