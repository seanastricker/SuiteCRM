<?php

/**
 * Direct SQL Equipment Creator
 * 
 * Bypasses SugarBean entirely and uses direct SQL to create equipment records.
 * This should work even if SugarBean save() is failing.
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

require_once('include/entryPoint.php');

// Complete output control
error_reporting(0);
ini_set('display_errors', 0);
ob_start();
header('Content-Type: application/json');

try {
    ob_clean();
    
    global $db, $current_user;
    
    // Ensure table exists
    require_once('modules/Equipment/EquipmentHelper.php');
    EquipmentHelper::createEquipmentTable();
    
    // Check current count
    $result = $db->query("SELECT COUNT(*) as count FROM equipment WHERE deleted = 0");
    $start_count = 0;
    if ($result && $row = $db->fetchByAssoc($result)) {
        $start_count = $row['count'];
    }
    
    // Equipment data to insert
    $equipment_items = array(
        array('name' => 'Soccer Goals', 'equipment_type' => 'soccer'),
        array('name' => 'Football Cones', 'equipment_type' => 'football'),
        array('name' => 'Basketball', 'equipment_type' => 'basketball'),
    );
    
    $created_count = 0;
    $errors = array();
    $sql_statements = array();
    
    foreach ($equipment_items as $item_data) {
        try {
            $id = create_guid();
            $name = $db->quote($item_data['name']);
            $equipment_type = $db->quote($item_data['equipment_type']);
            $checkout_status = $db->quote('available');
            $condition_status = $db->quote('good');
            $date_entered = $db->quote(date('Y-m-d H:i:s'));
            $date_modified = $db->quote(date('Y-m-d H:i:s'));
            $created_by = !empty($current_user) && !empty($current_user->id) ? $db->quote($current_user->id) : "''";
            $modified_user_id = !empty($current_user) && !empty($current_user->id) ? $db->quote($current_user->id) : "''";
            
            $sql = "INSERT INTO equipment (
                        id, name, equipment_type, checkout_status, condition_status,
                        date_entered, date_modified, created_by, modified_user_id, deleted
                    ) VALUES (
                        '$id', $name, $equipment_type, $checkout_status, $condition_status,
                        $date_entered, $date_modified, $created_by, $modified_user_id, 0
                    )";
            
            $sql_statements[] = $sql;
            
            $result = $db->query($sql);
            if ($result) {
                $created_count++;
            } else {
                $errors[] = "SQL failed for {$item_data['name']}: " . $db->lastError();
            }
            
        } catch (Exception $e) {
            $errors[] = "Error creating {$item_data['name']}: " . $e->getMessage();
        }
    }
    
    // Check final count
    $result = $db->query("SELECT COUNT(*) as count FROM equipment WHERE deleted = 0");
    $final_count = 0;
    if ($result && $row = $db->fetchByAssoc($result)) {
        $final_count = $row['count'];
    }
    
    $response = array(
        'success' => true,
        'message' => "Direct SQL: Successfully created {$created_count} equipment items",
        'created_count' => $created_count,
        'total_attempted' => count($equipment_items),
        'start_count' => $start_count,
        'final_count' => $final_count,
        'count_difference' => $final_count - $start_count,
        'errors' => $errors,
        'sql_statements' => $sql_statements
    );
    
    echo json_encode($response);
    ob_end_flush();
    
} catch (Exception $e) {
    ob_clean();
    echo json_encode(array(
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ));
    ob_end_flush();
} 