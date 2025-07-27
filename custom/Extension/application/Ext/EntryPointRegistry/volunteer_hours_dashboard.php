<?php
/**
 * Feature 6: Volunteer Hours & Recognition Tracker
 * Entry Point Registration for Volunteer Hours Dashboard
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry['volunteer_hours_dashboard'] = array(
    'file' => 'custom/volunteer_hours_dashboard.php',
    'auth' => true,
); 