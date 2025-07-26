<?php

/**
 * Debug Equipment Data
 * 
 * Check what's in the database vs what the dashboard is showing
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

require_once('include/entryPoint.php');

echo "<h2>Equipment Debug Report</h2>";

try {
    global $db;
    
    // Test 1: Raw database query
    echo "<h3>Test 1: Raw Database Query</h3>";
    $result = $db->query("SELECT COUNT(*) as count FROM equipment WHERE deleted = 0");
    if ($result && $row = $db->fetchByAssoc($result)) {
        echo "Total equipment count (not deleted): " . $row['count'] . "<br>";
    }
    
    $result = $db->query("SELECT id, name, equipment_type, checkout_status, deleted, date_entered FROM equipment ORDER BY date_entered DESC LIMIT 10");
    echo "<strong>Recent equipment records:</strong><br>";
    while ($row = $db->fetchByAssoc($result)) {
        echo "- ID: {$row['id']}<br>";
        echo "&nbsp;&nbsp;Name: {$row['name']}<br>";
        echo "&nbsp;&nbsp;Type: {$row['equipment_type']}<br>";
        echo "&nbsp;&nbsp;Status: {$row['checkout_status']}<br>";
        echo "&nbsp;&nbsp;Deleted: {$row['deleted']}<br>";
        echo "&nbsp;&nbsp;Created: {$row['date_entered']}<br><br>";
    }
    
    // Test 2: EquipmentHelper query
    echo "<h3>Test 2: EquipmentHelper Query</h3>";
    require_once('modules/Equipment/EquipmentHelper.php');
    $equipment_data = EquipmentHelper::getEquipment();
    echo "Equipment from EquipmentHelper: " . count($equipment_data) . " items<br>";
    
    foreach ($equipment_data as $eq) {
        echo "- {$eq['name']} ({$eq['equipment_type']}) - {$eq['checkout_status']}<br>";
    }
    
    // Test 3: BeanFactory query
    echo "<h3>Test 3: BeanFactory Query</h3>";
    $equipment = BeanFactory::getBean('Equipment');
    if ($equipment) {
        $equipment_list = $equipment->get_full_list("", "equipment.deleted = 0");
        echo "Equipment from BeanFactory: " . (is_array($equipment_list) ? count($equipment_list) : 0) . " items<br>";
        
        if (is_array($equipment_list)) {
            foreach ($equipment_list as $eq_bean) {
                echo "- {$eq_bean->name} ({$eq_bean->equipment_type}) - {$eq_bean->checkout_status}<br>";
            }
        }
    } else {
        echo "❌ Could not create Equipment bean<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<br><a href='index.php?module=Equipment&action=equipmentdashboard'>Go to Equipment Dashboard</a>";
echo "<br><a href='index.php?entryPoint=create_equipment_form'>Create Equipment Form</a>"; 