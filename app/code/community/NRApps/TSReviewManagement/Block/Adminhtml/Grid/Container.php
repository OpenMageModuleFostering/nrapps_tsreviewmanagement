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
 * Class NRApps_TSReviewManagement_Block_Adminhtml_Grid_Container
 */
class NRApps_TSReviewManagement_Block_Adminhtml_Grid_Container extends Mage_Core_Block_Abstract
{


    /**
     * @return Mage_Core_Block_Abstract
     */
    protected function _toHtml()
    {
        return '<div id="nrapps_tsreviewmanagement_grid_container"></div>';
    }
}
