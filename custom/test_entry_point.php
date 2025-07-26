<?php

/**
 * Quick Entry Point Test
 * 
 * Simple test to verify entry points are working.
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

require_once('include/entryPoint.php');

echo "<h2>Entry Point Test</h2>\n";

global $entry_point_registry;

echo "<strong>Entry Point Registry Status:</strong><br>\n";
if (isset($entry_point_registry)) {
    echo "✅ Entry point registry is loaded<br>\n";
    echo "Registry type: " . gettype($entry_point_registry) . "<br>\n";
    echo "Registry count: " . count($entry_point_registry) . "<br>\n";
    
    if (isset($entry_point_registry['add_sample_equipment'])) {
        echo "✅ add_sample_equipment is registered<br>\n";
        echo "File: " . $entry_point_registry['add_sample_equipment']['file'] . "<br>\n";
        
        // Check if file exists
        if (file_exists($entry_point_registry['add_sample_equipment']['file'])) {
            echo "✅ Entry point file exists<br>\n";
        } else {
            echo "❌ Entry point file NOT found<br>\n";
        }
    } else {
        echo "❌ add_sample_equipment NOT found in registry<br>\n";
        echo "Available entry points: " . implode(', ', array_keys($entry_point_registry)) . "<br>\n";
    }
} else {
    echo "❌ Entry point registry is NOT loaded<br>\n";
}

echo "<br><a href='index.php?entryPoint=add_sample_equipment'>Test Add Sample Equipment</a><br>\n";
echo "<a href='index.php?module=Equipment'>Go to Equipment Dashboard</a><br>\n"; 