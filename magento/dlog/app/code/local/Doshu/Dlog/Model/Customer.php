<?php

	class Doshu_Dlog_Model_Customer extends Mage_Core_Model_Abstract
	{
		
		public $customer = null;
		public $from = null;
		public $to = null;
		public $result = null;
		
		
		protected function _construct() {
		    $this->_init('dlog/customer');
		}
		
		public function setLog($customer, $from, $to) {
			$this->customer = $customer;
			$this->from = $from;
			$this->to = $to;
			
			$customers = (array)$customer;
			
			foreach($customers as $c) {
				$this->result[$c] = $this->getCollection()
					->addFieldToSelect('*')
					->addFilter('customer_id', $c)
					->addFilter('login_at >', $this->from)
					->addFilter('login_at <', $this->to);
			}	
			
			
			
		}
		
		
	}

?>
