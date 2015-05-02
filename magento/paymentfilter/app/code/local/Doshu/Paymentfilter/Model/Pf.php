<?php

	class Doshu_Paymentfilter_Model_Pf extends Mage_Core_Model_Abstract
	{
	
		
		public $disallowed = array('paypal_billing_agreement');
		
		protected function _construct() {
		    $this->_init('paymentfilter/pf');
		}
		
		
		public function getAvailablePayment() {
			$payments = Mage::getSingleton('payment/config')->getActiveMethods();
			$methods = array();
			
			foreach ($payments as $paymentCode => $paymentModel) {
				if(!in_array($paymentCode, $this->disallowed)) {
					$paymentTitle = Mage::getStoreConfig('payment/'.$paymentCode.'/title');
					$methods[$paymentCode] = $paymentTitle;
				}
			}
			return $methods;
		}
		
		public function customerHasPayment($customerId, $paymentCode) {
			
			return $this->getResource()->customerHasPayment($customerId, $paymentCode);
		}
		
		
		public function getCustomerPayment($customerId) {
			return $this->getResource()->getCustomerPayment($customerId);
		}
		
		
		public function getResource() {
			return Mage::getResourceModel('paymentfilter/pf');
		}
		
		
		public function savePayment($customerId, $isNew, $isAdmin, $data) {
			
			if($isNew && !$isAdmin) {
				foreach($this->getAvailablePayment() as $code => $name) {
					$pfInstance = Mage::getModel('paymentfilter/pf');
					$pfInstance->setData('payment', $code);
					$pfInstance->setData('customer', $customerId);
					$pfInstance->save();
					unset($pfInstance);
				}
			}
			elseif($isAdmin) {
				$this->getResource()->deletePayment($customerId);
				foreach($data['account']['Payment']['allowed'] as $code) {
					$pfInstance = Mage::getModel('paymentfilter/pf');
					$pfInstance->load();
					$pfInstance->setData('payment', $code);
					$pfInstance->setData('customer', $customerId);
					$pfInstance->save();
					unset($pfInstance);
				}
			}
		}
	}

?>
