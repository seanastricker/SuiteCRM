<?php
/**
 * Feature 3: Quick Incident Reporting Dashboard
 * Simplified entry point approach for incident reporting and management
 * 
 * Accessible via: index.php?entryPoint=incident_reporting
 */

// Error reporting and memory management
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('memory_limit', '512M');

// SuiteCRM initialization
global $current_user;
if (!defined('sugarEntry')) define('sugarEntry', true);
require_once('include/MVC/SugarApplication.php');
require_once('include/database/DBManagerFactory.php');

// Initialize database connection
global $db;
$db = DBManagerFactory::getInstance();

// Get current user info
session_start();
if (empty($current_user)) {
    require_once('modules/Users/User.php');
    $current_user = new User();
    if (isset($_SESSION['authenticated_user_id'])) {
        $current_user->retrieve($_SESSION['authenticated_user_id']);
    }
}

/**
 * Create the incidents table if it doesn't exist
 */
function createIncidentsTable() {
    global $db;
    
    $sql = "CREATE TABLE IF NOT EXISTS safety_incidents (
        id VARCHAR(36) PRIMARY KEY,
        name VARCHAR(255),
        date_entered DATETIME,
        date_modified DATETIME,
        created_by VARCHAR(36),
        modified_user_id VARCHAR(36),
        deleted TINYINT(1) DEFAULT 0,
        
        incident_date DATE NOT NULL,
        incident_time TIME,
        program_name VARCHAR(255),
        child_name VARCHAR(255),
        child_age INT,
        incident_type VARCHAR(50),
        severity_level VARCHAR(20),
        incident_description TEXT,
        immediate_action TEXT,
        incident_status VARCHAR(20) DEFAULT 'reported',
        reporter_name VARCHAR(255),
        reporter_role VARCHAR(50),
        medical_attention TINYINT(1) DEFAULT 0,
        parent_notified TINYINT(1) DEFAULT 0,
        followup_required TINYINT(1) DEFAULT 0,
        followup_notes TEXT
    )";
    
    try {
        $db->query($sql);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Save a new incident to the database
 */
function saveIncident($data) {
    global $db, $current_user;
    
    // Create table if needed
    createIncidentsTable();
    
    $id = create_guid();
    $now = date('Y-m-d H:i:s');
    $user_id = !empty($current_user->id) ? $current_user->id : '';
    
    // Generate incident name
    $incident_name = sprintf("Incident %s - %s", 
        date('Y-m-d', strtotime($data['incident_date'])), 
        substr($data['incident_type'], 0, 20)
    );
    
    // Incident save process
    
    // Use direct INSERT instead of pQuery to avoid parameter binding issues
    $sql = sprintf("INSERT INTO safety_incidents (
        id, name, date_entered, date_modified, created_by, modified_user_id,
        incident_date, incident_time, program_name, child_name, child_age,
        incident_type, severity_level, incident_description, immediate_action,
        incident_status, reporter_name, reporter_role, medical_attention,
        parent_notified, followup_required, followup_notes
    ) VALUES (
        '%s', '%s', '%s', '%s', '%s', '%s',
        '%s', '%s', '%s', '%s', %d,
        '%s', '%s', '%s', '%s',
        '%s', '%s', '%s', %d,
        %d, %d, '%s'
    )",
        $db->quote($id),
        $db->quote($incident_name),
        $db->quote($now),
        $db->quote($now),
        $db->quote($user_id),
        $db->quote($user_id),
        $db->quote($data['incident_date']),
        $db->quote($data['incident_time'] ?? ''),
        $db->quote($data['program_name'] ?? ''),
        $db->quote($data['child_name'] ?? ''),
        intval($data['child_age'] ?? 0),
        $db->quote($data['incident_type']),
        $db->quote($data['severity_level']),
        $db->quote($data['incident_description']),
        $db->quote($data['immediate_action'] ?? ''),
        $db->quote($data['incident_status'] ?? 'reported'),
        $db->quote($data['reporter_name']),
        $db->quote($data['reporter_role']),
        isset($data['medical_attention']) ? 1 : 0,
        isset($data['parent_notified']) ? 1 : 0,
        isset($data['followup_required']) ? 1 : 0,
        $db->quote($data['followup_notes'] ?? '')
    );
    
    try {
        $result = $db->query($sql);
        return $result ? $id : false;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Get incidents from the database
 */
function getIncidents($filter = array()) {
    global $db;
    
    $where_conditions = array("deleted = 0");
    
    if (!empty($filter['status'])) {
        $where_conditions[] = "incident_status = '" . $db->quote($filter['status']) . "'";
    }
    
    if (!empty($filter['severity'])) {
        $where_conditions[] = "severity_level = '" . $db->quote($filter['severity']) . "'";
    }
    
    if (!empty($filter['date_from'])) {
        $where_conditions[] = "incident_date >= '" . $db->quote($filter['date_from']) . "'";
    }
    
    $where_clause = implode(" AND ", $where_conditions);
    
    $sql = "SELECT * FROM safety_incidents 
            WHERE {$where_clause} 
            ORDER BY incident_date DESC, incident_time DESC 
            LIMIT 50";
    
    try {
        $result = $db->query($sql);
        $incidents = array();
        
        while ($row = $db->fetchByAssoc($result)) {
            $incidents[] = $row;
        }
        
        return $incidents;
    } catch (Exception $e) {
        return array();
    }
}

// Handle form submissions
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'report_incident') {
        $incident_id = saveIncident($_POST);
        if ($incident_id) {
            $message = "✅ Incident reported successfully! ID: " . substr($incident_id, 0, 8);
            $message_type = 'success';
        } else {
            $message = "❌ Error saving incident. Please try again.";
            $message_type = 'error';
        }
    }
}

// Get incidents for display
$filter = array();
if (isset($_GET['status'])) $filter['status'] = $_GET['status'];
if (isset($_GET['severity'])) $filter['severity'] = $_GET['severity'];
if (isset($_GET['date_from'])) $filter['date_from'] = $_GET['date_from'];

$incidents = getIncidents($filter);

/**
 * Display an incident card
 */
function displayIncidentCard($incident) {
    $severity_colors = array(
        'low' => 'bg-green-100 text-green-800',
        'medium' => 'bg-yellow-100 text-yellow-800',
        'high' => 'bg-orange-100 text-orange-800',
        'critical' => 'bg-red-100 text-red-800'
    );
    
    $status_colors = array(
        'reported' => 'bg-blue-100 text-blue-800',
        'investigating' => 'bg-purple-100 text-purple-800',
        'resolved' => 'bg-green-100 text-green-800',
        'closed' => 'bg-gray-100 text-gray-800'
    );
    
    $severity_class = $severity_colors[$incident['severity_level']] ?? 'bg-gray-100 text-gray-800';
    $status_class = $status_colors[$incident['incident_status']] ?? 'bg-gray-100 text-gray-800';
    
    echo '<div class="bg-white rounded-lg shadow-md p-6 mb-4 border-l-4 border-red-500">';
    echo '<div class="flex justify-between items-start mb-3">';
    echo '<h3 class="text-lg font-semibold text-gray-900">' . htmlspecialchars($incident['name'] ?? 'Untitled Incident') . '</h3>';
    echo '<div class="flex space-x-2">';
    echo '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $severity_class . '">' . ucfirst($incident['severity_level']) . '</span>';
    echo '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $status_class . '">' . ucfirst($incident['incident_status']) . '</span>';
    echo '</div>';
    echo '</div>';
    
    echo '<div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">';
    echo '<div><strong>Date:</strong> ' . date('M j, Y', strtotime($incident['incident_date']));
    if ($incident['incident_time']) echo ' at ' . date('g:i A', strtotime($incident['incident_time']));
    echo '</div>';
    echo '<div><strong>Program:</strong> ' . htmlspecialchars($incident['program_name'] ?? 'N/A') . '</div>';
    echo '<div><strong>Child:</strong> ' . htmlspecialchars($incident['child_name'] ?? 'N/A');
    if ($incident['child_age']) echo ' (Age ' . $incident['child_age'] . ')';
    echo '</div>';
    echo '<div><strong>Type:</strong> ' . htmlspecialchars($incident['incident_type'] ?? 'N/A') . '</div>';
    echo '<div><strong>Reporter:</strong> ' . htmlspecialchars($incident['reporter_name'] ?? 'N/A');
    if ($incident['reporter_role']) echo ' (' . $incident['reporter_role'] . ')';
    echo '</div>';
    echo '<div><strong>Medical Attention:</strong> ' . ($incident['medical_attention'] ? 'Yes' : 'No') . '</div>';
    echo '</div>';
    
    if (!empty($incident['incident_description'])) {
        echo '<div class="mt-4">';
        echo '<strong class="text-sm text-gray-700">Description:</strong>';
        echo '<p class="text-sm text-gray-600 mt-1">' . nl2br(htmlspecialchars($incident['incident_description'])) . '</p>';
        echo '</div>';
    }
    
    if (!empty($incident['immediate_action'])) {
        echo '<div class="mt-3">';
        echo '<strong class="text-sm text-gray-700">Immediate Action Taken:</strong>';
        echo '<p class="text-sm text-gray-600 mt-1">' . nl2br(htmlspecialchars($incident['immediate_action'])) . '</p>';
        echo '</div>';
    }
    
    echo '</div>';
}

// Create GUID function if not available
if (!function_exists('create_guid')) {
    function create_guid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safety Incident Reporting - Youth Sports League</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .form-section { margin-bottom: 24px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; margin-bottom: 4px; font-weight: 600; color: #374151; }
        input, select, textarea { width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        .btn { padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; text-align: center; }
        .btn-primary { background-color: #3b82f6; color: white; border: none; }
        .btn-primary:hover { background-color: #2563eb; }
        .btn-secondary { background-color: #6b7280; color: white; border: none; }
        .btn-secondary:hover { background-color: #4b5563; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">🚨 Safety Incident Reporting</h1>
                    <p class="text-gray-600 mt-2">Quick incident reporting and management for Youth Sports League</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Total Incidents: <?php echo count($incidents); ?></p>
                    <p class="text-sm text-gray-500">Last Updated: <?php echo date('M j, Y g:i A'); ?></p>
                </div>
            </div>
        </div>

        <?php if ($message): ?>
        <div class="mb-6 p-4 rounded-lg <?php echo $message_type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>

        <!-- Feature 3 filtering working perfectly! -->

        <!-- Quick Report Form -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">📝 Report New Incident</h2>
            
            <form method="POST" class="space-y-6">
                <input type="hidden" name="action" value="report_incident">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="form-section">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">📅 When & Where</h3>
                        
                        <div class="form-group">
                            <label for="incident_date">Incident Date *</label>
                            <input type="date" id="incident_date" name="incident_date" required 
                                   value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="incident_time">Incident Time</label>
                            <input type="time" id="incident_time" name="incident_time" 
                                   value="<?php echo date('H:i'); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="program_name">Program/Activity</label>
                            <input type="text" id="program_name" name="program_name" 
                                   placeholder="e.g., Soccer Practice U12">
                        </div>
                    </div>

                    <!-- Incident Details -->
                    <div class="form-section">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">🚨 Incident Details</h3>
                        
                        <div class="form-group">
                            <label for="incident_type">Incident Type *</label>
                            <select id="incident_type" name="incident_type" required>
                                <option value="">Select incident type</option>
                                <option value="injury">Injury</option>
                                <option value="accident">Accident</option>
                                <option value="illness">Illness</option>
                                <option value="behavioral">Behavioral Issue</option>
                                <option value="equipment">Equipment Malfunction</option>
                                <option value="facility">Facility Issue</option>
                                <option value="weather">Weather Related</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="severity_level">Severity Level *</label>
                            <select id="severity_level" name="severity_level" required>
                                <option value="">Select severity</option>
                                <option value="low">Low - Minor incident</option>
                                <option value="medium">Medium - Moderate incident</option>
                                <option value="high">High - Serious incident</option>
                                <option value="critical">Critical - Emergency</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- People Involved -->
                    <div class="form-section">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">👥 People Involved</h3>
                        
                        <div class="form-group">
                            <label for="child_name">Child's Name</label>
                            <input type="text" id="child_name" name="child_name" 
                                   placeholder="Enter child's name">
                        </div>
                        
                        <div class="form-group">
                            <label for="child_age">Child's Age</label>
                            <input type="number" id="child_age" name="child_age" min="3" max="18" 
                                   placeholder="Age">
                        </div>
                        
                        <div class="form-group">
                            <label for="reporter_name">Reporter Name *</label>
                            <input type="text" id="reporter_name" name="reporter_name" required 
                                   placeholder="Your name" 
                                   value="<?php echo htmlspecialchars($current_user->name ?? ''); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="reporter_role">Reporter Role *</label>
                            <select id="reporter_role" name="reporter_role" required>
                                <option value="">Select your role</option>
                                <option value="coach">Coach</option>
                                <option value="volunteer">Volunteer</option>
                                <option value="parent">Parent</option>
                                <option value="referee">Referee</option>
                                <option value="coordinator">Coordinator</option>
                                <option value="staff">Staff</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Response Actions -->
                    <div class="form-section">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">🏥 Response & Follow-up</h3>
                        
                        <div class="form-group">
                            <label for="incident_status">Status</label>
                            <select id="incident_status" name="incident_status">
                                <option value="reported">Reported</option>
                                <option value="investigating">Under Investigation</option>
                                <option value="resolved">Resolved</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="medical_attention" value="1" class="mr-2">
                                    Medical attention required
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="parent_notified" value="1" class="mr-2">
                                    Parent/Guardian notified
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="followup_required" value="1" class="mr-2">
                                    Follow-up required
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Fields -->
                <div class="form-section">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">📋 Detailed Information</h3>
                    
                    <div class="form-group">
                        <label for="incident_description">Incident Description *</label>
                        <textarea id="incident_description" name="incident_description" rows="4" required 
                                  placeholder="Provide a detailed description of what happened..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="immediate_action">Immediate Action Taken</label>
                        <textarea id="immediate_action" name="immediate_action" rows="3" 
                                  placeholder="Describe any immediate actions taken..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="followup_notes">Follow-up Notes</label>
                        <textarea id="followup_notes" name="followup_notes" rows="2" 
                                  placeholder="Any additional notes or follow-up actions needed..."></textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="reset" class="btn btn-secondary">Clear Form</button>
                    <button type="submit" class="btn btn-primary">🚨 Report Incident</button>
                </div>
            </form>
        </div>

        <!-- Incident List -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-900">📊 Recent Incidents</h2>
                
                <!-- Filter Options -->
                <div class="flex space-x-2">
                    <select onchange="updateFilter('status', this.value)" class="text-sm">
                        <option value="">All Statuses</option>
                        <option value="reported" <?php echo ($_GET['status'] ?? '') === 'reported' ? 'selected' : ''; ?>>Reported</option>
                        <option value="investigating" <?php echo ($_GET['status'] ?? '') === 'investigating' ? 'selected' : ''; ?>>Investigating</option>
                        <option value="resolved" <?php echo ($_GET['status'] ?? '') === 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                    </select>
                    
                    <select onchange="updateFilter('severity', this.value)" class="text-sm">
                        <option value="">All Severities</option>
                        <option value="low" <?php echo ($_GET['severity'] ?? '') === 'low' ? 'selected' : ''; ?>>Low</option>
                        <option value="medium" <?php echo ($_GET['severity'] ?? '') === 'medium' ? 'selected' : ''; ?>>Medium</option>
                        <option value="high" <?php echo ($_GET['severity'] ?? '') === 'high' ? 'selected' : ''; ?>>High</option>
                        <option value="critical" <?php echo ($_GET['severity'] ?? '') === 'critical' ? 'selected' : ''; ?>>Critical</option>
                    </select>
                </div>
            </div>

            <?php if (empty($incidents)): ?>
                <div class="text-center py-12">
                    <div class="text-gray-400 text-6xl mb-4">🚨</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No incidents reported</h3>
                    <p class="text-gray-500">Great! No safety incidents have been reported recently.</p>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($incidents as $incident): ?>
                        <?php displayIncidentCard($incident); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function updateFilter(param, value) {
            const url = new URL(window.location);
            if (value) {
                url.searchParams.set(param, value);
            } else {
                url.searchParams.delete(param);
            }
            window.location = url;
        }
        
        // Auto-clear success messages after 5 seconds
        setTimeout(function() {
            const messages = document.querySelectorAll('.bg-green-100, .bg-red-100');
            messages.forEach(msg => {
                msg.style.transition = 'opacity 0.5s';
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html> 