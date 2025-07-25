<?php
/**
 * Memory Fix for Quick Repair
 * 
 * This script ensures adequate memory for processing custom modules
 * during Quick Repair and Rebuild operations.
 */

// Increase memory limit for repair operations
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', 300); // 5 minutes

echo "Memory limit increased to: " . ini_get('memory_limit') . "\n";
echo "Max execution time set to: " . ini_get('max_execution_time') . " seconds\n";
echo "Current memory usage: " . memory_get_usage(true) / 1024 / 1024 . " MB\n";
echo "\nYou can now run Quick Repair and Rebuild safely.\n";
echo "Navigate to: Admin → System → Repair → Quick Repair and Rebuild\n"; 