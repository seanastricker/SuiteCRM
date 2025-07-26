<?php
/**
 * Feature 3: Basic Incident Reporting
 * Menu file for the IncidentReporting module
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
        'index.php?module=IncidentReporting&action=index',
        'Incident Reporting Dashboard',
        'IncidentReporting',
        'IncidentReporting'
    ),
    array(
        'index.php?module=IncidentReporting&action=ReportingDashboard',
        'Report New Incident',
        'IncidentReporting',
        'IncidentReporting'
    ),
); 