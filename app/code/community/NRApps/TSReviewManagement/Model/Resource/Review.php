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
 * Class NRApps_TSReviewManagement_Model_Resource_Review
 */
class NRApps_TSReviewManagement_Model_Resource_Review extends Mage_Core_Model_Resource_Db_Abstract
{


    /**
     *
     */
    protected function _construct()
    {
        $this->_init('nrapps_tsreviewmanagement/review', 'entity_id');
    }


    /**
     * @param Mage_Core_Model_Abstract|Varien_Object $object
     *
     * @return $this
     */
    public function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        parent::_afterLoad($object);
        $this->_loadCriterion($object);
        $this->_loadStatement($object);
        $this->_loadShop($object);

        return $this;
    }


    /**
     * @param Mage_Core_Model_Abstract $object
     *
     * @return $this
     */
    public function _afterSave(Mage_Core_Model_Abstract $object)
    {
        parent::_afterSave($object);
        $this->_saveCriterion($object);
        $this->_saveStatement($object);

        return $this;
    }


    /**
     * @param Mage_Core_Model_Abstract $object
     *
     * @return $this
     */
    public function _loadCriterion(Mage_Core_Model_Abstract $object)
    {
        $select = $this->getReadConnection()->select();
        $select->from($this->getTable('nrapps_tsreviewmanagement/review_criterion'), '*');
        $select->where('review_id = ?', $object->getId());

        $criterion = $this->getReadConnection()->fetchAssoc($select);

        foreach($criterion as $index => $_criterion) {
            unset($criterion[$index]);
            unset($_criterion['entity_id']);
            unset($_criterion['review_id']);
            $criterion[$_criterion['type']] = $_criterion;
        }

        if($criterion) {
            $object->setData('criterion', $criterion);

        }

        return $this;
    }


    /**
     * @param Mage_Core_Model_Abstract $object
     *
     * @return $this
     */
    public function _loadStatement(Mage_Core_Model_Abstract $object)
    {
        $select = $this->getReadConnection()->select();
        $select->from($this->getTable('nrapps_tsreviewmanagement/review_statement'), '*');
        $select->where('review_id = ?', $object->getId());

        $statement = $this->getReadConnection()->fetchRow($select);

        if($statement) {
            unset($statement['entity_id']);
            unset($statement['review_id']);
            $object->setData('statement', $statement);
        }

        return $this;
    }

    /**
     * @param Mage_Core_Model_Abstract $object
     *
     * @return $this
     */
    public function _loadShop(Mage_Core_Model_Abstract $object)
    {
        $select = $this->getReadConnection()->select();
        $select->from($this->getTable('nrapps_tsreviewmanagement/shop'), '*');
        $select->where('entity_id = ?', $object->getData('shop_id'));

        $shop = $this->getReadConnection()->fetchRow($select);

        if($shop) {
            $object->setData('shop', $shop);
        }

        return $this;
    }


    /**
     * @param Mage_Core_Model_Abstract $object
     *
     * @return $this
     */
    public function _saveCriterion(Mage_Core_Model_Abstract $object)
    {
        if ($object->hasData('criterion')) {

            $criterion = $object->getData('criterion');

            if (is_array($criterion) && count($criterion)) {

                foreach ($criterion as $_criterion) {

                    $_criterion['review_id'] = $object->getId();

                    $this->_getWriteAdapter()->insertOnDuplicate(
                        $this->getTable('nrapps_tsreviewmanagement/review_criterion'),
                        $_criterion,
                        array('review_id', 'type')
                    );

                    $this->_getWriteAdapter()->delete(
                        $this->getTable('nrapps_tsreviewmanagement/review_criterion'),
                        array(
                            'review_id = ?' => $object->getId(),
                            'type NOT IN (?)' => array_keys($criterion),
                        )
                    );
                }

            } else {

                $this->_getWriteAdapter()->delete(
                    $this->getTable('nrapps_tsreviewmanagement/review_criterion'),
                    array('review_id = ?' => $object->getId())
                );
            }
        }

        return $this;
    }


    /**
     * @param Mage_Core_Model_Abstract $object
     *
     * @return $this
     */
    public function _saveStatement(Mage_Core_Model_Abstract $object)
    {
        if ($object->hasData('statement')) {

            $statement = $object->getData('statement');

            if (is_array($statement) && count($statement)) {

                $statement['review_id'] = $object->getId();

                $this->_getWriteAdapter()->insertOnDuplicate(
                    $this->getTable('nrapps_tsreviewmanagement/review_statement'),
                    $statement,
                    array('review_id')
                );

            } else {

                $this->_getWriteAdapter()->delete(
                    $this->getTable('nrapps_tsreviewmanagement/review_statement'),
                    array('review_id = ?' => $object->getId())
                );
            }
        }

        return $this;
    }
}
