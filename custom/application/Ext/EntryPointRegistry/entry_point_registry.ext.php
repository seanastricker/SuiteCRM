<?php 
 //WARNING: The contents of this file are auto-generated


$entry_point_registry['debug_parents'] = array(
    'file' => 'custom/debug_parents.php',
    'auth' => true,
); 

/**
 * Entry Point Registration for Feature 3: Quick Incident Reporting
 * 
 * Registers the incident_reporting entry point to make the dashboard accessible
 * via: index.php?entryPoint=incident_reporting
 */

$entry_point_registry['incident_reporting'] = array(
    'file' => 'custom/incident_reporting_dashboard.php',
    'auth' => true,
); 

/**
 * Entry Point Registration for Feature 4: Basic Parent Notification System
 * 
 * Registers the parent_communication entry point to make the dashboard accessible
 * via: index.php?entryPoint=parent_communication
 */

$entry_point_registry['parent_communication'] = array(
    'file' => 'custom/parent_communication_dashboard.php',
    'auth' => true,
); 

/**
 * Volunteer Matching Dashboard Entry Point Registration
 * 
 * This registers a custom entry point for accessing the volunteer
 * matching dashboard directly via URL.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry['volunteer_matching'] = array(
    'file' => 'custom/volunteer_matching_dashboard.php',
    'auth' => true,
); 
?>