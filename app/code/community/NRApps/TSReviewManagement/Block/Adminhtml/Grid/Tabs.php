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
 * Class NRApps_TSReviewManagement_Block_Adminhtml_Grid_Tabs
 */
class NRApps_TSReviewManagement_Block_Adminhtml_Grid_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{


    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('nrapps_tsreviewmanagement_grid_tabs');
        $this->setDestElementId('nrapps_tsreviewmanagement_grid_container');
        $this->setTemplate('widget/tabshoriz.phtml');
    }


    /**
     * @return $this
     */
    protected function _prepareLayout()
    {

        $this->addTab('grid_gridOrder', array(
            'label' => $this->__('Reviews with reference'),
            'content' => $this->getLayout()->createBlock('nrapps_tsreviewmanagement/adminhtml_grid_gridOrder')->toHtml(),
        ));

        $this->addTab('grid_gridForeign', array(
            'label' => $this->__('Other Reviews'),
            'content' => $this->getLayout()->createBlock('nrapps_tsreviewmanagement/adminhtml_grid_gridForeign')->toHtml(),
        ));
    }
}
