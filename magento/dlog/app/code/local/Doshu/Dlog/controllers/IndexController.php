<?php

class Doshu_Dlog_IndexController extends Mage_Adminhtml_Controller_Action {

	

	public function customerAction() {
		
		if($this->getRequest()->isPost()) {
			$Log = Mage::getSingleton('dlog/customer');
			$customer = $this->getRequest()->getPost('customer');
			
			$from = date_create_from_format(
				'd/m/Y', 
				$this->getRequest()->getPost('from'), 
				new DateTimeZone(Mage::app()->getStore()->getConfig('general/locale/timezone'))
			);
			$to = date_create_from_format(
				'd/m/Y', 
				$this->getRequest()->getPost('to'),
				new DateTimeZone(Mage::app()->getStore()->getConfig('general/locale/timezone'))
			);
			
			if($from instanceof DateTime && $to instanceof DateTime) {
			
				$utc = new DateTimeZone('GMT');
				$from->setTime(0, 0, 0);
				$to->setTime(23, 59, 59);
				
				$from->setTimezone($utc);
				$to->setTimezone($utc);
				
				$from = $from->format('Y-m-d H:i:s');
				$to = $to->format('Y-m-d H:i:s');
			}
			if($customer && $from && $to) {
				$Log->setLog(
					$customer,
					$from,
					$to
				);
			}
		}
		$this->loadLayout();
		$this->renderLayout();
	}
	
}

?>
