#!/usr/bin/env php
<?php

/**
 * Equipment Overdue Notifications Cron Script
 * 
 * Automated script for sending overdue equipment notifications.
 * Can be run as a daily cron job to send automatic reminders.
 * 
 * Usage:
 * - Via cron: 0 9 * * * /usr/bin/php /path/to/suitecrm/custom/cron_equipment_notifications.php
 * - Via command line: php custom/cron_equipment_notifications.php
 * - Via URL: http://yoursite.com/suitecrm/index.php?entryPoint=equipment_notifications
 * 
 * @author SuiteCRM Development Team
 * @package Equipment
 */

// Set up environment for command line execution
if (php_sapi_name() === 'cli') {
    // Command line execution
    $script_dir = dirname(__FILE__);
    $suitecrm_root = dirname($script_dir);
    
    // Change to SuiteCRM directory
    chdir($suitecrm_root);
    
    // Define entry point
    if (!defined('sugarEntry')) {
        define('sugarEntry', true);
    }
    
    // Include SuiteCRM
    require_once('include/entryPoint.php');
} else {
    // Web execution - redirect to proper entry point
    header('Location: index.php?entryPoint=equipment_notifications');
    exit();
}

// Log start of cron job
error_log("Equipment Overdue Notifications Cron Job Started: " . date('Y-m-d H:i:s'));

try {
    // Load Equipment helper
    require_once('modules/Equipment/EquipmentHelper.php');
    
    // Get current overdue equipment count
    $overdue_equipment = EquipmentHelper::getOverdueEquipment();
    $overdue_count = count($overdue_equipment);
    
    echo "Equipment Overdue Notifications Cron Job\n";
    echo "=========================================\n";
    echo "Start Time: " . date('Y-m-d H:i:s') . "\n";
    echo "Checking for overdue equipment...\n";
    echo "Found {$overdue_count} overdue items\n\n";
    
    if ($overdue_count > 0) {
        // Send notifications
        $result = EquipmentHelper::sendOverdueNotifications();
        
        if ($result['success']) {
            echo "✓ " . $result['message'] . "\n";
            
            // Log individual overdue items
            echo "\nOverdue Equipment Details:\n";
            echo "--------------------------\n";
            foreach ($overdue_equipment as $equipment) {
                $days_overdue = floor((time() - strtotime($equipment['due_date'])) / (60 * 60 * 24));
                echo "- {$equipment['name']} ({$equipment['equipment_type']})\n";
                echo "  Checked out by: {$equipment['checked_out_by']}\n";
                echo "  Due date: {$equipment['due_date']} ({$days_overdue} days overdue)\n";
                if (!empty($equipment['program_association'])) {
                    echo "  Program: {$equipment['program_association']}\n";
                }
                echo "\n";
            }
            
            if (!empty($result['errors'])) {
                echo "\nWarnings/Errors:\n";
                echo "----------------\n";
                foreach ($result['errors'] as $error) {
                    echo "⚠ " . $error . "\n";
                }
            }
        } else {
            echo "✗ Error: " . $result['message'] . "\n";
        }
    } else {
        echo "✓ No overdue equipment found - no notifications needed\n";
    }
    
    // Generate summary statistics
    $summary = EquipmentHelper::getEquipmentSummary();
    $usage_stats = EquipmentHelper::getUsageStatistics(7); // Last 7 days
    
    echo "\nEquipment Summary:\n";
    echo "------------------\n";
    echo "Total Equipment: {$summary['total_equipment']}\n";
    echo "Available: {$summary['available']}\n";
    echo "Checked Out: {$summary['checked_out']}\n";
    echo "In Maintenance: {$summary['maintenance']}\n";
    echo "Overdue: {$summary['overdue']}\n";
    
    echo "\nRecent Activity (7 days):\n";
    echo "-------------------------\n";
    echo "Checkouts: {$usage_stats['total_checkouts']}\n";
    echo "Returns: {$usage_stats['total_returns']}\n";
    
    echo "\nCron Job Completed Successfully\n";
    echo "End Time: " . date('Y-m-d H:i:s') . "\n";
    
    // Log successful completion
    error_log("Equipment Overdue Notifications Cron Job Completed: {$overdue_count} overdue items processed");
    
} catch (Exception $e) {
    $error_message = "Equipment Notifications Cron Job Error: " . $e->getMessage();
    echo "✗ " . $error_message . "\n";
    error_log($error_message);
    
    // Exit with error code for cron monitoring
    exit(1);
}

// Exit successfully
exit(0); 