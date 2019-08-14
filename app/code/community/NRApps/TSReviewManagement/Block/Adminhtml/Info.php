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
 * Class NRApps_TSReviewManagement_Block_Adminhtml_Info
 */
class NRApps_TSReviewManagement_Block_Adminhtml_Info extends Mage_Adminhtml_Block_Template
{


    /**
     * @var string
     */
    protected $_template = 'nrapps_tsreviewmanagement/info.phtml';

    /**
     * @var NRApps_TSReviewManagement_Model_Review
     */
    protected $_review;


    /**
     * @param NRApps_TSReviewManagement_Model_Review $review
     *
     * @return $this
     */
    public function setReview(NRApps_TSReviewManagement_Model_Review $review)
    {
        $this->_review = $review;

        return $this;
    }


    /**
     * @return null|NRApps_TSReviewManagement_Model_Review
     */
    public function getReview()
    {
        return $this->_review;
    }


    /**
     * @param $orderReference
     *
     * @return null|string
     */
    public function getOrderLink($orderReference)
    {
        /** @var Mage_Sales_Model_Resource_Order $orderResource */
        $orderResource = Mage::getResourceModel('sales/order');
        $incrementId = $orderResource->getIncrementId($orderReference);

        if($incrementId ) {

            $url = $this->getUrl('*/sales_order/view', array('order_id' => $orderReference));

            return sprintf('<a target="_blank" href="%s">%s</div>', $url, $incrementId);
        }

        return $orderReference;
    }

    /**
     * @param $mark
     * @param $description
     * @param bool $row
     *
     * @return string
     */
    public function getMarkInfo($mark, $description, $row = false)
    {
        $markOptions = $this->getReview() ? $this->getReview()->getMarkOptions() : array();

        $iconColor = array(
            1 => 'yellow',
            2 => 'yellow',
            3 => 'yellow',
            4 => 'yellow',
            5 => 'yellow',
        );

        if (array_key_exists($description, $markOptions)) {
            $description = $markOptions[$description];
        }

        $markIcon = $mark;
        $markIcon = round($markIcon);
        $markIconColor = array_key_exists((int)$markIcon, $iconColor) ? $iconColor[(int)$markIcon] : null;
        $markIcon = str_repeat("&#9733;", $markIcon);

        if ($row) {
            return sprintf('<span style="display: inline-block; width: 80px; font-size: 14px; color: %s">%s</span> <span>%s (%s)</span>', $markIconColor, $markIcon, $description, (float)$mark);
        }

        return sprintf('<span style="font-size: 14px; color: %s">%s</span> <span>%s (%s)</span>', $markIconColor, $markIcon, $description, (float)$mark);
    }
}
