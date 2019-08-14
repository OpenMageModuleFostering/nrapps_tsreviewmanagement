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
 * Class NRApps_TSReviewManagement_Model_Review
 *
 * @method NRApps_TSReviewManagement_Model_Resource_Review getResource()
 */
class NRApps_TSReviewManagement_Model_Review extends Mage_Core_Model_Abstract
{


    /**
     *
     */
    protected function _construct()
    {
        $this->_init('nrapps_tsreviewmanagement/review');
    }


    /**
     * @param string $uid
     *
     * @return $this
     */
    public function loadByUid($uid)
    {
        $this->load($uid, 'uid');

        return $this;
    }


    /**
     * @param int $shopId
     *
     * @return $this
     */
    public function setShopId($shopId)
    {
        $this->setData('shop_id', $shopId);

        return $this;
    }


    /**
     * @return array
     */
    public function getMarkOptions()
    {
        return array(
            'EXCELLENT' => Mage::helper('nrapps_tsreviewmanagement')->__('Excellent'),
            'GOOD' => Mage::helper('nrapps_tsreviewmanagement')->__('Good'),
            'FAIR' => Mage::helper('nrapps_tsreviewmanagement')->__('Fair'),
            'POOR' => Mage::helper('nrapps_tsreviewmanagement')->__('Poor'),
            'VERY_POOR' => Mage::helper('nrapps_tsreviewmanagement')->__('Very Poor'),
        );
    }
}
