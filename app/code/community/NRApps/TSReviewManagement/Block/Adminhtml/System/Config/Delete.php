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
 * Class NRApps_TSReviewManagement_Block_Adminhtml_System_Config_Delete
 */
class NRApps_TSReviewManagement_Block_Adminhtml_System_Config_Delete extends Mage_Adminhtml_Block_System_Config_Form_Field
{


    /**
     * Unset some non-related element parameters
     *
     * @param Varien_Data_Form_Element_Abstract $element
     *
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();

        return parent::render($element);
    }


    /**
     * Get the button and scripts contents
     *
     * @param Varien_Data_Form_Element_Abstract $element
     *
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $originalData = $element->getOriginalData();
        $url = $this->getUrl('*/nrappstsreviewmanagement_index/delete', array('_current' => true));

        return <<<BUTTON
        <button onclick="setLocation('{$url}')" class="scalable" type="button" id="{$element->getHtmlId()}">
            <span>{$this->escapeHtml($originalData['button_label'])}</span>
        </button>
BUTTON;
    }
}
