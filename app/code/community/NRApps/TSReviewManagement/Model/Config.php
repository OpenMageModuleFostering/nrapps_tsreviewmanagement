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
 * Class NRApps_TSReviewManagement_Model_Config
 */
class NRApps_TSReviewManagement_Model_Config
{


    /**
     * @return bool
     */
    public function isScheduling()
    {
        return Mage::getStoreConfigFlag('nrapps_tsreviewmanagement/settings/is_scheduling', Mage_Core_Model_App::ADMIN_STORE_ID);
    }


    /**
     * @param null $store
     *
     * @return string
     */
    public function getTsid($store = null)
    {
        return trim(Mage::getStoreConfig('nrapps_tsreviewmanagement/settings/tsid', $store));
    }


    /**
     * @param null $store
     *
     * @return string
     */
    public function getApiUri($store = null)
    {
        return trim(Mage::getStoreConfig('nrapps_tsreviewmanagement/settings/api_uri', $store));
    }


    /**
     * @param null $store
     *
     * @return string
     */
    public function getApiUser($store = null)
    {
        return trim(Mage::getStoreConfig('nrapps_tsreviewmanagement/settings/api_user', $store));
    }


    /**
     * @param null $store
     *
     * @return string
     */
    public function getApiPassword($store = null)
    {
        return Mage::helper('core')->decrypt(Mage::getStoreConfig('nrapps_tsreviewmanagement/settings/api_password', $store));
    }


    /**
     * @param null $store
     *
     * @return string
     */
    public function getApiParamSize($store = null)
    {
        return trim(Mage::getStoreConfig('nrapps_tsreviewmanagement/settings/api_param_size', $store));
    }

    /**
     * @return bool
     */
    public function isDevMode()
    {
        return Mage::getStoreConfigFlag('nrapps_tsreviewmanagement/settings/dev_mode');
    }
}
