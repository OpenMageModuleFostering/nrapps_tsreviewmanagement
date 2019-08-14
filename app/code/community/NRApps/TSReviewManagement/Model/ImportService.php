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
 * Class NRApps_TSReviewManagement_Model_ImportService
 */
class NRApps_TSReviewManagement_Model_ImportService
{


    /**
     * max recursive api call iterations
     */
    const MAX_API_CALLS = 10;

    /**
     * @var NRApps_TSReviewManagement_Model_Config
     */
    protected $_config;

    /**
     * @var NRApps_TSReviewManagement_Model_Client
     */
    protected $_client;

    /**
     * @var NRApps_TSReviewManagement_Model_Response
     */
    protected $_response;

    /**
     * @var NRApps_TSReviewManagement_Model_Shop
     */
    protected $_shop;

    /**
     * @var boolean
     */
    protected $_isShopCreate = false;

    /**
     * @var boolean
     */
    protected $_isShopUpdate = false;

    /**
     * @var int
     */
    protected $_countReviewCreate = 0;

    /**
     * @var int
     */
    protected $_countReviewUpdate = 0;


    /**
     *
     */
    public function __construct()
    {
        $this->_config = Mage::getSingleton('nrapps_tsreviewmanagement/config');
        $this->_client = Mage::getSingleton('nrapps_tsreviewmanagement/client');
        $this->_response = Mage::getSingleton('nrapps_tsreviewmanagement/response');
        $this->_shop = Mage::getSingleton('nrapps_tsreviewmanagement/shop');
    }


    /**
     * @param $store
     * @param DateTime $startDate
     * @param DateTime $endDate
     *
     * @return bool
     */
    public function import($store, DateTime $startDate, DateTime $endDate = null)
    {
        $this->_client->setUri($this->_config->getApiUri($store));
        $this->_client->setTsid($this->_config->getTsid($store));
        $this->_client->setUser($this->_config->getApiUser($store));
        $this->_client->setPassword($this->_config->getApiPassword($store));
        $this->_client->setStartDate($startDate->format('Y-m-d'));
        $this->_client->setEndDate($endDate ? $endDate->format('Y-m-d') : null);
        $this->_client->setSize($this->_config->getApiParamSize($store));

        return $this->_import(0, $store, $startDate, $endDate);
    }


    /**
     * @param $page
     * @param $store
     * @param DateTime $startDate
     * @param DateTime $endDate
     *
     * @return bool
     */
    protected function _import($page, $store, DateTime $startDate, DateTime $endDate = null)
    {
        $this->_client->setPage($page);

        $data = $this->_client->fetch();
        $data = Mage::helper('core')->jsonDecode($data);

        $this->_response->setResponseData($data);

        if ($error = $this->_response->getError()) {

            $message = Mage::helper('nrapps_tsreviewmanagement')->__($error->getData('message'));
            $message = Mage::helper('nrapps_tsreviewmanagement')->__('Service Error: %1$s/%2$s - %3$s', $error->getData('status'), $error->getData('code'), $message);

            Mage::throwException($message);
        }

        /**
         * create-update shop
         */
        if (!$this->_isShopUpdate && !$this->_isShopCreate) {

            $shopInfo = $this->_response->getShopInfo();

            $this->_shop->loadByTsid($shopInfo['tsid']);
            $this->_shop->getId() ? ($this->_isShopUpdate = true) : ($this->_isShopCreate = true);
            $this->_shop->addData($shopInfo);
            $this->_shop->setData('store_id', $store);
            $this->_shop->save();
        }

        /**
         * create-update review
         */
        $reviewInfo = $this->_response->getReviewInfo();

        foreach ($reviewInfo as $reviewData) {

            $review = $this->_getReviewInstance();
            $review->loadByUid($reviewData['uid']);
            $review->getId() ? $this->_countReviewUpdate++ : $this->_countReviewCreate++;
            $review->setShopId($this->_shop->getId());
            $review->addData($reviewData);
            $review->save();
        }

        /**
         * recursive call
         */
        if (count($reviewInfo) == $this->_config->getApiParamSize($store) && $page < (self::MAX_API_CALLS - 1)) {

            return $this->_import(++$page, $store, $startDate, $endDate);

        } else if ($page == (self::MAX_API_CALLS - 1)) {

            return false;
        }

        return true;
    }


    /**
     * @return NRApps_TSReviewManagement_Model_Shop
     */
    protected function _getShopInstance()
    {
        return Mage::getModel('nrapps_tsreviewmanagement/shop');
    }


    /**
     * @return NRApps_TSReviewManagement_Model_Review
     */
    protected function _getReviewInstance()
    {
        return Mage::getModel('nrapps_tsreviewmanagement/review');
    }


    /**
     * @return NRApps_TSReviewManagement_Model_Shop
     */
    public function getShop()
    {
        return $this->_shop;
    }


    /**
     * @return bool
     */
    public function isShopCreate()
    {
        return $this->_isShopCreate;
    }


    /**
     * @return bool
     */
    public function isShopUpdate()
    {
        return $this->_isShopUpdate;
    }


    /**
     * @return int
     */
    public function getCountReviewCreate()
    {
        return $this->_countReviewCreate;
    }


    /**
     * @return int
     */
    public function getCountReviewUpdate()
    {
        return $this->_countReviewUpdate;
    }
}
