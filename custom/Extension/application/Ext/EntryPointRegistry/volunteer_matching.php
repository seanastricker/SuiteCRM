<?php
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