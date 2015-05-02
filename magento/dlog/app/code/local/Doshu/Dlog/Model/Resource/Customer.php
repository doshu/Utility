<?php

	class Doshu_Dlog_Model_Resource_Customer extends Mage_Core_Model_Resource_Db_Abstract {
	
		protected function _construct() {
		    $this->_init('dlog/customer', 'log_id');
		}
		
		
	}

?>
