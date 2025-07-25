<?php
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