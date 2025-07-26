<?php

/**
 * Database Diagnostic for Equipment Table
 * 
 * Checks database permissions, table structure, and basic insert capabilities
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

require_once('include/entryPoint.php');

echo "<h2>Database Diagnostic for Equipment Table</h2>";

try {
    global $db;
    
    // 1. Check if we can connect to database
    echo "<h3>1. Database Connection</h3>";
    if ($db) {
        echo "✅ Database connection established<br>";
        echo "Database type: " . get_class($db) . "<br>";
    } else {
        echo "❌ No database connection<br>";
        exit;
    }
    
    // 2. Check table existence and structure
    echo "<h3>2. Table Structure</h3>";
    $result = $db->query("DESCRIBE equipment");
    if ($result) {
        echo "✅ Equipment table exists<br>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        while ($row = $db->fetchByAssoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . ($row['Default'] ?? 'NULL') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "❌ Equipment table does not exist or cannot be accessed<br>";
    }
    
    // 3. Check current user permissions
    echo "<h3>3. Database User Permissions</h3>";
    try {
        $result = $db->query("SHOW GRANTS");
        if ($result) {
            echo "✅ Can check grants<br>";
            while ($row = $db->fetchByAssoc($result)) {
                echo "Grant: " . print_r($row, true) . "<br>";
            }
        }
    } catch (Exception $e) {
        echo "Permission check failed: " . $e->getMessage() . "<br>";
    }
    
    // 4. Test simple insert with minimal data
    echo "<h3>4. Minimal Insert Test</h3>";
    $test_id = 'test_' . time();
    $test_name = 'Diagnostic Test ' . date('H:i:s');
    
    // Try the most basic insert possible
    $sql = "INSERT INTO equipment (id, name, deleted) VALUES ('$test_id', '$test_name', 0)";
    echo "SQL: $sql<br>";
    
    $result = $db->query($sql);
    if ($result) {
        echo "✅ Insert query executed<br>";
        
        // Check if it actually saved
        $check_result = $db->query("SELECT COUNT(*) as count FROM equipment WHERE id = '$test_id'");
        if ($check_result && $row = $db->fetchByAssoc($check_result)) {
            if ($row['count'] > 0) {
                echo "✅ Record actually saved to database<br>";
                
                // Clean up test record
                $db->query("DELETE FROM equipment WHERE id = '$test_id'");
                echo "✅ Test record cleaned up<br>";
            } else {
                echo "❌ Insert executed but no record found - possible rollback<br>";
            }
        }
    } else {
        echo "❌ Insert query failed<br>";
        if (method_exists($db, 'lastError')) {
            echo "Error: " . $db->lastError() . "<br>";
        }
    }
    
    // 5. Check for any locked tables or transactions
    echo "<h3>5. Database Status</h3>";
    try {
        $result = $db->query("SHOW PROCESSLIST");
        if ($result) {
            echo "Active processes:<br>";
            while ($row = $db->fetchByAssoc($result)) {
                if ($row['Info'] && strpos($row['Info'], 'equipment') !== false) {
                    echo "Equipment-related process: " . print_r($row, true) . "<br>";
                }
            }
        }
    } catch (Exception $e) {
        echo "Process check failed: " . $e->getMessage() . "<br>";
    }
    
    // 6. Test transaction handling
    echo "<h3>6. Transaction Test</h3>";
    try {
        $db->query("START TRANSACTION");
        echo "✅ Transaction started<br>";
        
        $test_id2 = 'txn_test_' . time();
        $result = $db->query("INSERT INTO equipment (id, name, deleted) VALUES ('$test_id2', 'Transaction Test', 0)");
        
        if ($result) {
            echo "✅ Insert in transaction succeeded<br>";
            $db->query("COMMIT");
            echo "✅ Transaction committed<br>";
            
            // Verify and cleanup
            $check = $db->query("SELECT COUNT(*) as count FROM equipment WHERE id = '$test_id2'");
            if ($check && $row = $db->fetchByAssoc($check)) {
                echo "Records after commit: " . $row['count'] . "<br>";
                $db->query("DELETE FROM equipment WHERE id = '$test_id2'");
            }
        } else {
            echo "❌ Insert in transaction failed<br>";
            $db->query("ROLLBACK");
        }
    } catch (Exception $e) {
        echo "Transaction test failed: " . $e->getMessage() . "<br>";
        try {
            $db->query("ROLLBACK");
        } catch (Exception $e2) {
            // Ignore rollback errors
        }
    }
    
    // 7. Final count check
    echo "<h3>7. Final Equipment Count</h3>";
    $result = $db->query("SELECT COUNT(*) as count FROM equipment WHERE deleted = 0");
    if ($result && $row = $db->fetchByAssoc($result)) {
        echo "Total equipment records: " . $row['count'] . "<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Diagnostic failed: " . $e->getMessage() . "<br>";
}

echo "<br><a href='index.php?entryPoint=create_equipment_form'>Create Equipment Form</a>";
echo "<br><a href='index.php?module=Equipment&action=equipmentdashboard'>Equipment Dashboard</a>"; 