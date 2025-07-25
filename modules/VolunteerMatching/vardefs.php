<?php
/**
 * Feature 2: Simple Volunteer-Program Matching
 * Vardefs for VolunteerMatching module
 * 
 * Minimal table definition to prevent memory issues
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$dictionary['VolunteerMatching'] = array(
    'table' => 'volunteer_matching',
    'audited' => false,
    'duplicate_merge' => false,
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'id',
            'required' => true,
            'reportable' => true,
            'comment' => 'Unique identifier'
        ),
        'name' => array(
            'name' => 'name',
            'vname' => 'LBL_NAME',
            'type' => 'name',
            'link' => true,
            'dbType' => 'varchar',
            'len' => 255,
            'unified_search' => true,
            'full_text_search' => array('boost' => 3),
            'required' => true,
            'importable' => 'required',
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'disabled',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'duplicate_merge_dom_value' => '0',
            'audited' => false,
            'inline_edit' => true,
            'reportable' => true,
            'size' => '20'
        ),
        'date_entered' => array(
            'name' => 'date_entered',
            'vname' => 'LBL_DATE_ENTERED',
            'type' => 'datetime',
            'group' => 'created_by_name',
            'comment' => 'Date record created',
            'enable' => false,
            'studio' => false,
            'readonly' => true,
        ),
        'date_modified' => array(
            'name' => 'date_modified',
            'vname' => 'LBL_DATE_MODIFIED',
            'type' => 'datetime',
            'group' => 'modified_by_name',
            'comment' => 'Date record last modified',
            'enable' => false,
            'studio' => false,
            'readonly' => true,
        ),
        'created_by' => array(
            'name' => 'created_by',
            'rname' => 'user_name',
            'id_name' => 'created_by',
            'vname' => 'LBL_CREATED',
            'type' => 'assigned_user_name',
            'table' => 'users',
            'isnull' => 'false',
            'group' => 'created_by_name',
            'dbType' => 'id',
            'comment' => 'User who created record',
            'massupdate' => false,
            'readonly' => true,
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
            'comment' => 'User who last modified record',
            'massupdate' => false,
            'readonly' => true,
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
            'comment' => 'Record deletion indicator'
        ),
    ),
    'indices' => array(
        array(
            'name' => 'volunteer_matching_pk',
            'type' => 'primary',
            'fields' => array('id')
        ),
        array(
            'name' => 'idx_volunteer_matching_name',
            'type' => 'index',
            'fields' => array('name')
        ),
    ),
    'uses' => array(
        'basic',
        'assignable',
    ),
); 