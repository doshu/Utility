<?php
class Doshu_Rewards_Block_Adminhtml_Customer_Edit_Tab_Rewards
    extends Mage_Adminhtml_Block_Template
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected $_chat = null;

    protected function _construct()
    {
        parent::_construct();

        $this->setTemplate('rewards/customer/edit/tab/rewards.phtml');
    }

    public function getTabLabel() {
        return $this->__('Raccolta Punti');
    }

    public function getTabTitle() {
        return $this->__('Raccolta Punti');
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
    	$customer = Mage::getModel('customer/customer')->load($this->getCustomer());
    	return $customer->getData();
    }
  
}

?>
