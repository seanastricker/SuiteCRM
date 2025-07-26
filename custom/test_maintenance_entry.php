<?php

/**
 * Test Equipment Maintenance Entry Point
 * 
 * Tests if the equipment_maintenance entry point is properly registered and working
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

require_once('include/entryPoint.php');

echo "<h2>Testing Equipment Maintenance Entry Point</h2>";

try {
    // Check if entry point is registered
    global $entry_point_registry;
    
    echo "<h3>1. Entry Point Registration Check</h3>";
    if (isset($entry_point_registry['equipment_maintenance'])) {
        echo "✅ equipment_maintenance entry point is registered<br>";
        echo "File: " . $entry_point_registry['equipment_maintenance']['file'] . "<br>";
        echo "Auth required: " . ($entry_point_registry['equipment_maintenance']['auth'] ? 'Yes' : 'No') . "<br>";
    } else {
        echo "❌ equipment_maintenance entry point is NOT registered<br>";
    }
    
    // Check if the file exists
    echo "<h3>2. File Existence Check</h3>";
    $maintenance_file = 'custom/equipment_maintenance.php';
    if (file_exists($maintenance_file)) {
        echo "✅ File exists: $maintenance_file<br>";
        echo "File size: " . filesize($maintenance_file) . " bytes<br>";
        echo "File permissions: " . substr(sprintf('%o', fileperms($maintenance_file)), -4) . "<br>";
    } else {
        echo "❌ File does not exist: $maintenance_file<br>";
    }
    
    // Check if we can include the file
    echo "<h3>3. File Syntax Check</h3>";
    ob_start();
    $include_result = include_once($maintenance_file);
    $output = ob_get_clean();
    
    if ($include_result !== false) {
        echo "✅ File includes without syntax errors<br>";
        if (!empty($output)) {
            echo "⚠️ File produced output (this could cause JSON issues):<br>";
            echo "<pre>" . htmlspecialchars($output) . "</pre>";
        }
    } else {
        echo "❌ File has syntax errors or failed to include<br>";
    }
    
    // Test a simple POST request simulation
    echo "<h3>4. Simulated POST Request Test</h3>";
    
    // Simulate POST data
    $_POST['equipment_id'] = 'test-id';
    $_POST['action'] = 'mark_maintenance';
    $_SERVER['REQUEST_METHOD'] = 'POST';
    
    echo "Testing with equipment_id: test-id<br>";
    echo "Expected result: Should return JSON error about equipment not found<br>";
    
    // Try to capture the output from the maintenance script
    ob_start();
    
    // Simulate the entry point call
    try {
        include($maintenance_file);
        $json_output = ob_get_clean();
        
        echo "Raw output:<br>";
        echo "<pre>" . htmlspecialchars($json_output) . "</pre>";
        
        // Try to decode as JSON
        $decoded = json_decode($json_output, true);
        if ($decoded !== null) {
            echo "✅ Valid JSON response<br>";
            echo "Response: " . print_r($decoded, true) . "<br>";
        } else {
            echo "❌ Invalid JSON response<br>";
            echo "JSON error: " . json_last_error_msg() . "<br>";
        }
        
    } catch (Exception $e) {
        ob_end_clean();
        echo "❌ Exception during execution: " . $e->getMessage() . "<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Test failed: " . $e->getMessage() . "<br>";
}

echo "<br><a href='index.php?module=Equipment&action=equipmentdashboard'>Back to Equipment Dashboard</a>"; 