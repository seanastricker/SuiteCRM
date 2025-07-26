<?php
/**
 * Feature 3: Basic Incident Reporting
 * Entry point for saving incidents - returns pure JSON
 * 
 * Accessible via: index.php?entryPoint=save_incident
 */

// Start output buffering to ensure clean JSON
ob_start();

// Suppress PHP notices/warnings that could break JSON
error_reporting(E_ERROR | E_WARNING | E_PARSE);

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
    require_once('modules/IncidentReporting/IncidentReportingHelper.php');
    
    // Validate required fields
    if (empty($_POST['incident_date']) || empty($_POST['incident_type']) || empty($_POST['severity_level'])) {
        echo json_encode(array('success' => false, 'message' => 'Please fill in all required fields'));
        exit();
    }
    
    // Save the incident
    $incident_id = IncidentReportingHelper::saveIncident($_POST);
    
    // Clean any unwanted output
    ob_clean();
    
    if ($incident_id) {
        echo json_encode(array(
            'success' => true, 
            'message' => 'Incident report saved successfully', 
            'id' => $incident_id
        ));
    } else {
        echo json_encode(array(
            'success' => false, 
            'message' => 'Error saving incident report'
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