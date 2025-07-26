<?php

/**
 * Test Form Save Process
 * 
 * Simulates exactly what the equipment creation form should be doing
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

require_once('include/entryPoint.php');

header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 0);
ob_start();
ob_clean();

try {
    global $db, $current_user;
    
    // Simulate form data (exactly like the form would send)
    $test_data = array(
        'name' => 'Form Test Equipment - ' . date('H:i:s'),
        'equipment_type' => 'soccer',
        'checkout_status' => 'available',
        'condition_status' => 'good',
        'current_location' => 'Equipment Storage',
        'brand' => 'Test Brand',
        'model' => 'Test Model'
    );
    
    // Method 1: Try SugarBean save (like the form does)
    $equipment = BeanFactory::getBean('Equipment');
    if (!$equipment) {
        throw new Exception('Could not create Equipment bean');
    }
    
    // Set all fields exactly like the form
    foreach ($test_data as $field => $value) {
        $equipment->$field = $value;
    }
    
    // Set standard fields
    $equipment->id = create_guid();
    $equipment->date_entered = date('Y-m-d H:i:s');
    $equipment->date_modified = date('Y-m-d H:i:s');
    $equipment->deleted = 0;
    
    if (!empty($current_user) && !empty($current_user->id)) {
        $equipment->created_by = $current_user->id;
        $equipment->modified_user_id = $current_user->id;
    }
    
    // Save with SugarBean
    $save_result = $equipment->save();
    $sugar_id = $equipment->id;
    
    // Verify SugarBean save
    $verify_result = $db->query("SELECT COUNT(*) as count FROM equipment WHERE id = '$sugar_id' AND deleted = 0");
    $sugar_verified = 0;
    if ($verify_result && $row = $db->fetchByAssoc($verify_result)) {
        $sugar_verified = $row['count'];
    }
    
    // Method 2: Try direct SQL insert
    $sql_id = create_guid();
    $name = $db->quote($test_data['name'] . ' (SQL)');
    $equipment_type = $db->quote($test_data['equipment_type']);
    $checkout_status = $db->quote($test_data['checkout_status']);
    $condition_status = $db->quote($test_data['condition_status']);
    $current_location = $db->quote($test_data['current_location']);
    $date_entered = $db->quote(date('Y-m-d H:i:s'));
    $created_by = !empty($current_user) && !empty($current_user->id) ? $db->quote($current_user->id) : "''";
    
    $sql = "INSERT INTO equipment (
                id, name, equipment_type, checkout_status, condition_status,
                current_location, date_entered, date_modified, created_by, 
                modified_user_id, deleted
            ) VALUES (
                '$sql_id', $name, $equipment_type, $checkout_status, $condition_status,
                $current_location, $date_entered, $date_entered, $created_by, 
                $created_by, 0
            )";
    
    $sql_result = $db->query($sql);
    
    // Verify SQL insert
    $verify_result = $db->query("SELECT COUNT(*) as count FROM equipment WHERE id = '$sql_id' AND deleted = 0");
    $sql_verified = 0;
    if ($verify_result && $row = $db->fetchByAssoc($verify_result)) {
        $sql_verified = $row['count'];
    }
    
    // Final count check
    $result = $db->query("SELECT COUNT(*) as count FROM equipment WHERE deleted = 0");
    $total_count = 0;
    if ($result && $row = $db->fetchByAssoc($result)) {
        $total_count = $row['count'];
    }
    
    echo json_encode(array(
        'success' => true,
        'message' => 'Test completed',
        'sugarbean_save_result' => $save_result,
        'sugarbean_verified' => $sugar_verified > 0,
        'sugarbean_id' => $sugar_id,
        'sql_insert_result' => $sql_result ? true : false,
        'sql_verified' => $sql_verified > 0,
        'sql_id' => $sql_id,
        'total_equipment_count' => $total_count,
        'sql_statement' => $sql
    ));
    
} catch (Exception $e) {
    echo json_encode(array(
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ));
}

ob_end_flush(); 