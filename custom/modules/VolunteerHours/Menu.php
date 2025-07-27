<?php
/**
 * VolunteerHours Module - Menu Configuration
 * 
 * This file defines the menu items that appear in the module's
 * shortcuts menu and actions.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $mod_strings, $app_strings, $sugar_config;

$module_menu = Array(
    Array(
        "index.php?module=VolunteerHours&action=EditView&return_module=VolunteerHours&return_action=DetailView", 
        $mod_strings['LNK_NEW_RECORD'],
        "VolunteerHours",
        'VolunteerHours'
    ),
    Array(
        "index.php?module=VolunteerHours&action=index&return_module=VolunteerHours&return_action=DetailView", 
        $mod_strings['LNK_LIST'],
        "VolunteerHours",
        'VolunteerHours'
    ),
    Array(
        "index.php?module=VolunteerHours&action=volunteerhoursrecognition", 
        $mod_strings['LBL_DASHBOARD_TITLE'],
        "VolunteerHours",
        'VolunteerHours'
    ),
);
?> 