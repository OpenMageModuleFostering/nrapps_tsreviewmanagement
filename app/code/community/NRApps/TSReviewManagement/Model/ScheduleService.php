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
 * Class class NRApps_TSReviewManagement_Model_ScheduleService
 */
class NRApps_TSReviewManagement_Model_ScheduleService
{


    /**
     * @var NRApps_TSReviewManagement_Model_Config
     */
    protected $_config;

    /**
     * @var NRApps_TSReviewManagement_Model_Shop
     */
    protected $_shop;

    /**
     * @var NRApps_TSReviewManagement_Model_ImportService
     */
    protected $_importService;


    /**
     *
     */
    public function __construct()
    {
        $this->_config = Mage::getSingleton('nrapps_tsreviewmanagement/config');
        $this->_shop = Mage::getSingleton('nrapps_tsreviewmanagement/shop');
        $this->_importService = Mage::getSingleton('nrapps_tsreviewmanagement/importService');
    }


    /**
     *
     */
    public function exec(Varien_Object $schedule = null)
    {
        if ($this->_config->isScheduling()) {

            $message = array();

            $startDate = new DateTime();
            $startDate->sub(new DateInterval('P2D'));
            $endDate = new DateTime();

            $startDate2 = new DateTime();
            $startDate2->sub(new DateInterval('P14D'));
            $endDate2 = new DateTime();
            $endDate2->sub(new DateInterval('P12D'));

            foreach (array_keys($this->_shop->getConfiguredStores()) as $storeId) {

                try {
                    $this->_importService->import($storeId, $startDate, $endDate);
                } catch (Exception $e) {
                    $message[] = sprintf('Store Id: %1$s - %2$s',$storeId, $e->getMessage());
                }

                try {
                    $this->_importService->import($storeId, $startDate2, $endDate2);
                } catch (Exception $e) {
                    $message[] = sprintf('Store Id: %1$s - %2$s',$storeId, $e->getMessage());
                }
            }

            if ($schedule && $message) {

                Mage::throwException(implode("\n", $message));
            }
        }
    }
}
