<?php

class Doshu_Rewards_Model_Observer {

    
	public function setRewardsDiscount($observer) {

		$quote = $observer->getEvent()->getQuote();
		$quoteid = $quote->getId();
		
    
		if($quoteid) {
		
			if(Mage::getSingleton('customer/session')->isLoggedIn() && Mage::getModel('customer/session')->getData('doshu_use_points')) {
				$discountAmount = Mage::helper('rewards')->getDiscount();
				$type = strtolower(Mage::getStoreConfig('customer/rewards/type'));
				if($type == 'fixed') { 
					$discountAmount = min($quote->getGrandTotal(), $discountAmount);
					$step = Mage::getStoreConfig('customer/rewards/step');
					$usedPoints = Mage::helper('rewards')->getUsedPoints($quote->getBaseGrandTotal(), 'fixed'); 
					//ceil($quote->getBaseGrandTotal()/$step);
					Mage::getModel('customer/session')->setData('current_order_used_points', $usedPoints);
				}
				else {
					$discountAmount = round($quote->getGrandTotal()/100*(min(100, $discountAmount)),2);
					$usedPoints = Mage::helper('rewards')->getUsedPoints($quote->getBaseGrandTotal(), 'percent'); 
				}
			}
			else {
				$discountAmount = 0;
			}
		   
       		if($discountAmount > 0) {
       		
        		$total=$quote->getBaseSubtotal();
            	$quote->setSubtotal(0);
            	$quote->setBaseSubtotal(0);

            	$quote->setSubtotalWithDiscount(0);
            	$quote->setBaseSubtotalWithDiscount(0);

            	$quote->setGrandTotal(0);
            	$quote->setBaseGrandTotal(0);
        
             
            	$canAddItems = $quote->isVirtual()? ('billing') : ('shipping');
            	    
            	foreach ($quote->getAllAddresses() as $address) {
                
            		$address->setSubtotal(0);
            		$address->setBaseSubtotal(0);

            		$address->setGrandTotal(0);
            		$address->setBaseGrandTotal(0);

            		$address->collectTotals();

            		$quote->setSubtotal((float) $quote->getSubtotal() + $address->getSubtotal());
            		$quote->setBaseSubtotal((float) $quote->getBaseSubtotal() + $address->getBaseSubtotal());

            		$quote->setSubtotalWithDiscount(
                		(float) $quote->getSubtotalWithDiscount() + $address->getSubtotalWithDiscount()
            		);
            		
            		$quote->setBaseSubtotalWithDiscount(
                		(float) $quote->getBaseSubtotalWithDiscount() + $address->getBaseSubtotalWithDiscount()
            		);

            		$quote->setGrandTotal((float) $quote->getGrandTotal() + $address->getGrandTotal());
            		$quote->setBaseGrandTotal((float) $quote->getBaseGrandTotal() + $address->getBaseGrandTotal());
    
            		$quote->save(); 
    
					$quote->setGrandTotal($quote->getBaseSubtotal()-$discountAmount)
					->setBaseGrandTotal($quote->getBaseSubtotal()-$discountAmount)
					->setSubtotalWithDiscount($quote->getBaseSubtotal()-$discountAmount)
					->setBaseSubtotalWithDiscount($quote->getBaseSubtotal()-$discountAmount)
					->save(); 
               
                
                	if($address->getAddressType() == $canAddItems) {
                		//echo $address->setDiscountAmount; exit;
		                $address->setSubtotalWithDiscount((float) $address->getSubtotalWithDiscount()-$discountAmount);
		                $address->setGrandTotal((float) $address->getGrandTotal()-$discountAmount);
		                $address->setBaseSubtotalWithDiscount((float) $address->getBaseSubtotalWithDiscount()-$discountAmount);
		                $address->setBaseGrandTotal((float) $address->getBaseGrandTotal()-$discountAmount);
                    	if($address->getDiscountDescription()){
				            $address->setDiscountAmount(-($address->getDiscountAmount()-$discountAmount));
				            $address->setDiscountDescription($address->getDiscountDescription().', '.Mage::helper('rewards')->__('Raccolta Punti'));
				            $address->setBaseDiscountAmount(-($address->getBaseDiscountAmount()-$discountAmount));
                    	}else {
				            $address->setDiscountAmount(-($discountAmount));
				            $address->setDiscountDescription(Mage::helper('rewards')->__('Raccolta Punti'));
				            $address->setBaseDiscountAmount(-($discountAmount));
		                }
                    	$address->save();
                	}//end: if
            	} //end: foreach
            	//echo $quote->getGrandTotal();
        
        		foreach($quote->getAllItems() as $item){
					//We apply discount amount based on the ratio between the GrandTotal and the RowTotal
					$rat=$item->getPriceInclTax()/$total;
					$ratdisc=$discountAmount*$rat;
					$item->setDiscountAmount(($item->getDiscountAmount()+$ratdisc) * $item->getQty());
					$item->setBaseDiscountAmount(($item->getBaseDiscountAmount()+$ratdisc) * $item->getQty())->save();

				}
            
                
            }
            
		}
 	}
 	
 	
 	public function useCustomerPoints($observer) {
 		
 		if(Mage::getSingleton('customer/session')->isLoggedIn()) {
 		
 			$order = $observer->getEvent()->getOrder();
 			
 			/*
			$step = Mage::getStoreConfig('customer/rewards/step');
			$actual = Mage::getSingleton('customer/session')->getCustomer()->getData('points');
			$used = $actual-($actual%$step);
			*/
			$actual = Mage::getSingleton('customer/session')->getCustomer()->getData('points');
			$used = Mage::getModel('customer/session')->getData('current_order_used_points');
 		
 			if($used) {
 			
	 			$customer = Mage::getModel('customer/customer')->load(
	 				Mage::getSingleton('customer/session')->getCustomer()->getData('entity_id')
	 			);
	 			
	 			$customer->setData('points', $actual - $used);
	 			$customer->save();
	 			Mage::getModel('customer/session')->setData('current_order_used_points', 0);
	 		}
 		}
 	}
 	
 	
 	//da lanciare alla creazione della fattura
 	//dalla fattura prendere l'ordine
 	public function addCustomerPoints($observer) {
 		
 		if(Mage::getSingleton('customer/session')->isLoggedIn()) {
	 		$order = $order = $observer->getEvent()->getOrder();
	 		$points = 0;
	 		foreach($order->getAllItems() as $item){
	 			$point = Mage::getModel('catalog/product')->load($item->getProductId())->getRewardPoint();
	 			$points += $point;
	 		}
	 		
	 		if($points) {
	 			$customer = Mage::getModel('customer/customer')->load(
	 				Mage::getSingleton('customer/session')->getCustomer()->getData('entity_id')
	 			);
	 			
	 			$customer->setData('points', $customer->getData('points') + $points);
	 			$customer->save();
	 		}
	 	}
 	}
 	
 	
 	public function adminAddCustomerPoints($observer) {
 		
 		$order = $order = $observer->getEvent()->getInvoice()->getOrder();
 		$customerId = $order->getCustomerId();
 		if($customerId) {
 		
	 		$points = 0;
	 		foreach($order->getAllItems() as $item){
	 			$point = Mage::getModel('catalog/product')->load($item->getProductId())->getRewardPoint();
	 			$points += $point;
	 		}
	 		
	 		if($points) {
	 			$customer = Mage::getModel('customer/customer')->load($customerId);
	 			
	 			$customer->setData('points', $customer->getData('points') + $points);
	 			$customer->save();
	 		}
	 	}
 	}
 	
}
