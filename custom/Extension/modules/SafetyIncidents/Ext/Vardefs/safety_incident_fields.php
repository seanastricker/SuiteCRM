<?php
/**
 * SafetyIncidents Custom Field Definitions
 * Feature 3: Quick Incident Reporting Form
 * 
 * Defines all custom fields for safety incident reporting in youth sports programs
 */

// Incident Date and Time
$dictionary['SafetyIncidents']['fields']['incident_date_c'] = array(
    'name' => 'incident_date_c',
    'vname' => 'LBL_INCIDENT_DATE',
    'type' => 'date',
    'required' => true,
    'comment' => 'Date when the incident occurred',
    'audited' => true,
    'reportable' => true,
);

$dictionary['SafetyIncidents']['fields']['incident_time_c'] = array(
    'name' => 'incident_time_c',
    'vname' => 'LBL_INCIDENT_TIME',
    'type' => 'time',
    'required' => true,
    'comment' => 'Time when the incident occurred',
    'audited' => true,
    'reportable' => true,
);

// Program Reference
$dictionary['SafetyIncidents']['fields']['program_name_c'] = array(
    'name' => 'program_name_c',
    'vname' => 'LBL_PROGRAM_NAME',
    'type' => 'varchar',
    'len' => 100,
    'required' => true,
    'comment' => 'Name of the sports program where incident occurred',
    'audited' => true,
    'reportable' => true,
);

// Child/Participant Involved
$dictionary['SafetyIncidents']['fields']['child_name_c'] = array(
    'name' => 'child_name_c',
    'vname' => 'LBL_CHILD_NAME',
    'type' => 'varchar',
    'len' => 100,
    'required' => true,
    'comment' => 'Name of child/participant involved in incident',
    'audited' => true,
    'reportable' => true,
);

$dictionary['SafetyIncidents']['fields']['child_age_c'] = array(
    'name' => 'child_age_c',
    'vname' => 'LBL_CHILD_AGE',
    'type' => 'int',
    'len' => 2,
    'comment' => 'Age of child involved in incident',
    'audited' => true,
    'reportable' => true,
);

// Incident Type
$dictionary['SafetyIncidents']['fields']['incident_type_c'] = array(
    'name' => 'incident_type_c',
    'vname' => 'LBL_INCIDENT_TYPE',
    'type' => 'enum',
    'options' => 'incident_type_list',
    'len' => 50,
    'required' => true,
    'comment' => 'Type of safety incident',
    'audited' => true,
    'reportable' => true,
);

// Severity Level
$dictionary['SafetyIncidents']['fields']['severity_level_c'] = array(
    'name' => 'severity_level_c',
    'vname' => 'LBL_SEVERITY_LEVEL',
    'type' => 'enum',
    'options' => 'severity_level_list',
    'len' => 25,
    'required' => true,
    'comment' => 'Severity level of the incident',
    'audited' => true,
    'reportable' => true,
);

// Incident Description
$dictionary['SafetyIncidents']['fields']['incident_description_c'] = array(
    'name' => 'incident_description_c',
    'vname' => 'LBL_INCIDENT_DESCRIPTION',
    'type' => 'text',
    'required' => true,
    'comment' => 'Detailed description of what happened',
    'audited' => true,
    'reportable' => true,
);

// Immediate Action Taken
$dictionary['SafetyIncidents']['fields']['immediate_action_c'] = array(
    'name' => 'immediate_action_c',
    'vname' => 'LBL_IMMEDIATE_ACTION',
    'type' => 'text',
    'comment' => 'Immediate actions taken in response to incident',
    'audited' => true,
    'reportable' => true,
);

// Status Tracking
$dictionary['SafetyIncidents']['fields']['incident_status_c'] = array(
    'name' => 'incident_status_c',
    'vname' => 'LBL_INCIDENT_STATUS',
    'type' => 'enum',
    'options' => 'incident_status_list',
    'len' => 25,
    'default' => 'reported',
    'comment' => 'Current status of incident processing',
    'audited' => true,
    'reportable' => true,
);

// Reporter Information
$dictionary['SafetyIncidents']['fields']['reporter_name_c'] = array(
    'name' => 'reporter_name_c',
    'vname' => 'LBL_REPORTER_NAME',
    'type' => 'varchar',
    'len' => 100,
    'required' => true,
    'comment' => 'Name of person reporting the incident',
    'audited' => true,
    'reportable' => true,
);

$dictionary['SafetyIncidents']['fields']['reporter_role_c'] = array(
    'name' => 'reporter_role_c',
    'vname' => 'LBL_REPORTER_ROLE',
    'type' => 'enum',
    'options' => 'reporter_role_list',
    'len' => 50,
    'comment' => 'Role of person reporting incident',
    'audited' => true,
    'reportable' => true,
);

// Medical Attention
$dictionary['SafetyIncidents']['fields']['medical_attention_c'] = array(
    'name' => 'medical_attention_c',
    'vname' => 'LBL_MEDICAL_ATTENTION',
    'type' => 'bool',
    'default' => 0,
    'comment' => 'Whether medical attention was required',
    'audited' => true,
    'reportable' => true,
);

// Parent/Guardian Notified
$dictionary['SafetyIncidents']['fields']['parent_notified_c'] = array(
    'name' => 'parent_notified_c',
    'vname' => 'LBL_PARENT_NOTIFIED',
    'type' => 'bool',
    'default' => 0,
    'comment' => 'Whether parent/guardian was notified',
    'audited' => true,
    'reportable' => true,
);

// Follow-up Required
$dictionary['SafetyIncidents']['fields']['followup_required_c'] = array(
    'name' => 'followup_required_c',
    'vname' => 'LBL_FOLLOWUP_REQUIRED',
    'type' => 'bool',
    'default' => 0,
    'comment' => 'Whether follow-up action is required',
    'audited' => true,
    'reportable' => true,
);

// Follow-up Notes
$dictionary['SafetyIncidents']['fields']['followup_notes_c'] = array(
    'name' => 'followup_notes_c',
    'vname' => 'LBL_FOLLOWUP_NOTES',
    'type' => 'text',
    'comment' => 'Notes about required follow-up actions',
    'audited' => true,
    'reportable' => true,
); 