<?php

/**
 * Check Recent Equipment Records
 * 
 * Shows the exact field values of recently created equipment
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

require_once('include/entryPoint.php');

echo "<h2>Recent Equipment Records Check</h2>";

try {
    global $db;
    
    // Get all equipment ordered by creation time
    $result = $db->query("
        SELECT id, name, equipment_type, checkout_status, condition_status, 
               current_location, brand, model, deleted, date_entered, 
               created_by, modified_user_id
        FROM equipment 
        ORDER BY date_entered DESC 
        LIMIT 10
    ");
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background-color: #f0f0f0;'>";
    echo "<th>Created</th><th>Name</th><th>Type</th><th>Status</th><th>Condition</th><th>Location</th><th>Brand</th><th>Deleted</th><th>Created By</th>";
    echo "</tr>";
    
    $count = 0;
    while ($row = $db->fetchByAssoc($result)) {
        $count++;
        $bg_color = $count <= 2 ? '#ffffcc' : '#ffffff'; // Highlight recent ones
        
        echo "<tr style='background-color: $bg_color;'>";
        echo "<td>" . ($row['date_entered'] ?? 'NULL') . "</td>";
        echo "<td>" . ($row['name'] ?? 'NULL') . "</td>";
        echo "<td>" . ($row['equipment_type'] ?? 'NULL') . "</td>";
        echo "<td>" . ($row['checkout_status'] ?? 'NULL') . "</td>";
        echo "<td>" . ($row['condition_status'] ?? 'NULL') . "</td>";
        echo "<td>" . ($row['current_location'] ?? 'NULL') . "</td>";
        echo "<td>" . ($row['brand'] ?? 'NULL') . "</td>";
        echo "<td>" . ($row['deleted'] ?? 'NULL') . "</td>";
        echo "<td>" . ($row['created_by'] ?? 'NULL') . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    if ($count == 0) {
        echo "<p>No equipment records found.</p>";
    } else {
        echo "<p><strong>Total records:</strong> $count</p>";
        echo "<p><em>Recent items (highlighted in yellow) should be from your form submissions.</em></p>";
    }
    
    // Test if we can see any NULL or empty required fields
    echo "<h3>Field Validation Check</h3>";
    $result = $db->query("
        SELECT COUNT(*) as count 
        FROM equipment 
        WHERE (name IS NULL OR name = '') 
           OR (equipment_type IS NULL OR equipment_type = '')
           OR (checkout_status IS NULL OR checkout_status = '')
    ");
    
    if ($result && $row = $db->fetchByAssoc($result)) {
        echo "Equipment with missing required fields: " . $row['count'] . "<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<br><a href='index.php?entryPoint=create_equipment_form'>Create Equipment Form</a>";
echo "<br><a href='index.php?module=Equipment&action=equipmentdashboard'>Equipment Dashboard</a>"; 