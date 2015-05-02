<?php

	/*
	$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
	$setup->addAttribute('customer', 'points', array(
		'label'		=> 'Punti Accumulati',
		'type'		=> 'decimal',
		'input'		=> 'text',
		'visible'	=> true,
		'required'	=> false,
		'position'	=> 1,
	));
	*/
	$installer = new Mage_Customer_Model_Entity_Setup('core_setup');
	
	$installer->startSetup();
	$attribute  = array(
		    'type'          => 'text',
		    'backend_type'  => 'decimal',
		    'frontend_input' => 'text',
		    'is_user_defined' => true,
		    'label'         => 'Punti Accumulati',
		    'visible'       => 0,
		    'is_visible' => 0,
		    'required'      => false,
		    'user_defined'  => false,   
		    'searchable'    => false,
		    'filterable'    => false,
		    'comparable'    => false,
		    'default'       => 0,
		    'group' => 'rewards'
	);
	
	/*
	$vCustomerEntityType = $installer->getEntityTypeId('customer');
	$vCustAttributeSetId = $installer->getDefaultAttributeSetId($vCustomerEntityType);
	$vCustAttributeGroupId = $installer->getDefaultAttributeGroupId($vCustomerEntityType, $vCustAttributeSetId);
	*/
	
	$installer->addAttribute('customer', 'points', $attribute);
	
	//$installer->addAttributeToGroup($vCustomerEntityType, $vCustAttributeSetId, $vCustAttributeGroupId, 'points', 0);
	
	$oAttribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'points');
	$oAttribute->setData('used_in_forms', array('adminhtml_customer'));
	
	$oAttribute->save();

	$installer->endSetup();
	
	
	/*
	$installer = new Mage_Customer_Model_Entity_Setup('core_setup');

$installer->startSetup();

$vCustomerEntityType = $installer->getEntityTypeId('customer');
$vCustAttributeSetId = $installer->getDefaultAttributeSetId($vCustomerEntityType);
$vCustAttributeGroupId = $installer->getDefaultAttributeGroupId($vCustomerEntityType, $vCustAttributeSetId);

$installer->addAttribute('customer', 'mobile', array(
        'label' => 'Customer Mobile',
        'input' => 'text',
        'type'  => 'varchar',
        'forms' => array('customer_account_edit','customer_account_create','adminhtml_customer','checkout_register'),
        'required' => 0,
        'user_defined' => 1,
));

$installer->addAttributeToGroup($vCustomerEntityType, $vCustAttributeSetId, $vCustAttributeGroupId, 'mobile', 0);

$oAttribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'mobile');
$oAttribute->setData('used_in_forms', array('customer_account_edit','customer_account_create','adminhtml_customer','checkout_register'));
$oAttribute->save();

$installer->endSetup();
*/

