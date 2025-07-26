<?php

/**
 * Equipment Module - English Language File
 * 
 * Contains all language strings and labels for the Equipment module.
 * 
 * @author SuiteCRM Development Team
 * @package Equipment
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$mod_strings = array(
    // Module labels
    'LBL_MODULE_NAME' => 'Equipment',
    'LBL_MODULE_TITLE' => 'Equipment Management',
    'LBL_SEARCH_FORM_TITLE' => 'Equipment Search',
    'LBL_LIST_FORM_TITLE' => 'Equipment List',
    'LBL_NEW_FORM_TITLE' => 'New Equipment Item',
    'LBL_EQUIPMENT' => 'Equipment',
    
    // Standard field labels
    'LBL_ID' => 'ID',
    'LBL_NAME' => 'Equipment Name',
    'LBL_DATE_ENTERED' => 'Date Created',
    'LBL_DATE_MODIFIED' => 'Date Modified',
    'LBL_MODIFIED' => 'Modified By',
    'LBL_MODIFIED_NAME' => 'Modified By Name',
    'LBL_CREATED' => 'Created By',
    'LBL_DESCRIPTION' => 'Description',
    'LBL_DELETED' => 'Deleted',
    
    // Equipment-specific field labels
    'LBL_EQUIPMENT_TYPE' => 'Equipment Type',
    'LBL_BRAND' => 'Brand',
    'LBL_MODEL' => 'Model',
    'LBL_SERIAL_NUMBER' => 'Serial Number',
    'LBL_CONDITION' => 'Condition',
    'LBL_STATUS' => 'Status',
    'LBL_CURRENT_LOCATION' => 'Current Location',
    'LBL_PURCHASE_DATE' => 'Purchase Date',
    'LBL_PURCHASE_PRICE' => 'Purchase Price',
    'LBL_CHECKOUT_DATE' => 'Check-Out Date',
    'LBL_DUE_DATE' => 'Due Date',
    'LBL_RETURN_DATE' => 'Return Date',
    'LBL_CHECKED_OUT_BY' => 'Checked Out By',
    'LBL_CHECKOUT_NOTES' => 'Check-Out Notes',
    'LBL_PROGRAM' => 'Program Association',
    
    // Dashboard labels
    'LBL_DASHBOARD_TITLE' => 'Equipment Check-Out Tracker',
    'LBL_EQUIPMENT_SUMMARY' => 'Equipment Summary',
    'LBL_EQUIPMENT_INVENTORY' => 'Equipment Inventory',
    'LBL_CHECKOUT_EQUIPMENT' => 'Check-Out Equipment',
    'LBL_RETURN_EQUIPMENT' => 'Return Equipment',
    'LBL_OVERDUE_EQUIPMENT' => 'Overdue Equipment',
    'LBL_EQUIPMENT_HISTORY' => 'Equipment History',
    
    // Summary statistics
    'LBL_TOTAL_EQUIPMENT' => 'Total Equipment',
    'LBL_AVAILABLE' => 'Available',
    'LBL_CHECKED_OUT' => 'Checked Out',
    'LBL_IN_MAINTENANCE' => 'In Maintenance',
    'LBL_OVERDUE' => 'Overdue',
    'LBL_DAMAGED' => 'Damaged',
    
    // Action labels
    'LBL_CHECK_OUT' => 'Check Out',
    'LBL_RETURN' => 'Return',
    'LBL_VIEW_DETAILS' => 'View Details',
    'LBL_EDIT' => 'Edit',
    'LBL_DELETE' => 'Delete',
    'LBL_ADD_EQUIPMENT' => 'Add Equipment',
    'LBL_FILTER_EQUIPMENT' => 'Filter Equipment',
    'LBL_CLEAR_FILTERS' => 'Clear Filters',
    'LBL_APPLY_FILTERS' => 'Apply Filters',
    
    // Form labels
    'LBL_WHO_CHECKING_OUT' => 'Who is checking out this equipment?',
    'LBL_DUE_BACK_DATE' => 'When is this due back?',
    'LBL_CHECKOUT_PURPOSE' => 'Purpose/Notes',
    'LBL_RETURN_CONDITION' => 'Return Condition',
    'LBL_RETURN_LOCATION' => 'Return Location',
    'LBL_RETURN_NOTES' => 'Return Notes',
    
    // Filter labels
    'LBL_FILTER_BY_STATUS' => 'Filter by Status',
    'LBL_FILTER_BY_TYPE' => 'Filter by Type',
    'LBL_FILTER_BY_PROGRAM' => 'Filter by Program',
    'LBL_FILTER_BY_CONDITION' => 'Filter by Condition',
    'LBL_SHOW_OVERDUE_ONLY' => 'Show Overdue Only',
    'LBL_SHOW_AVAILABLE_ONLY' => 'Show Available Only',
    
    // Status messages
    'LBL_NO_EQUIPMENT_FOUND' => 'No equipment found matching your criteria.',
    'LBL_EQUIPMENT_CHECKED_OUT' => 'Equipment checked out successfully.',
    'LBL_EQUIPMENT_RETURNED' => 'Equipment returned successfully.',
    'LBL_ERROR_CHECKING_OUT' => 'Error checking out equipment.',
    'LBL_ERROR_RETURNING' => 'Error returning equipment.',
    'LBL_EQUIPMENT_NOT_AVAILABLE' => 'This equipment is not available for check-out.',
    'LBL_EQUIPMENT_NOT_CHECKED_OUT' => 'This equipment is not currently checked out.',
    'LBL_MISSING_REQUIRED_FIELDS' => 'Please fill in all required fields.',
    
    // Equipment types
    'LBL_FOOTBALL_EQUIPMENT' => 'Football Equipment',
    'LBL_SOCCER_EQUIPMENT' => 'Soccer Equipment',
    'LBL_BASKETBALL_EQUIPMENT' => 'Basketball Equipment',
    'LBL_TENNIS_EQUIPMENT' => 'Tennis Equipment',
    'LBL_BASEBALL_EQUIPMENT' => 'Baseball Equipment',
    'LBL_VOLLEYBALL_EQUIPMENT' => 'Volleyball Equipment',
    'LBL_GENERAL_EQUIPMENT' => 'General Sports Equipment',
    'LBL_SAFETY_EQUIPMENT' => 'Safety Equipment',
    'LBL_MAINTENANCE_EQUIPMENT' => 'Maintenance Equipment',
    
    // Equipment conditions
    'LBL_EXCELLENT' => 'Excellent',
    'LBL_GOOD' => 'Good',
    'LBL_FAIR' => 'Fair',
    'LBL_POOR' => 'Poor',
    'LBL_NEEDS_REPAIR' => 'Needs Repair',
    
    // Equipment statuses
    'LBL_AVAILABLE' => 'Available',
    'LBL_CHECKED_OUT' => 'Checked Out',
    'LBL_MAINTENANCE' => 'In Maintenance',
    'LBL_RETIRED' => 'Retired',
    
    // Programs
    'LBL_FOOTBALL_U7' => 'Football U7',
    'LBL_SOCCER_U8' => 'Soccer U8',
    'LBL_BASKETBALL_U12' => 'Basketball U12',
    'LBL_TENNIS_U10' => 'Tennis U10',
    'LBL_BASEBALL_U9' => 'Baseball U9',
    'LBL_VOLLEYBALL_U11' => 'Volleyball U11',
    'LBL_GENERAL_USE' => 'General Use',
    
    // List view labels
    'LBL_LIST_NAME' => 'Name',
    'LBL_LIST_EQUIPMENT_TYPE' => 'Type',
    'LBL_LIST_STATUS' => 'Status',
    'LBL_LIST_CONDITION' => 'Condition',
    'LBL_LIST_LOCATION' => 'Location',
    'LBL_LIST_DUE_DATE' => 'Due Date',
    'LBL_LIST_CHECKED_OUT_BY' => 'Checked Out By',
    
    // Navigation
    'LNK_EQUIPMENT_LIST' => 'View Equipment',
    'LNK_NEW_EQUIPMENT' => 'Add Equipment',
    'LNK_EQUIPMENT_DASHBOARD' => 'Equipment Dashboard',
    'LNK_EQUIPMENT_CHECKOUT' => 'Check-Out Equipment',
    'LNK_EQUIPMENT_REPORTS' => 'Equipment Reports',
    
    // Additional view labels
    'LBL_EQUIPMENT_LIST' => 'Equipment List',
    'LBL_CREATE_EQUIPMENT' => 'Create Equipment',
    'LBL_EDIT_EQUIPMENT' => 'Edit Equipment',
    'LBL_VIEW_EQUIPMENT' => 'View Equipment',
    'LBL_LIST_EQUIPMENT' => 'List Equipment',
    'LBL_EQUIPMENT_DASHBOARD' => 'Equipment Dashboard',
    
    // Reports and notifications
    'LBL_EQUIPMENT_REPORTS' => 'Equipment Reports & Analytics',
    'LBL_OVERDUE_ALERT' => 'Overdue Equipment Alert',
    'LBL_SEND_REMINDERS' => 'Send Reminders',
    'LBL_VIEW_DETAILS' => 'View Details',
    'LBL_UTILIZATION_RATE' => 'Utilization Rate',
    'LBL_USAGE_STATISTICS' => 'Usage Statistics',
    'LBL_CONDITION_REPORT' => 'Condition Report',
    'LBL_OVERDUE_REPORT' => 'Overdue Report',
    'LBL_GENERATE_REPORT' => 'Generate Report',
    'LBL_EXPORT_DATA' => 'Export Data',
    'LBL_SEND_NOTIFICATIONS' => 'Send Notifications',
    'LBL_DAYS_OVERDUE' => 'Days Overdue',
    'LBL_ACTION_REQUIRED' => 'Action Required',
    'LBL_ALL_CURRENT' => 'All Current',
    'LBL_NOTIFICATIONS_SENT' => 'Notifications sent successfully',
    'LBL_NO_OVERDUE_EQUIPMENT' => 'No overdue equipment found',
); 