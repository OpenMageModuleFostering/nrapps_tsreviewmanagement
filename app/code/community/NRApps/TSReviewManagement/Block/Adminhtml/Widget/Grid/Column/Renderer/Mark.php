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
 * Class NRApps_TSReviewManagement_Block_Adminhtml_Widget_Grid_Column_Renderer_Mark
 */
class NRApps_TSReviewManagement_Block_Adminhtml_Widget_Grid_Column_Renderer_Mark extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Options
{


    /**
     * @param Varien_Object $row
     *
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $value = parent::render($row);

        $mark = (float)$row->getData($this->getColumn()->getData('mark'));

        $iconColor = array(
            1 => 'yellow',
            2 => 'yellow',
            3 => 'yellow',
            4 => 'yellow',
            5 => 'yellow',
        );

        $markIcon = $row->getData($this->getColumn()->getData('mark'));
        $markIcon = round($markIcon);
        $markIconColor = array_key_exists((int)$markIcon, $iconColor) ? $iconColor[(int)$markIcon] : null;
        $markIcon = str_repeat("&#9733;", $markIcon);

        return sprintf('<span title="%s (%s)" style="font-size: 14px; color: %s">%s</span>', $value, $mark, $markIconColor, $markIcon);
    }
}
