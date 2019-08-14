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
 * Class NRApps_TSReviewManagement_Block_Adminhtml_Widget_Grid_Column_Renderer_Order
 */
class NRApps_TSReviewManagement_Block_Adminhtml_Widget_Grid_Column_Renderer_Order extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{


    /**
     * @param Varien_Object $row
     *
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $orderId = $row->getData('entity_id');
        $url = $this->getUrl('*/sales_order/view', array('order_id' => $orderId));
        $value = $row->getData($this->getColumn()->getIndex());

        if ($value) {
            return sprintf('<a target="_blank" href="%s">%s</div>', $url, $value);
        }
    }
}
