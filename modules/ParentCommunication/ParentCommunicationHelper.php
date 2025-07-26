<?php
/**
 * Feature 4: Basic Parent Notification System
 * Helper class for parent communication business logic
 * 
 * Contains all the business logic for managing parent communications,
 * separated from the bean to prevent memory issues.
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class ParentCommunicationHelper
{
    /**
     * Get all parent contacts from the database using SuiteCRM BeanFactory
     */
    public static function getParents($filter = array()) {
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
    public static function sendBroadcastEmail($parent_ids, $subject, $message, $template_used = '') {
        global $db, $current_user;
        
        if (empty($parent_ids) || empty($subject) || empty($message)) {
            return array('success' => false, 'message' => 'Missing required fields');
        }
        
        $sent_count = 0;
        $failed_count = 0;
        $errors = array();
        
        // Get parent details for selected IDs
        $id_list = "'" . implode("','", array_map(array($db, 'quote'), $parent_ids)) . "'";
        $sql = "SELECT id, first_name, last_name, children_names_c 
                FROM contacts 
                WHERE id IN ({$id_list}) AND deleted = 0";
        
        try {
            $result = $db->query($sql);
            
            while ($row = $db->fetchByAssoc($result)) {
                // Get email address using BeanFactory
                $contact_bean = BeanFactory::getBean('Contacts', $row['id']);
                if (!$contact_bean || empty($contact_bean->email1)) {
                    $failed_count++;
                    $errors[] = "No email address for " . $row['first_name'] . " " . $row['last_name'];
                    continue;
                }
                
                $recipient_name = trim($row['first_name'] . ' ' . $row['last_name']);
                $email_sent = self::sendEmail($contact_bean->email1, $subject, $message, $recipient_name);
                
                if ($email_sent) {
                    $sent_count++;
                    // Update communication tracking
                    self::updateCommunicationTracking($row['id'], $subject, $template_used);
                } else {
                    $failed_count++;
                    $errors[] = "Failed to send email to " . $recipient_name . " (mail server not configured in development environment)";
                }
            }
            
            // Log the communication
            self::logCommunication($parent_ids, $subject, $message, $template_used, $sent_count);
            
            return array(
                'success' => true,
                'message' => "Email sent successfully. Delivered to {$sent_count} parents.",
                'sent_count' => $sent_count,
                'failed_count' => $failed_count,
                'errors' => $errors
            );
            
        } catch (Exception $e) {
            return array(
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            );
        }
    }
    
    /**
     * Send individual email
     */
    public static function sendEmail($to, $subject, $message, $recipient_name) {
        try {
            // Get current user info for sender
            global $current_user;
            $from_name = !empty($current_user->full_name) ? $current_user->full_name : 'Youth Sports League';
            $from_email = !empty($current_user->email1) ? $current_user->email1 : 'noreply@sportsleague.com';
            
            // Prepare headers
            $headers = array();
            $headers[] = "From: {$from_name} <{$from_email}>";
            $headers[] = "Reply-To: {$from_email}";
            $headers[] = "X-Mailer: PHP/" . phpversion();
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-Type: text/html; charset=UTF-8";
            
            // Personalize message
            $personalized_message = str_replace('[PARENT_NAME]', $recipient_name, $message);
            
            // Send email (suppress warnings for development environment)
            $result = @mail($to, $subject, $personalized_message, implode("\r\n", $headers));
            
            return $result;
            
        } catch (Exception $e) {
            error_log("Email sending error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update communication tracking for a parent
     */
    public static function updateCommunicationTracking($parent_id, $subject, $template_used) {
        require_once('data/BeanFactory.php');
        
        $contact = BeanFactory::getBean('Contacts', $parent_id);
        if ($contact) {
            $contact->last_communication_date_c = date('Y-m-d H:i:s');
            $contact->communication_count_c = intval($contact->communication_count_c) + 1;
            $contact->save();
        }
    }
    
    /**
     * Log communication to database
     */
    public static function logCommunication($parent_ids, $subject, $message, $template_used, $sent_count) {
        global $db, $current_user;
        
        if (!function_exists('create_guid')) {
            require_once('include/utils.php');
        }
        
        $id = create_guid();
        $now = date('Y-m-d H:i:s');
        $user_id = !empty($current_user->id) ? $current_user->id : '';
        $user_name = !empty($current_user->full_name) ? $current_user->full_name : 'System';
        
        // Create communication name
        $name = "Broadcast: " . substr($subject, 0, 50) . " (" . date('M j, Y') . ")";
        
        // Create the communication log entry
        $sql = sprintf("INSERT INTO parent_communications (
            id, name, date_entered, date_modified, created_by, modified_user_id,
            communication_type, subject, message, template_used, recipient_count,
            sent_date, sent_by, status
        ) VALUES (
            '%s', '%s', '%s', '%s', '%s', '%s',
            '%s', '%s', '%s', '%s', %d,
            '%s', '%s', '%s'
        )",
            $db->quote($id),
            $db->quote($name),
            $db->quote($now),
            $db->quote($now),
            $db->quote($user_id),
            $db->quote($user_id),
            $db->quote('broadcast_email'),
            $db->quote($subject),
            $db->quote($message),
            $db->quote($template_used),
            $sent_count,
            $db->quote($now),
            $db->quote($user_name),
            $db->quote('sent')
        );
        
        try {
            $db->query($sql);
            return $id;
        } catch (Exception $e) {
            error_log("Error logging communication: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get recent communications
     */
    public static function getRecentCommunications($limit = 10) {
        global $db;
        
        // Ensure the table exists
        self::createCommunicationsTable();
        
        $sql = "SELECT * FROM parent_communications 
                WHERE deleted = 0 
                ORDER BY sent_date DESC, date_entered DESC 
                LIMIT " . intval($limit);
        
        try {
            $result = $db->query($sql);
            $communications = array();
            
            while ($row = $db->fetchByAssoc($result)) {
                $communications[] = array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'subject' => $row['subject'],
                    'template_used' => $row['template_used'],
                    'recipient_count' => $row['recipient_count'],
                    'sent_date' => $row['sent_date'],
                    'sent_by' => $row['sent_by'],
                    'status' => $row['status'],
                    'date_entered' => $row['date_entered'],
                );
            }
            
            return $communications;
            
        } catch (Exception $e) {
            error_log("Error retrieving communications: " . $e->getMessage());
            return array();
        }
    }
    
    /**
     * Get message templates
     */
    public static function getMessageTemplates() {
        return array(
            'welcome' => array(
                'name' => 'Welcome Message',
                'subject' => 'Welcome to Youth Sports League!',
                'message' => 'Dear [PARENT_NAME],

Welcome to the Youth Sports League! We\'re excited to have your family as part of our community.

Important Information:
- Season starts soon - watch for schedule updates
- Uniforms will be distributed at the first practice
- Please ensure emergency contact information is up to date

If you have any questions, please don\'t hesitate to contact us.

Best regards,
Youth Sports League Team'
            ),
            'schedule_update' => array(
                'name' => 'Schedule Update',
                'subject' => 'Important Schedule Update',
                'message' => 'Dear [PARENT_NAME],

We have an important update regarding the upcoming schedule:

[Please customize this message with specific schedule details]

Please mark your calendars and let us know if you have any conflicts.

Thank you for your attention to this matter.

Best regards,
Youth Sports League Team'
            ),
            'weather_cancellation' => array(
                'name' => 'Weather Cancellation',
                'subject' => 'Game/Practice Cancelled Due to Weather',
                'message' => 'Dear [PARENT_NAME],

Due to inclement weather conditions, today\'s scheduled games and practices have been cancelled for safety reasons.

We will update you with rescheduled times as soon as possible.

Stay safe and warm!

Youth Sports League Team'
            ),
            'reminder' => array(
                'name' => 'General Reminder',
                'subject' => 'Important Reminder',
                'message' => 'Dear [PARENT_NAME],

This is a friendly reminder about:

[Please customize this message with specific reminder details]

Thank you for your continued participation in our league.

Best regards,
Youth Sports League Team'
            ),
        );
    }
    
    /**
     * Get parent communication statistics
     */
    public static function getParentStats() {
        $stats = array(
            'total_parents' => 0,
            'email_enabled' => 0,
            'recent_communications' => 0,
            'active_programs' => 0,
        );
        
        try {
            // Get total parents
            require_once('data/BeanFactory.php');
            $contact = BeanFactory::newBean('Contacts');
            if ($contact) {
                $where = "contacts.deleted = 0 AND (TRIM(LOWER(contacts.contact_type_c)) LIKE '%parent%' OR contacts.contact_type_c LIKE '%Parent%')";
                $parents = $contact->get_full_list("", $where);
                $stats['total_parents'] = count($parents ?: array());
                
                // Count email enabled parents
                $email_enabled = 0;
                $programs = array();
                if ($parents) {
                    foreach ($parents as $parent) {
                        if (!empty($parent->email_notifications_c)) {
                            $email_enabled++;
                        }
                        if (!empty($parent->programs_enrolled_c)) {
                            $program_list = explode(',', $parent->programs_enrolled_c);
                            foreach ($program_list as $prog) {
                                $programs[trim($prog)] = true;
                            }
                        }
                    }
                }
                $stats['email_enabled'] = $email_enabled;
                $stats['active_programs'] = count($programs);
            }
            
            // Get recent communications count (last 7 days)
            global $db;
            self::createCommunicationsTable();
            $week_ago = date('Y-m-d H:i:s', strtotime('-7 days'));
            $result = $db->query("SELECT COUNT(*) as count FROM parent_communications WHERE deleted = 0 AND sent_date >= '$week_ago'");
            $row = $db->fetchByAssoc($result);
            $stats['recent_communications'] = intval($row['count']);
            
        } catch (Exception $e) {
            error_log("Error retrieving parent stats: " . $e->getMessage());
        }
        
        return $stats;
    }
    
    /**
     * Create the communications table if it doesn't exist
     */
    public static function createCommunicationsTable() {
        global $db;
        
        $sql = "CREATE TABLE IF NOT EXISTS parent_communications (
            id VARCHAR(36) PRIMARY KEY,
            name VARCHAR(255),
            date_entered DATETIME,
            date_modified DATETIME,
            created_by VARCHAR(36),
            modified_user_id VARCHAR(36),
            deleted TINYINT(1) DEFAULT 0,
            
            communication_type VARCHAR(50),
            subject VARCHAR(255),
            message TEXT,
            template_used VARCHAR(100),
            recipient_count INT DEFAULT 0,
            sent_date DATETIME,
            sent_by VARCHAR(255),
            status VARCHAR(20) DEFAULT 'draft'
        )";
        
        try {
            $db->query($sql);
            return true;
        } catch (Exception $e) {
            error_log("Error creating communications table: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get dropdown options for parent communication fields
     */
    public static function getDropdownOptions() {
        return array(
            'communication_types' => array(
                'broadcast_email' => 'Broadcast Email',
                'individual_email' => 'Individual Email',
                'sms' => 'SMS Message',
                'phone_call' => 'Phone Call',
                'newsletter' => 'Newsletter',
            ),
            'communication_statuses' => array(
                'draft' => 'Draft',
                'sending' => 'Sending',
                'sent' => 'Sent',
                'failed' => 'Failed',
                'cancelled' => 'Cancelled',
            ),
            'programs' => array(
                'Football U7' => 'Football U7',
                'Soccer U8' => 'Soccer U8', 
                'Basketball U12' => 'Basketball U12',
                'Tennis U10' => 'Tennis U10',
                'Baseball U9' => 'Baseball U9',
                'Volleyball U11' => 'Volleyball U11',
            ),
            'frequencies' => array(
                'daily' => 'Daily',
                'weekly' => 'Weekly',
                'monthly' => 'Monthly',
                'as_needed' => 'As Needed',
                'emergency_only' => 'Emergency Only',
            ),
        );
    }
} 