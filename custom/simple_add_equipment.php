<?php

/**
 * Simple Equipment Sample Data Creator
 * 
 * A simplified script to create sample equipment items.
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

require_once('include/entryPoint.php');

// Suppress all output and start clean buffer
ob_start();
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');

try {
    // Clean any previous output
    ob_clean();
    
    global $db, $current_user;
    
    // Ensure table exists
    require_once('modules/Equipment/EquipmentHelper.php');
    EquipmentHelper::createEquipmentTable();
    
    // Simple sample equipment
    $equipment_items = array(
        array('name' => 'Soccer Goals', 'equipment_type' => 'soccer', 'checkout_status' => 'available'),
        array('name' => 'Football Cones', 'equipment_type' => 'football', 'checkout_status' => 'available'),
        array('name' => 'Basketball', 'equipment_type' => 'basketball', 'checkout_status' => 'checked_out'),
        array('name' => 'Tennis Rackets', 'equipment_type' => 'tennis', 'checkout_status' => 'available'),
        array('name' => 'Baseball Helmets', 'equipment_type' => 'baseball', 'checkout_status' => 'checked_out'),
    );
    
    $created_count = 0;
    $errors = array();
    
    foreach ($equipment_items as $item_data) {
        try {
            $equipment = BeanFactory::getBean('Equipment');
            if (!$equipment) {
                throw new Exception('Could not create Equipment bean');
            }
            
            $equipment->name = $item_data['name'];
            $equipment->equipment_type = $item_data['equipment_type'];
            $equipment->checkout_status = $item_data['checkout_status'];
            $equipment->condition_status = 'good';
            $equipment->current_location = 'Storage Room';
            $equipment->purchase_date = '2024-01-01';
            
            $equipment->id = create_guid();
            $equipment->date_entered = date('Y-m-d H:i:s');
            $equipment->date_modified = date('Y-m-d H:i:s');
            $equipment->deleted = 0;
            
            if (!empty($current_user)) {
                $equipment->created_by = $current_user->id;
                $equipment->modified_user_id = $current_user->id;
            }
            
            $equipment->save();
            $created_count++;
            
        } catch (Exception $e) {
            $errors[] = "Error creating {$item_data['name']}: " . $e->getMessage();
        }
    }
    
    $response = array(
        'success' => true,
        'message' => "Successfully created {$created_count} equipment items",
        'created_count' => $created_count,
        'total_attempted' => count($equipment_items),
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