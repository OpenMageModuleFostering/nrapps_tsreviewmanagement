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
 * Class NRApps_TSReviewManagement_Block_Adminhtml_Widget_Grid_Column_Renderer_Line
 */
class NRApps_TSReviewManagement_Block_Adminhtml_Widget_Grid_Column_Renderer_Line extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Longtext
{


    /**
     * @param Varien_Object $row
     *
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $value = parent::render($row);

        return sprintf('<div style="height: 18px; overflow: hidden;">%s</div>', $value);
    }
}
