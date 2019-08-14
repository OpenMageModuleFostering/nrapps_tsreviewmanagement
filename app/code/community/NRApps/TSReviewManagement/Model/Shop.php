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
 * Class NRApps_TSReviewManagement_Model_Shop
 *
 * @method NRApps_TSReviewManagement_Model_Resource_Shop getResource()
 */
class NRApps_TSReviewManagement_Model_Shop extends Mage_Core_Model_Abstract
{


    /**
     *
     */
    protected function _construct()
    {
        $this->_init('nrapps_tsreviewmanagement/shop');
    }


    /**
     * @param string $tsid
     *
     * @return $this
     */
    public function loadByTsid($tsid)
    {
        $this->load($tsid, 'tsid');

        return $this;
    }


    /**
     * @return array
     */
    public function getConfiguredStores()
    {
        $configuredStores = array();

        $config = Mage::getSingleton('nrapps_tsreviewmanagement/config');

        /** @var Mage_Core_Model_Store $store */
        foreach (Mage::app()->getStores() as $store) {

            $tsid = $config->getTsid($store);

            if ($tsid) {

                $configuredStores[$store->getId()] = $store->getId();
            }
        }

        return $configuredStores;
    }
}
