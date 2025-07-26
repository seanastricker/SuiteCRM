<?php

/**
 * Equipment Check-Out Entry Point
 * 
 * Handles AJAX requests for equipment check-out operations.
 * Returns clean JSON responses for client-side processing.
 * 
 * @author SuiteCRM Development Team
 * @package Equipment
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

// Suppress PHP notices and warnings for clean JSON output
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
    
    // Validate request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(array('success' => false, 'message' => 'Invalid request method'));
        exit();
    }
    
    // Get POST data
    $equipment_id = $_POST['equipment_id'] ?? '';
    $checked_out_by = $_POST['checked_out_by'] ?? '';
    $due_date = $_POST['due_date'] ?? '';
    $program_association = $_POST['program_association'] ?? '';
    $current_location = $_POST['current_location'] ?? '';
    $checkout_notes = $_POST['checkout_notes'] ?? '';
    
    // Validate required fields
    if (empty($equipment_id) || empty($checked_out_by) || empty($due_date)) {
        echo json_encode(array('success' => false, 'message' => 'Missing required fields'));
        exit();
    }
    
    // Load Equipment helper
    require_once('modules/Equipment/EquipmentHelper.php');
    
    // Prepare checkout data
    $checkout_data = array(
        'checked_out_by' => $checked_out_by,
        'due_date' => $due_date,
        'program_association' => $program_association,
        'current_location' => $current_location,
        'checkout_notes' => $checkout_notes,
    );
    
    // Process checkout
    $result = EquipmentHelper::checkOutEquipment($equipment_id, $checkout_data);
    
    // Return result
    echo json_encode($result);
    
} catch (Exception $e) {
    error_log("Equipment checkout error: " . $e->getMessage());
    echo json_encode(array('success' => false, 'message' => 'An error occurred while processing the checkout'));
}

// End output buffering and flush
ob_end_flush(); 