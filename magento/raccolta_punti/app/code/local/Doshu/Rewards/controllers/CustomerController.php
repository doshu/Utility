<?php
	
	class Doshu_Rewards_CustomerController extends Mage_Core_Controller_Front_Action {  

    public function preDispatch() {
        
        parent::preDispatch();
 
        if (!Mage::getSingleton('customer/session')->authenticate($this)) {
            $this->setFlag('', 'no-dispatch', true);
        	// adding message in customer login page
        	//Mage::getSingleton('core/session')->addSuccess(Mage::helper('mymodule')->__('Please sign in or create a new account'));
        }
    }          
                 

    public function viewAction() {                  
    	$this->loadLayout();       
       	$this->getLayout()->getBlock('head')->setTitle($this->__('Raccolta Punti'));    
    	$this->renderLayout();
    }
    
    public function usepointsAction() {
    	Mage::getModel('customer/session')->setData('doshu_use_points', true);
    	$this->_redirectUrl(Mage::getUrl('checkout/cart/index'));
    }
    
    
    public function notusepointsAction() {
    	Mage::getModel('customer/session')->setData('doshu_use_points', false);
    	$this->_redirectUrl(Mage::getUrl('checkout/cart/index'));
    }
}   
