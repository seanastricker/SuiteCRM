<?php
/**
 * Debug Volunteers Script
 * 
 * This script helps debug why volunteers aren't appearing in the dashboard
 * by checking what contacts exist and their field values.
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

// Fix the paths to point to the root directory
require_once('../config.php');
require_once('../include/database/DBManagerFactory.php');

global $db;
$db = DBManagerFactory::getInstance();

echo "<h2>🔍 Volunteer Debug Information</h2>";

// Check 1: All contacts
echo "<h3>📋 All Contacts (first 10)</h3>";
$query = "SELECT id, first_name, last_name, contact_type_c FROM contacts WHERE deleted = 0 LIMIT 10";
$result = $db->query($query);

echo "<table border='1' style='border-collapse: collapse; margin-bottom: 20px;'>";
echo "<tr><th>ID</th><th>Name</th><th>Contact Type</th></tr>";

$contact_count = 0;
while ($row = $db->fetchByAssoc($result)) {
    $contact_count++;
    $name = trim($row['first_name'] . ' ' . $row['last_name']);
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
    echo "<td>" . htmlspecialchars($name) . "</td>";
    echo "<td>" . htmlspecialchars($row['contact_type_c'] ?? 'NULL') . "</td>";
    echo "</tr>";
}
echo "</table>";

if ($contact_count == 0) {
    echo "<p><strong>❌ No contacts found. Create some contacts first!</strong></p>";
} else {
    echo "<p>✅ Found {$contact_count} contacts total.</p>";
}

// Check 2: Contacts with volunteer-related types
echo "<h3>👥 Volunteer-Type Contacts</h3>";
$query = "
    SELECT id, first_name, last_name, contact_type_c, volunteer_status_c, 
           preferred_sports_c, preferred_age_groups_c
    FROM contacts 
    WHERE deleted = 0 
    AND contact_type_c IN ('volunteer', 'coach', 'staff')
    LIMIT 10
";
$result = $db->query($query);

echo "<table border='1' style='border-collapse: collapse; margin-bottom: 20px;'>";
echo "<tr><th>Name</th><th>Contact Type</th><th>Volunteer Status</th><th>Sports</th><th>Age Groups</th></tr>";

$volunteer_count = 0;
while ($row = $db->fetchByAssoc($result)) {
    $volunteer_count++;
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

if ($volunteer_count == 0) {
    echo "<p><strong>❌ No volunteer-type contacts found.</strong></p>";
    echo "<p>Create contacts and set Contact Type to 'volunteer', 'coach', or 'staff'.</p>";
} else {
    echo "<p>✅ Found {$volunteer_count} volunteer-type contacts.</p>";
}

// Check 3: Database schema for contact_type_c field
echo "<h3>🗄️ Database Schema Check</h3>";
$query = "DESCRIBE contacts contact_type_c";
$result = $db->query($query);

if ($result && $db->getRowCount($result) > 0) {
    echo "<p>✅ contact_type_c field exists in contacts table.</p>";
    $row = $db->fetchByAssoc($result);
    echo "<p>Field type: " . htmlspecialchars($row['Type']) . "</p>";
} else {
    echo "<p>❌ contact_type_c field not found in contacts table.</p>";
    echo "<p>Run Quick Repair and Rebuild to add the field.</p>";
}

// Check 4: Available dropdown values
echo "<h3>📝 Dropdown Values Check</h3>";
echo "<p>Expected contact_type_c values: volunteer, coach, staff</p>";
echo "<p>If contacts exist but aren't showing, check that Contact Type field matches these values exactly.</p>";

// Check 5: Quick fixes
echo "<h3>🔧 Quick Fixes</h3>";
echo "<ol>";
echo "<li><strong>Create Test Contact:</strong> <a href='../index.php?module=Contacts&action=EditView'>Create New Contact</a></li>";
echo "<li><strong>Set Contact Type:</strong> Make sure to set 'Contact Type' to 'Volunteer'</li>";
echo "<li><strong>Add Preferences:</strong> Fill in Preferred Sports, Age Groups, etc.</li>";
echo "<li><strong>Return to Dashboard:</strong> <a href='../index.php?entryPoint=volunteer_matching'>Volunteer Matching Dashboard</a></li>";
echo "</ol>";

echo "<hr>";
echo "<p><a href='../index.php?entryPoint=volunteer_matching'>← Back to Volunteer Dashboard</a></p>";
?> 