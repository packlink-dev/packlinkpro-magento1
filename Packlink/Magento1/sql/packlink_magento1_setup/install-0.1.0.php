<?php
/**
 * Copyright 2016 Packlink
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = Mage::getResourceModel('core/setup', 'core_setup');

$installer->startSetup();

//<editor-fold desc="Shipment status table creation">
$table = $installer->getConnection()
    ->newTable($installer->getTable('packlink_magento1/shipment_status'))
    ->addColumn(
        'id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
        ),
        'ID'
    )
    ->addColumn(
        'shipment_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'nullable' => false,
            'unsigned' => true,
        ),
        'Shipment ID'
    )
    ->addForeignKey(
        $installer->getFkName('packlink_magento1/shipment_status', 'shipment_id', 'sales/shipment', 'entity_id'),
        'shipment_id',
        $installer->getTable('sales/shipment'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->addColumn(
        'shipment_status', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'nullable' => false,
            'unsigned' => true,
            'default' => 0,
        ),
        'Shipment Status'
    )
    ->addIndex(
        $installer->getIdxName(
            'packlink_magento1/shipment_status',
            array('shipment_status'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
        ),
        array('shipment_status'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX)
    )
    ->addColumn(
        'created', Varien_Db_Ddl_Table::TYPE_DATETIME, null,
        array(
            'nullable' => false,
        ),
        'Created At'
    )
    ->addColumn(
        'modified', Varien_Db_Ddl_Table::TYPE_DATETIME, null,
        array(
            'nullable' => false,
        ),
        'Modified At'
    )
    ->addColumn(
        'error_message', Varien_Db_Ddl_Table::TYPE_TEXT, Varien_Db_Ddl_Table::MAX_TEXT_SIZE,
        array(
            'nullable' => false,
        ),
        'Error Message'
    )
    ->addColumn(
        'reference', Varien_Db_Ddl_Table::TYPE_TEXT, Varien_Db_Ddl_Table::MAX_TEXT_SIZE,
        array(
            'nullable' => false,
        ),
        'Reference'
    )
    ->addColumn(
        'tracking', Varien_Db_Ddl_Table::TYPE_TEXT, Varien_Db_Ddl_Table::MAX_TEXT_SIZE,
        array(
            'nullable' => false,
        ),
        'Tracking'
    );
$installer->getConnection()->createTable($table);
//</editor-fold>

// DDL cache refresh if available
if(method_exists($this->_conn, 'resetDdlCache')) {
    $this->_conn->resetDdlCache();
}

$installer->endSetup();
