<?php
/**
 * Feature 4: Basic Parent Notification System
 * Parent Communication Dashboard
 * 
 * Accessible via: index.php?entryPoint=parent_communication
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
 * Get all parent contacts from the database using SuiteCRM BeanFactory
 */
function getParents($filter = array()) {
    // Use SuiteCRM's BeanFactory to query contacts
    require_once('data/BeanFactory.php');
    
    $contact = BeanFactory::newBean('Contacts');
    if (!$contact) {
        return array();
    }
    
    // Build the WHERE clause for the query
    $where = "contacts.deleted = 0";
    $where .= " AND (TRIM(LOWER(contacts.contact_type_c)) LIKE '%parent%' OR contacts.contact_type_c LIKE '%Parent%')";
    
    // Apply filters if provided
    if (!empty($filter['email_enabled'])) {
        $where .= " AND contacts.email_notifications_c = 1";
    }
    
    if (!empty($filter['program'])) {
        $where .= " AND contacts.programs_enrolled_c LIKE '%" . $contact->db->quote($filter['program']) . "%'";
    }
    
    if (!empty($filter['frequency'])) {
        $where .= " AND contacts.communication_frequency_c = '" . $contact->db->quote($filter['frequency']) . "'";
    }
    
    // Use get_full_list to retrieve contacts
    $contacts = $contact->get_full_list("last_name, first_name", $where);
    
    $parents = array();
    
    if ($contacts) {
        foreach ($contacts as $contact_bean) {
            $parent = array(
                'id' => $contact_bean->id,
                'first_name' => $contact_bean->first_name,
                'last_name' => $contact_bean->last_name,
                'email1' => $contact_bean->email1,
                'phone_mobile' => $contact_bean->phone_mobile,
                'phone_home' => $contact_bean->phone_home,
                'contact_type_c' => $contact_bean->contact_type_c,
                // Parent-specific fields with defaults
                'children_names_c' => $contact_bean->children_names_c ?? '',
                'children_ages_c' => $contact_bean->children_ages_c ?? '',
                'programs_enrolled_c' => $contact_bean->programs_enrolled_c ?? '',
                'preferred_communication_c' => $contact_bean->preferred_communication_c ?? '',
                'communication_frequency_c' => $contact_bean->communication_frequency_c ?? '',
                'email_notifications_c' => $contact_bean->email_notifications_c ?? 1,
                'emergency_contact_name_c' => $contact_bean->emergency_contact_name_c ?? '',
                'emergency_contact_phone_c' => $contact_bean->emergency_contact_phone_c ?? '',
                'last_communication_date_c' => $contact_bean->last_communication_date_c ?? null,
                'communication_count_c' => $contact_bean->communication_count_c ?? 0,
            );
            
            $parents[] = $parent;
        }
    }
    
    return $parents;
}

/**
 * Send email to selected parents
 */
function sendBroadcastEmail($parent_ids, $subject, $message, $template_used = '') {
    global $db, $current_user;
    
    if (empty($parent_ids) || empty($subject) || empty($message)) {
        return array('success' => false, 'message' => 'Missing required fields');
    }
    
    $sent_count = 0;
    $failed_count = 0;
    $errors = array();
    

    
    // Get parent details for selected IDs - use correct email column name
    $id_list = "'" . implode("','", array_map(array($db, 'quote'), $parent_ids)) . "'";
    $sql = "SELECT id, first_name, last_name, children_names_c 
            FROM contacts 
            WHERE id IN ({$id_list}) AND deleted = 0";
    
    try {
        $result = $db->query($sql);
        
        if (!$result) {
            return array('success' => false, 'message' => 'Database query failed');
        }
        
        while ($parent = $db->fetchByAssoc($result)) {
            // Get the contact bean to access email properly
            require_once('data/BeanFactory.php');
            $contact_bean = BeanFactory::getBean('Contacts', $parent['id']);
            
            $email_address = '';
            if ($contact_bean && $contact_bean->email1) {
                $email_address = $contact_bean->email1;
            }
            
            if (empty($email_address)) {
                $failed_count++;
                $errors[] = "No email address for {$parent['first_name']} {$parent['last_name']}";
                continue;
            }
            
            // Personalize message
            $personalized_message = str_replace(
                array('[PARENT_NAME]', '[CHILDREN_NAMES]'),
                array($parent['first_name'], $parent['children_names_c'] ?: 'your child'),
                $message
            );
            
            // Send email using SuiteCRM's email system
            if (sendEmail($email_address, $subject, $personalized_message, $parent['first_name'] . ' ' . $parent['last_name'])) {
                $sent_count++;
                
                // Update communication tracking
                updateCommunicationTracking($parent['id'], $subject, $template_used);
            } else {
                $failed_count++;
                $errors[] = "Failed to send to {$parent['first_name']} {$parent['last_name']}";
            }
        }
        
        // Log communication in database
        logCommunication($parent_ids, $subject, $message, $template_used, $sent_count);
        
        return array(
            'success' => true,
            'sent_count' => $sent_count,
            'failed_count' => $failed_count,
            'errors' => $errors
        );
        
    } catch (Exception $e) {
        return array('success' => false, 'message' => 'Database error: ' . $e->getMessage());
    }
}

/**
 * Simple email sending function
 */
function sendEmail($to, $subject, $message, $recipient_name) {
    global $current_user;
    
    // Basic email headers
    $headers = array();
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=UTF-8';
    $headers[] = 'From: Youth Sports League <' . ($current_user->email1 ?: 'noreply@example.com') . '>';
    $headers[] = 'Reply-To: ' . ($current_user->email1 ?: 'noreply@example.com');
    
    // Convert message to HTML format
    $html_message = nl2br(htmlspecialchars($message));
    $html_message = "
    <html>
    <body style='font-family: Arial, sans-serif; line-height: 1.6;'>
        <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
            <h2 style='color: #333;'>Youth Sports League</h2>
            {$html_message}
            <hr style='margin: 20px 0;'>
            <p style='color: #666; font-size: 12px;'>
                This message was sent to {$recipient_name} via the Youth Sports League communication system.
            </p>
        </div>
    </body>
    </html>";
    
    // Send email
    return mail($to, $subject, $html_message, implode("\r\n", $headers));
}

/**
 * Update communication tracking for a parent
 */
function updateCommunicationTracking($parent_id, $subject, $template_used) {
    global $db;
    
    $now = date('Y-m-d H:i:s');
    
    $sql = "UPDATE contacts SET 
                last_communication_date_c = '{$now}',
                communication_count_c = COALESCE(communication_count_c, 0) + 1
            WHERE id = '" . $db->quote($parent_id) . "'";
    
    try {
        $db->query($sql);
    } catch (Exception $e) {
        // Log error but don't fail the operation
        error_log("Failed to update communication tracking for parent {$parent_id}: " . $e->getMessage());
    }
}

/**
 * Log communication in communication history table
 */
function logCommunication($parent_ids, $subject, $message, $template_used, $sent_count) {
    global $db, $current_user;
    
    // Create communication log table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS parent_communications (
        id VARCHAR(36) PRIMARY KEY,
        subject VARCHAR(255),
        message TEXT,
        template_used VARCHAR(100),
        parent_ids TEXT,
        sent_count INT,
        sent_by VARCHAR(36),
        date_sent DATETIME,
        deleted TINYINT(1) DEFAULT 0
    )";
    
    try {
        $db->query($sql);
        
        // Insert communication log
        $log_id = create_guid();
        $now = date('Y-m-d H:i:s');
        $user_id = $current_user->id ?: '';
        
        $insert_sql = sprintf("INSERT INTO parent_communications 
            (id, subject, message, template_used, parent_ids, sent_count, sent_by, date_sent) 
            VALUES ('%s', '%s', '%s', '%s', '%s', %d, '%s', '%s')",
            $db->quote($log_id),
            $db->quote($subject),
            $db->quote($message),
            $db->quote($template_used),
            $db->quote(implode(',', $parent_ids)),
            $sent_count,
            $db->quote($user_id),
            $db->quote($now)
        );
        
        $db->query($insert_sql);
        
    } catch (Exception $e) {
        error_log("Failed to log communication: " . $e->getMessage());
    }
}

/**
 * Get recent communications
 */
function getRecentCommunications($limit = 10) {
    global $db;
    
    try {
        $sql = "SELECT pc.*, u.first_name, u.last_name 
                FROM parent_communications pc
                LEFT JOIN users u ON pc.sent_by = u.id
                WHERE pc.deleted = 0 
                ORDER BY pc.date_sent DESC 
                LIMIT {$limit}";
        
        $result = $db->query($sql);
        $communications = array();
        
        while ($row = $db->fetchByAssoc($result)) {
            $communications[] = $row;
        }
        
        return $communications;
    } catch (Exception $e) {
        return array();
    }
}

/**
 * Get predefined message templates
 */
function getMessageTemplates() {
    return array(
        'schedule_change' => array(
            'name' => 'Schedule Change',
            'subject' => 'Important: Schedule Change for [PROGRAM_NAME]',
            'message' => "Dear [PARENT_NAME],\n\nWe have an important schedule change for [CHILDREN_NAMES]'s program.\n\n[DETAILS]\n\nPlease let us know if you have any questions.\n\nThank you,\nYouth Sports League"
        ),
        'weather_cancellation' => array(
            'name' => 'Weather Cancellation',
            'subject' => 'Program Cancelled Due to Weather',
            'message' => "Dear [PARENT_NAME],\n\nDue to weather conditions, [CHILDREN_NAMES]'s program scheduled for today has been cancelled.\n\nWe will update you on rescheduling as soon as possible.\n\nStay safe,\nYouth Sports League"
        ),
        'general_reminder' => array(
            'name' => 'General Reminder',
            'subject' => 'Reminder: [PROGRAM_NAME]',
            'message' => "Dear [PARENT_NAME],\n\nThis is a friendly reminder about [CHILDREN_NAMES]'s upcoming program.\n\n[DETAILS]\n\nSee you there!\nYouth Sports League"
        ),
        'emergency_notification' => array(
            'name' => 'Emergency Notification',
            'subject' => 'URGENT: Important Information',
            'message' => "Dear [PARENT_NAME],\n\nWe have an urgent update regarding [CHILDREN_NAMES]'s program.\n\n[DETAILS]\n\nPlease contact us immediately if you have questions.\n\nYouth Sports League"
        ),
        'thank_you' => array(
            'name' => 'Thank You Message',
            'subject' => 'Thank You!',
            'message' => "Dear [PARENT_NAME],\n\nThank you for your continued support of [CHILDREN_NAMES] and our Youth Sports League programs.\n\n[DETAILS]\n\nWe appreciate you!\nYouth Sports League"
        )
    );
}

// Handle form submissions
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'send_broadcast') {
        $parent_ids = $_POST['parent_ids'] ?? array();
        $subject = $_POST['subject'] ?? '';
        $email_message = $_POST['message'] ?? '';
        $template_used = $_POST['template_used'] ?? '';
        

        
        $result = sendBroadcastEmail($parent_ids, $subject, $email_message, $template_used);
        
        if ($result['success']) {
            $message = "✅ Email sent successfully! Delivered to {$result['sent_count']} parents.";
            if ($result['failed_count'] > 0) {
                $message .= " {$result['failed_count']} failed.";
            }
            $message_type = 'success';
        } else {
            $message = "❌ " . $result['message'];
            $message_type = 'error';
        }
    }
}

// Get parents for display
$filter = array();
if (isset($_GET['email_enabled'])) $filter['email_enabled'] = $_GET['email_enabled'];
if (isset($_GET['program'])) $filter['program'] = $_GET['program'];
if (isset($_GET['frequency'])) $filter['frequency'] = $_GET['frequency'];

$parents = getParents($filter);
$recent_communications = getRecentCommunications(5);
$templates = getMessageTemplates();

/**
 * Display parent card
 */
function displayParentCard($parent) {
    $children_display = !empty($parent['children_names_c']) ? htmlspecialchars($parent['children_names_c']) : 'No children listed';
    $programs_display = !empty($parent['programs_enrolled_c']) ? htmlspecialchars($parent['programs_enrolled_c']) : 'No programs listed';
    $email_status = ($parent['email_notifications_c'] ?? 1) ? 'text-green-600' : 'text-red-600';
    $email_icon = ($parent['email_notifications_c'] ?? 1) ? '✅' : '❌';
    
    echo '<div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">';
    echo '<div class="flex items-center mb-2">';
    echo '<input type="checkbox" name="parent_ids[]" value="' . htmlspecialchars($parent['id']) . '" class="mr-3 parent-checkbox">';
    echo '<h3 class="text-lg font-semibold text-gray-900">' . htmlspecialchars($parent['first_name'] . ' ' . $parent['last_name']) . '</h3>';
    echo '<span class="ml-2 ' . $email_status . '">' . $email_icon . '</span>';
    echo '</div>';
    
    echo '<div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-600">';
    echo '<div><strong>Email:</strong> ' . htmlspecialchars($parent['email1'] ?: 'Not provided') . '</div>';
    echo '<div><strong>Phone:</strong> ' . htmlspecialchars($parent['phone_mobile'] ?: $parent['phone_home'] ?: 'Not provided') . '</div>';
    echo '<div><strong>Children:</strong> ' . $children_display . '</div>';
    echo '<div><strong>Programs:</strong> ' . $programs_display . '</div>';
    echo '<div><strong>Comm. Method:</strong> ' . htmlspecialchars(($parent['preferred_communication_c'] ?? '') ?: 'Not set') . '</div>';
    echo '<div><strong>Frequency:</strong> ' . htmlspecialchars(($parent['communication_frequency_c'] ?? '') ?: 'Not set') . '</div>';
    echo '</div>';
    
    if (!empty($parent['last_communication_date_c'])) {
        echo '<div class="mt-2 text-xs text-gray-500">';
        echo 'Last contact: ' . date('M j, Y g:i A', strtotime($parent['last_communication_date_c']));
        echo ' (' . ($parent['communication_count_c'] ?? 0) . ' total)';
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
    <title>Parent Communication Dashboard - Youth Sports League</title>
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
        .btn-success { background-color: #059669; color: white; border: none; }
        .btn-success:hover { background-color: #047857; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">📧 Parent Communication Dashboard</h1>
                    <p class="text-gray-600 mt-2">Send updates and manage parent communications for Youth Sports League</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Total Parents: <?php echo count($parents); ?></p>
                    <p class="text-sm text-gray-500">Email Enabled: <?php echo count(array_filter($parents, function($p) { return $p['email_notifications_c']; })); ?></p>
                </div>
            </div>
        </div>

        <?php if ($message): ?>
        <div class="mb-6 p-4 rounded-lg <?php echo $message_type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>

        <!-- Feature 4 parent communication working! -->

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Parent List -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">👨‍👩‍👧‍👦 Parent Contacts</h2>
                        
                        <!-- Filter Options -->
                        <div class="flex space-x-2">
                            <select onchange="updateFilter('email_enabled', this.value)" class="text-sm">
                                <option value="">All Parents</option>
                                <option value="1" <?php echo ($_GET['email_enabled'] ?? '') === '1' ? 'selected' : ''; ?>>Email Enabled Only</option>
                            </select>
                            
                            <select onchange="updateFilter('frequency', this.value)" class="text-sm">
                                <option value="">All Frequencies</option>
                                <option value="daily" <?php echo ($_GET['frequency'] ?? '') === 'daily' ? 'selected' : ''; ?>>Daily Updates</option>
                                <option value="weekly" <?php echo ($_GET['frequency'] ?? '') === 'weekly' ? 'selected' : ''; ?>>Weekly</option>
                                <option value="as_needed" <?php echo ($_GET['frequency'] ?? '') === 'as_needed' ? 'selected' : ''; ?>>As Needed</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <button onclick="selectAll()" class="btn btn-secondary text-sm mr-2">Select All</button>
                        <button onclick="selectNone()" class="btn btn-secondary text-sm mr-2">Select None</button>
                        <button onclick="selectEmailEnabled()" class="btn btn-secondary text-sm">Select Email Enabled</button>
                        <span id="selected-count" class="ml-4 text-sm text-gray-600">0 selected</span>
                    </div>

                    <!-- Start of broadcast form - includes both parent selection and message composition -->
                    <form method="POST" id="broadcast-form">
                        <input type="hidden" name="action" value="send_broadcast">
                        
                        <?php if (empty($parents)): ?>
                            <div class="text-center py-12">
                                <div class="text-gray-400 text-6xl mb-4">👨‍👩‍👧‍👦</div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No parents found</h3>
                                <p class="text-gray-500">No parent contacts match the current filters.</p>
                            </div>
                        <?php else: ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto">
                                <?php foreach ($parents as $parent): ?>
                                    <?php displayParentCard($parent); ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                </div>
            </div>

            <!-- Message Composition -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">📝 Compose Message</h2>
                    
                    <div class="form-group">
                        <label for="template_select">Message Template</label>
                        <select id="template_select" onchange="loadTemplate()" class="mb-2">
                            <option value="">Select a template...</option>
                            <?php foreach ($templates as $key => $template): ?>
                                <option value="<?php echo $key; ?>"><?php echo htmlspecialchars($template['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <input type="text" id="subject" name="subject" required placeholder="Enter email subject">
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" rows="8" required 
                                  placeholder="Enter your message here...&#10;&#10;Use [PARENT_NAME] and [CHILDREN_NAMES] for personalization"></textarea>
                    </div>
                    
                    <div class="text-xs text-gray-500 mb-4">
                        <strong>Personalization:</strong><br>
                        • [PARENT_NAME] - Parent's first name<br>
                        • [CHILDREN_NAMES] - Children's names
                    </div>
                    
                    <button type="submit" class="btn btn-success w-full" 
                            onclick="return validateBroadcast()">
                        📧 Send to Selected Parents
                    </button>
                    
                    <input type="hidden" name="template_used" id="template_used">
                    </form>
                    <!-- End of broadcast form -->
                </div>

                <!-- Recent Communications -->
                <?php if (!empty($recent_communications)): ?>
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">📊 Recent Communications</h3>
                    <div class="space-y-3">
                        <?php foreach ($recent_communications as $comm): ?>
                            <div class="border-l-4 border-blue-400 pl-3 py-2">
                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($comm['subject']); ?></div>
                                <div class="text-xs text-gray-500">
                                    <?php echo date('M j, g:i A', strtotime($comm['date_sent'])); ?> 
                                    by <?php echo htmlspecialchars($comm['first_name'] . ' ' . $comm['last_name']); ?>
                                </div>
                                <div class="text-xs text-gray-500"><?php echo $comm['sent_count']; ?> recipients</div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Message templates data
        const templates = <?php echo json_encode($templates); ?>;
        
        function loadTemplate() {
            const select = document.getElementById('template_select');
            const template = templates[select.value];
            
            if (template) {
                document.getElementById('subject').value = template.subject;
                document.getElementById('message').value = template.message;
                document.getElementById('template_used').value = select.value;
            }
        }
        
        function updateFilter(param, value) {
            const url = new URL(window.location);
            if (value) {
                url.searchParams.set(param, value);
            } else {
                url.searchParams.delete(param);
            }
            window.location = url;
        }
        
        function selectAll() {
            const checkboxes = document.querySelectorAll('.parent-checkbox');
            checkboxes.forEach(cb => cb.checked = true);
            updateSelectedCount();
        }
        
        function selectNone() {
            const checkboxes = document.querySelectorAll('.parent-checkbox');
            checkboxes.forEach(cb => cb.checked = false);
            updateSelectedCount();
        }
        
        function selectEmailEnabled() {
            const checkboxes = document.querySelectorAll('.parent-checkbox');
            checkboxes.forEach(cb => {
                const card = cb.closest('.bg-white');
                const emailIcon = card.querySelector('.text-green-600');
                cb.checked = emailIcon !== null;
            });
            updateSelectedCount();
        }
        
        function updateSelectedCount() {
            const count = document.querySelectorAll('.parent-checkbox:checked').length;
            document.getElementById('selected-count').textContent = count + ' selected';
        }
        
        function validateBroadcast() {
            const selected = document.querySelectorAll('.parent-checkbox:checked').length;
            const subject = document.getElementById('subject').value.trim();
            const message = document.getElementById('message').value.trim();
            
            if (selected === 0) {
                alert('Please select at least one parent to send the message to.');
                return false;
            }
            
            if (!subject || !message) {
                alert('Please enter both a subject and message.');
                return false;
            }
            
            // DEBUG: Log checkbox details before confirming
            console.log('Selected checkboxes:');
            const checkedBoxes = document.querySelectorAll('.parent-checkbox:checked');
            checkedBoxes.forEach((checkbox, index) => {
                console.log(`Checkbox ${index}: name="${checkbox.name}", value="${checkbox.value}"`);
            });
            
            if (!confirm(`Send email to ${selected} selected parent(s)?`)) {
                return false;
            }
            
            return true;
        }
        
        // Update selected count when checkboxes change
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('parent-checkbox')) {
                updateSelectedCount();
            }
        });
        
        // Initialize selected count
        updateSelectedCount();
        
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