<?php

/**
 * Force Equipment Save
 * 
 * Bulletproof save that bypasses SuiteCRM's database layer
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

require_once('include/entryPoint.php');

header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 0);
ob_start();
ob_clean();

try {
    global $sugar_config;
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Only POST requests allowed');
    }
    
    // Get database config directly from SuiteCRM
    $db_host = $sugar_config['dbconfig']['db_host_name'];
    $db_name = $sugar_config['dbconfig']['db_name'];
    $db_user = $sugar_config['dbconfig']['db_user_name'];
    $db_pass = $sugar_config['dbconfig']['db_password'];
    
    // Create direct MySQL connection
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
    
    if ($mysqli->connect_error) {
        throw new Exception('Database connection failed: ' . $mysqli->connect_error);
    }
    
    // Set autocommit to true to ensure immediate saves
    $mysqli->autocommit(true);
    
    // Generate equipment data
    $id = create_guid();
    $name = $_POST['name'] ?? 'Equipment ' . date('H:i:s');
    $equipment_type = $_POST['equipment_type'] ?? 'general';
    $checkout_status = $_POST['checkout_status'] ?? 'available';
    $condition_status = $_POST['condition_status'] ?? 'good';
    $current_location = $_POST['current_location'] ?? 'Storage';
    $brand = $_POST['brand'] ?? '';
    $model = $_POST['model'] ?? '';
    $serial_number = $_POST['serial_number'] ?? '';
    $purchase_date = $_POST['purchase_date'] ?? null;
    $purchase_price = $_POST['purchase_price'] ?? null;
    $checked_out_by = $_POST['checked_out_by'] ?? '';
    $checkout_date = $_POST['checkout_date'] ?? null;
    $due_date = $_POST['due_date'] ?? null;
    $description = $_POST['description'] ?? '';
    $checkout_notes = $_POST['checkout_notes'] ?? '';
    $program_association = $_POST['program_association'] ?? '';
    
    $date_entered = date('Y-m-d H:i:s');
    $date_modified = date('Y-m-d H:i:s');
    
    // Get current user ID if available
    global $current_user;
    $created_by = (!empty($current_user) && !empty($current_user->id)) ? $current_user->id : '1';
    
    // Prepare statement to prevent SQL injection
    $stmt = $mysqli->prepare("
        INSERT INTO equipment (
            id, name, equipment_type, checkout_status, condition_status,
            current_location, brand, model, serial_number, purchase_date,
            purchase_price, checked_out_by, checkout_date, due_date,
            description, checkout_notes, program_association,
            date_entered, date_modified, created_by, modified_user_id, deleted
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0
        )
    ");
    
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $mysqli->error);
    }
    
    $stmt->bind_param(
        'sssssssssdsssssssssss',
        $id, $name, $equipment_type, $checkout_status, $condition_status,
        $current_location, $brand, $model, $serial_number, $purchase_date,
        $purchase_price, $checked_out_by, $checkout_date, $due_date,
        $description, $checkout_notes, $program_association,
        $date_entered, $date_modified, $created_by, $created_by
    );
    
    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }
    
    $affected_rows = $stmt->affected_rows;
    $stmt->close();
    
    // Verify the record was saved
    $verify_stmt = $mysqli->prepare("SELECT COUNT(*) as count FROM equipment WHERE id = ? AND deleted = 0");
    $verify_stmt->bind_param('s', $id);
    $verify_stmt->execute();
    $result = $verify_stmt->get_result();
    $verify_row = $result->fetch_assoc();
    $verified = $verify_row['count'] > 0;
    $verify_stmt->close();
    
    // Get total count
    $count_result = $mysqli->query("SELECT COUNT(*) as count FROM equipment WHERE deleted = 0");
    $count_row = $count_result->fetch_assoc();
    $total_count = $count_row['count'];
    
    $mysqli->close();
    
    echo json_encode(array(
        'success' => true,
        'message' => 'Equipment created successfully using direct database connection',
        'equipment_id' => $id,
        'equipment_name' => $name,
        'affected_rows' => $affected_rows,
        'verified_in_db' => $verified,
        'total_equipment_count' => $total_count,
        'method' => 'Direct MySQL with prepared statements'
    ));
    
} catch (Exception $e) {
    echo json_encode(array(
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
        'method' => 'Direct MySQL connection'
    ));
}

ob_end_flush(); 