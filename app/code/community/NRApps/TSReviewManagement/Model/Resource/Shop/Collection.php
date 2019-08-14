<?php
/**
 * @category   NRApps
 * @package    NRApps_TSReviewManagement
 * @copyright  Copyright (c) 2014 integer_net GmbH (http://www.integer-net.de/)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software Licence 3.0 (OSL-3.0)
 * @author     nr-apps.com (http://www.nr-apps.com/) powered by integer_net GmbH
 * @author     integer_net GmbH <info@integer-net.de>
 * @author     Viktor Franz <vf@integer-net.de>
 */


/**
 * Class NRApps_TSReviewManagement_Model_Resource_Review_Shop_Collection
 */
class NRApps_TSReviewManagement_Model_Resource_Review_Shop_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{


    /**
     *
     */
    protected function _construct()
    {
        $this->_init('nrapps_tsreviewmanagement/shop');
    }
}
