<?php

	class Doshu_Paymentfilter_Model_Resource_Pf extends Mage_Core_Model_Resource_Db_Abstract {
	
		protected function _construct() {
		    $this->_init('paymentfilter/pf', 'id');
		}
		
		public function deletePayment($customerId) {
			$this->_getWriteAdapter()->delete($this->getMainTable() , 'customer = '.$customerId);
			//$this->_getReadAdapter()->delete()->from($this->getMainTable())->where('customer=?', $customerId);
		}
		
		public function getCustomerPayment($customerId) {
			
			$select = $this->_getReadAdapter()->select()->from($this->getMainTable())->where('customer=?', $customerId);
			return $this->_getReadAdapter()->fetchAll($select);
		}
		
		public function customerHasPayment($customerId, $paymentCode) {
			
			$select = $this->_getReadAdapter()->select()->from($this->getMainTable())->where(
				'customer=?', $customerId
			)
			->where(
				'payment=?', $paymentCode
			);
			
			return (bool)$this->_getReadAdapter()->fetchOne($select);
		}
	}

?>
