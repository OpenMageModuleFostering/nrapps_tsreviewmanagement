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
 * Class NRApps_TSReviewManagement_Block_Adminhtml_Grid_GridForeign
 */
class NRApps_TSReviewManagement_Block_Adminhtml_Grid_GridForeign extends Mage_Adminhtml_Block_Widget_Grid
{


    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->setId('grid_grid_foreign');
        $this->setSaveParametersInSession(true);
        $this->setDefaultSort('creation_date');
        $this->setData('use_ajax', true);
        $this->setData('row_click_callback', 'row_click_callback');
    }


    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        /** @var NRApps_TSReviewManagement_Model_Resource_Review_Collection $collection */
        $collection = Mage::getResourceModel('nrapps_tsreviewmanagement/review_collection');

        $collection->getSelect()->joinLeft(
            array('shop' => $collection->getTable('nrapps_tsreviewmanagement/shop')),
            'shop.entity_id = main_table.shop_id',
            array('store_id' => 'store_id')
        );

        $collection->getSelect()->joinLeft(
            array('statement' => $collection->getTable('nrapps_tsreviewmanagement/review_statement')),
            'statement.review_id = main_table.entity_id',
            array('statement' => 'statement')
        );

        $collection->getSelect()->joinLeft(
            array('order' => $collection->getTable('sales/order')),
            "order.increment_id = main_table.order_reference",
            null
        );

        $collection->getSelect()->where('order.entity_id IS NULL');

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }


    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        if (!Mage::app()->isSingleStoreMode()) {

            $this->addColumn('shop_id', array(
                'index' => 'store_id',
                'filter_index' => 'shop.store_id',
                'type' => 'store',
                'header' => $this->__('Store'),
                'width' => '160px',
            ));
        }

        $this->addColumn('order_reference', array(
            'index' => 'order_reference',
            'filter_index' => 'main_table.order_reference',
            'header' => $this->__('Order Reference'),
            'width' => '120px',
            'align' => 'center',
        ));

        $this->addColumn('order_date', array(
            'index' => 'order_date',
            'filter_index' => 'main_table.order_date',
            'type' => 'datetime',
            'header' => $this->__('Order Date'),
            'width' => '160px',
            'align' => 'center',
        ));

        $this->addColumn('creation_date', array(
            'index' => 'creation_date',
            'filter_index' => 'main_table.creation_date',
            'type' => 'datetime',
            'header' => $this->__('Review Date'),
            'width' => '160px',
            'align' => 'center',
        ));

        $this->addColumn('mark', array(
            'index' => 'mark_description',
            'filter_index' => 'main_table.mark_description',
            'type' => 'options',
            'options' => $this->_getMarkOptions(),
            'renderer' => 'nrapps_tsreviewmanagement/adminhtml_widget_grid_column_renderer_mark',
            'mark' => 'mark',
            'header' => $this->__('Overall Score'),
            'width' => '100px',
            'align' => 'center',
        ));

        $this->addColumn('comment', array(
            'index' => 'comment',
            'filter_index' => 'main_table.comment',
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
        return $this->getUrl('*/*/gridreviewforeign');
    }


    /**
     * @param $row
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/view', array('id' => $row->getId()));
    }


    /**
     * @return array
     */
    protected function _getMarkOptions()
    {
        return Mage::getSingleton('nrapps_tsreviewmanagement/review')->getMarkOptions();
    }
}
