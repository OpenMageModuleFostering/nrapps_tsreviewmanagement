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
 * Class NRApps_TSReviewManagement_Model_Response
 */
class NRApps_TSReviewManagement_Model_Response
{


    /**
     * @var Varien_Object
     */
    protected $_responseData;


    /**
     * @param array $responseData
     *
     * @return $this
     */
    public function setResponseData(array $responseData)
    {
        $this->_responseData = new Varien_Object($responseData);

        return $this;
    }


    /**
     * @return null|Varien_Object
     */
    public function getError()
    {
        if ($this->_responseData->getData('response/code') != 200) {

            return new Varien_Object(array(
                'code' => $this->_responseData->getData('response/code'),
                'status' => $this->_responseData->getData('response/status'),
                'message' => $this->_responseData->getData('response/message'),
            ));
        }

        return null;
    }


    /**
     * @return array
     */
    public function getShopInfo()
    {
        return array(
            'tsid' => $this->_responseData->getData('response/data/shop/tsId'),
            'url' => $this->_responseData->getData('response/data/shop/url'),
            'name' => $this->_responseData->getData('response/data/shop/name'),
            'language_iso2' => $this->_responseData->getData('response/data/shop/languageISO2'),
            'target_market_iso3' => $this->_responseData->getData('response/data/shop/targetMarketISO3'),
        );
    }


    /**
     * @return array
     */
    public function getReviewInfo()
    {
        $review = array();
        $reviewsIndex = $this->_responseData->getData('response/data/shop/reviews');
		
		
        if (is_array($reviewsIndex)) {
        	

            /**
             * if one review in in response it is not wrapped in sub array
             */
            if (!array_key_exists('0', $reviewsIndex)) {
                $reviewsIndex = array('-1' => true);
            }

            foreach (array_keys($reviewsIndex) as $_reviewsIndex) {

                $dataKeyPrefix = "response/data/shop/reviews/{$_reviewsIndex}/";


                $review[$_reviewsIndex] = array(
                    'uid' => $this->_responseData->getData($dataKeyPrefix . 'UID'),
                    'change_date' => $this->_date($this->_responseData->getData($dataKeyPrefix . 'changeDate')),
                    'creation_date' => $this->_date($this->_responseData->getData($dataKeyPrefix . 'creationDate')),
                    'confirmation_date' => $this->_date($this->_responseData->getData($dataKeyPrefix . 'confirmationDate')),
                    'order_date' => $this->_date($this->_responseData->getData($dataKeyPrefix . 'orderDate')),
                    'mark' => $this->_responseData->getData($dataKeyPrefix . 'mark'),
                    'mark_description' => $this->_responseData->getData($dataKeyPrefix . 'markDescription'),
                    'consumer_email' => $this->_responseData->getData($dataKeyPrefix . 'consumerEmail'),
                    'comment' => $this->_responseData->getData($dataKeyPrefix . 'comment'),
                    'order_reference' => $this->_responseData->getData($dataKeyPrefix . 'orderReference'),
                    'criterion' => array(),
                    'statement' => array(),
                );


                $criterionIndex = $this->_responseData->getData($dataKeyPrefix . 'criteria');

                if (is_array($criterionIndex)) {

                    foreach (array_keys($criterionIndex) as $_criterionIndex) {

                        $criterionType = $this->_responseData->getData("{$dataKeyPrefix}criteria/{$_criterionIndex}/type");

                        $review[$_reviewsIndex]['criterion'][$criterionType] = array(
                            'type' => $criterionType,
                            'mark' => $this->_responseData->getData("{$dataKeyPrefix}criteria/{$_criterionIndex}/mark"),
                            'mark_description' => $this->_responseData->getData("{$dataKeyPrefix}criteria/{$_criterionIndex}/markDescription"),
                        );
                    }
                }


                if ($this->_responseData->getData($dataKeyPrefix . 'statements')) {
              	
                        $review[$_reviewsIndex]['statement'] = array(
                        'uid' => $this->_responseData->getData($dataKeyPrefix . 'statements/0/UID'),
                        'change_date' => $this->_date($this->_responseData->getData($dataKeyPrefix . 'statements/0/changeDate')),
                        'creation_date' => $this->_date($this->_responseData->getData($dataKeyPrefix . 'statements/0/creationDate')),
                        'statement' => $this->_responseData->getData($dataKeyPrefix . 'statements/0/comment'),
                    );
                }
            }
        }
		
        return $review;
    }


    /**
     * @param $date
     *
     * @return null|string
     */
    protected function _date($date)
    {
        if ($date) {
            $date = new DateTime($date);
            return $date->format('Y-m-d H:i:s');
        }

        return null;
    }
}
