<?php 
 //WARNING: The contents of this file are auto-generated



/**
 * Equipment Entry Points Registration
 * 
 * Registers entry points for equipment operations (check-out and return).
 * 
 * @author SuiteCRM Development Team
 * @package Equipment
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry['equipment_checkout'] = array(
    'file' => 'custom/equipment_checkout.php',
    'auth' => true,
);

$entry_point_registry['equipment_return'] = array(
    'file' => 'custom/equipment_return.php',
    'auth' => true,
);

$entry_point_registry['equipment_maintenance'] = array(
    'file' => 'custom/equipment_maintenance.php',
    'auth' => true,
);

$entry_point_registry['test_maintenance_entry'] = array(
    'file' => 'custom/test_maintenance_entry.php',
    'auth' => true,
);

$entry_point_registry['equipment_notifications'] = array(
    'file' => 'custom/equipment_notifications.php',
    'auth' => true,
);

$entry_point_registry['equipment_reports'] = array(
    'file' => 'custom/equipment_reports.php',
    'auth' => true,
);

$entry_point_registry['equipment_full_report'] = array(
    'file' => 'custom/equipment_full_report.php',
    'auth' => true,
);

$entry_point_registry['add_sample_equipment'] = array(
    'file' => 'custom/add_sample_equipment.php',
    'auth' => true,
);

$entry_point_registry['debug_equipment'] = array(
    'file' => 'custom/debug_equipment.php',
    'auth' => true,
);

$entry_point_registry['simple_add_equipment'] = array(
    'file' => 'custom/simple_add_equipment.php',
    'auth' => true,
);

$entry_point_registry['ultra_simple_equipment'] = array(
    'file' => 'custom/ultra_simple_equipment.php',
    'auth' => true,
);

$entry_point_registry['direct_sql_equipment'] = array(
    'file' => 'custom/direct_sql_equipment.php',
    'auth' => true,
);

$entry_point_registry['minimal_equipment'] = array(
    'file' => 'custom/minimal_equipment.php',
    'auth' => true,
);

$entry_point_registry['create_equipment_form'] = array(
    'file' => 'custom/create_equipment_form.php',
    'auth' => true,
);

$entry_point_registry['debug_equipment_data'] = array(
    'file' => 'custom/debug_equipment_data.php',
    'auth' => true,
);

$entry_point_registry['check_recent_equipment'] = array(
    'file' => 'custom/check_recent_equipment.php',
    'auth' => true,
);

$entry_point_registry['test_form_save'] = array(
    'file' => 'custom/test_form_save.php',
    'auth' => true,
);

$entry_point_registry['diagnose_database'] = array(
    'file' => 'custom/diagnose_database.php',
    'auth' => true,
);

$entry_point_registry['force_equipment_save'] = array(
    'file' => 'custom/force_equipment_save.php',
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

/**
 * Feature 4: Basic Parent Notification System
 * Entry point registration for parent email sending
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry['send_parent_email'] = array(
    'file' => 'custom/send_parent_email.php',
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