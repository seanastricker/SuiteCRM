<?php
/**
 * Feature 4: Basic Parent Notification System
 * Variable definitions for the ParentCommunication module
 * 
 * Defines the database table structure and field properties for parent communications.
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$dictionary['ParentCommunication'] = array(
    'table' => 'parent_communications',
    'audited' => true,
    'unified_search' => true,
    'full_text_search' => true,
    'unified_search_default_enabled' => true,
    'duplicate_merge' => true,
    'comment' => 'Parent communication tracking for youth sports league',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'id',
            'required' => true,
            'reportable' => true,
            'comment' => 'Unique identifier',
            'inline_edit' => false,
        ),
        'name' => array(
            'name' => 'name',
            'vname' => 'LBL_NAME',
            'type' => 'name',
            'dbtype' => 'varchar',
            'len' => 255,
            'unified_search' => true,
            'full_text_search' => array('boost' => 3),
            'required' => true,
            'importable' => 'required',
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
            'comment' => 'Communication name/title',
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
        'created_by' => array(
            'name' => 'created_by',
            'rname' => 'user_name',
            'id_name' => 'created_by',
            'vname' => 'LBL_CREATED',
            'type' => 'assigned_user_name',
            'table' => 'users',
            'isnull' => 'false',
            'dbtype' => 'id',
            'group' => 'created_by_name',
            'comment' => 'User who created record',
            'massupdate' => false,
        ),
        'modified_user_id' => array(
            'name' => 'modified_user_id',
            'rname' => 'user_name',
            'id_name' => 'modified_user_id',
            'vname' => 'LBL_MODIFIED',
            'type' => 'assigned_user_name',
            'table' => 'users',
            'isnull' => 'false',
            'dbtype' => 'id',
            'group' => 'modified_by_name',
            'comment' => 'User who last modified record',
            'massupdate' => false,
        ),
        'deleted' => array(
            'name' => 'deleted',
            'vname' => 'LBL_DELETED',
            'type' => 'bool',
            'default' => '0',
            'reportable' => false,
            'comment' => 'Record deletion indicator',
        ),
        
        // Communication-specific fields
        'communication_type' => array(
            'name' => 'communication_type',
            'vname' => 'LBL_COMMUNICATION_TYPE',
            'type' => 'enum',
            'options' => 'communication_type_list',
            'len' => 50,
            'comment' => 'Type of communication (email, broadcast, etc.)',
            'required' => true,
        ),
        'subject' => array(
            'name' => 'subject',
            'vname' => 'LBL_SUBJECT',
            'type' => 'varchar',
            'len' => 255,
            'comment' => 'Subject of the communication',
            'required' => true,
        ),
        'message' => array(
            'name' => 'message',
            'vname' => 'LBL_MESSAGE',
            'type' => 'text',
            'comment' => 'Message content',
            'rows' => 6,
            'cols' => 80,
        ),
        'template_used' => array(
            'name' => 'template_used',
            'vname' => 'LBL_TEMPLATE_USED',
            'type' => 'varchar',
            'len' => 100,
            'comment' => 'Template used for the communication',
        ),
        'recipient_count' => array(
            'name' => 'recipient_count',
            'vname' => 'LBL_RECIPIENT_COUNT',
            'type' => 'int',
            'comment' => 'Number of recipients',
            'default' => '0',
        ),
        'sent_date' => array(
            'name' => 'sent_date',
            'vname' => 'LBL_SENT_DATE',
            'type' => 'datetime',
            'comment' => 'Date and time the communication was sent',
            'enable_range_search' => true,
        ),
        'sent_by' => array(
            'name' => 'sent_by',
            'vname' => 'LBL_SENT_BY',
            'type' => 'varchar',
            'len' => 255,
            'comment' => 'User who sent the communication',
        ),
        'status' => array(
            'name' => 'status',
            'vname' => 'LBL_STATUS',
            'type' => 'enum',
            'options' => 'communication_status_list',
            'len' => 20,
            'default' => 'draft',
            'comment' => 'Status of the communication',
        ),
    ),
    'indices' => array(
        array(
            'name' => 'parent_communication_pk',
            'type' => 'primary',
            'fields' => array('id'),
        ),
        array(
            'name' => 'idx_communication_type',
            'type' => 'index',
            'fields' => array('communication_type'),
        ),
        array(
            'name' => 'idx_sent_date',
            'type' => 'index',
            'fields' => array('sent_date'),
        ),
        array(
            'name' => 'idx_status',
            'type' => 'index',
            'fields' => array('status'),
        ),
    ),
); 