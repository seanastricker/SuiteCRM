<?php
/**
 * BackgroundChecks Module - Language File (English)
 * 
 * This file defines language labels for the BackgroundChecks module
 * in the Youth Sports League CRM.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$mod_strings = array(
    // Module Names
    'LBL_MODULE_NAME' => 'Background Checks',
    'LBL_MODULE_TITLE' => 'Background Checks',
    'LBL_MODULE_ID' => 'Background Checks',
    'LBL_HOMEPAGE_TITLE' => 'My Background Checks',
    'LNK_NEW_RECORD' => 'Create Background Check',
    'LNK_LIST' => 'View Background Checks',
    'LNK_IMPORT_BACKGROUND_CHECKS' => 'Import Background Checks',
    'LBL_SEARCH_FORM_TITLE' => 'Background Check Search',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'View History',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activities',
    'LBL_NEW_FORM_TITLE' => 'New Background Check',
    'LBL_LIST_FORM_TITLE' => 'Background Check List',

    // Field Labels
    'LBL_ID' => 'ID',
    'LBL_NAME' => 'Name',
    'LBL_DATE_ENTERED' => 'Date Created',
    'LBL_DATE_MODIFIED' => 'Date Modified',
    'LBL_MODIFIED' => 'Modified By',
    'LBL_MODIFIED_NAME' => 'Modified By Name',
    'LBL_CREATED' => 'Created By',
    'LBL_DESCRIPTION' => 'Description',
    'LBL_DELETED' => 'Deleted',
    'LBL_ASSIGNED_TO_ID' => 'Assigned User ID',
    'LBL_ASSIGNED_TO_NAME' => 'Assigned To',

    // Custom Field Labels
    'LBL_VOLUNTEER_ID' => 'Volunteer ID',
    'LBL_VOLUNTEER_NAME' => 'Volunteer',
    'LBL_BACKGROUND_CHECK_TYPE' => 'Check Type',
    'LBL_CHECK_DATE' => 'Check Date',
    'LBL_EXPIRATION_DATE' => 'Expiration Date',
    'LBL_STATUS' => 'Status',
    'LBL_AUTO_CALCULATED_STATUS' => 'Auto Status',
    'LBL_PROVIDER' => 'Provider',
    'LBL_CERTIFICATE_NUMBER' => 'Certificate Number',
    'LBL_COST' => 'Cost',
    'LBL_NOTES' => 'Notes',
    'LBL_RENEWAL_REMINDER_SENT' => 'Reminder Sent',

    // List View Headers
    'LBL_LIST_VOLUNTEER_NAME' => 'Volunteer',
    'LBL_LIST_BACKGROUND_CHECK_TYPE' => 'Type',
    'LBL_LIST_CHECK_DATE' => 'Check Date',
    'LBL_LIST_EXPIRATION_DATE' => 'Expires',
    'LBL_LIST_STATUS' => 'Status',
    'LBL_LIST_AUTO_CALCULATED_STATUS' => 'Auto Status',
    'LBL_LIST_PROVIDER' => 'Provider',
    'LBL_LIST_COST' => 'Cost',

    // Subpanel Titles
    'LBL_BACKGROUND_CHECKS_SUBPANEL_TITLE' => 'Background Checks',

    // Dashboard and Quick Actions
    'LBL_DASHBOARD_TITLE' => 'Background Check Dashboard',
    'LBL_CREATE_BUTTON_TITLE' => 'Create Background Check',
    'LBL_CREATE_BUTTON_LABEL' => 'Create Background Check',
    'LBL_LIST_BUTTON_TITLE' => 'List Background Checks',
    'LBL_LIST_BUTTON_LABEL' => 'List Background Checks',

    // Help Text
    'LBL_HELP_VOLUNTEER_NAME' => 'Select the volunteer for this background check',
    'LBL_HELP_CHECK_TYPE' => 'Select the type of background check performed',
    'LBL_HELP_CHECK_DATE' => 'Date when the background check was completed',
    'LBL_HELP_EXPIRATION_DATE' => 'Date when this background check expires',
    'LBL_HELP_STATUS' => 'Manual status override (optional)',
    'LBL_HELP_AUTO_STATUS' => 'Automatically calculated based on expiration date',
    'LBL_HELP_PROVIDER' => 'Company or organization that performed the check',
    'LBL_HELP_CERTIFICATE' => 'Reference or certificate number from the provider',
    'LBL_HELP_COST' => 'Cost paid for this background check',

    // Error Messages
    'LBL_ERROR_VOLUNTEER_REQUIRED' => 'Volunteer is required',
    'LBL_ERROR_CHECK_TYPE_REQUIRED' => 'Check type is required',
    'LBL_ERROR_CHECK_DATE_REQUIRED' => 'Check date is required',
    'LBL_ERROR_EXPIRATION_DATE_REQUIRED' => 'Expiration date is required',
    'LBL_ERROR_INVALID_DATE' => 'Invalid date format',

    // Status Messages
    'LBL_STATUS_VALID' => 'Valid',
    'LBL_STATUS_EXPIRING' => 'Expiring Soon',
    'LBL_STATUS_EXPIRED' => 'Expired',
    'LBL_STATUS_PENDING' => 'Pending',
    'LBL_STATUS_NOT_REQUIRED' => 'Not Required',
); 