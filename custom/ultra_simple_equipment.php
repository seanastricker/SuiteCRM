<?php

/**
 * Ultra Simple Equipment Creator
 * 
 * Creates equipment with only essential fields to avoid any undefined property issues.
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
    
    // Ultra simple equipment data - only required/core fields
    $equipment_items = array(
        array('name' => 'Soccer Goals', 'equipment_type' => 'soccer'),
        array('name' => 'Football Cones', 'equipment_type' => 'football'),
        array('name' => 'Basketball', 'equipment_type' => 'basketball'),
    );
    
    $created_count = 0;
    $errors = array();
    
    foreach ($equipment_items as $item_data) {
        try {
            $equipment = BeanFactory::getBean('Equipment');
            if (!$equipment) {
                throw new Exception('Could not create Equipment bean');
            }
            
            // Set only essential fields
            $equipment->name = $item_data['name'];
            $equipment->equipment_type = $item_data['equipment_type'];
            $equipment->checkout_status = 'available';
            $equipment->condition_status = 'good';
            
            // Standard SugarBean fields
            $equipment->id = create_guid();
            $equipment->date_entered = date('Y-m-d H:i:s');
            $equipment->date_modified = date('Y-m-d H:i:s');
            $equipment->deleted = 0;
            
            if (!empty($current_user) && !empty($current_user->id)) {
                $equipment->created_by = $current_user->id;
                $equipment->modified_user_id = $current_user->id;
            }
            
            $equipment->save();
            $created_count++;
            
        } catch (Exception $e) {
            $errors[] = "Error creating {$item_data['name']}: " . $e->getMessage();
        }
    }
    
    // Verify items were actually created
    $verify_count = 0;
    if ($db) {
        $result = $db->query("SELECT COUNT(*) as count FROM equipment WHERE deleted = 0");
        if ($result && $row = $db->fetchByAssoc($result)) {
            $verify_count = $row['count'];
        }
    }
    
    $response = array(
        'success' => true,
        'message' => "Successfully created {$created_count} equipment items",
        'created_count' => $created_count,
        'total_attempted' => count($equipment_items),
        'verify_count' => $verify_count,
        'errors' => $errors
    );
    
    echo json_encode($response);
    ob_end_flush();
    
} catch (Exception $e) {
    ob_clean();
    echo json_encode(array(
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ));
    ob_end_flush();
} 