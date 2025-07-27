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

// Enhanced menu with email functionality
$module_menu = array(
    array(
        'index.php?module=ParentCommunication&action=index',
        'Parent Communication Dashboard',
        'ParentCommunication',
        'ParentCommunication'
    ),
    array(
        'index.php?module=ParentCommunication&action=emailcompose',
        'Compose Email',
        'ParentCommunication',
        'ParentCommunication'
    ),
    array(
        'index.php?module=ParentCommunication&action=emailtemplates',
        'Email Templates',
        'ParentCommunication',
        'ParentCommunication'
    ),
    array(
        'index.php?module=ParentCommunication&action=emailhistory',
        'Email History',
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