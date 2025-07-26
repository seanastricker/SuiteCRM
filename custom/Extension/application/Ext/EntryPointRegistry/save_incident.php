<?php
/**
 * Feature 3: Basic Incident Reporting
 * Entry point registration for incident saving
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry['save_incident'] = array(
    'file' => 'custom/save_incident.php',
    'auth' => true,
); 