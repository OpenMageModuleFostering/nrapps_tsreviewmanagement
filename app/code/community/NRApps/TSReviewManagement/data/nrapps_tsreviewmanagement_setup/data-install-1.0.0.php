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


/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

/**
 * Copy TSID from Symmetrics_TrustedRating module config
 */
foreach(Mage::app()->getStores() as $store) {

    $tsid = trim(Mage::getStoreConfig('trustedrating/data/trustedrating_id', $store->getId()));

    if($tsid) {
        $installer->setConfigData('nrapps_tsreviewmanagement/settings/tsid', $tsid, 'stores', $store->getId());
    }
}
