<?php

/**
 * Equipment Overdue Notifications Entry Point
 * 
 * Handles automated overdue equipment notifications.
 * Can be run manually or scheduled as a cron job.
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
    
    // Load Equipment helper
    require_once('modules/Equipment/EquipmentHelper.php');
    
    // Send overdue notifications
    $result = EquipmentHelper::sendOverdueNotifications();
    
    // Get additional report data
    $reports = EquipmentHelper::generateReports();
    $usage_stats = EquipmentHelper::getUsageStatistics(30);
    
    // Combine results
    $response = array(
        'success' => $result['success'],
        'message' => $result['message'],
        'timestamp' => date('Y-m-d H:i:s'),
        'overdue_count' => $reports['overdue']['count'],
        'utilization_rate' => $reports['utilization']['utilization_rate'],
        'usage_stats' => $usage_stats,
    );
    
    if (!empty($result['errors'])) {
        $response['errors'] = $result['errors'];
    }
    
    // Return result
    echo json_encode($response);
    
} catch (Exception $e) {
    error_log("Equipment notifications error: " . $e->getMessage());
    echo json_encode(array(
        'success' => false, 
        'message' => 'An error occurred while processing notifications',
        'timestamp' => date('Y-m-d H:i:s')
    ));
}

// End output buffering and flush
ob_end_flush(); 