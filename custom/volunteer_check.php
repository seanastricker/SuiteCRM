<?php
/**
 * Simple MySQL Check for Volunteers
 * Direct database query without SuiteCRM dependencies
 */

// Database connection settings from your XAMPP setup
$host = 'localhost';
$dbname = 'suitecrm';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>🔍 Direct Database Volunteer Check</h2>";
    
    // Test 1: Basic contact count
    echo "<h3>📋 Total Contacts</h3>";
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM contacts WHERE deleted = 0");
    $row = $stmt->fetch();
    echo "<p>Total contacts: <strong>" . $row['count'] . "</strong></p>";
    
    // Test 2: Check if contact_type_c column exists
    echo "<h3>🗄️ Database Schema Check</h3>";
    try {
        $stmt = $pdo->query("SHOW COLUMNS FROM contacts LIKE 'contact_type_c'");
        if ($stmt->rowCount() > 0) {
            echo "<p>✅ contact_type_c column exists</p>";
        } else {
            echo "<p>❌ contact_type_c column does NOT exist</p>";
            echo "<p><strong>Problem found:</strong> Run Quick Repair and Rebuild to add custom fields!</p>";
        }
    } catch (Exception $e) {
        echo "<p>❌ Error checking column: " . $e->getMessage() . "</p>";
    }
    
    // Test 3: Show all contact types
    echo "<h3>📝 Contact Type Values</h3>";
    try {
        $stmt = $pdo->query("SELECT contact_type_c, COUNT(*) as count FROM contacts WHERE deleted = 0 AND contact_type_c IS NOT NULL AND contact_type_c != '' GROUP BY contact_type_c");
        
        if ($stmt->rowCount() > 0) {
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>Contact Type</th><th>Count</th></tr>";
            while ($row = $stmt->fetch()) {
                echo "<tr>";
                echo "<td>'" . htmlspecialchars($row['contact_type_c']) . "'</td>";
                echo "<td>" . $row['count'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>❌ No contacts with Contact Type set</p>";
            echo "<p><strong>Problem found:</strong> Create volunteers and set their Contact Type field!</p>";
        }
    } catch (Exception $e) {
        echo "<p>❌ Error: " . $e->getMessage() . "</p>";
        echo "<p>This usually means the contact_type_c field doesn't exist yet.</p>";
    }
    
    // Test 4: Show sample volunteer data
    echo "<h3>👥 Sample Volunteer Data</h3>";
    try {
        $stmt = $pdo->query("
            SELECT first_name, last_name, contact_type_c, volunteer_status_c, 
                   preferred_sports_c, preferred_age_groups_c 
            FROM contacts 
            WHERE deleted = 0 
            AND contact_type_c IS NOT NULL 
            AND contact_type_c != ''
            LIMIT 5
        ");
        
        if ($stmt->rowCount() > 0) {
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>Name</th><th>Contact Type</th><th>Volunteer Status</th><th>Sports</th><th>Age Groups</th></tr>";
            while ($row = $stmt->fetch()) {
                $name = trim($row['first_name'] . ' ' . $row['last_name']);
                echo "<tr>";
                echo "<td>" . htmlspecialchars($name) . "</td>";
                echo "<td>" . htmlspecialchars($row['contact_type_c'] ?? 'NULL') . "</td>";
                echo "<td>" . htmlspecialchars($row['volunteer_status_c'] ?? 'NULL') . "</td>";
                echo "<td>" . htmlspecialchars($row['preferred_sports_c'] ?? 'NULL') . "</td>";
                echo "<td>" . htmlspecialchars($row['preferred_age_groups_c'] ?? 'NULL') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>❌ No volunteer data found</p>";
        }
    } catch (Exception $e) {
        echo "<p>❌ Error: " . $e->getMessage() . "</p>";
    }
    
    // Test 5: Test dashboard query
    echo "<h3>🎯 Dashboard Query Test</h3>";
    try {
        $stmt = $pdo->query("
            SELECT COUNT(*) as count
            FROM contacts c
            WHERE c.deleted = 0 
            AND (c.contact_type_c LIKE '%volunteer%' OR c.contact_type_c LIKE '%coach%' OR c.contact_type_c LIKE '%staff%')
        ");
        $row = $stmt->fetch();
        $count = $row['count'];
        
        if ($count > 0) {
            echo "<p>✅ Dashboard query finds <strong>{$count}</strong> volunteers!</p>";
            echo "<p>The query works. There might be a PHP error in the dashboard itself.</p>";
        } else {
            echo "<p>❌ Dashboard query finds <strong>0</strong> volunteers</p>";
            echo "<p>The LIKE pattern isn't matching your Contact Type values.</p>";
        }
    } catch (Exception $e) {
        echo "<p>❌ Error: " . $e->getMessage() . "</p>";
    }
    
} catch (PDOException $e) {
    echo "<h3>❌ Database Connection Error</h3>";
    echo "<p>Could not connect to database: " . $e->getMessage() . "</p>";
    echo "<p>Make sure XAMPP MySQL is running and the database name is 'suitecrm'</p>";
}

echo "<hr>";
echo "<h3>🔧 Quick Fixes</h3>";
echo "<ol>";
echo "<li><a href='../index.php?module=Administration&action=repair'>Run Quick Repair and Rebuild</a></li>";
echo "<li><a href='../index.php?module=Contacts&action=EditView'>Create a Test Volunteer</a></li>";
echo "<li><a href='../index.php?entryPoint=volunteer_matching'>Try Dashboard Again</a></li>";
echo "</ol>";
?> 