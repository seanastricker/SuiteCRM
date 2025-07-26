<?php
if (!defined('sugarEntry')) define('sugarEntry', true);
require_once('include/entryPoint.php');

error_reporting(0);
ini_set('display_errors', 0);
ob_start();
ob_clean();
header('Content-Type: application/json');

try {
    global $db;
    
    // Ensure table exists first
    require_once('modules/Equipment/EquipmentHelper.php');
    EquipmentHelper::createEquipmentTable();
    
    // Check current count
    $result = $db->query("SELECT COUNT(*) as count FROM equipment WHERE deleted = 0");
    $start_count = $result ? $db->fetchByAssoc($result)['count'] : 0;
    
    // Insert just ONE item with minimal fields to test
    $id = create_guid();
    $sql = "INSERT INTO equipment (id, name, deleted) VALUES ('$id', 'Test Equipment', 0)";
    
    $insert_result = $db->query($sql);
    $success = $insert_result ? true : false;
    $error = $success ? '' : $db->lastError();
    
    // Check final count  
    $result = $db->query("SELECT COUNT(*) as count FROM equipment WHERE deleted = 0");
    $final_count = $result ? $db->fetchByAssoc($result)['count'] : 0;
    
    echo json_encode(array(
        'success' => $success,
        'start_count' => $start_count,
        'final_count' => $final_count,
        'sql' => $sql,
        'error' => $error,
        'db_error' => $db->lastError(),
        'message' => $success ? 'Minimal insert worked!' : 'Insert failed: ' . $error
    ));
    
} catch (Exception $e) {
    echo json_encode(array(
        'success' => false,
        'error' => $e->getMessage()
    ));
}
ob_end_flush(); 