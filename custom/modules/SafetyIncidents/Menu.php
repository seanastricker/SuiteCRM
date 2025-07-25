<?php
/**
 * SafetyIncidents Menu Configuration
 * Feature 3: Quick Incident Reporting Form
 * 
 * Navigation menu items for SafetyIncidents module
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $module_menu;

$module_menu = array(
    array(
        "index.php?module=SafetyIncidents&action=EditView&return_module=SafetyIncidents&return_action=DetailView",
        $mod_strings['LBL_REPORT_INCIDENT'],
        "Create",
        'SafetyIncidents'
    ),
    array(
        "index.php?module=SafetyIncidents&action=index&return_module=SafetyIncidents&return_action=DetailView",
        $mod_strings['LBL_VIEW_INCIDENTS'],
        "SafetyIncidents",
        'SafetyIncidents'
    ),
    array(
        "index.php?module=SafetyIncidents&action=index&incident_status_c=reported",
        "New Reports",
        "SafetyIncidents",
        'SafetyIncidents'
    ),
    array(
        "index.php?module=SafetyIncidents&action=index&incident_status_c=under_review",
        "Under Review",
        "SafetyIncidents", 
        'SafetyIncidents'
    ),
); 