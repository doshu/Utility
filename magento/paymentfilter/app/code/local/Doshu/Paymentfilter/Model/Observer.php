<?php

class Doshu_Paymentfilter_Model_Observer {
 
    public function paymentMethodIsActive(Varien_Event_Observer $observer) {
    
        $event           = $observer->getEvent();
        $method          = $event->getMethodInstance();
        $result          = $event->getResult();
        $currencyCode    = Mage::app()->getStore()->getCurrentCurrencyCode();
 
 		
 		$payments = Mage::getModel('paymentfilter/pf')->getAvailablePayment();
 		$customerPayments = Mage::getModel('paymentfilter/pf')->getCustomerPayment(
 			
 		);
		$selected = array();
		foreach($customerPayments as $customerPayment) {
			$selected[] = $customerPayment['payment'];
		}
		
 		if(isset($payments[$method->getCode()])) {
 			
 			if(Mage::getModel('paymentfilter/pf')->customerHasPayment(
 				Mage::getSingleton('customer/session')->getCustomer()->getData('entity_id'), 
 				$method->getCode()
 			)) {
        		$result->isAvailable = true;
        	}
        	else {
        		$result->isAvailable = false;
        	}
        }
        else {
        	$result->isAvailable = false;
        }
           
    }
 
}

?>
