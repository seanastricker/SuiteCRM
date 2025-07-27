<?php
/**
 * Feature 6: Volunteer Hours & Recognition Tracker
 * Entry Point for Volunteer Hours Recognition Dashboard
 * 
 * This file provides direct access to the volunteer hours dashboard
 * for viewing recognition reports and statistics.
 * 
 * URL: index.php?entryPoint=volunteer_hours_dashboard
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Start session and check authentication
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if not authenticated
if (empty($_SESSION['authenticated_user_id'])) {
    header('Location: index.php');
    exit;
}

// Set up the environment
global $current_user, $sugar_config;

require_once('include/MVC/Controller/SugarController.php');
require_once('data/BeanFactory.php');

// Set module and action
$_REQUEST['module'] = 'VolunteerHours';
$_REQUEST['action'] = 'volunteerhoursrecognition';

// Create and execute controller
$controller = new SugarController();
$controller->execute();

?> 