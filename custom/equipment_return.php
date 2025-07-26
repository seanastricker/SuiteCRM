<?php

/**
 * Equipment Return Entry Point
 * 
 * Handles AJAX requests for equipment return operations.
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
    $condition_status = $_POST['condition_status'] ?? '';
    $current_location = $_POST['current_location'] ?? '';
    $return_notes = $_POST['return_notes'] ?? '';
    
    // Validate required fields
    if (empty($equipment_id)) {
        echo json_encode(array('success' => false, 'message' => 'Equipment ID is required'));
        exit();
    }
    
    // Load Equipment helper
    require_once('modules/Equipment/EquipmentHelper.php');
    
    // Prepare return data
    $return_data = array(
        'condition_status' => $condition_status,
        'current_location' => $current_location,
        'return_notes' => $return_notes,
    );
    
    // Process return
    $result = EquipmentHelper::returnEquipment($equipment_id, $return_data);
    
    // Return result
    echo json_encode($result);
    
} catch (Exception $e) {
    error_log("Equipment return error: " . $e->getMessage());
    echo json_encode(array('success' => false, 'message' => 'An error occurred while processing the return'));
}

// End output buffering and flush
ob_end_flush(); 