<?php
/**
 * SafetyIncidents Vardefs
 * Feature 3: Quick Incident Reporting Form
 * 
 * Table and field definitions for SafetyIncidents module
 */

$dictionary['SafetyIncidents'] = array(
    'table' => 'safety_incidents',
    'audited' => true,
    'duplicate_merge' => false,
    'comment' => 'Safety incidents tracking for youth sports programs',
    'fields' => array(
        
        // Standard SugarCRM fields
        'id' => array(
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'id',
            'required' => true,
            'reportable' => false,
            'comment' => 'Unique identifier',
        ),
        
        'name' => array(
            'name' => 'name',
            'vname' => 'LBL_NAME',
            'type' => 'name',
            'dbType' => 'varchar',
            'len' => 150,
            'unified_search' => true,
            'comment' => 'Incident summary name',
            'importable' => 'required',
            'required' => false,
        ),
        
        'date_entered' => array(
            'name' => 'date_entered',
            'vname' => 'LBL_DATE_ENTERED',
            'type' => 'datetime',
            'comment' => 'Date record entered',
            'enable' => false,
            'studio' => false,
        ),
        
        'date_modified' => array(
            'name' => 'date_modified',
            'vname' => 'LBL_DATE_MODIFIED',
            'type' => 'datetime',
            'comment' => 'Date record last modified',
            'enable' => false,
            'studio' => false,
        ),
        
        'modified_user_id' => array(
            'name' => 'modified_user_id',
            'rname' => 'user_name',
            'id_name' => 'modified_user_id',
            'vname' => 'LBL_MODIFIED',
            'type' => 'assigned_user_name',
            'table' => 'users',
            'isnull' => 'false',
            'dbType' => 'id',
            'reportable' => true,
            'comment' => 'User who last modified record',
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
            'comment' => 'User who created record',
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
            'type' => 'relate',
            'table' => 'users',
            'module' => 'Users',
            'reportable' => true,
            'isnull' => 'false',
            'dbType' => 'id',
            'audited' => true,
            'comment' => 'User ID assigned to record',
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
        
        // TEMPORARILY DISABLED assigned_user_link to avoid memory issues
        // 'assigned_user_link' => array(
        //     'name' => 'assigned_user_link',
        //     'type' => 'link',
        //     'relationship' => 'safetyincidents_assigned_user',
        //     'vname' => 'LBL_ASSIGNED_TO_USER',
        //     'link_type' => 'one',
        //     'module' => 'Users',
        //     'bean_name' => 'User',
        //     'source' => 'non-db',
        // ),
        
        // Custom incident fields
        'incident_date_c' => array(
            'name' => 'incident_date_c',
            'vname' => 'LBL_INCIDENT_DATE',
            'type' => 'date',
            'required' => true,
            'comment' => 'Date when the incident occurred',
            'audited' => true,
            'reportable' => true,
        ),
        
        'incident_time_c' => array(
            'name' => 'incident_time_c',
            'vname' => 'LBL_INCIDENT_TIME',
            'type' => 'time',
            'required' => true,
            'comment' => 'Time when the incident occurred',
            'audited' => true,
            'reportable' => true,
        ),
        
        'program_name_c' => array(
            'name' => 'program_name_c',
            'vname' => 'LBL_PROGRAM_NAME',
            'type' => 'varchar',
            'len' => 100,
            'required' => true,
            'comment' => 'Name of the sports program where incident occurred',
            'audited' => true,
            'reportable' => true,
        ),
        
        'child_name_c' => array(
            'name' => 'child_name_c',
            'vname' => 'LBL_CHILD_NAME',
            'type' => 'varchar',
            'len' => 100,
            'required' => true,
            'comment' => 'Name of child/participant involved in incident',
            'audited' => true,
            'reportable' => true,
        ),
        
        'child_age_c' => array(
            'name' => 'child_age_c',
            'vname' => 'LBL_CHILD_AGE',
            'type' => 'int',
            'len' => 2,
            'comment' => 'Age of child involved in incident',
            'audited' => true,
            'reportable' => true,
        ),
        
        'incident_type_c' => array(
            'name' => 'incident_type_c',
            'vname' => 'LBL_INCIDENT_TYPE',
            'type' => 'enum',
            'options' => 'incident_type_list',
            'len' => 50,
            'required' => true,
            'comment' => 'Type of safety incident',
            'audited' => true,
            'reportable' => true,
        ),
        
        'severity_level_c' => array(
            'name' => 'severity_level_c',
            'vname' => 'LBL_SEVERITY_LEVEL',
            'type' => 'enum',
            'options' => 'severity_level_list',
            'len' => 25,
            'required' => true,
            'comment' => 'Severity level of the incident',
            'audited' => true,
            'reportable' => true,
        ),
        
        'incident_description_c' => array(
            'name' => 'incident_description_c',
            'vname' => 'LBL_INCIDENT_DESCRIPTION',
            'type' => 'text',
            'required' => true,
            'comment' => 'Detailed description of what happened',
            'audited' => true,
            'reportable' => true,
        ),
        
        'immediate_action_c' => array(
            'name' => 'immediate_action_c',
            'vname' => 'LBL_IMMEDIATE_ACTION',
            'type' => 'text',
            'comment' => 'Immediate actions taken in response to incident',
            'audited' => true,
            'reportable' => true,
        ),
        
        'incident_status_c' => array(
            'name' => 'incident_status_c',
            'vname' => 'LBL_INCIDENT_STATUS',
            'type' => 'enum',
            'options' => 'incident_status_list',
            'len' => 25,
            'default' => 'reported',
            'comment' => 'Current status of incident processing',
            'audited' => true,
            'reportable' => true,
        ),
        
        'reporter_name_c' => array(
            'name' => 'reporter_name_c',
            'vname' => 'LBL_REPORTER_NAME',
            'type' => 'varchar',
            'len' => 100,
            'required' => true,
            'comment' => 'Name of person reporting the incident',
            'audited' => true,
            'reportable' => true,
        ),
        
        'reporter_role_c' => array(
            'name' => 'reporter_role_c',
            'vname' => 'LBL_REPORTER_ROLE',
            'type' => 'enum',
            'options' => 'reporter_role_list',
            'len' => 50,
            'comment' => 'Role of person reporting incident',
            'audited' => true,
            'reportable' => true,
        ),
        
        'medical_attention_c' => array(
            'name' => 'medical_attention_c',
            'vname' => 'LBL_MEDICAL_ATTENTION',
            'type' => 'bool',
            'default' => 0,
            'comment' => 'Whether medical attention was required',
            'audited' => true,
            'reportable' => true,
        ),
        
        'parent_notified_c' => array(
            'name' => 'parent_notified_c',
            'vname' => 'LBL_PARENT_NOTIFIED',
            'type' => 'bool',
            'default' => 0,
            'comment' => 'Whether parent/guardian was notified',
            'audited' => true,
            'reportable' => true,
        ),
        
        'followup_required_c' => array(
            'name' => 'followup_required_c',
            'vname' => 'LBL_FOLLOWUP_REQUIRED',
            'type' => 'bool',
            'default' => 0,
            'comment' => 'Whether follow-up action is required',
            'audited' => true,
            'reportable' => true,
        ),
        
        'followup_notes_c' => array(
            'name' => 'followup_notes_c',
            'vname' => 'LBL_FOLLOWUP_NOTES',
            'type' => 'text',
            'comment' => 'Notes about required follow-up actions',
            'audited' => true,
            'reportable' => true,
        ),
    ),
    
    // TEMPORARILY DISABLED relationships to avoid memory issues during repair
    // 'relationships' => array(
    //     'safetyincidents_assigned_user' => array(
    //         'lhs_module' => 'Users',
    //         'lhs_table' => 'users',
    //         'lhs_key' => 'id',
    //         'rhs_module' => 'SafetyIncidents',
    //         'rhs_table' => 'safety_incidents',
    //         'rhs_key' => 'assigned_user_id',
    //         'relationship_type' => 'one-to-many',
    //     ),
    // ),
    
    'indices' => array(
        array(
            'name' => 'safetyincidents_pk',
            'type' => 'primary',
            'fields' => array('id'),
        ),
        array(
            'name' => 'idx_safety_incidents_name',
            'type' => 'index',
            'fields' => array('name'),
        ),
        array(
            'name' => 'idx_safety_incidents_date',
            'type' => 'index',
            'fields' => array('incident_date_c'),
        ),
        array(
            'name' => 'idx_safety_incidents_status',
            'type' => 'index',
            'fields' => array('incident_status_c'),
        ),
        array(
            'name' => 'idx_safety_incidents_severity',
            'type' => 'index',
            'fields' => array('severity_level_c'),
        ),
        array(
            'name' => 'idx_safety_incidents_deleted',
            'type' => 'index',
            'fields' => array('deleted'),
        ),
    ),
);

VardefManager::createVardef('SafetyIncidents', 'SafetyIncidents'); 