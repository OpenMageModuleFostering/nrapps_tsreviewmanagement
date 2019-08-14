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


/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();


/**
 * NRApps_TSReviewManagement / Shop
 */

if (!$installer->getConnection()->isTableExists($installer->getTable('nrapps_tsreviewmanagement/shop'))) {

    $table = $installer->getConnection()
        ->newTable($installer->getTable('nrapps_tsreviewmanagement/shop'))
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
            'unsigned' => true,
        ), 'Entity Id')
        ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => true,
            'unsigned' => true,
        ), 'Store Id')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
        ), 'Creation Time')
        ->addColumn('tsid', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
            'nullable' => false,
        ), 'TSID')
        ->addColumn('url', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
            'nullable' => true,
        ), 'URL')
        ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
            'nullable' => true,
        ), 'Name')
        ->addColumn('language_iso2', Varien_Db_Ddl_Table::TYPE_TEXT, 2, array(
            'nullable' => true,
        ), 'Language ISO 2')
        ->addColumn('target_market_iso3', Varien_Db_Ddl_Table::TYPE_TEXT, 3, array(
            'nullable' => true,
        ), 'Target Market ISO 3')
        ->addIndex($installer->getIdxName('nrapps_tsreviewmanagement/shop', array('store_id')),
            array('store_id'))
        ->addForeignKey($installer->getFkName('nrapps_tsreviewmanagement/shop', 'store_id', 'core/store', 'store_id'),
            'store_id', $installer->getTable('core/store'), 'store_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment('NRApps_TSReviewManagement / Shop');
    $installer->getConnection()->createTable($table);
}

/**
 * NRApps_TSReviewManagement / Review
 */

if (!$installer->getConnection()->isTableExists($installer->getTable('nrapps_tsreviewmanagement/review'))) {

    $table = $installer->getConnection()
        ->newTable($installer->getTable('nrapps_tsreviewmanagement/review'))
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
            'unsigned' => true,
        ), 'Entity Id')
        ->addColumn('shop_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => true,
            'unsigned' => true,
        ), 'Shop Id')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
        ), 'Creation Time')
        ->addColumn('uid', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
            'nullable' => false,
        ), 'UID')
        ->addColumn('order_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
            'nullable' => true,
        ), 'Order Date')
        ->addColumn('creation_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
            'nullable' => true,
        ), 'Creation Date')
        ->addColumn('change_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
            'nullable' => true,
        ), 'Change Date')
        ->addColumn('confirmation_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
            'nullable' => true,
        ), 'Confirmation Date')
        ->addColumn('mark', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
            'nullable' => true,
        ), 'Mark')
        ->addColumn('mark_description', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
            'nullable' => true,
        ), 'Mark Description')
        ->addColumn('comment', Varien_Db_Ddl_Table::TYPE_TEXT, 1024, array(
            'nullable' => true,
        ), 'Comment')
        ->addColumn('consumer_email', Varien_Db_Ddl_Table::TYPE_TEXT, 128, array(
            'nullable' => true,
        ), 'Consumer Email')
        ->addColumn('order_reference', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
            'nullable' => true,
        ), 'Order Reference')
        ->addIndex($installer->getIdxName('nrapps_tsreviewmanagement/review', array('shop_id')),
            array('shop_id'))
        ->addForeignKey($installer->getFkName('nrapps_tsreviewmanagement/review', 'shop_id', 'nrapps_tsreviewmanagement/shop', 'entity_id'),
            'shop_id', $installer->getTable('nrapps_tsreviewmanagement/shop'), 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment('NRApps_TSReviewManagement / Review');
    $installer->getConnection()->createTable($table);
}

/**
 * NRApps_TSReviewManagement / Review Criterion
 */

if (!$installer->getConnection()->isTableExists($installer->getTable('nrapps_tsreviewmanagement/review_criterion'))) {

    $table = $installer->getConnection()
        ->newTable($installer->getTable('nrapps_tsreviewmanagement/review_criterion'))
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
            'unsigned' => true,
        ), 'Entity Id')
        ->addColumn('review_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
            'unsigned' => true,
        ), 'Review Id')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
        ), 'Creation Time')
        ->addColumn('type', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
            'nullable' => false,
        ), 'Type')
        ->addColumn('mark', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
            'nullable' => true,
        ), 'Mark')
        ->addColumn('mark_description', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
            'nullable' => true,
        ), 'Mark Description')
        ->addIndex($installer->getIdxName('nrapps_tsreviewmanagement/review_statement', array('review_id', 'type'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
            array('review_id', 'type'),
            array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
        ->addForeignKey($installer->getFkName('nrapps_tsreviewmanagement/review_criterion', 'review_id', 'nrapps_tsreviewmanagement/review', 'entity_id'),
            'review_id', $installer->getTable('nrapps_tsreviewmanagement/review'), 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment('NRApps_TSReviewManagement / Review Criterion');
    $installer->getConnection()->createTable($table);
}

/**
 * NRApps_TSReviewManagement / Review Statement
 */

if (!$installer->getConnection()->isTableExists($installer->getTable('nrapps_tsreviewmanagement/review_statement'))) {

    $table = $installer->getConnection()
        ->newTable($installer->getTable('nrapps_tsreviewmanagement/review_statement'))
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
            'unsigned' => true,
        ), 'Entity Id')
        ->addColumn('review_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
            'unsigned' => true,
        ), 'Review Id')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
        ), 'Creation Time')
        ->addColumn('uid', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
            'nullable' => false,
        ), 'UID')
        ->addColumn('creation_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
            'nullable' => true,
        ), 'Creation Date')
        ->addColumn('change_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
            'nullable' => true,
        ), 'Change Date')
        ->addColumn('statement', Varien_Db_Ddl_Table::TYPE_TEXT, 1024, array(
            'nullable' => true,
        ), 'Statement')
        ->addIndex($installer->getIdxName('nrapps_tsreviewmanagement/review_statement', array('review_id'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
            array('review_id'),
            array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
        ->addForeignKey($installer->getFkName('nrapps_tsreviewmanagement/review_statement', 'review_id', 'nrapps_tsreviewmanagement/review', 'entity_id'),
            'review_id', $installer->getTable('nrapps_tsreviewmanagement/review'), 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment('NRApps_TSReviewManagement / Statement Review');
    $installer->getConnection()->createTable($table);
}

$installer->endSetup();
