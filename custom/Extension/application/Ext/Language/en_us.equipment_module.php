<?php

/**
 * Equipment Module - Global Language Strings
 * 
 * Global application language strings for Equipment module navigation.
 * 
 * @author SuiteCRM Development Team
 * @package Equipment
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$app_list_strings['moduleList']['Equipment'] = 'Equipment';
$app_list_strings['moduleListSingular']['Equipment'] = 'Equipment';

// Equipment dropdown options
$app_list_strings['equipment_type_list'] = array(
    'football' => 'Football Equipment',
    'soccer' => 'Soccer Equipment', 
    'basketball' => 'Basketball Equipment',
    'tennis' => 'Tennis Equipment',
    'baseball' => 'Baseball Equipment',
    'volleyball' => 'Volleyball Equipment',
    'general' => 'General Sports Equipment',
    'safety' => 'Safety Equipment',
    'maintenance' => 'Maintenance Equipment',
);

$app_list_strings['equipment_condition_list'] = array(
    'excellent' => 'Excellent',
    'good' => 'Good',
    'fair' => 'Fair',
    'poor' => 'Poor',
    'damaged' => 'Damaged',
    'needs_repair' => 'Needs Repair',
);

$app_list_strings['equipment_status_list'] = array(
    'available' => 'Available',
    'checked_out' => 'Checked Out',
    'maintenance' => 'In Maintenance',
    'damaged' => 'Damaged',
    'retired' => 'Retired',
);

$app_list_strings['equipment_program_list'] = array(
    'Football U7' => 'Football U7',
    'Soccer U8' => 'Soccer U8', 
    'Basketball U12' => 'Basketball U12',
    'Tennis U10' => 'Tennis U10',
    'Baseball U9' => 'Baseball U9',
    'Volleyball U11' => 'Volleyball U11',
    'General' => 'General Use',
); 