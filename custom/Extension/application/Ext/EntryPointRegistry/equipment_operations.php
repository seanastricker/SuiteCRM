<?php

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

$entry_point_registry['equipment_notifications'] = array(
    'file' => 'custom/equipment_notifications.php',
    'auth' => true,
);

$entry_point_registry['equipment_reports'] = array(
    'file' => 'custom/equipment_reports.php',
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