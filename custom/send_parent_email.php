<?php
/**
 * Feature 4: Basic Parent Notification System
 * Entry point for sending parent emails - returns pure JSON
 * 
 * Accessible via: index.php?entryPoint=send_parent_email
 */

// Start output buffering to ensure clean JSON
ob_start();

// Suppress PHP notices/warnings that could break JSON (including mail warnings)
error_reporting(E_ERROR);
ini_set('display_errors', 0);

// Set JSON header immediately before any output
header('Content-Type: application/json');

// Prevent any caching
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

// SuiteCRM initialization
if (!defined('sugarEntry')) define('sugarEntry', true);

// Only handle POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(array('success' => false, 'message' => 'Only POST requests allowed'));
    exit();
}

try {
    // Initialize SuiteCRM minimally
    require_once('include/MVC/SugarApplication.php');
    require_once('include/database/DBManagerFactory.php');
    
    // Initialize database connection
    global $db;
    $db = DBManagerFactory::getInstance();
    
    // Get current user info (session already started by SuiteCRM)
    global $current_user;
    if (empty($current_user)) {
        require_once('modules/Users/User.php');
        $current_user = new User();
        if (isset($_SESSION['authenticated_user_id'])) {
            $current_user->retrieve($_SESSION['authenticated_user_id']);
        }
    }
    
    // Load helper class
    require_once('modules/ParentCommunication/ParentCommunicationHelper.php');
    
    // Validate required fields
    if (empty($_POST['parent_ids']) || empty($_POST['subject']) || empty($_POST['message'])) {
        echo json_encode(array('success' => false, 'message' => 'Please fill in all required fields'));
        exit();
    }
    
    // Get parent IDs (can be array or comma-separated string)
    $parent_ids = $_POST['parent_ids'];
    if (is_string($parent_ids)) {
        $parent_ids = explode(',', $parent_ids);
    }
    
    // Clean parent IDs
    $parent_ids = array_filter(array_map('trim', $parent_ids));
    
    if (empty($parent_ids)) {
        echo json_encode(array('success' => false, 'message' => 'No valid parent IDs provided'));
        exit();
    }
    
    // Send the broadcast email
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $template_used = $_POST['template_used'] ?? '';
    
    // Clean any unwanted output and suppress any remaining output
    ob_clean();
    ob_start();
    
    $result = ParentCommunicationHelper::sendBroadcastEmail($parent_ids, $subject, $message, $template_used);
    
    // Clean any output generated during email sending
    ob_clean();
    
    if ($result['success']) {
        echo json_encode(array(
            'success' => true,
            'message' => $result['message'],
            'sent_count' => $result['sent_count'],
            'failed_count' => $result['failed_count'],
            'errors' => $result['errors']
        ));
    } else {
        echo json_encode(array(
            'success' => false,
            'message' => $result['message']
        ));
    }
    
} catch (Exception $e) {
    // Clean any unwanted output
    ob_clean();
    echo json_encode(array(
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ));
}

// Flush output and exit
ob_end_flush();
exit(); 