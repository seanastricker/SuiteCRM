<?php

/**
 * Equipment Maintenance Entry Point
 * 
 * Handles AJAX requests for equipment maintenance operations.
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

try {
    require_once('include/entryPoint.php');
    
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
    $action = $_POST['action'] ?? 'mark_maintenance';
    $maintenance_notes = $_POST['maintenance_notes'] ?? '';
    $return_condition = $_POST['return_condition'] ?? '';
    $return_location = $_POST['return_location'] ?? 'Equipment Storage';
    
    // Validate required fields
    if (empty($equipment_id)) {
        echo json_encode(array('success' => false, 'message' => 'Equipment ID is required'));
        exit();
    }
    
    // Load Equipment helper - with error checking
    if (!file_exists('modules/Equipment/EquipmentHelper.php')) {
        echo json_encode(array('success' => false, 'message' => 'Equipment helper not found'));
        exit();
    }
    
    require_once('modules/Equipment/EquipmentHelper.php');
    
    // Check if helper class exists
    if (!class_exists('EquipmentHelper')) {
        echo json_encode(array('success' => false, 'message' => 'EquipmentHelper class not found'));
        exit();
    }
    
    // Process based on action
    if ($action === 'mark_maintenance') {
        $maintenance_data = array(
            'maintenance_notes' => $maintenance_notes,
        );
        
        // Check if method exists
        if (!method_exists('EquipmentHelper', 'markForMaintenance')) {
            echo json_encode(array('success' => false, 'message' => 'markForMaintenance method not found'));
            exit();
        }
        
        $result = EquipmentHelper::markForMaintenance($equipment_id, $maintenance_data);
        
    } elseif ($action === 'return_from_maintenance') {
        $return_data = array(
            'condition_status' => $return_condition,
            'current_location' => $return_location,
        );
        
        // Check if method exists
        if (!method_exists('EquipmentHelper', 'returnFromMaintenance')) {
            echo json_encode(array('success' => false, 'message' => 'returnFromMaintenance method not found'));
            exit();
        }
        
        $result = EquipmentHelper::returnFromMaintenance($equipment_id, $return_data);
        
    } else {
        echo json_encode(array('success' => false, 'message' => 'Invalid action'));
        exit();
    }
    
    // Return result
    echo json_encode($result);
    
} catch (Exception $e) {
    // Clean output buffer in case of error
    if (ob_get_level()) {
        ob_clean();
    }
    
    error_log("Equipment maintenance error: " . $e->getMessage());
    echo json_encode(array(
        'success' => false, 
        'message' => 'An error occurred while processing the maintenance request',
        'debug' => $e->getMessage()
    ));
} catch (Error $e) {
    // Handle fatal errors
    if (ob_get_level()) {
        ob_clean();
    }
    
    error_log("Equipment maintenance fatal error: " . $e->getMessage());
    echo json_encode(array(
        'success' => false, 
        'message' => 'A fatal error occurred',
        'debug' => $e->getMessage()
    ));
}

// End output buffering and flush
ob_end_flush(); 