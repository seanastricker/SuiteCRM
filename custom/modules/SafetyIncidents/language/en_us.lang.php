<?php
/**
 * SafetyIncidents Module Language File
 * Feature 3: Quick Incident Reporting Form
 * 
 * Main language definitions for SafetyIncidents module
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$mod_strings = array(
    // Module Identification
    'LBL_MODULE_NAME' => 'Safety Incidents',
    'LBL_MODULE_TITLE' => 'Safety Incidents: Home',
    'LBL_SEARCH_FORM_TITLE' => 'Safety Incident Search',
    'LBL_LIST_FORM_TITLE' => 'Safety Incidents List',
    'LBL_NEW_FORM_TITLE' => 'Report New Safety Incident',
    'LBL_INCIDENT_REPORTS' => 'Incident Reports',
    
    // Standard Labels
    'LBL_ID' => 'ID',
    'LBL_NAME' => 'Name',
    'LBL_DESCRIPTION' => 'Description',
    'LBL_DATE_ENTERED' => 'Date Created',
    'LBL_DATE_MODIFIED' => 'Date Modified',
    'LBL_MODIFIED' => 'Modified By',
    'LBL_CREATED' => 'Created By',
    'LBL_ASSIGNED_TO' => 'Assigned To',
    'LBL_ASSIGNED_TO_ID' => 'Assigned User Id',
    'LBL_ASSIGNED_TO_NAME' => 'Assigned to',
    'LBL_DELETED' => 'Deleted',
    
    // Custom Field Labels
    'LBL_INCIDENT_DATE' => 'Incident Date',
    'LBL_INCIDENT_TIME' => 'Incident Time',
    'LBL_PROGRAM_NAME' => 'Program Name',
    'LBL_CHILD_NAME' => 'Child/Participant Name',
    'LBL_CHILD_AGE' => 'Child Age',
    'LBL_INCIDENT_TYPE' => 'Incident Type',
    'LBL_SEVERITY_LEVEL' => 'Severity Level',
    'LBL_INCIDENT_DESCRIPTION' => 'Incident Description',
    'LBL_IMMEDIATE_ACTION' => 'Immediate Action Taken',
    'LBL_INCIDENT_STATUS' => 'Status',
    'LBL_REPORTER_NAME' => 'Reporter Name',
    'LBL_REPORTER_ROLE' => 'Reporter Role',
    'LBL_MEDICAL_ATTENTION' => 'Medical Attention Required',
    'LBL_PARENT_NOTIFIED' => 'Parent/Guardian Notified',
    'LBL_FOLLOWUP_REQUIRED' => 'Follow-up Required',
    'LBL_FOLLOWUP_NOTES' => 'Follow-up Notes',
    
    // Panel Labels for Edit/Detail View
    'LBL_INCIDENT_INFORMATION' => 'Incident Information',
    'LBL_PARTICIPANT_INFORMATION' => 'Participant Information',
    'LBL_RESPONSE_ACTIONS' => 'Response & Actions',
    'LBL_REPORTER_INFORMATION' => 'Reporter Information',
    'LBL_FOLLOW_UP' => 'Follow-up & Status',
    
    // List View Labels
    'LBL_LIST_INCIDENT_DATE' => 'Date',
    'LBL_LIST_INCIDENT_TIME' => 'Time',
    'LBL_LIST_PROGRAM_NAME' => 'Program',
    'LBL_LIST_CHILD_NAME' => 'Participant',
    'LBL_LIST_INCIDENT_TYPE' => 'Type',
    'LBL_LIST_SEVERITY_LEVEL' => 'Severity',
    'LBL_LIST_INCIDENT_STATUS' => 'Status',
    'LBL_LIST_REPORTER_NAME' => 'Reporter',
    'LBL_LIST_MEDICAL_ATTENTION' => 'Medical',
    'LBL_LIST_PARENT_NOTIFIED' => 'Parent Notified',
    'LBL_LIST_FOLLOWUP_REQUIRED' => 'Follow-up',
    
    // Search Form Labels
    'LBL_SEARCH_INCIDENT_DATE' => 'Incident Date',
    'LBL_SEARCH_PROGRAM_NAME' => 'Program',
    'LBL_SEARCH_INCIDENT_TYPE' => 'Incident Type',
    'LBL_SEARCH_SEVERITY_LEVEL' => 'Severity',
    'LBL_SEARCH_INCIDENT_STATUS' => 'Status',
    'LBL_SEARCH_CHILD_NAME' => 'Participant',
    'LBL_SEARCH_REPORTER_NAME' => 'Reporter',
    
    // Action Labels
    'LBL_REPORT_INCIDENT' => 'Report Incident',
    'LBL_QUICK_REPORT' => 'Quick Report',
    'LBL_VIEW_INCIDENTS' => 'View Incidents',
    'LBL_MARK_REVIEWED' => 'Mark as Reviewed',
    'LBL_CLOSE_INCIDENT' => 'Close Incident',
    'LBL_ESCALATE' => 'Escalate to Management',
    'LBL_NEW_INCIDENT' => 'New Incident',
    'LBL_CREATE_INCIDENT' => 'Create Incident',
    'LBL_EDIT_INCIDENT' => 'Edit Incident',
    
    // Messages and Help Text
    'LBL_INCIDENT_SAVED' => 'Safety incident report has been saved successfully.',
    'LBL_QUICK_REPORT_HELP' => 'Use this form to quickly report safety incidents. All required fields must be completed.',
    'LBL_EMERGENCY_NOTICE' => 'For medical emergencies, call 911 immediately before reporting the incident.',
    
    // Status Labels
    'LBL_STATUS_REPORTED' => 'Reported',
    'LBL_STATUS_UNDER_REVIEW' => 'Under Review',
    'LBL_STATUS_INVESTIGATED' => 'Investigated',
    'LBL_STATUS_FOLLOW_UP_REQUIRED' => 'Follow-up Required',
    'LBL_STATUS_CLOSED' => 'Closed',
    'LBL_STATUS_ESCALATED' => 'Escalated',
    
    // Severity Labels
    'LBL_SEVERITY_MINOR' => 'Minor',
    'LBL_SEVERITY_MODERATE' => 'Moderate',
    'LBL_SEVERITY_SEVERE' => 'Severe',
    'LBL_SEVERITY_CRITICAL' => 'Critical',
    
    // Navigation
    'LNK_NEW_RECORD' => 'Report New Incident',
    'LNK_LIST' => 'View Incidents',
    'LNK_IMPORT_INCIDENTS' => 'Import Incidents',
    
    // Subpanel Labels
    'LBL_SUBPANEL_TITLE' => 'Safety Incidents',
    
    // Help Text
    'LBL_INCIDENT_DATE_HELP' => 'Enter the date when the incident occurred',
    'LBL_INCIDENT_TIME_HELP' => 'Enter the approximate time when the incident occurred',
    'LBL_PROGRAM_NAME_HELP' => 'Enter the name of the sports program during which the incident occurred',
    'LBL_CHILD_NAME_HELP' => 'Enter the full name of the child or participant involved',
    'LBL_INCIDENT_TYPE_HELP' => 'Select the type that best describes the incident',
    'LBL_SEVERITY_LEVEL_HELP' => 'Select the severity level based on the seriousness of the incident',
    'LBL_INCIDENT_DESCRIPTION_HELP' => 'Provide a detailed description of exactly what happened',
    'LBL_IMMEDIATE_ACTION_HELP' => 'Describe any immediate actions taken in response to the incident',
    'LBL_REPORTER_NAME_HELP' => 'Enter the name of the person reporting this incident',
    'LBL_REPORTER_ROLE_HELP' => 'Select your role or relationship to the program',
    
    // Error Messages
    'ERR_REQUIRED_FIELDS' => 'Please fill in all required fields.',
    'ERR_INVALID_DATE' => 'Please enter a valid incident date.',
    'ERR_INVALID_TIME' => 'Please enter a valid incident time.',
); 