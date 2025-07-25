<?php
// WARNING: The contents of this file are auto-generated


/**
 * Account Priority Levels Language Extensions
 * 
 * This file defines the dropdown options and language labels for the
 * custom Priority Level field in the Accounts module.
 * 
 * @package SuiteCRM
 * @subpackage Custom
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Dropdown list options for account priority levels
$app_list_strings['account_priority_levels_list'] = array(
    '' => '',
    'high' => 'High Priority',
    'medium' => 'Medium Priority', 
    'low' => 'Low Priority',
    'unassigned' => 'Unassigned',
);

// Language labels
$app_strings['LBL_PRIORITY_LEVEL'] = 'Priority Level'; 

/**
 * Background Check and Contact Type Language Extensions
 * 
 * This file defines dropdown options and language labels for the
 * Youth Sports League volunteer management system.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Background Check Status dropdown options
$app_list_strings['background_check_status_list'] = array(
    '' => '',
    'valid' => 'Valid',
    'expiring' => 'Expiring Soon (30 days)',
    'expired' => 'Expired',
    'pending' => 'Pending Review',
    'not_required' => 'Not Required',
);

// Contact Type dropdown options  
$app_list_strings['contact_type_list'] = array(
    '' => '',
    'volunteer' => 'Volunteer',
    'parent' => 'Parent/Guardian',
    'staff' => 'Staff Member',
    'board_member' => 'Board Member',
    'coach' => 'Coach',
    'official' => 'Official/Referee',
    'other' => 'Other',
);

// Language labels for global use
$app_strings['LBL_BACKGROUND_CHECK_EXPIRATION'] = 'Background Check Expiration';
$app_strings['LBL_BACKGROUND_CHECK_STATUS'] = 'Background Check Status';
$app_strings['LBL_CONTACT_TYPE'] = 'Contact Type'; 

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

/**
 * Volunteer Profile Language Extensions
 * 
 * This file defines dropdown options and language labels for the
 * volunteer profile fields used in Youth Sports League volunteer matching.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Sports List - Multi-select options
$app_list_strings['sports_list'] = array(
    'soccer' => 'Soccer',
    'basketball' => 'Basketball', 
    'baseball' => 'Baseball',
    'softball' => 'Softball',
    'football' => 'Football',
    'tennis' => 'Tennis',
    'volleyball' => 'Volleyball',
    'track_field' => 'Track & Field',
    'swimming' => 'Swimming',
    'wrestling' => 'Wrestling',
    'gymnastics' => 'Gymnastics',
    'lacrosse' => 'Lacrosse',
    'hockey' => 'Hockey',
    'golf' => 'Golf',
    'cross_country' => 'Cross Country',
    'cheerleading' => 'Cheerleading',
    'martial_arts' => 'Martial Arts',
    'other' => 'Other Sport',
);

// Age Groups List - Multi-select options
$app_list_strings['age_groups_list'] = array(
    '5_7' => '5-7 years (T-Ball/Mini)',
    '8_10' => '8-10 years (Little League)',
    '11_13' => '11-13 years (Junior)',
    '14_16' => '14-16 years (High School JV)',
    '17_18' => '17-18 years (High School Varsity)',
    'adult' => 'Adult Programs',
    'all_ages' => 'All Age Groups',
);

// Days of Week List - Multi-select options
$app_list_strings['days_of_week_list'] = array(
    'monday' => 'Monday',
    'tuesday' => 'Tuesday',
    'wednesday' => 'Wednesday',
    'thursday' => 'Thursday',
    'friday' => 'Friday',
    'saturday' => 'Saturday',
    'sunday' => 'Sunday',
);

// Experience Level List - Single select options
$app_list_strings['experience_level_list'] = array(
    '' => '',
    'beginner' => 'Beginner - New to volunteering',
    'some_experience' => 'Some Experience - Occasional volunteer',
    'experienced' => 'Experienced - Regular volunteer',
    'expert' => 'Expert - Leadership/coaching experience',
    'professional' => 'Professional - Sports industry background',
);

// Volunteer Status List - Single select options
$app_list_strings['volunteer_status_list'] = array(
    '' => '',
    'active' => 'Active - Currently volunteering',
    'available' => 'Available - Ready to volunteer',
    'inactive' => 'Inactive - Not currently available',
    'seasonal' => 'Seasonal - Available certain times of year',
    'on_hold' => 'On Hold - Temporarily unavailable',
    'retired' => 'Retired - No longer volunteering',
);

// Global language labels
$app_strings['LBL_PREFERRED_SPORTS'] = 'Preferred Sports';
$app_strings['LBL_PREFERRED_AGE_GROUPS'] = 'Preferred Age Groups';
$app_strings['LBL_AVAILABILITY_DAYS'] = 'Available Days';
$app_strings['LBL_VOLUNTEER_EXPERIENCE_LEVEL'] = 'Experience Level';
$app_strings['LBL_SPECIAL_SKILLS'] = 'Special Skills & Certifications';
$app_strings['LBL_VOLUNTEER_STATUS'] = 'Volunteer Status'; 
