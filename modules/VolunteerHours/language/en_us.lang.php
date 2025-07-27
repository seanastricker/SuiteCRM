<?php
/**
 * VolunteerHours Module - English Language File
 * 
 * This file contains all the language labels and dropdown options
 * for the VolunteerHours module.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 * @author Youth Sports League CRM
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$mod_strings = array(
    // Module Labels
    'LBL_MODULE_NAME' => 'Volunteer Hours',
    'LBL_MODULE_TITLE' => 'Volunteer Hours',
    'LBL_MODULE_ID' => 'Volunteer Hours',
    'LBL_SEARCH_FORM_TITLE' => 'Search Volunteer Hours',
    'LBL_LIST_FORM_TITLE' => 'Volunteer Hours List',
    'LBL_NEW_FORM_TITLE' => 'New Volunteer Hours Entry',
    'LBL_EDIT_FORM_TITLE' => 'Edit Volunteer Hours',
    'LBL_VIEW_FORM_TITLE' => 'View Volunteer Hours',

    // Field Labels
    'LBL_ID' => 'ID',
    'LBL_NAME' => 'Entry Name',
    'LBL_DATE_ENTERED' => 'Date Entered',
    'LBL_DATE_MODIFIED' => 'Date Modified',
    'LBL_MODIFIED' => 'Modified By',
    'LBL_MODIFIED_NAME' => 'Modified By Name',
    'LBL_CREATED' => 'Created By',
    'LBL_CREATED_BY' => 'Created By',
    'LBL_DESCRIPTION' => 'Description',
    'LBL_DELETED' => 'Deleted',
    'LBL_ASSIGNED_TO_ID' => 'Assigned User ID',
    'LBL_ASSIGNED_TO_NAME' => 'Assigned to',
    'LBL_ASSIGNED_TO' => 'Assigned to',

    // Custom Field Labels
    'LBL_VOLUNTEER_ID' => 'Volunteer ID',
    'LBL_VOLUNTEER_NAME' => 'Volunteer',
    'LBL_VOLUNTEER' => 'Volunteer',
    'LBL_ACTIVITY_DATE' => 'Activity Date',
    'LBL_HOURS_LOGGED' => 'Hours Logged',
    'LBL_ACTIVITY_TYPE' => 'Activity Type',
    'LBL_PROGRAM_NAME' => 'Program Name',
    'LBL_ACTIVITY_DESCRIPTION' => 'Activity Description',
    'LBL_APPROVAL_STATUS' => 'Approval Status',
    'LBL_APPROVED_BY' => 'Approved By',
    'LBL_APPROVED_DATE' => 'Approved Date',

    // List View Labels
    'LBL_LIST_VOLUNTEER_NAME' => 'Volunteer',
    'LBL_LIST_ACTIVITY_DATE' => 'Date',
    'LBL_LIST_HOURS_LOGGED' => 'Hours',
    'LBL_LIST_ACTIVITY_TYPE' => 'Activity',
    'LBL_LIST_PROGRAM_NAME' => 'Program',
    'LBL_LIST_APPROVAL_STATUS' => 'Status',

    // Dashboard Labels
    'LBL_DASHBOARD_TITLE' => 'Volunteer Hours Dashboard',
    'LBL_TOTAL_HOURS' => 'Total Hours',
    'LBL_THIS_MONTH' => 'This Month',
    'LBL_THIS_YEAR' => 'This Year',
    'LBL_TOP_VOLUNTEERS' => 'Top Volunteers',
    'LBL_PENDING_APPROVAL' => 'Pending Approval',
    'LBL_RECENT_ENTRIES' => 'Recent Entries',

    // Form Labels
    'LBL_HOUR_ENTRY_FORM' => 'Log Volunteer Hours',
    'LBL_BULK_ENTRY_FORM' => 'Bulk Hour Entry',
    'LBL_RECOGNITION_REPORT' => 'Recognition Report',

    // Action Labels
    'LBL_APPROVE_HOURS' => 'Approve Hours',
    'LBL_REJECT_HOURS' => 'Reject Hours',
    'LBL_EXPORT_REPORT' => 'Export Report',
    'LBL_GENERATE_CERTIFICATE' => 'Generate Certificate',

    // Help Text
    'LBL_HELP_VOLUNTEER_HOURS' => 'Track volunteer hours for recognition and reporting',
    'LBL_HELP_ACTIVITY_TYPE' => 'Select the type of volunteer activity performed',
    'LBL_HELP_APPROVAL' => 'Hours must be approved before counting toward totals',

    // Error Messages
    'ERR_INVALID_HOURS' => 'Please enter a valid number of hours (0.25 - 24.00)',
    'ERR_FUTURE_DATE' => 'Activity date cannot be in the future',
    'ERR_VOLUNTEER_REQUIRED' => 'Please select a volunteer',
    'ERR_ALREADY_APPROVED' => 'These hours have already been approved',

    // Success Messages
    'MSG_HOURS_LOGGED' => 'Volunteer hours have been logged successfully',
    'MSG_HOURS_APPROVED' => 'Volunteer hours have been approved',
    'MSG_HOURS_REJECTED' => 'Volunteer hours have been rejected',
    'MSG_CERTIFICATE_GENERATED' => 'Recognition certificate has been generated',

    // Navigation Links
    'LNK_NEW_RECORD' => 'Create Volunteer Hours Entry',
    'LNK_LIST' => 'View Volunteer Hours',
    'LNK_IMPORT_VOLUNTEER_HOURS' => 'Import Volunteer Hours',
);

// Dropdown Options
$app_list_strings['volunteer_activity_type_list'] = array(
    '' => '',
    'coaching' => 'Coaching',
    'refereeing' => 'Refereeing/Umpiring',
    'equipment_setup' => 'Equipment Setup/Cleanup',
    'event_coordination' => 'Event Coordination',
    'fundraising' => 'Fundraising',
    'registration' => 'Registration/Check-in',
    'concessions' => 'Concessions',
    'transportation' => 'Transportation',
    'first_aid' => 'First Aid/Medical',
    'photography' => 'Photography/Videography',
    'field_maintenance' => 'Field Maintenance',
    'administrative' => 'Administrative',
    'mentoring' => 'Mentoring/Training',
    'special_events' => 'Special Events',
    'other' => 'Other',
);

$app_list_strings['volunteer_hours_approval_status_list'] = array(
    '' => '',
    'pending' => 'Pending Approval',
    'approved' => 'Approved',
    'rejected' => 'Rejected',
    'needs_review' => 'Needs Review',
);

// Module Names for Global Navigation
$app_list_strings['moduleList']['VolunteerHours'] = 'Volunteer Hours';
$app_list_strings['moduleListSingular']['VolunteerHours'] = 'Volunteer Hours Entry'; 