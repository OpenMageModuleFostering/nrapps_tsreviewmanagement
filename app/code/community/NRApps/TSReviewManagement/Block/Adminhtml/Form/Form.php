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
 * Class NRApps_TSReviewManagement_Block_Adminhtml_Form_Form
 */
class NRApps_TSReviewManagement_Block_Adminhtml_Form_Form extends Mage_Adminhtml_Block_Widget_Form
{


    /**
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'action' => $this->getUrl('*/*/import'),
            'id' => 'edit_form',
            'method' => 'post',
        ));

        $fieldset = $form->addFieldset('form', array(
            'legend' => $this->__('Import Reviews'),
        ));

        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);

        $configuredStores = Mage::getModel('nrapps_tsreviewmanagement/shop')->getConfiguredStores();

        if ($configuredStores) {

            if (!Mage::app()->isSingleStoreMode()) {
                $fieldset->addField('store_id', 'select', array(
                    'name' => 'store_id',
                    'label' => $this->__('Store'),
                    'title' => $this->__('Store'),
                    'required' => true,
                    'values' => Mage::getSingleton('nrapps_tsreviewmanagement/system_store')->getConfiguredStoreValuesForForm($configuredStores),
                ));
            }

            $fieldset->addField('start_date', 'date', array(
                'name' => 'start_date',
                'label' => $this->__('Start Date'),
                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'format' => $dateFormatIso,
                'required' => true,
            ));

            $fieldset->addField('end_date', 'date', array(
                'name' => 'end_date',
                'label' => $this->__('End Date'),
                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'format' => $dateFormatIso,
                'required' => true,
            ));

            /** @var Mage_Adminhtml_Block_Widget_Button $submitButton */
            $submitButton = $this->getLayout()->createBlock('adminhtml/widget_button', null, array(
                'type' => 'submit',
                'label' => $this->__('Import'),
            ));

            $fieldset->addField('submit', 'note', array(
                'text' => $submitButton->toHtml(),
            ));

        } else {
            $fieldset->addField('submit', 'note', array(
                'text' => $this->__('No configuration available.'),
            ));
        }

        $form->setValues($this->_getValues());
        $form->setData('use_container', true);
        $this->setForm($form);

        return parent::_prepareForm();
    }


    /**
     * @return array
     */
    protected function _getValues()
    {
        $endDate = new DateTime();
        $endDate->setTime(0, 0, 0);

        $startDate = clone $endDate;
        $startDate->sub(new DateInterval('P1D'));

        return array(
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        );
    }
}
