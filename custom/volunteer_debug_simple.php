<?php
/**
 * Simple Volunteer Debug - Test the exact query
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

// Get to the right directory for SuiteCRM
chdir('..');
require_once('config.php');
require_once('include/database/DBManagerFactory.php');

global $db;
$db = DBManagerFactory::getInstance();

echo "<h2>🔍 Simple Volunteer Debug</h2>";

// Test 1: Check if any contacts exist at all
echo "<h3>📋 Basic Contact Check</h3>";
$query = "SELECT COUNT(*) as count FROM contacts WHERE deleted = 0";
$result = $db->query($query);
$row = $db->fetchByAssoc($result);
echo "<p>Total contacts in database: <strong>" . $row['count'] . "</strong></p>";

// Test 2: Check contacts with contact_type_c field
echo "<h3>👥 Contact Type Check</h3>";
$query = "SELECT id, first_name, last_name, contact_type_c FROM contacts WHERE deleted = 0 AND contact_type_c IS NOT NULL LIMIT 5";
$result = $db->query($query);

echo "<table border='1' style='border-collapse: collapse;'>";
echo "<tr><th>Name</th><th>Contact Type</th></tr>";

$found_with_type = 0;
while ($row = $db->fetchByAssoc($result)) {
    $found_with_type++;
    $name = trim($row['first_name'] . ' ' . $row['last_name']);
    echo "<tr>";
    echo "<td>" . htmlspecialchars($name) . "</td>";
    echo "<td>" . htmlspecialchars($row['contact_type_c']) . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<p>Contacts with Contact Type set: <strong>{$found_with_type}</strong></p>";

// Test 3: Try our exact dashboard query
echo "<h3>🎯 Dashboard Query Test</h3>";
$query = "
    SELECT c.id, c.first_name, c.last_name, c.contact_type_c, c.volunteer_status_c,
           c.preferred_sports_c, c.preferred_age_groups_c, c.availability_days_c
    FROM contacts c
    WHERE c.deleted = 0 
    AND (c.contact_type_c LIKE '%volunteer%' OR c.contact_type_c LIKE '%coach%' OR c.contact_type_c LIKE '%staff%')
    LIMIT 10
";

echo "<p><strong>Query:</strong></p>";
echo "<pre>" . htmlspecialchars($query) . "</pre>";

$result = $db->query($query);

echo "<table border='1' style='border-collapse: collapse;'>";
echo "<tr><th>Name</th><th>Contact Type</th><th>Volunteer Status</th><th>Sports</th><th>Age Groups</th></tr>";

$dashboard_count = 0;
while ($row = $db->fetchByAssoc($result)) {
    $dashboard_count++;
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

echo "<p>Volunteers found by dashboard query: <strong>{$dashboard_count}</strong></p>";

if ($dashboard_count == 0) {
    echo "<div style='background: #ffebee; border: 1px solid #f44336; padding: 10px; margin: 10px 0;'>";
    echo "<h4>❌ No volunteers found by dashboard query</h4>";
    echo "<p>This means the LIKE queries aren't matching your Contact Type values.</p>";
    echo "</div>";
} else {
    echo "<div style='background: #e8f5e8; border: 1px solid #4caf50; padding: 10px; margin: 10px 0;'>";
    echo "<h4>✅ Found {$dashboard_count} volunteers!</h4>";
    echo "<p>The query is working. Check for PHP errors in the dashboard.</p>";
    echo "</div>";
}

// Test 4: Show exact Contact Type values
echo "<h3>📝 Exact Contact Type Values</h3>";
$query = "SELECT DISTINCT contact_type_c, COUNT(*) as count FROM contacts WHERE deleted = 0 AND contact_type_c IS NOT NULL GROUP BY contact_type_c";
$result = $db->query($query);

echo "<table border='1' style='border-collapse: collapse;'>";
echo "<tr><th>Contact Type Value</th><th>Count</th></tr>";

while ($row = $db->fetchByAssoc($result)) {
    echo "<tr>";
    echo "<td>'" . htmlspecialchars($row['contact_type_c']) . "'</td>";
    echo "<td>" . $row['count'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<hr>";
echo "<p><a href='index.php?entryPoint=volunteer_matching'>← Try Dashboard Again</a></p>";
?> 