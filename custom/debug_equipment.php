<?php

/**
 * Equipment Module Debug Script
 * 
 * Simple debugging script to test Equipment module functionality.
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

require_once('include/entryPoint.php');

echo "<h2>Equipment Module Debug</h2>\n";

try {
    global $db;
    
    // Test 1: Check if Equipment module is registered
    echo "<h3>Test 1: Module Registration</h3>\n";
    if (class_exists('Equipment')) {
        echo "✅ Equipment class exists<br>\n";
    } else {
        echo "❌ Equipment class NOT found<br>\n";
    }
    
    // Test 2: Check database table
    echo "<h3>Test 2: Database Table</h3>\n";
    $tables = $db->getTablesArray();
    if (in_array('equipment', $tables)) {
        echo "✅ Equipment table exists<br>\n";
        
        // Check table structure
        $result = $db->query("DESCRIBE equipment");
        echo "<strong>Table structure:</strong><br>\n";
        while ($row = $db->fetchByAssoc($result)) {
            echo "- {$row['Field']} ({$row['Type']})<br>\n";
        }
        
        // Check data count
        $result = $db->query("SELECT COUNT(*) as count FROM equipment");
        if ($result && $row = $db->fetchByAssoc($result)) {
            echo "<br><strong>Equipment count:</strong> {$row['count']}<br>\n";
        }
        
        // Show existing data
        $result = $db->query("SELECT id, name, equipment_type, checkout_status FROM equipment LIMIT 5");
        if ($result) {
            echo "<strong>Sample data:</strong><br>\n";
            while ($row = $db->fetchByAssoc($result)) {
                echo "- {$row['name']} ({$row['equipment_type']}) - Status: {$row['checkout_status']}<br>\n";
            }
        }
        
    } else {
        echo "❌ Equipment table NOT found<br>\n";
        echo "Available tables: " . implode(', ', array_slice($tables, 0, 10)) . "...<br>\n";
        
        // Try to create table
        echo "<br><strong>Attempting to create table...</strong><br>\n";
        require_once('modules/Equipment/EquipmentHelper.php');
        $result = EquipmentHelper::createEquipmentTable();
        if ($result) {
            echo "✅ Table created successfully<br>\n";
        } else {
            echo "❌ Failed to create table<br>\n";
        }
    }
    
    // Test 3: Test BeanFactory
    echo "<h3>Test 3: BeanFactory</h3>\n";
    $equipment = BeanFactory::getBean('Equipment');
    if ($equipment) {
        echo "✅ BeanFactory can create Equipment bean<br>\n";
        echo "Bean class: " . get_class($equipment) . "<br>\n";
        echo "Table name: " . $equipment->table_name . "<br>\n";
    } else {
        echo "❌ BeanFactory CANNOT create Equipment bean<br>\n";
    }
    
    // Test 4: Try to create one sample item
    echo "<h3>Test 4: Create Sample Item</h3>\n";
    if ($equipment) {
        try {
            $equipment->name = 'Test Equipment Item';
            $equipment->equipment_type = 'general';
            $equipment->condition_status = 'good';
            $equipment->checkout_status = 'available';
            $equipment->current_location = 'Test Storage';
            $equipment->purchase_date = '2024-01-01';
            $equipment->purchase_price = 99.99;
            
            $equipment->id = create_guid();
            $equipment->date_entered = date('Y-m-d H:i:s');
            $equipment->date_modified = date('Y-m-d H:i:s');
            $equipment->deleted = 0;
            
            $equipment->save();
            
            echo "✅ Successfully created test equipment item<br>\n";
            echo "ID: {$equipment->id}<br>\n";
            
        } catch (Exception $e) {
            echo "❌ Error creating test item: " . $e->getMessage() . "<br>\n";
        }
    }
    
    // Test 5: Check entry point registration
    echo "<h3>Test 5: Entry Point Registration</h3>\n";
    global $entry_point_registry;
    if (isset($entry_point_registry['add_sample_equipment'])) {
        echo "✅ add_sample_equipment entry point is registered<br>\n";
    } else {
        echo "❌ add_sample_equipment entry point NOT registered<br>\n";
        echo "Available entry points: " . implode(', ', array_keys($entry_point_registry)) . "<br>\n";
    }
    
} catch (Exception $e) {
    echo "❌ Fatal error: " . $e->getMessage() . "<br>\n";
    echo "Stack trace:<br>\n<pre>" . $e->getTraceAsString() . "</pre>\n";
}

echo "<br><strong>Debug complete!</strong><br>\n";
echo "<a href='index.php?module=Equipment'>Go to Equipment Module</a><br>\n";
echo "<a href='index.php?entryPoint=add_sample_equipment'>Test Add Sample Equipment Entry Point</a><br>\n"; 