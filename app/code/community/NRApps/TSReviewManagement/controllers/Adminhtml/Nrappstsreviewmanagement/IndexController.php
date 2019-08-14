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
 * Class NRApps_TSReviewManagement_Adminhtml_NrappsTSReviewManagement_IndexController
 */
class NRApps_TSReviewManagement_Adminhtml_NrappsTSReviewManagement_IndexController extends Mage_Adminhtml_Controller_Action
{


    /**
     *
     */
    public function indexAction()
    {
        $this->loadLayout();

        $this->_setActiveMenu('sales/nrapps_tsreviewmanagement');
        $this->_title(Mage::helper('sales')->__('Sales'));
        $this->_title($this->__('Trusted Shops Reviews'));
        $this->getLayout()->getBlock('head')->addJs('nrapps_tsreviewmanagement/script.js');

        $this->_addContent($this->getLayout()->createBlock('nrapps_tsreviewmanagement/adminhtml_form_container'));
        $this->_addContent($this->getLayout()->createBlock('nrapps_tsreviewmanagement/adminhtml_grid_tabs'));
        $this->_addContent($this->getLayout()->createBlock('nrapps_tsreviewmanagement/adminhtml_grid_container'));

        $this->renderLayout();
    }


    /**
     *
     */
    public function importAction()
    {
        try {
            $postData = $this->getRequest()->getParams();
            $postData = $this->_filterDates($postData, array('start_date', 'end_date'));

            $storeId = $this->_getStoreId($postData);
            $startDate = $this->_getStartDate($postData);
            $endDate = $this->_getEndDate($postData);

            $importService = Mage::getSingleton('nrapps_tsreviewmanagement/importService');
            $importServiceStatus = $importService->import($storeId, $startDate, $endDate);

            $dateFormat = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
            $startDate = Mage::getSingleton('core/locale')->date($startDate->format('Y-m-d'), null, null, false)->toString($dateFormat);
            $endDate = Mage::getSingleton('core/locale')->date($endDate->format('Y-m-d'), null, null, false)->toString($dateFormat);

            if ($importServiceStatus) {
                $this->_getSession()->addSuccess($this->__('Rewies import for time period %1$s to %2$s has been successfully completed.', $startDate, $endDate));
            } else {
                $max = Mage::getSingleton('nrapps_tsreviewmanagement/config')->getApiParamSize() * NRApps_TSReviewManagement_Model_ImportService::MAX_API_CALLS;
                $this->_getSession()->addWarning($this->__('Reached maximum (%1$s) reviews import for time periode %2$s to %3$s, please choose a smaller time period.', $max, $startDate, $endDate));
            }

            $this->_getSession()->addSuccess($this->__('%s Reviews has been created.', $importService->getCountReviewCreate()));
            $this->_getSession()->addSuccess($this->__('%s Reviews has been updated.', $importService->getCountReviewUpdate()));

        } catch (Exception $e) {

            $this->_getSession()->addError($e->getMessage());
            Mage::logException($e);
        }

        $this->_redirect('*/*/index');
    }


    /**
     * Review Order Grid AJAX Request Action
     */
    public function gridrevieworderAction()
    {
        /** @var NRApps_TSReviewManagement_Block_Adminhtml_Grid_GridOrder $grid */
        $grid = $this->getLayout()->createBlock('nrapps_tsreviewmanagement/adminhtml_grid_gridOrder');

        $this->getResponse()->setBody($grid->toHtml());
    }


    /**
     * Review Foreign Grid AJAX Request Action
     */
    public function gridreviewforeignAction()
    {
        /** @var NRApps_TSReviewManagement_Block_Adminhtml_Grid_GridForeign $grid */
        $grid = $this->getLayout()->createBlock('nrapps_tsreviewmanagement/adminhtml_grid_gridForeign');

        $this->getResponse()->setBody($grid->toHtml());
    }


    /**
     * Mass Delete
     */
    public function massDeleteAction()
    {
        foreach ((array)$this->getRequest()->getParam('entity_id') as $entityId) {

            $review = Mage::getModel('nrapps_tsreviewmanagement/review');
            $review->setId($entityId);
            $review->delete();
        }
    }


    /**
     *
     */
    public function viewAction()
    {
        /** @var NRApps_TSReviewManagement_Model_Review $review */
        $review = Mage::getModel('nrapps_tsreviewmanagement/review');
        $review->load($this->getRequest()->getParam('id'));

        /** @var NRApps_TSReviewManagement_Block_Adminhtml_Info $reviewInfo */
        $reviewInfo = $this->getLayout()->createBlock('nrapps_tsreviewmanagement/adminhtml_info');
        $reviewInfo->setReview($review);

        $this->getResponse()->setBody($reviewInfo->toHtml());
    }


    /**
     * @param $postData
     *
     * @throws Exception
     *
     * @return integer
     */
    protected function _getStoreId($postData)
    {
        $configuredStores = Mage::getModel('nrapps_tsreviewmanagement/shop')->getConfiguredStores();

        if (array_key_exists('store_id', $postData)
            && array_key_exists($postData['store_id'], $configuredStores)
        ) {
            return $postData['store_id'];

        } elseif (count($configuredStores) === 1) {

            return array_pop($configuredStores);
        }

        Mage::throwException($this->__('Trusted Shops Reviews store configuration error.'));
    }

    /**
     *
     */
    public function deleteAction()
    {
        $store = $this->getRequest()->getParam('store');
        $store = Mage::app()->getStore($store);

        if($store && $store->getId()) {

            try {
                Mage::getResourceModel('nrapps_tsreviewmanagement/shop')->deleteByStoreId($store->getId());
                $this->_getSession()->addSuccess($this->__('The store reviews has been deleted.'));

            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                Mage::logException($e);
            }
        }

        $this->_redirect('*/system_config/edit', array('_current' => true));
    }


    /**
     * @param array $postData
     *
     * @return DateTime
     */
    protected function _getStartDate($postData)
    {
        $endDate = clone $this->_getEndDate($postData);

        if (array_key_exists('start_date', $postData)) {
            $startDate = DateTime::createFromFormat('Y-m-d', $postData['start_date']);
        } else {
            $startDate = clone $endDate;
        }

        if ($startDate > $endDate) {

            return $endDate;
        }

        return $startDate;
    }


    /**
     * @param array $postData
     *
     * @return DateTime
     */
    protected function _getEndDate($postData)
    {
        $nowDate = new DateTime();

        if (array_key_exists('end_date', $postData)) {
            $endDate = DateTime::createFromFormat('Y-m-d', $postData['end_date']);
        } else {
            $endDate = clone $nowDate;
        }

        if ($endDate > $nowDate) {
            return $nowDate;
        }

        return $endDate;
    }
}
