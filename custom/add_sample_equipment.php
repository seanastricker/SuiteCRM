<?php

/**
 * Add Sample Equipment Entry Point
 * 
 * Quickly adds sample equipment items for testing the Equipment Check-Out Tracker.
 * This is a utility script for demonstration and testing purposes.
 * 
 * @author SuiteCRM Development Team
 * @package Equipment
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

// Suppress PHP notices and warnings for clean output
error_reporting(E_ERROR);
ini_set('display_errors', 0);

// Start output buffering to ensure clean JSON
ob_start();

// Set JSON header
header('Content-Type: application/json');

require_once('include/entryPoint.php');

try {
    // Clean any unwanted output
    ob_clean();
    
    global $db, $current_user;
    
    // Load Equipment helper to ensure table exists
    require_once('modules/Equipment/EquipmentHelper.php');
    EquipmentHelper::createEquipmentTable();
    
    // Sample equipment data
    $sample_equipment = array(
        array(
            'name' => 'Soccer Goals (Portable)',
            'equipment_type' => 'soccer',
            'brand' => 'Kwik Goal',
            'model' => 'Academy 6x18',
            'serial_number' => 'KG-2024-001',
            'condition_status' => 'good',
            'checkout_status' => 'available',
            'current_location' => 'Equipment Storage',
            'purchase_date' => '2024-01-15',
            'purchase_price' => 299.99,
            'program_association' => 'Soccer U8',
        ),
        array(
            'name' => 'Football Practice Cones (Set of 20)',
            'equipment_type' => 'football',
            'brand' => 'Champion Sports',
            'model' => 'Hi-Vis Orange',
            'serial_number' => 'CS-CONE-2024-002',
            'condition_status' => 'excellent',
            'checkout_status' => 'available',
            'current_location' => 'Equipment Storage',
            'purchase_date' => '2024-02-10',
            'purchase_price' => 45.99,
            'program_association' => 'Football U7',
        ),
        array(
            'name' => 'Basketball (Official Size)',
            'equipment_type' => 'basketball',
            'brand' => 'Spalding',
            'model' => 'NBA Official',
            'serial_number' => 'SP-NBA-2024-003',
            'condition_status' => 'good',
            'checkout_status' => 'checked_out',
            'current_location' => 'Gym A',
            'purchase_date' => '2024-03-05',
            'purchase_price' => 89.99,
            'program_association' => 'Basketball U12',
            'checkout_date' => date('Y-m-d H:i:s', strtotime('-5 days')),
            'due_date' => date('Y-m-d', strtotime('+2 days')),
            'checked_out_by' => 'Coach Miller',
            'checkout_notes' => 'For weekend tournament practice',
        ),
        array(
            'name' => 'Tennis Rackets (Junior Set)',
            'equipment_type' => 'tennis',
            'brand' => 'Wilson',
            'model' => 'Youth Starter Set',
            'serial_number' => 'WS-YTH-2024-004',
            'condition_status' => 'fair',
            'checkout_status' => 'available',
            'current_location' => 'Equipment Storage',
            'purchase_date' => '2023-12-20',
            'purchase_price' => 159.99,
            'program_association' => 'Tennis U10',
        ),
        array(
            'name' => 'Baseball Batting Helmets (6 pack)',
            'equipment_type' => 'baseball',
            'brand' => 'Rawlings',
            'model' => 'Youth Safety Pack',
            'serial_number' => 'RW-YSP-2024-005',
            'condition_status' => 'good',
            'checkout_status' => 'checked_out',
            'current_location' => 'Field 2',
            'purchase_date' => '2024-03-20',
            'purchase_price' => 234.99,
            'program_association' => 'Baseball U9',
            'checkout_date' => date('Y-m-d H:i:s', strtotime('-10 days')),
            'due_date' => date('Y-m-d', strtotime('-3 days')), // This will be overdue
            'checked_out_by' => 'Coach Rodriguez',
            'checkout_notes' => 'For league championship games',
        ),
        array(
            'name' => 'Volleyball Net and Posts',
            'equipment_type' => 'volleyball',
            'brand' => 'Mikasa',
            'model' => 'Tournament Pro',
            'serial_number' => 'MK-TP-2024-006',
            'condition_status' => 'excellent',
            'checkout_status' => 'available',
            'current_location' => 'Equipment Storage',
            'purchase_date' => '2024-04-01',
            'purchase_price' => 399.99,
            'program_association' => 'Volleyball U11',
        ),
        array(
            'name' => 'First Aid Kit (Portable)',
            'equipment_type' => 'safety',
            'brand' => 'Johnson & Johnson',
            'model' => 'Sports Team Kit',
            'serial_number' => 'JJ-STK-2024-007',
            'condition_status' => 'good',
            'checkout_status' => 'maintenance',
            'current_location' => 'Medical Office',
            'purchase_date' => '2024-01-30',
            'purchase_price' => 79.99,
            'program_association' => 'General',
        ),
        array(
            'name' => 'Equipment Cart (Mobile)',
            'equipment_type' => 'general',
            'brand' => 'Rubbermaid',
            'model' => 'Heavy Duty Cart',
            'serial_number' => 'RM-HDC-2024-008',
            'condition_status' => 'excellent',
            'checkout_status' => 'checked_out',
            'current_location' => 'Soccer Field A',
            'purchase_date' => '2024-02-28',
            'purchase_price' => 189.99,
            'program_association' => 'General',
            'checkout_date' => date('Y-m-d H:i:s', strtotime('-15 days')),
            'due_date' => date('Y-m-d', strtotime('-8 days')), // This will be overdue
            'checked_out_by' => 'Equipment Manager',
            'checkout_notes' => 'For field setup and teardown',
        ),
    );
    
    $created_count = 0;
    $errors = array();
    
    foreach ($sample_equipment as $equipment_data) {
        try {
            // Create new equipment bean
            $equipment = BeanFactory::getBean('Equipment');
            if (!$equipment) {
                throw new Exception('Could not create Equipment bean');
            }
            
            // Set equipment properties
            foreach ($equipment_data as $field => $value) {
                $equipment->$field = $value;
            }
            
            // Set standard fields
            $equipment->id = create_guid();
            $equipment->date_entered = date('Y-m-d H:i:s');
            $equipment->date_modified = date('Y-m-d H:i:s');
            $equipment->created_by = !empty($current_user) ? $current_user->id : '';
            $equipment->modified_user_id = !empty($current_user) ? $current_user->id : '';
            $equipment->deleted = 0;
            
            // Save the equipment
            $equipment->save();
            $created_count++;
            
        } catch (Exception $e) {
            $errors[] = "Error creating {$equipment_data['name']}: " . $e->getMessage();
            error_log("Error creating sample equipment {$equipment_data['name']}: " . $e->getMessage());
        }
    }
    
    // Return results
    $response = array(
        'success' => true,
        'message' => "Successfully created {$created_count} sample equipment items",
        'created_count' => $created_count,
        'total_attempted' => count($sample_equipment),
        'errors' => $errors,
        'timestamp' => date('Y-m-d H:i:s'),
    );
    
    echo json_encode($response);
    
} catch (Exception $e) {
    error_log("Add sample equipment error: " . $e->getMessage());
    echo json_encode(array(
        'success' => false, 
        'message' => 'An error occurred while creating sample equipment: ' . $e->getMessage(),
        'timestamp' => date('Y-m-d H:i:s')
    ));
}

// End output buffering and flush
ob_end_flush(); 