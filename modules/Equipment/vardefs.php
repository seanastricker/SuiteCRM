<?php

/**
 * Equipment Module - Variable Definitions
 * 
 * Defines database table structure and field properties for equipment tracking.
 * 
 * @author SuiteCRM Development Team
 * @package Equipment
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$dictionary['Equipment'] = array(
    'table' => 'equipment',
    'audited' => true,
    'unified_search' => true,
    'full_text_search' => true,
    'unified_search_default_enabled' => true,
    'duplicate_merge' => true,
    'comment' => 'Sports equipment inventory and check-out tracking',
    'fields' => array(
        // Standard SugarBean fields
        'id' => array(
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'id',
            'required' => true,
            'reportable' => true,
            'comment' => 'Unique identifier',
        ),
        'name' => array(
            'name' => 'name',
            'vname' => 'LBL_NAME',
            'type' => 'name',
            'dbType' => 'varchar',
            'len' => '255',
            'unified_search' => true,
            'full_text_search' => array(
                'boost' => 3,
            ),
            'required' => true,
            'importable' => 'required',
            'comment' => 'Equipment item name',
        ),
        'date_entered' => array(
            'name' => 'date_entered',
            'vname' => 'LBL_DATE_ENTERED',
            'type' => 'datetime',
            'group' => 'created_by_name',
            'comment' => 'Date record created',
            'enable_range_search' => true,
            'options' => 'date_range_search_dom',
        ),
        'date_modified' => array(
            'name' => 'date_modified',
            'vname' => 'LBL_DATE_MODIFIED',
            'type' => 'datetime',
            'group' => 'modified_by_name',
            'comment' => 'Date record last modified',
            'enable_range_search' => true,
            'options' => 'date_range_search_dom',
        ),
        'modified_user_id' => array(
            'name' => 'modified_user_id',
            'rname' => 'user_name',
            'id_name' => 'modified_user_id',
            'vname' => 'LBL_MODIFIED',
            'type' => 'assigned_user_name',
            'table' => 'users',
            'isnull' => 'false',
            'group' => 'modified_by_name',
            'dbType' => 'id',
            'reportable' => true,
            'comment' => 'User who last modified record',
            'massupdate' => false,
        ),
        'modified_by_name' => array(
            'name' => 'modified_by_name',
            'vname' => 'LBL_MODIFIED_NAME',
            'type' => 'relate',
            'reportable' => false,
            'source' => 'non-db',
            'rname' => 'user_name',
            'table' => 'users',
            'id_name' => 'modified_user_id',
            'module' => 'Users',
            'link' => 'modified_user_link',
            'duplicate_merge' => false,
            'massupdate' => false,
        ),
        'created_by' => array(
            'name' => 'created_by',
            'rname' => 'user_name',
            'id_name' => 'created_by',
            'vname' => 'LBL_CREATED',
            'type' => 'assigned_user_name',
            'table' => 'users',
            'isnull' => 'false',
            'dbType' => 'id',
            'group' => 'created_by_name',
            'comment' => 'User who created record',
            'massupdate' => false,
        ),
        'created_by_name' => array(
            'name' => 'created_by_name',
            'vname' => 'LBL_CREATED',
            'type' => 'relate',
            'reportable' => false,
            'link' => 'created_by_link',
            'rname' => 'user_name',
            'source' => 'non-db',
            'table' => 'users',
            'id_name' => 'created_by',
            'module' => 'Users',
            'duplicate_merge' => false,
            'importable' => 'false',
            'massupdate' => false,
        ),
        'description' => array(
            'name' => 'description',
            'vname' => 'LBL_DESCRIPTION',
            'type' => 'text',
            'comment' => 'Full text of the note',
            'rows' => 6,
            'cols' => 80,
        ),
        'deleted' => array(
            'name' => 'deleted',
            'vname' => 'LBL_DELETED',
            'type' => 'bool',
            'default' => '0',
            'reportable' => false,
            'comment' => 'Record deletion indicator',
        ),

        // Equipment-specific fields
        'equipment_type' => array(
            'name' => 'equipment_type',
            'vname' => 'LBL_EQUIPMENT_TYPE',
            'type' => 'enum',
            'options' => 'equipment_type_list',
            'len' => 100,
            'comment' => 'Type/category of equipment',
            'required' => true,
        ),
        'brand' => array(
            'name' => 'brand',
            'vname' => 'LBL_BRAND',
            'type' => 'varchar',
            'len' => 100,
            'comment' => 'Equipment brand/manufacturer',
        ),
        'model' => array(
            'name' => 'model',
            'vname' => 'LBL_MODEL',
            'type' => 'varchar',
            'len' => 100,
            'comment' => 'Equipment model number',
        ),
        'serial_number' => array(
            'name' => 'serial_number',
            'vname' => 'LBL_SERIAL_NUMBER',
            'type' => 'varchar',
            'len' => 100,
            'comment' => 'Unique serial number',
        ),
        'condition_status' => array(
            'name' => 'condition_status',
            'vname' => 'LBL_CONDITION',
            'type' => 'enum',
            'options' => 'equipment_condition_list',
            'len' => 50,
            'comment' => 'Current condition of equipment',
            'default' => 'good',
        ),
        'checkout_status' => array(
            'name' => 'checkout_status',
            'vname' => 'LBL_STATUS',
            'type' => 'enum',
            'options' => 'equipment_status_list',
            'len' => 50,
            'comment' => 'Current availability status',
            'default' => 'available',
            'required' => true,
        ),
        'current_location' => array(
            'name' => 'current_location',
            'vname' => 'LBL_CURRENT_LOCATION',
            'type' => 'varchar',
            'len' => 200,
            'comment' => 'Current physical location',
        ),
        'purchase_date' => array(
            'name' => 'purchase_date',
            'vname' => 'LBL_PURCHASE_DATE',
            'type' => 'date',
            'comment' => 'Date equipment was purchased',
        ),
        'purchase_price' => array(
            'name' => 'purchase_price',
            'vname' => 'LBL_PURCHASE_PRICE',
            'type' => 'currency',
            'comment' => 'Original purchase price',
        ),
        'checkout_date' => array(
            'name' => 'checkout_date',
            'vname' => 'LBL_CHECKOUT_DATE',
            'type' => 'datetime',
            'comment' => 'Date equipment was checked out',
        ),
        'due_date' => array(
            'name' => 'due_date',
            'vname' => 'LBL_DUE_DATE',
            'type' => 'date',
            'comment' => 'Date equipment is due back',
        ),
        'return_date' => array(
            'name' => 'return_date',
            'vname' => 'LBL_RETURN_DATE',
            'type' => 'datetime',
            'comment' => 'Date equipment was returned',
        ),
        'checked_out_by' => array(
            'name' => 'checked_out_by',
            'vname' => 'LBL_CHECKED_OUT_BY',
            'type' => 'varchar',
            'len' => 100,
            'comment' => 'Name of person who checked out equipment',
        ),
        'checkout_notes' => array(
            'name' => 'checkout_notes',
            'vname' => 'LBL_CHECKOUT_NOTES',
            'type' => 'text',
            'comment' => 'Notes about the checkout',
        ),
        'program_association' => array(
            'name' => 'program_association',
            'vname' => 'LBL_PROGRAM',
            'type' => 'enum',
            'options' => 'equipment_program_list',
            'len' => 100,
            'comment' => 'Associated sports program',
        ),
    ),
    'relationships' => array(),
    'optimistic_locking' => true,
    'unified_search' => true,
);

// Set table name for VardefManager
if (!class_exists('VardefManager')) {
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('Equipment', 'Equipment', array('basic', 'assignable')); 