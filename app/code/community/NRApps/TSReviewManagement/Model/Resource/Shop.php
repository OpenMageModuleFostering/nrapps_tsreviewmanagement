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
 * Class NRApps_TSReviewManagement_Model_Resource_Shop
 */
class NRApps_TSReviewManagement_Model_Resource_Shop extends Mage_Core_Model_Resource_Db_Abstract
{


    /**
     *
     */
    protected function _construct()
    {
        $this->_init('nrapps_tsreviewmanagement/shop', 'entity_id');
    }


    /**
     * @param $storeId
     */
    public function deleteByStoreId($storeId)
    {
        $this->_getWriteAdapter()->delete(
            $this->getMainTable(),
            $this->_getWriteAdapter()->quoteInto('store_id' . ' = ?', $storeId)
        );
    }
}
