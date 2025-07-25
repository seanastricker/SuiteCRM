<?php
/**
 * SportPrograms Module - Field Definitions (Vardefs)
 * 
 * This file defines all fields, relationships, and database structure
 * for the SportPrograms module in the Youth Sports League system.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$dictionary['SportPrograms'] = array(
    'table' => 'sportprograms',
    'audited' => true,
    'unified_search' => true,
    'full_text_search' => true,
    'unified_search_default_enabled' => true,
    'duplicate_merge' => true,
    'comment' => 'Youth Sports League Programs that need volunteer assignments',
    'fields' => array(
        
        // Standard SuiteCRM fields
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
            'len' => 100,
            'unified_search' => true,
            'full_text_search' => true,
            'required' => true,
            'importable' => 'required',
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
            'comment' => 'Name of the sports program',
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
            'vname' => 'LBL_ASSIGNED_TO',
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
            'vname' => 'LBL_MODIFIED',
            'type' => 'relate',
            'reportable' => false,
            'source' => 'non-db',
            'rname' => 'user_name',
            'table' => 'users',
            'id_name' => 'modified_user_id',
            'module' => 'Users',
            'link' => 'modified_user_link',
            'duplicate_merge' => 'disabled',
            'massupdate' => false,
        ),
        
        'created_by' => array(
            'name' => 'created_by',
            'rname' => 'user_name',
            'id_name' => 'modified_user_id',
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
            'duplicate_merge' => 'disabled',
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
        
        'assigned_user_id' => array(
            'name' => 'assigned_user_id',
            'rname' => 'user_name',
            'id_name' => 'assigned_user_id',
            'vname' => 'LBL_ASSIGNED_TO_ID',
            'group' => 'assigned_user_name',
            'type' => 'relate',
            'table' => 'users',
            'module' => 'Users',
            'reportable' => true,
            'isnull' => 'false',
            'dbType' => 'id',
            'audited' => true,
            'comment' => 'User ID assigned to record',
            'duplicate_merge' => 'disabled',
        ),
        
        'assigned_user_name' => array(
            'name' => 'assigned_user_name',
            'link' => 'assigned_user_link',
            'vname' => 'LBL_ASSIGNED_TO_NAME',
            'rname' => 'user_name',
            'type' => 'relate',
            'reportable' => false,
            'source' => 'non-db',
            'table' => 'users',
            'id_name' => 'assigned_user_id',
            'module' => 'Users',
            'duplicate_merge' => 'disabled',
        ),
        
        // Custom SportPrograms fields
        'sport_type_c' => array(
            'name' => 'sport_type_c',
            'vname' => 'LBL_SPORT_TYPE',
            'type' => 'enum',
            'options' => 'sports_list',
            'len' => 50,
            'required' => true,
            'comment' => 'Type of sport for this program',
            'audited' => true,
            'reportable' => true,
            'unified_search' => true,
            'merge_filter' => 'enabled',
            'duplicate_merge' => 'enabled',
            'importable' => 'required',
        ),
        
        'age_group_c' => array(
            'name' => 'age_group_c',
            'vname' => 'LBL_AGE_GROUP',
            'type' => 'enum',
            'options' => 'age_groups_list',
            'len' => 50,
            'required' => true,
            'comment' => 'Age group served by this program',
            'audited' => true,
            'reportable' => true,
            'unified_search' => true,
            'merge_filter' => 'enabled',
            'duplicate_merge' => 'enabled',
            'importable' => 'required',
        ),
        
        'meeting_days_c' => array(
            'name' => 'meeting_days_c',
            'vname' => 'LBL_MEETING_DAYS',
            'type' => 'multienum',
            'options' => 'days_of_week_list',
            'isMultiSelect' => true,
            'comment' => 'Days of the week this program meets',
            'audited' => true,
            'reportable' => true,
            'merge_filter' => 'enabled',
            'duplicate_merge' => 'enabled',
            'importable' => 'true',
        ),
        
        'volunteers_needed_c' => array(
            'name' => 'volunteers_needed_c',
            'vname' => 'LBL_VOLUNTEERS_NEEDED',
            'type' => 'int',
            'len' => 11,
            'default' => 1,
            'comment' => 'Number of volunteers needed for this program',
            'audited' => true,
            'reportable' => true,
            'merge_filter' => 'enabled',
            'duplicate_merge' => 'enabled',
            'importable' => 'true',
        ),
        
        'volunteers_assigned_c' => array(
            'name' => 'volunteers_assigned_c',
            'vname' => 'LBL_VOLUNTEERS_ASSIGNED',
            'type' => 'int',
            'len' => 11,
            'default' => 0,
            'comment' => 'Number of volunteers currently assigned',
            'audited' => false,
            'reportable' => true,
            'merge_filter' => 'disabled',
            'duplicate_merge' => 'disabled',
            'importable' => 'false',
            'calculated' => true,
        ),
        
        'program_status_c' => array(
            'name' => 'program_status_c',
            'vname' => 'LBL_PROGRAM_STATUS',
            'type' => 'enum',
            'options' => 'program_status_list',
            'len' => 50,
            'default' => 'planning',
            'comment' => 'Current status of the program',
            'audited' => true,
            'reportable' => true,
            'merge_filter' => 'enabled',
            'duplicate_merge' => 'enabled',
            'importable' => 'true',
        ),
        
        'season_c' => array(
            'name' => 'season_c',
            'vname' => 'LBL_SEASON',
            'type' => 'enum',
            'options' => 'season_list',
            'len' => 50,
            'comment' => 'Season when this program runs',
            'audited' => true,
            'reportable' => true,
            'merge_filter' => 'enabled',
            'duplicate_merge' => 'enabled',
            'importable' => 'true',
        ),
        
        'start_date_c' => array(
            'name' => 'start_date_c',
            'vname' => 'LBL_START_DATE',
            'type' => 'date',
            'comment' => 'Program start date',
            'audited' => true,
            'reportable' => true,
            'merge_filter' => 'enabled',
            'duplicate_merge' => 'enabled',
            'importable' => 'true',
            'enable_range_search' => true,
        ),
        
        'end_date_c' => array(
            'name' => 'end_date_c',
            'vname' => 'LBL_END_DATE',
            'type' => 'date',
            'comment' => 'Program end date',
            'audited' => true,
            'reportable' => true,
            'merge_filter' => 'enabled',
            'duplicate_merge' => 'enabled',
            'importable' => 'true',
            'enable_range_search' => true,
        ),
        
        'meeting_location_c' => array(
            'name' => 'meeting_location_c',
            'vname' => 'LBL_MEETING_LOCATION',
            'type' => 'varchar',
            'len' => 255,
            'comment' => 'Location where program activities take place',
            'audited' => true,
            'reportable' => true,
            'merge_filter' => 'enabled',
            'duplicate_merge' => 'enabled',
            'importable' => 'true',
        ),
    ),
    
    // Relationships commented out temporarily to avoid memory issues
    // 'relationships' => array(),
    
    'indices' => array(
        array(
            'name' => 'idx_sportprograms_id_del', 
            'type' => 'index', 
            'fields' => array('id', 'deleted')
        ),
        array(
            'name' => 'idx_sportprograms_name_del', 
            'type' => 'index', 
            'fields' => array('name', 'deleted')
        ),
        array(
            'name' => 'idx_sportprograms_assigned_del', 
            'type' => 'index', 
            'fields' => array('deleted', 'assigned_user_id')
        ),
        array(
            'name' => 'idx_sportprograms_sport_age', 
            'type' => 'index', 
            'fields' => array('sport_type_c', 'age_group_c', 'deleted')
        ),
        array(
            'name' => 'idx_sportprograms_status', 
            'type' => 'index', 
            'fields' => array('program_status_c', 'deleted')
        ),
    ),
); 