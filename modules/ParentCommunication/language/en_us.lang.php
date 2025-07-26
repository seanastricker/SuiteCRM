<?php
/**
 * Feature 4: Basic Parent Notification System
 * Language file for the ParentCommunication module
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$mod_strings = array(
    // Module name and navigation
    'LBL_MODULE_NAME' => 'Parent Communication',
    'LBL_MODULE_TITLE' => 'Parent Communication Dashboard',
    'LBL_MODULE_ID' => 'ParentCommunication',
    'LBL_NEW_FORM_TITLE' => 'New Communication',
    'LBL_SEARCH_FORM_TITLE' => 'Search Communications',
    'LBL_LIST_FORM_TITLE' => 'Parent Communication Dashboard',
    
    // Dashboard labels
    'LBL_DASHBOARD_TITLE' => 'Parent Communication Dashboard',
    'LBL_PARENT_STATS' => 'Parent Statistics',
    'LBL_BROADCAST_EMAIL' => 'Send Broadcast Email',
    'LBL_PARENT_SELECTION' => 'Parent Selection',
    'LBL_RECENT_COMMUNICATIONS' => 'Recent Communications',
    'LBL_MESSAGE_TEMPLATES' => 'Message Templates',
    
    // Statistics labels
    'LBL_TOTAL_PARENTS' => 'Total Parents',
    'LBL_EMAIL_ENABLED' => 'Email Enabled',
    'LBL_RECENT_COMMS' => 'Recent Communications',
    'LBL_ACTIVE_PROGRAMS' => 'Active Programs',
    
    // Form field labels
    'LBL_COMMUNICATION_TYPE' => 'Communication Type',
    'LBL_SUBJECT' => 'Subject',
    'LBL_MESSAGE' => 'Message',
    'LBL_TEMPLATE_USED' => 'Template Used',
    'LBL_RECIPIENT_COUNT' => 'Recipients',
    'LBL_SENT_DATE' => 'Sent Date',
    'LBL_SENT_BY' => 'Sent By',
    'LBL_STATUS' => 'Status',
    
    // Parent information labels
    'LBL_PARENT_NAME' => 'Parent Name',
    'LBL_CONTACT_INFO' => 'Contact Information',
    'LBL_CHILDREN_NAMES' => 'Children Names',
    'LBL_CHILDREN_AGES' => 'Children Ages',
    'LBL_PROGRAMS_ENROLLED' => 'Programs Enrolled',
    'LBL_PREFERRED_COMMUNICATION' => 'Preferred Communication',
    'LBL_COMMUNICATION_FREQUENCY' => 'Communication Frequency',
    'LBL_EMAIL_NOTIFICATIONS' => 'Email Notifications',
    'LBL_EMERGENCY_CONTACT_NAME' => 'Emergency Contact Name',
    'LBL_EMERGENCY_CONTACT_PHONE' => 'Emergency Contact Phone',
    'LBL_LAST_COMMUNICATION_DATE' => 'Last Communication',
    'LBL_COMMUNICATION_COUNT' => 'Total Communications',
    
    // Filter labels
    'LBL_FILTER_BY_PROGRAM' => 'Filter by Program',
    'LBL_FILTER_BY_FREQUENCY' => 'Filter by Frequency',
    'LBL_EMAIL_ENABLED_ONLY' => 'Email Enabled Only',
    'LBL_APPLY_FILTERS' => 'Apply Filters',
    'LBL_CLEAR_FILTERS' => 'Clear',
    'LBL_ALL_PARENTS' => 'All Parents',
    
    // Selection labels
    'LBL_SELECT_ALL' => 'Select All',
    'LBL_SELECT_NONE' => 'Select None',
    'LBL_SELECT_EMAIL_ENABLED' => 'Select Email Enabled',
    'LBL_SELECTED_COUNT' => 'Selected: {count} parents',
    'LBL_NO_PARENTS_SELECTED' => 'No parents selected',
    
    // Template labels
    'LBL_LOAD_TEMPLATE' => 'Load Template',
    'LBL_TEMPLATE_SELECT' => 'Select Template',
    'LBL_WELCOME_TEMPLATE' => 'Welcome Message',
    'LBL_SCHEDULE_UPDATE_TEMPLATE' => 'Schedule Update',
    'LBL_WEATHER_CANCELLATION_TEMPLATE' => 'Weather Cancellation',
    'LBL_REMINDER_TEMPLATE' => 'General Reminder',
    
    // Action labels
    'LBL_SEND_EMAIL' => 'Send Email',
    'LBL_SAVE_DRAFT' => 'Save Draft',
    'LBL_PREVIEW' => 'Preview',
    'LBL_VIEW_DETAILS' => 'View Details',
    'LBL_VIEW_HISTORY' => 'View History',
    
    // List view labels
    'LBL_NAME' => 'Communication Name',
    'LBL_DATE_ENTERED' => 'Date Created',
    'LBL_DATE_MODIFIED' => 'Last Modified',
    'LBL_CREATED' => 'Created By',
    'LBL_MODIFIED' => 'Modified By',
    'LBL_DELETED' => 'Deleted',
    
    // Messages
    'LBL_NO_PARENTS' => 'No parents found',
    'LBL_NO_COMMUNICATIONS' => 'No recent communications',
    'LBL_EMAIL_SENT_SUCCESS' => 'Email sent successfully to {count} parents',
    'LBL_EMAIL_SEND_ERROR' => 'Error sending email',
    'LBL_REQUIRED_FIELDS' => 'Please fill in all required fields',
    'LBL_SELECT_PARENTS_FIRST' => 'Please select at least one parent',
    'LBL_LOADING' => 'Loading...',
    'LBL_SENDING' => 'Sending email...',
    
    // Help text
    'LBL_SUBJECT_HELP' => 'Enter the email subject line',
    'LBL_MESSAGE_HELP' => 'Enter your message. Use [PARENT_NAME] to personalize.',
    'LBL_TEMPLATE_HELP' => 'Select a template to auto-fill subject and message',
    'LBL_FILTER_HELP' => 'Use filters to narrow down the parent list',
    
    // Navigation menu items
    'LNK_LIST' => 'View Communications',
    'LNK_NEW' => 'Send Communication',
    'LNK_DASHBOARD' => 'Dashboard',
    'LNK_REPORTS' => 'Communication Reports',
    'LNK_PARENTS' => 'Manage Parents',
);

// Global dropdown lists for parent communication
global $app_list_strings;

$app_list_strings['communication_type_list'] = array(
    '' => '',
    'broadcast_email' => 'Broadcast Email',
    'individual_email' => 'Individual Email',
    'sms' => 'SMS Message',
    'phone_call' => 'Phone Call',
    'newsletter' => 'Newsletter',
);

$app_list_strings['communication_status_list'] = array(
    '' => '',
    'draft' => 'Draft',
    'sending' => 'Sending',
    'sent' => 'Sent',
    'failed' => 'Failed',
    'cancelled' => 'Cancelled',
);

$app_list_strings['parent_programs_list'] = array(
    '' => '',
    'Football U7' => 'Football U7',
    'Soccer U8' => 'Soccer U8', 
    'Basketball U12' => 'Basketball U12',
    'Tennis U10' => 'Tennis U10',
    'Baseball U9' => 'Baseball U9',
    'Volleyball U11' => 'Volleyball U11',
);

$app_list_strings['communication_frequency_list'] = array(
    '' => '',
    'daily' => 'Daily',
    'weekly' => 'Weekly',
    'monthly' => 'Monthly',
    'as_needed' => 'As Needed',
    'emergency_only' => 'Emergency Only',
); 