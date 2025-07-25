<?php
/**
 * SportPrograms Module Language File (English US)
 * 
 * This file defines all language labels and strings for the
 * SportPrograms module in the Youth Sports League system.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$mod_strings = array(
    // Module Meta
    'LBL_MODULE_NAME' => 'Sport Programs',
    'LBL_MODULE_TITLE' => 'Sport Programs: Home',
    'LBL_SEARCH_FORM_TITLE' => 'Sport Program Search',
    'LBL_LIST_FORM_TITLE' => 'Sport Programs List',
    'LBL_NEW_FORM_TITLE' => 'Create Sport Program',
    'LBL_EDIT_FORM_TITLE' => 'Edit Sport Program',
    'LBL_DETAIL_FORM_TITLE' => 'Sport Program Details',
    
    // Navigation
    'LNK_NEW_RECORD' => 'Create Sport Program',
    'LNK_LIST' => 'View Sport Programs',
    'LNK_IMPORT_SPORTPROGRAMS' => 'Import Sport Programs',
    
    // Standard Field Labels
    'LBL_ID' => 'ID',
    'LBL_NAME' => 'Program Name',
    'LBL_DESCRIPTION' => 'Description',
    'LBL_DATE_ENTERED' => 'Date Created',
    'LBL_DATE_MODIFIED' => 'Date Modified',
    'LBL_MODIFIED' => 'Modified By',
    'LBL_MODIFIED_ID' => 'Modified By Id',
    'LBL_MODIFIED_NAME' => 'Modified By Name',
    'LBL_CREATED' => 'Created By',
    'LBL_CREATED_ID' => 'Created By Id',
    'LBL_DELETED' => 'Deleted',
    'LBL_ASSIGNED_TO' => 'Assigned To',
    'LBL_ASSIGNED_TO_ID' => 'Assigned User Id',
    'LBL_ASSIGNED_TO_NAME' => 'Assigned to',
    
    // Custom Field Labels
    'LBL_SPORT_TYPE' => 'Sport Type',
    'LBL_AGE_GROUP' => 'Age Group',
    'LBL_MEETING_DAYS' => 'Meeting Days',
    'LBL_VOLUNTEERS_NEEDED' => 'Volunteers Needed',
    'LBL_VOLUNTEERS_ASSIGNED' => 'Volunteers Assigned',
    'LBL_PROGRAM_STATUS' => 'Program Status',
    'LBL_SEASON' => 'Season',
    'LBL_START_DATE' => 'Start Date',
    'LBL_END_DATE' => 'End Date',
    'LBL_MEETING_LOCATION' => 'Meeting Location',
    
    // Help Text
    'LBL_SPORT_TYPE_HELP' => 'Type of sport for this program',
    'LBL_AGE_GROUP_HELP' => 'Age group this program serves',
    'LBL_MEETING_DAYS_HELP' => 'Days of the week when this program meets',
    'LBL_VOLUNTEERS_NEEDED_HELP' => 'Total number of volunteers needed for this program',
    'LBL_VOLUNTEERS_ASSIGNED_HELP' => 'Number of volunteers currently assigned (auto-calculated)',
    'LBL_PROGRAM_STATUS_HELP' => 'Current status of the program',
    'LBL_SEASON_HELP' => 'Season when this program runs',
    'LBL_START_DATE_HELP' => 'When the program starts',
    'LBL_END_DATE_HELP' => 'When the program ends',
    'LBL_MEETING_LOCATION_HELP' => 'Where program activities take place',
    
    // List View Labels (shortened for space)
    'LBL_LIST_SPORT_TYPE' => 'Sport',
    'LBL_LIST_AGE_GROUP' => 'Age Group',
    'LBL_LIST_VOLUNTEERS_NEEDED' => 'Need',
    'LBL_LIST_VOLUNTEERS_ASSIGNED' => 'Have',
    'LBL_LIST_PROGRAM_STATUS' => 'Status',
    'LBL_LIST_SEASON' => 'Season',
    'LBL_LIST_START_DATE' => 'Starts',
    
    // Panel Labels
    'LBL_PANEL_DEFAULT' => 'Program Information',
    'LBL_PANEL_SCHEDULE' => 'Schedule & Location',
    'LBL_PANEL_VOLUNTEERS' => 'Volunteer Requirements',
    
    // Search Labels
    'LBL_SEARCH_PROGRAMS_NEEDING_VOLUNTEERS' => 'Programs Needing Volunteers',
    'LBL_SEARCH_PROGRAMS_BY_SPORT' => 'Find Programs by Sport',
    'LBL_SEARCH_PROGRAMS_BY_STATUS' => 'Find Programs by Status',
    
    // Actions
    'LBL_ASSIGN_VOLUNTEERS' => 'Assign Volunteers',
    'LBL_FIND_MATCHING_VOLUNTEERS' => 'Find Matching Volunteers',
    'LBL_VIEW_ASSIGNED_VOLUNTEERS' => 'View Assigned Volunteers',
    
    // Status Messages
    'LBL_PROGRAM_FULLY_STAFFED' => 'This program is fully staffed',
    'LBL_PROGRAM_NEEDS_VOLUNTEERS' => 'This program needs more volunteers',
    'LBL_NO_VOLUNTEERS_ASSIGNED' => 'No volunteers assigned yet',
    
    // Error Messages
    'ERR_INVALID_SPORT_TYPE' => 'Please select a valid sport type',
    'ERR_INVALID_AGE_GROUP' => 'Please select a valid age group',
    'ERR_INVALID_DATE_RANGE' => 'End date must be after start date',
    'ERR_NO_VOLUNTEERS_NEEDED' => 'Number of volunteers needed must be greater than 0',
    
    // Subpanel Labels
    'LBL_SPORTPROGRAMS_CONTACTS_FROM_CONTACTS_TITLE' => 'Volunteers',
    'LBL_SPORTPROGRAMS_CONTACTS_FROM_SPORTPROGRAMS_TITLE' => 'Assigned Volunteers',
); 