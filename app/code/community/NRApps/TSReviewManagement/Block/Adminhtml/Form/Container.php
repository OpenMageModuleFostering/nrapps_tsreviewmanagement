<?php
/**
 * @category   NRApps
 * @package    NRApps_TSReviewManagement
 * @copyright  Copyright (c) 2014 integer_net GmbH (http://www.integer-net.de/)
 * @license    http://www.trustedshops.com/tsdocument/TS_EULA_en.pdf
 * @author     nr-apps.com (http://www.nr-apps.com/) powered by integer_net GmbH
 * @author     integer_net GmbH <info@integer-net.de>
 * @author     Viktor Franz <vf@integer-net.de>
 */


/**
 * Class NRApps_TSReviewManagement_Block_Adminhtml_Form_Container
 */
class NRApps_TSReviewManagement_Block_Adminhtml_Form_Container extends Mage_Adminhtml_Block_Widget_Form_Container
{


    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->_removeButton('back');
        $this->_removeButton('save');
        $this->_removeButton('reset');

        $configUrl = $this->getUrl('*/system_config/edit', array('section' => 'nrapps_tsreviewmanagement'));

        $this->_addButton('config', array(
            'label' => $this->__('Configuration'),
            'onclick' => sprintf("setLocation('%s')", $configUrl),
        ));

        if(Mage::getSingleton('nrapps_tsreviewmanagement/config')->isDevMode()) {

            $this->_addButton('delete', array(
                'label' => $this->__('DEV DELETE ALL DATA'),
                'onclick' => sprintf("setLocation('%s')", $this->getUrl('*/*/delete')),
                'class' => 'delete',
            ));
        }
    }


    /**
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        /** @var NRApps_TSReviewManagement_Block_Adminhtml_Form_Form $form */
        $form = $this->getLayout()->createBlock('nrapps_tsreviewmanagement/adminhtml_form_form', 'form');

        $this->setChild('form', $form);

        return Mage_Adminhtml_Block_Widget_Container::_prepareLayout();
    }


    /**
     * @return string
     */
    public function getHeaderText()
    {
        return $this->__('Trusted Shops Customer Review Management');
    }
}
