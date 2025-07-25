<?php
/**
 * SportPrograms Module Language Extensions
 * 
 * This file defines dropdown options and language labels for the
 * SportPrograms module in the Youth Sports League system.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Program Status List - Single select options
$app_list_strings['program_status_list'] = array(
    '' => '',
    'planning' => 'Planning - Program being organized',
    'recruiting' => 'Recruiting - Looking for volunteers',
    'ready' => 'Ready - Fully staffed and ready to start',
    'active' => 'Active - Currently running',
    'on_hold' => 'On Hold - Temporarily suspended',
    'completed' => 'Completed - Program finished',
    'cancelled' => 'Cancelled - Program was cancelled',
);

// Season List - Single select options
$app_list_strings['season_list'] = array(
    '' => '',
    'spring' => 'Spring (March - May)',
    'summer' => 'Summer (June - August)',
    'fall' => 'Fall (September - November)',
    'winter' => 'Winter (December - February)',
    'year_round' => 'Year Round',
);

// Global language labels for SportPrograms
$app_strings['LBL_SPORT_TYPE'] = 'Sport Type';
$app_strings['LBL_AGE_GROUP'] = 'Age Group';
$app_strings['LBL_MEETING_DAYS'] = 'Meeting Days';
$app_strings['LBL_VOLUNTEERS_NEEDED'] = 'Volunteers Needed';
$app_strings['LBL_VOLUNTEERS_ASSIGNED'] = 'Volunteers Assigned';
$app_strings['LBL_PROGRAM_STATUS'] = 'Program Status';
$app_strings['LBL_SEASON'] = 'Season';
$app_strings['LBL_START_DATE'] = 'Start Date';
$app_strings['LBL_END_DATE'] = 'End Date';
$app_strings['LBL_MEETING_LOCATION'] = 'Meeting Location'; 