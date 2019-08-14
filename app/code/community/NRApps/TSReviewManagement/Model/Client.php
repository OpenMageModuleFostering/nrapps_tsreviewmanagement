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
 * Class NRApps_TSReviewManagement_Model_Client
 */
class NRApps_TSReviewManagement_Model_Client
{


    protected $_uri;
    protected $_tsid;
    protected $_user;
    protected $_password;
    protected $_startDate;
    protected $_endDate;
    protected $_betterThan;
    protected $_worseThan;
    protected $_page;
    protected $_size;


    /**
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->_uri = $uri;
    }


    /**
     * @return string
     */
    protected function _getUri()
    {
        return str_replace('{{tsid}}', $this->_tsid, $this->_uri);
    }


    /**
     * @param string $tsid
     */
    public function setTsid($tsid)
    {
        $this->_tsid = $tsid;
    }


    /**
     * @param string $user
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }


    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }


    /**
     * @param string $paramFrom
     */
    public function setStartDate($paramFrom)
    {
        $this->_startDate = $paramFrom;
    }


    /**
     * @param string $paramTo
     */
    public function setEndDate($paramTo)
    {
        $this->_endDate = $paramTo;
    }


    /**
     * @param integer $betterThan
     */
    public function setBetterThan($betterThan)
    {
        $this->_betterThan = $betterThan;
    }


    /**
     * @param integer $worseThan
     */
    public function setWorseThan($worseThan)
    {
        $this->_worseThan = $worseThan;
    }


    /**
     * @param integer $page
     */
    public function setPage($page)
    {
        $this->_page = $page;
    }


    /**
     * @param integer $paramSize
     */
    public function setSize($paramSize)
    {
        $this->_size = $paramSize;
    }


    /**
     * @throws Exception
     *
     * @return string
     */
    public function fetch()
    {
        $client = new Zend_Http_Client();

        $client->setUri($this->_getUri());
        $client->setAuth($this->_user, $this->_password);

        if ($this->_startDate) {
            $client->setParameterGet('startDate', $this->_startDate);
        }

        if ($this->_endDate) {
            $client->setParameterGet('endDate', $this->_endDate);
        }

        if ($this->_betterThan) {
            $client->setParameterGet('betterThan', $this->_betterThan);
        }

        if ($this->_worseThan) {
            $client->setParameterGet('worseThan', $this->_worseThan);
        }

        if ($this->_page) {
            $client->setParameterGet('page', $this->_page);
        }

        if ($this->_size) {
            $client->setParameterGet('size', $this->_size);
        }

        /** @var Zend_Http_Response $response */
        $response = $client->request();

        if($response->isError()) {

            $message = Mage::helper('nrapps_tsreviewmanagement')->__($response->getMessage());
            $message = Mage::helper('nrapps_tsreviewmanagement')->__('Service Error: %1$s - %2$s', $response->getStatus(), $message);

            throw new Exception($message);
        }

        return $response->getBody();
    }
}
