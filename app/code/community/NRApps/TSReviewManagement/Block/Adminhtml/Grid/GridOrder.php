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
 * Class NRApps_TSReviewManagement_Block_Adminhtml_Grid_GridOrder
 */
class NRApps_TSReviewManagement_Block_Adminhtml_Grid_GridOrder extends Mage_Adminhtml_Block_Widget_Grid
{


    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->setId('grid_grid_order');
        $this->setSaveParametersInSession(true);
        $this->setDefaultSort('order_created_at');
        $this->setData('use_ajax', true);
        $this->setData('row_click_callback', 'row_click_callback');
    }


    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $shipmentCollection = Mage::getResourceModel('sales/order_shipment_collection');
        $shipmentCollection->getSelect()->reset();
        $shipmentCollection->getSelect()->from(array('shipment' => $shipmentCollection->getMainTable()), null);
        $shipmentCollection->getSelect()->columns(array('shipment_date' => 'shipment.created_at'));
        $shipmentCollection->getSelect()->where('shipment.order_id = main_table.entity_id');
        $shipmentCollection->getSelect()->order('shipment_date DESC');
        $shipmentCollection->getSelect()->limit(1);

        /** @var NRApps_TSReviewManagement_Model_Resource_Review_Collection $collection */
        $collection = Mage::getResourceModel('sales/order_collection');
        $collection->getSelect()->reset(Zend_Db_Select::COLUMNS);
        $collection->getSelect()->columns(array(
            'entity_id',
            'increment_id',
            'created_at',
            'store_id',
            'base_grand_total',
            'base_currency_code',
            'shipment_date' => new Zend_Db_Expr('(' . $shipmentCollection->getSelect() . ')'),
        ));

        $collection->getSelect()->joinLeft(
            array('review' => $collection->getTable('nrapps_tsreviewmanagement/review')),
            'review.order_reference = main_table.increment_id',
            array(
                'review_id' => 'entity_id',
                'review_creation_date' => 'creation_date',
                'review_mark' => 'mark',
                'review_mark_description' => 'mark_description',
                'review_comment' => 'comment',
            )
        );

        $collection->getSelect()->joinLeft(
            array('statement' => $collection->getTable('nrapps_tsreviewmanagement/review_statement')),
            'statement.review_id = review.entity_id',
            array('statement' => 'statement')
        );

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }


    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        if (!Mage::app()->isSingleStoreMode()) {

            $this->addColumn('store_id', array(
                'index' => 'store_id',
                'filter_index' => 'main_table.store_id',
                'type' => 'store',
                'header' => $this->__('Store'),
                'width' => '160px',
            ));
        }

        $this->addColumn('order_increment_id', array(
            'index' => 'increment_id',
            'filter_index' => 'main_table.increment_id',
            'renderer' => 'nrapps_tsreviewmanagement/adminhtml_widget_grid_column_renderer_order',
            'header' => $this->__('Order Reference'),
            'width' => '120px',
            'align' => 'center',
        ));

        $this->addColumn('order_created_at', array(
            'index' => 'created_at',
            'filter_index' => 'main_table.created_at',
            'type' => 'datetime',
            'header' => $this->__('Order Date'),
            'width' => '160px',
            'align' => 'center',
        ));

        $this->addColumn('review_creation_date', array(
            'index' => 'review_creation_date',
            'filter_index' => 'review.creation_date',
            'type' => 'datetime',
            'header' => $this->__('Review Date'),
            'width' => '160px',
            'align' => 'center',
        ));

        $this->addColumn('review_mark', array(
            'index' => 'review_mark_description',
            'filter_index' => 'review.mark_description',
            'type' => 'options',
            'options' => $this->_getMarkOptions(),
            'renderer' => 'nrapps_tsreviewmanagement/adminhtml_widget_grid_column_renderer_mark',
            'mark' => 'review_mark',
            'header' => $this->__('Overall Score'),
            'width' => '100px',
            'align' => 'center',
        ));

        $this->addColumn('base_grand_total', array(
            'header' => $this->__('Cart Amount'),
            'index' => 'base_grand_total',
            'type'  => 'currency',
            'currency' => 'base_currency_code',
        ));

        $this->addColumn('shipment_date', array(
            'index' => 'shipment_date',
            'type' => 'datetime',
            'header' => $this->__('Delivery Date'),
            'width' => '160px',
            'align' => 'center',
        ));

        $this->addColumn('review_comment', array(
            'index' => 'review_comment',
            'filter_index' => 'review.comment',
            'type' => 'text',
            'nl2br' => true,
            'truncate' => 80,
            'header' => $this->__('Comment'),
        ));

        $this->addColumn('statement', array(
            'index' => 'statement',
            'filter_index' => 'statement.statement',
            'type' => 'text',
            'nl2br' => true,
            'truncate' => 80,
            'header' => $this->__('Statement'),
        ));

        return parent::_prepareColumns();
    }


    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/gridrevieworder');
    }


    /**
     * @param $row
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        if($row->getData('review_id')) {
            return $this->getUrl('*/*/view', array('id' => $row->getData('review_id')));
        }

        return null;
    }


    /**
     * @return array
     */
    protected function _getMarkOptions()
    {
        return Mage::getSingleton('nrapps_tsreviewmanagement/review')->getMarkOptions();
    }
}
