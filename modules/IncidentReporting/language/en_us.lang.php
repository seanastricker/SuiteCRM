<?php
/**
 * Feature 3: Basic Incident Reporting
 * Language file for the IncidentReporting module
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$mod_strings = array(
    // Module name and navigation
    'LBL_MODULE_NAME' => 'Incident Reporting',
    'LBL_MODULE_TITLE' => 'Safety Incident Reporting',
    'LBL_MODULE_ID' => 'IncidentReporting',
    'LBL_NEW_FORM_TITLE' => 'Report New Incident',
    'LBL_SEARCH_FORM_TITLE' => 'Search Incidents',
    'LBL_LIST_FORM_TITLE' => 'Incident Reporting Dashboard',
    
    // Dashboard labels
    'LBL_DASHBOARD_TITLE' => 'Safety Incident Reporting Dashboard',
    'LBL_REPORT_INCIDENT' => 'Report New Incident',
    'LBL_INCIDENT_FILTERS' => 'Filter Incidents',
    'LBL_RECENT_INCIDENTS' => 'Recent Incidents',
    'LBL_INCIDENT_STATS' => 'Incident Statistics',
    
    // Form field labels
    'LBL_INCIDENT_DATE' => 'Incident Date',
    'LBL_INCIDENT_TIME' => 'Incident Time',
    'LBL_PROGRAM_NAME' => 'Program/Activity',
    'LBL_CHILD_NAME' => 'Child Involved',
    'LBL_CHILD_AGE' => 'Child Age',
    'LBL_INCIDENT_TYPE' => 'Incident Type',
    'LBL_SEVERITY_LEVEL' => 'Severity Level',
    'LBL_INCIDENT_DESCRIPTION' => 'Description of Incident',
    'LBL_IMMEDIATE_ACTION' => 'Immediate Action Taken',
    'LBL_INCIDENT_STATUS' => 'Status',
    'LBL_REPORTER_NAME' => 'Reporter Name',
    'LBL_REPORTER_ROLE' => 'Reporter Role',
    'LBL_MEDICAL_ATTENTION' => 'Medical Attention Required',
    'LBL_PARENT_NOTIFIED' => 'Parents Notified',
    'LBL_FOLLOWUP_REQUIRED' => 'Follow-up Required',
    'LBL_FOLLOWUP_NOTES' => 'Follow-up Notes',
    
    // Field help text
    'LBL_INCIDENT_DATE_HELP' => 'Date when the incident occurred',
    'LBL_INCIDENT_TIME_HELP' => 'Approximate time of the incident',
    'LBL_PROGRAM_NAME_HELP' => 'Name of the sports program or activity',
    'LBL_CHILD_NAME_HELP' => 'Name of the child who was involved',
    'LBL_CHILD_AGE_HELP' => 'Age of the child at time of incident',
    'LBL_INCIDENT_TYPE_HELP' => 'Category that best describes the incident',
    'LBL_SEVERITY_LEVEL_HELP' => 'How serious was this incident?',
    'LBL_INCIDENT_DESCRIPTION_HELP' => 'Detailed description of what happened',
    'LBL_IMMEDIATE_ACTION_HELP' => 'What was done immediately after the incident?',
    
    // Statistics labels
    'LBL_TOTAL_INCIDENTS' => 'Total Incidents',
    'LBL_TODAY_INCIDENTS' => 'Today\'s Incidents',
    'LBL_WEEK_INCIDENTS' => 'This Week',
    'LBL_CRITICAL_INCIDENTS' => 'Critical',
    'LBL_HIGH_INCIDENTS' => 'High Severity',
    'LBL_OPEN_INCIDENTS' => 'Open Cases',
    
    // Filter labels
    'LBL_FILTER_BY_SEVERITY' => 'Filter by Severity',
    'LBL_FILTER_BY_STATUS' => 'Filter by Status',
    'LBL_FILTER_BY_TYPE' => 'Filter by Type',
    'LBL_FILTER_DATE_FROM' => 'From Date',
    'LBL_FILTER_DATE_TO' => 'To Date',
    'LBL_APPLY_FILTERS' => 'Apply Filters',
    'LBL_CLEAR_FILTERS' => 'Clear',
    
    // List view labels
    'LBL_NAME' => 'Incident Name',
    'LBL_DATE_ENTERED' => 'Date Reported',
    'LBL_DATE_MODIFIED' => 'Last Modified',
    'LBL_CREATED' => 'Created By',
    'LBL_MODIFIED' => 'Modified By',
    'LBL_DELETED' => 'Deleted',
    
    // Action labels
    'LBL_SAVE_INCIDENT' => 'Save Incident',
    'LBL_VIEW_DETAILS' => 'View Details',
    'LBL_EDIT_INCIDENT' => 'Edit',
    'LBL_DELETE_INCIDENT' => 'Delete',
    
    // Messages
    'LBL_NO_INCIDENTS' => 'No incidents found',
    'LBL_INCIDENT_SAVED' => 'Incident report saved successfully',
    'LBL_INCIDENT_ERROR' => 'Error saving incident report',
    'LBL_REQUIRED_FIELDS' => 'Please fill in all required fields',
    
    // Navigation menu items
    'LNK_LIST' => 'View Incidents',
    'LNK_NEW' => 'Report Incident',
    'LNK_DASHBOARD' => 'Dashboard',
    'LNK_REPORTS' => 'Incident Reports',
);

// Global dropdown lists for incident reporting
global $app_list_strings;

$app_list_strings['incident_type_list'] = array(
    '' => '',
    'injury' => 'Injury',
    'collision' => 'Player Collision',
    'equipment' => 'Equipment Malfunction',
    'facility' => 'Facility Issue',
    'behavior' => 'Behavioral Incident',
    'weather' => 'Weather Related',
    'medical' => 'Medical Emergency',
    'other' => 'Other',
);

$app_list_strings['severity_level_list'] = array(
    '' => '',
    'low' => 'Low',
    'medium' => 'Medium',
    'high' => 'High',
    'critical' => 'Critical',
);

$app_list_strings['incident_status_list'] = array(
    '' => '',
    'reported' => 'Reported',
    'investigating' => 'Under Investigation',
    'pending' => 'Pending Resolution',
    'resolved' => 'Resolved',
    'closed' => 'Closed',
);

$app_list_strings['reporter_role_list'] = array(
    '' => '',
    'coach' => 'Coach',
    'volunteer' => 'Volunteer',
    'parent' => 'Parent',
    'referee' => 'Referee',
    'administrator' => 'Administrator',
    'medical_staff' => 'Medical Staff',
    'other' => 'Other',
); 