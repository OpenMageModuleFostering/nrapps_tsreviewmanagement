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
 * Class NRApps_TSReviewManagement_Model_System_Store
 */
class NRApps_TSReviewManagement_Model_System_Store extends Mage_Adminhtml_Model_System_Store
{


    /**
     * @param $configuredStores
     *
     * @return array
     */
    public function getConfiguredStoreValuesForForm($configuredStores)
    {
        foreach ($this->_storeCollection as $index => $store) {
            if (!array_key_exists($store->getId(), $configuredStores)) {
                unset($this->_storeCollection[$index]);
            }
        }

        return $this->getStoreValuesForForm(false, false);
    }
}
