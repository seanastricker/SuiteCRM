<?php

/**
 * Equipment Reports Entry Point
 * 
 * Handles AJAX requests for equipment reports and statistics.
 * Returns comprehensive equipment analytics data.
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
    
    // Get report type from request
    $report_type = $_GET['type'] ?? 'all';
    $period_days = (int)($_GET['period'] ?? 30);
    $format = $_GET['format'] ?? 'json';
    
    // Load Equipment helper
    require_once('modules/Equipment/EquipmentHelper.php');
    
    // Handle CSV export format
    if ($format === 'csv' && $report_type === 'all') {
        // Set CSV headers
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="equipment_data_' . date('Y-m-d') . '.csv"');
        header('Cache-Control: no-cache, must-revalidate');
        
        // Clean output buffer
        ob_clean();
        
        // Get equipment data
        $equipment = EquipmentHelper::getEquipment();
        $dropdown_options = EquipmentHelper::getDropdownOptions();
        
        // Open output stream
        $output = fopen('php://output', 'w');
        
        // Add BOM for UTF-8
        fwrite($output, "\xEF\xBB\xBF");
        
        // CSV Headers
        fputcsv($output, array(
            'Equipment Name',
            'Type',
            'Status', 
            'Condition',
            'Current Location',
            'Brand',
            'Model',
            'Serial Number',
            'Purchase Date',
            'Purchase Price',
            'Checked Out By',
            'Due Date',
            'Program Association',
            'Description',
            'Date Added'
        ));
        
        // CSV Data
        foreach ($equipment as $item) {
            fputcsv($output, array(
                $item['name'],
                $dropdown_options['equipment_types'][$item['equipment_type']] ?? $item['equipment_type'],
                $dropdown_options['equipment_statuses'][$item['checkout_status']] ?? $item['checkout_status'],
                $dropdown_options['equipment_conditions'][$item['condition_status']] ?? $item['condition_status'],
                $item['current_location'] ?: '',
                $item['brand'] ?: '',
                $item['model'] ?: '',
                $item['serial_number'] ?: '',
                $item['purchase_date'] ?: '',
                $item['purchase_price'] ?: '',
                $item['checked_out_by'] ?: '',
                $item['due_date'] ?: '',
                $item['program_association'] ?: '',
                $item['description'] ?: '',
                $item['date_entered'] ?: ''
            ));
        }
        
        fclose($output);
        exit();
    }
    
    $response = array(
        'success' => true,
        'timestamp' => date('Y-m-d H:i:s'),
        'period_days' => $period_days,
    );
    
    switch ($report_type) {
        case 'summary':
            $response['data'] = EquipmentHelper::getEquipmentSummary();
            break;
            
        case 'overdue':
            $response['data'] = EquipmentHelper::getOverdueEquipment();
            break;
            
        case 'usage':
            $response['data'] = EquipmentHelper::getUsageStatistics($period_days);
            break;
            
        case 'reports':
            $response['data'] = EquipmentHelper::generateReports();
            break;
            
        case 'history':
            $equipment_id = $_GET['equipment_id'] ?? '';
            if (empty($equipment_id)) {
                throw new Exception('Equipment ID required for history report');
            }
            $response['data'] = EquipmentHelper::getEquipmentHistory($equipment_id);
            break;
            
        case 'all':
        default:
            $response['data'] = array(
                'summary' => EquipmentHelper::getEquipmentSummary(),
                'reports' => EquipmentHelper::generateReports(),
                'usage_stats' => EquipmentHelper::getUsageStatistics($period_days),
                'overdue_equipment' => EquipmentHelper::getOverdueEquipment(),
            );
            break;
    }
    
    // Return result
    echo json_encode($response);
    
} catch (Exception $e) {
    error_log("Equipment reports error: " . $e->getMessage());
    echo json_encode(array(
        'success' => false, 
        'message' => 'An error occurred while generating reports: ' . $e->getMessage(),
        'timestamp' => date('Y-m-d H:i:s')
    ));
}

// End output buffering and flush
ob_end_flush(); 