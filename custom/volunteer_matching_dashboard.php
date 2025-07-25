<?php
/**
 * Volunteer Matching Dashboard Entry Point
 * 
 * This file provides a direct entry point for the volunteer matching
 * dashboard functionality in the Youth Sports League system.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $theme, $current_user, $db;

// Load SuiteCRM environment
require_once('include/MVC/View/SugarView.php');
require_once('include/utils.php');
require_once('include/database/DBManagerFactory.php');

// Initialize database connection
$db = DBManagerFactory::getInstance();

// Enable error reporting for debugging but suppress deprecation warnings
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', 1);

// Simple debug test first
echo "<!-- DEBUG: Script loaded successfully -->";

// Test direct database connection immediately
try {
    $test_pdo = new PDO("mysql:host=localhost;dbname=suitecrm", 'root', '');
    $test_result = $test_pdo->query("SELECT COUNT(*) as count FROM contacts WHERE deleted = 0 AND contact_type_c LIKE '%volunteer%'");
    $test_row = $test_result->fetch(PDO::FETCH_ASSOC);
    echo "<!-- DEBUG: Direct DB test found " . $test_row['count'] . " volunteer contacts -->";
} catch (Exception $e) {
    echo "<!-- ERROR: Direct DB test failed: " . $e->getMessage() . " -->";
}

// Debug database connection
echo "<!-- DEBUG: Database connection type: " . get_class($db) . " -->";
echo "<!-- DEBUG: Script starting, about to begin main logic -->";

// Start output
echo get_form_header('Volunteer-Program Matching Dashboard', '', false);

// Include CSS for better styling
echo '<style>
.volunteer-card { border: 1px solid #ddd; padding: 10px; margin-bottom: 8px; border-radius: 3px; background: white; }
.program-card { border: 1px solid #ddd; padding: 10px; margin-bottom: 8px; border-radius: 3px; background: white; }
.stats-panel { background: #f9f9f9; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
.dashboard-container { display: flex; gap: 20px; margin-bottom: 20px; }
.dashboard-panel { flex: 1; border: 1px solid #ccc; padding: 15px; border-radius: 5px; }
.analysis-panel { border: 1px solid #ccc; padding: 15px; border-radius: 5px; background-color: #f9f9f9; }
.scrollable { max-height: 500px; overflow-y: auto; }
.priority-high { background: #28a745; color: white; padding: 2px 8px; border-radius: 10px; font-size: 10px; }
.priority-medium { background: #ffc107; color: white; padding: 2px 8px; border-radius: 10px; font-size: 10px; }
.priority-low { background: #6c757d; color: white; padding: 2px 8px; border-radius: 10px; font-size: 10px; }
</style>';

// Get volunteer data using direct database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=suitecrm", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $query = "
        SELECT c.id, c.first_name, c.last_name, 
               c.preferred_sports_c, c.preferred_age_groups_c, c.availability_days_c,
               c.volunteer_experience_level_c, c.volunteer_status_c, c.special_skills_c,
               c.background_check_status_c, c.background_check_expiration_c, c.contact_type_c
        FROM contacts c
        WHERE c.deleted = 0 
        AND (TRIM(c.contact_type_c) = 'volunteer' OR TRIM(c.contact_type_c) = 'coach' OR TRIM(c.contact_type_c) = 'staff')
        ORDER BY c.volunteer_status_c DESC, c.volunteer_experience_level_c DESC, c.last_name ASC
    ";
    
    $stmt = $pdo->query($query);
    $volunteers = array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $volunteers[] = $row;
    }
    
} catch (PDOException $e) {
    echo "<!-- ERROR: Database query failed: " . $e->getMessage() . " -->";
    $volunteers = array();
}

// Store volunteer count for statistics
$total_volunteer_count = count($volunteers);

$programs_needed = generateProgramsFromVolunteers($volunteers);

// Display the dashboard
echo '<div class="moduleTitle">';
echo '<h2>🏆 Volunteer-Program Matching Dashboard</h2>';
echo '<p>Analyze volunteer preferences and suggest program assignments.</p>';
echo '</div>';

// Statistics panel
// Display statistics panel
echo '<div class="stats-panel">';
echo '<h3>📊 Current Statistics</h3>';
echo '<div style="display: flex; gap: 30px;">';
echo '<div><strong>Total Volunteers:</strong> ' . count($volunteers) . '</div>';
echo '<div><strong>Available:</strong> ' . countByStatus($volunteers, ['active', 'available']) . '</div>';
echo '<div><strong>Valid Background Checks:</strong> ' . countByBackgroundCheck($volunteers, ['valid', 'expiring']) . '</div>';
echo '</div></div>';

echo '<div class="dashboard-container">';

// Left panel - Available volunteers
echo '<div class="dashboard-panel">';
echo '<h3>👥 Available Volunteers</h3>';

if (empty($volunteers)) {
    echo '<p><em>No volunteers found. Create some volunteer contacts first!</em></p>';
    echo '<p><a href="index.php?module=Contacts&action=EditView&contact_type_c=volunteer">Create a Volunteer Contact</a></p>';
} else {
    echo '<p><strong>DEBUG: Found ' . count($volunteers) . ' volunteers in dashboard</strong></p>';
    echo '<div class="scrollable">';
    foreach ($volunteers as $volunteer) {
        echo "<!-- Processing volunteer: " . $volunteer['first_name'] . " " . $volunteer['last_name'] . " -->";
        displayVolunteerCard($volunteer);
    }
    echo '</div>';
}
echo '</div>';

// Right panel - Suggested programs
echo '<div class="dashboard-panel">';
echo '<h3>🎯 Suggested Programs</h3>';
echo '<p><em>Based on volunteer preferences, here are programs you should consider creating:</em></p>';

if (empty($programs_needed)) {
    echo '<p><em>Add volunteer preferences to see program suggestions.</em></p>';
} else {
    foreach ($programs_needed as $program => $data) {
        displayProgramSuggestion($program, $data);
    }
}
echo '</div>';

echo '</div>';

// Matching analysis section
echo '<div class="analysis-panel">';
echo '<h3>🔍 Volunteer Preference Analysis</h3>';
displayPreferenceAnalysis($volunteers);
echo '</div>';

// Back link
echo '<div style="margin-top: 20px; text-align: center;">';
echo '<a href="index.php?module=Contacts&action=index" class="button">« Back to Contacts</a>';
echo '</div>';



/**
 * Get volunteers with their profile information
 */
function getVolunteers()
{
    global $db;
    
    // Debug: Check if $db is available
    if (!$db) {
        echo "<!-- ERROR: No database connection available, trying direct connection -->";
        return getVolunteersDirect();
    }
    
    // TEMPORARY: Force use of direct connection since SuiteCRM query returns 0
    echo "<!-- DEBUG: Forcing direct connection since SuiteCRM query issues -->";
    
    try {
        $direct_result = getVolunteersDirect();
        echo "<!-- DEBUG: getVolunteers received from direct: " . (is_array($direct_result) ? count($direct_result) : 'NOT_ARRAY') . " -->";
        echo "<!-- DEBUG: direct_result type: " . gettype($direct_result) . " -->";
        return $direct_result;
    } catch (Exception $e) {
        echo "<!-- ERROR: Exception in getVolunteersDirect call: " . $e->getMessage() . " -->";
        return array();
    }
    
    $query = "
        SELECT c.id, c.first_name, c.last_name, c.email1, c.phone_work,
               c.preferred_sports_c, c.preferred_age_groups_c, c.availability_days_c,
               c.volunteer_experience_level_c, c.volunteer_status_c, c.special_skills_c,
               c.background_check_status_c, c.background_check_expiration_c, c.contact_type_c
        FROM contacts c
        WHERE c.deleted = 0 
        AND (c.contact_type_c LIKE '%volunteer%' OR c.contact_type_c LIKE '%coach%' OR c.contact_type_c LIKE '%staff%')
        ORDER BY c.volunteer_status_c DESC, c.volunteer_experience_level_c DESC, c.last_name ASC
    ";
    
    echo "<!-- DEBUG: About to execute query -->";
    echo "<!-- DEBUG: SQL Query: " . str_replace(array("\n", "\r"), ' ', $query) . " -->";
    
    try {
        $result = $db->query($query);
        echo "<!-- DEBUG: Query executed successfully -->";
    } catch (Exception $e) {
        echo "<!-- ERROR: Query exception: " . $e->getMessage() . " -->";
        return array();
    }
    
    if (!$result) {
        echo "<!-- ERROR: Query failed -->";
        return array();
    }
    
    echo "<!-- DEBUG: Result object type: " . get_class($result) . " -->";
    
    $volunteers = array();
    $count = 0;
    
    echo "<!-- DEBUG: Starting to fetch rows -->";
    while ($row = $db->fetchByAssoc($result)) {
        $count++;
        echo "<!-- DEBUG: Processing row $count -->";
        if ($count == 1) {
            echo "<!-- DEBUG: First row keys: " . implode(', ', array_keys($row)) . " -->";
            echo "<!-- DEBUG: First row contact_type_c: '" . ($row['contact_type_c'] ?? 'NULL') . "' -->";
        }
        $volunteers[] = $row;
    }
    
    echo "<!-- DEBUG: Found $count volunteers in getVolunteers() -->";
    
    return $volunteers;
}

/**
 * Generate suggested programs based on volunteer preferences
 */
function generateProgramsFromVolunteers($volunteers)
{
    $programs = array();
    
    foreach ($volunteers as $volunteer) {
        if (empty($volunteer['preferred_sports_c']) || empty($volunteer['preferred_age_groups_c'])) {
            continue;
        }
        
        $sports = explode('^,^', trim($volunteer['preferred_sports_c'], '^'));
        $ages = explode('^,^', trim($volunteer['preferred_age_groups_c'], '^'));
        
        foreach ($sports as $sport) {
            foreach ($ages as $age) {
                if (empty($sport) || empty($age)) continue;
                
                $program_key = $sport . " - " . $age;
                
                if (!isset($programs[$program_key])) {
                    $programs[$program_key] = array(
                        'sport' => $sport,
                        'age_group' => $age,
                        'interested_volunteers' => array(),
                        'count' => 0
                    );
                }
                
                $programs[$program_key]['interested_volunteers'][] = $volunteer;
                $programs[$program_key]['count']++;
            }
        }
    }
    
    // Sort by volunteer interest (highest first)
    uasort($programs, function($a, $b) {
        return $b['count'] - $a['count'];
    });
    
    return array_slice($programs, 0, 10, true); // Top 10
}

/**
 * Display a volunteer card
 */
function displayVolunteerCard($volunteer)
{
    // Add error handling for missing data
    $name = trim(($volunteer['first_name'] ?? '') . ' ' . ($volunteer['last_name'] ?? ''));
    $volunteer_status = $volunteer['volunteer_status_c'] ?? 'Unknown';
    $bg_check_status = $volunteer['background_check_status_c'] ?? 'Unknown';
    $experience_level = $volunteer['volunteer_experience_level_c'] ?? 'Not specified';
    
    $status_color = getStatusColor($volunteer_status);
    $bg_check_color = getBackgroundCheckColor($bg_check_status);
    
    echo '<div class="volunteer-card">';
    echo '<div style="display: flex; justify-content: space-between; align-items: start;">';
    echo '<div>';
    echo '<strong>' . htmlspecialchars($name) . '</strong>';
    echo '<div style="font-size: 11px; color: #666;">';
    echo 'Status: <span style="color: ' . $status_color . ';">●</span> ' . htmlspecialchars($volunteer_status) . ' | ';
    echo 'Background: <span style="color: ' . $bg_check_color . ';">●</span> ' . htmlspecialchars($bg_check_status);
    echo '</div>';
    echo '</div>';
    echo '<div style="font-size: 10px; color: #999;">' . htmlspecialchars($experience_level) . '</div>';
    echo '</div>';
    
    if (!empty($volunteer['preferred_sports_c'])) {
        $sports = str_replace('^,^', ', ', trim($volunteer['preferred_sports_c'], '^'));
        echo '<div style="font-size: 11px; margin-top: 5px;"><strong>Sports:</strong> ' . htmlspecialchars($sports) . '</div>';
    }
    
    if (!empty($volunteer['preferred_age_groups_c'])) {
        $ages = str_replace('^,^', ', ', trim($volunteer['preferred_age_groups_c'], '^'));
        echo '<div style="font-size: 11px;"><strong>Ages:</strong> ' . htmlspecialchars($ages) . '</div>';
    }
    
    if (!empty($volunteer['availability_days_c'])) {
        $days = str_replace('^,^', ', ', trim($volunteer['availability_days_c'], '^'));
        echo '<div style="font-size: 11px;"><strong>Available:</strong> ' . htmlspecialchars($days) . '</div>';
    }
    
    echo '</div>';
}

/**
 * Display a program suggestion
 */
function displayProgramSuggestion($program_name, $data)
{
    $priority = $data['count'] >= 3 ? 'High' : ($data['count'] >= 2 ? 'Medium' : 'Low');
    $priority_class = $data['count'] >= 3 ? 'priority-high' : ($data['count'] >= 2 ? 'priority-medium' : 'priority-low');
    
    echo '<div class="program-card">';
    echo '<div style="display: flex; justify-content: space-between; align-items: center;">';
    echo '<strong>' . htmlspecialchars($program_name) . '</strong>';
    echo '<span class="' . $priority_class . '">' . $priority . '</span>';
    echo '</div>';
    echo '<div style="font-size: 11px; color: #666; margin-top: 5px;">';
    echo '<strong>' . $data['count'] . ' volunteers interested</strong>';
    echo '</div>';
    
    // Show first few interested volunteers
    $names = array();
    foreach (array_slice($data['interested_volunteers'], 0, 3) as $vol) {
        $names[] = trim($vol['first_name'] . ' ' . $vol['last_name']);
    }
    echo '<div style="font-size: 10px; color: #999;">';
    echo htmlspecialchars(implode(', ', $names));
    if (count($data['interested_volunteers']) > 3) {
        echo ' + ' . (count($data['interested_volunteers']) - 3) . ' more';
    }
    echo '</div>';
    echo '</div>';
}

/**
 * Display preference analysis
 */
function displayPreferenceAnalysis($volunteers)
{
    $sports_count = array();
    $ages_count = array();
    $days_count = array();
    
    foreach ($volunteers as $volunteer) {
        // Count sports
        if (!empty($volunteer['preferred_sports_c'])) {
            $sports = explode('^,^', trim($volunteer['preferred_sports_c'], '^'));
            foreach ($sports as $sport) {
                if (!empty($sport)) {
                    $sports_count[$sport] = ($sports_count[$sport] ?? 0) + 1;
                }
            }
        }
        
        // Count age groups
        if (!empty($volunteer['preferred_age_groups_c'])) {
            $ages = explode('^,^', trim($volunteer['preferred_age_groups_c'], '^'));
            foreach ($ages as $age) {
                if (!empty($age)) {
                    $ages_count[$age] = ($ages_count[$age] ?? 0) + 1;
                }
            }
        }
        
        // Count availability
        if (!empty($volunteer['availability_days_c'])) {
            $days = explode('^,^', trim($volunteer['availability_days_c'], '^'));
            foreach ($days as $day) {
                if (!empty($day)) {
                    $days_count[$day] = ($days_count[$day] ?? 0) + 1;
                }
            }
        }
    }
    
    echo '<div style="display: flex; gap: 20px;">';
    
    echo '<div style="flex: 1;">';
    echo '<h4>🏃 Most Popular Sports</h4>';
    if (empty($sports_count)) {
        echo '<p><em>No sports preferences recorded</em></p>';
    } else {
        arsort($sports_count);
        foreach (array_slice($sports_count, 0, 5, true) as $sport => $count) {
            echo '<div>' . htmlspecialchars($sport) . ': <strong>' . $count . '</strong> volunteers</div>';
        }
    }
    echo '</div>';
    
    echo '<div style="flex: 1;">';
    echo '<h4>👶 Most Popular Age Groups</h4>';
    if (empty($ages_count)) {
        echo '<p><em>No age group preferences recorded</em></p>';
    } else {
        arsort($ages_count);
        foreach (array_slice($ages_count, 0, 5, true) as $age => $count) {
            echo '<div>' . htmlspecialchars($age) . ': <strong>' . $count . '</strong> volunteers</div>';
        }
    }
    echo '</div>';
    
    echo '<div style="flex: 1;">';
    echo '<h4>📅 Most Available Days</h4>';
    if (empty($days_count)) {
        echo '<p><em>No availability preferences recorded</em></p>';
    } else {
        arsort($days_count);
        foreach (array_slice($days_count, 0, 7, true) as $day => $count) {
            echo '<div>' . htmlspecialchars($day) . ': <strong>' . $count . '</strong> volunteers</div>';
        }
    }
    echo '</div>';
    
    echo '</div>';
}

/**
 * Helper functions
 */
function countByStatus($volunteers, $statuses)
{
    $count = 0;
    foreach ($volunteers as $vol) {
        $status = strtolower($vol['volunteer_status_c']);
        foreach ($statuses as $search_status) {
            if (strpos($status, strtolower($search_status)) !== false) {
                $count++;
                break;
            }
        }
    }
    return $count;
}

function countByBackgroundCheck($volunteers, $statuses)
{
    $count = 0;
    foreach ($volunteers as $vol) {
        $status = strtolower($vol['background_check_status_c']);
        foreach ($statuses as $search_status) {
            if (strpos($status, strtolower($search_status)) !== false) {
                $count++;
                break;
            }
        }
    }
    return $count;
}

function getStatusColor($status)
{
    switch ($status) {
        case 'active': return '#28a745';
        case 'available': return '#17a2b8';
        case 'inactive': return '#6c757d';
        default: return '#ffc107';
    }
}

function getBackgroundCheckColor($status)
{
    switch ($status) {
        case 'valid': return '#28a745';
        case 'expiring': return '#ffc107';
        case 'expired': return '#dc3545';
        default: return '#6c757d';
    }
} 

/**
 * Get volunteers using direct PDO connection (fallback)
 */
function getVolunteersDirect()
{
    echo "<!-- DEBUG: Using direct database connection -->";
    
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=suitecrm", 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $query = "
            SELECT c.id, c.first_name, c.last_name, c.email1, c.phone_work,
                   c.preferred_sports_c, c.preferred_age_groups_c, c.availability_days_c,
                   c.volunteer_experience_level_c, c.volunteer_status_c, c.special_skills_c,
                   c.background_check_status_c, c.background_check_expiration_c, c.contact_type_c
            FROM contacts c
            WHERE c.deleted = 0 
            AND (c.contact_type_c LIKE '%volunteer%' OR c.contact_type_c LIKE '%coach%' OR c.contact_type_c LIKE '%staff%')
            ORDER BY c.volunteer_status_c DESC, c.volunteer_experience_level_c DESC, c.last_name ASC
        ";
        
        $stmt = $pdo->query($query);
        $volunteers = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $volunteers[] = $row;
        }
        
        echo "<!-- DEBUG: Direct connection found " . count($volunteers) . " volunteers -->";
        echo "<!-- DEBUG: About to return from getVolunteersDirect, volunteers is_array: " . (is_array($volunteers) ? 'YES' : 'NO') . " -->";
        
        // Additional return debugging
        $return_count = count($volunteers);
        echo "<!-- DEBUG: Final return count check: $return_count -->";
        
        if ($return_count > 0) {
            echo "<!-- DEBUG: Returning " . $return_count . " volunteers -->";
        } else {
            echo "<!-- ERROR: About to return empty array! -->";
        }
        
        return $volunteers;
        
    } catch (PDOException $e) {
        echo "<!-- ERROR: Direct connection failed: " . $e->getMessage() . " -->";
        return array();
    }
} 