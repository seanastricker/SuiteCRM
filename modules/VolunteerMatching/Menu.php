<?php
/**
 * Feature 2: Simple Volunteer-Program Matching
 * Menu file for the VolunteerMatching module
 * 
 * Adds navigation items to SuiteCRM menu
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $mod_strings, $app_strings, $sugar_config;

// All menu items point to the dashboard
$module_menu = array(
    array(
        'index.php?module=VolunteerMatching&action=index',
        'Volunteer Matching Dashboard',
        'VolunteerMatching',
        'VolunteerMatching'
    ),
    array(
        'index.php?module=Contacts&action=index&contact_type=volunteer',
        'Manage Volunteers',
        'Contacts',
        'VolunteerMatching'
    ),
); 