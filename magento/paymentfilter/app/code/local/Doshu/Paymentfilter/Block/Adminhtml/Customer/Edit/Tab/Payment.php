<?php
class Doshu_Paymentfilter_Block_Adminhtml_Customer_Edit_Tab_Payment
    extends Mage_Adminhtml_Block_Template
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected $_chat = null;

    protected function _construct()
    {
        parent::_construct();

        $this->setTemplate('paymentfilter/customer/edit/tab/payment.phtml');
    }

    public function getTabLabel() {
        return $this->__('Metodi di pagamento');
    }

    public function getTabTitle() {
        return $this->__('Metodi di pagamento');
    }

    public function canShowTab() {
        return true;
    }

    public function isHidden() {
        return false;
    }

    public function getCustomer() {
        $customer = Mage::registry('current_customer');
        return $customer->getData('entity_id');
    }
    
    public function getCustomerData() {
    	$order = Mage::registry('current_user');
    	return $order->getData();
    }
  
}

?>
