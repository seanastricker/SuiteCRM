<?php
/**
 * Feature 4: Basic Parent Notification System
 * Menu file for the ParentCommunication module
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
        'index.php?module=ParentCommunication&action=index',
        'Parent Communication Dashboard',
        'ParentCommunication',
        'ParentCommunication'
    ),
    array(
        'index.php?module=Contacts&action=index&contact_type=parent',
        'Manage Parents',
        'Contacts',
        'ParentCommunication'
    ),
); 