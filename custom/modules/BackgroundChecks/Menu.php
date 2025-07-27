<?php
/**
 * BackgroundChecks Module - Menu Definitions
 * 
 * This file defines the menu items and navigation for the BackgroundChecks module.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $mod_strings;

$module_menu = Array(
    Array(
        "index.php?module=BackgroundChecks&action=EditView&return_module=BackgroundChecks&return_action=DetailView", 
        $mod_strings['LNK_NEW_RECORD'],
        "BackgroundChecks",
        'BackgroundChecks'
    ),
    Array(
        "index.php?module=BackgroundChecks&action=index&return_module=BackgroundChecks&return_action=DetailView", 
        $mod_strings['LNK_LIST'],
        "BackgroundChecks",
        'BackgroundChecks'
    ),
    Array(
        "index.php?module=BackgroundChecks&action=backgroundcheckdashboard", 
        $mod_strings['LBL_DASHBOARD_TITLE'],
        "BackgroundChecks",
        'BackgroundChecks'
    ),
    Array(
        "index.php?module=Import&action=Step1&import_module=BackgroundChecks&return_module=BackgroundChecks&return_action=index",
        $mod_strings['LNK_IMPORT_BACKGROUND_CHECKS'],
        "Import",
        'BackgroundChecks'
    ),
); 