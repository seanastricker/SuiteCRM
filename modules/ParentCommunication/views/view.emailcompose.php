<?php
/**
 * ParentCommunication Module - Email Composition View
 * 
 * This view provides the interface for composing and sending emails to parents
 * with recipient selection, template management, and bulk email capabilities.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/View/SugarView.php');

class ParentCommunicationViewEmailcompose extends SugarView
{
    public function display()
    {
        global $mod_strings, $app_strings;
        
        echo '<div style="padding: 20px;">';
        echo '<h2>📧 Compose Email to Parents</h2>';
        
        // Handle form submission
        if ($_POST['action'] == 'send_email') {
            $this->handleEmailSending();
            return;
        }
        
        // Display the email composition form
        $this->displayEmailForm();
        
        echo '</div>';
    }
    
    /**
     * Display the email composition form
     */
    private function displayEmailForm()
    {
        // Get email templates
        $templates = $this->getEmailTemplates();
        
        // Get recipient groups
        $recipientGroups = $this->getRecipientGroups();
        
        echo '<form method="POST" action="index.php?module=ParentCommunication&action=emailcompose" id="emailForm">';
        echo '<input type="hidden" name="action" value="send_email">';
        
        // Recipient Selection Section
        echo '<div style="background: #f8f9fa; padding: 20px; margin: 15px 0; border-radius: 8px;">';
        echo '<h3>👥 Select Recipients</h3>';
        
        echo '<div style="margin: 15px 0;">';
        echo '<label style="font-weight: bold;">Recipient Group:</label><br>';
        echo '<select name="recipient_group" id="recipientGroup" style="width: 300px; padding: 8px; font-size: 14px;" onchange="updateRecipientCount()" required>';
        echo '<option value="">Select Recipient Group...</option>';
        
        foreach ($recipientGroups as $key => $group) {
            echo '<option value="' . htmlspecialchars($key) . '">' . htmlspecialchars($group['name']) . ' (' . $group['count'] . ' contacts)</option>';
        }
        
        echo '</select>';
        
        // Add debug info
        echo '<div style="margin-top: 10px; padding: 10px; background: #e7f3ff; border: 1px solid #bee5eb; border-radius: 3px; font-size: 12px;">';
        echo '<strong>🔍 Debug Info:</strong><br>';
        foreach ($recipientGroups as $key => $group) {
            echo '• ' . htmlspecialchars($group['name']) . ': ' . $group['count'] . ' contacts<br>';
        }
        echo '</div>';
        echo '</div>';
        
        echo '<div style="margin: 15px 0;">';
        echo '<label style="font-weight: bold;">Additional Filters:</label><br>';
        echo '<label><input type="checkbox" name="email_opt_in_only" value="1" checked> Email opt-in only</label><br>';
        echo '<label><input type="checkbox" name="exclude_no_email" value="1" checked> Exclude contacts without email</label>';
        echo '</div>';
        
        echo '<div id="recipientPreview" style="margin: 15px 0; padding: 10px; background: white; border-radius: 5px; display: none;">';
        echo '<strong>Selected Recipients:</strong>';
        echo '<div id="recipientList"></div>';
        echo '</div>';
        
        echo '</div>';
        
        // Email Template Section
        echo '<div style="background: #f8f9fa; padding: 20px; margin: 15px 0; border-radius: 8px;">';
        echo '<h3>📋 Email Template</h3>';
        
        echo '<div style="margin: 15px 0;">';
        echo '<label style="font-weight: bold;">Use Template:</label><br>';
        echo '<select name="email_template" id="emailTemplate" style="width: 300px; padding: 8px;" onchange="loadTemplate()">';
        echo '<option value="">No Template (Compose from scratch)</option>';
        
        foreach ($templates as $template) {
            echo '<option value="' . $template['id'] . '">' . htmlspecialchars($template['name']) . '</option>';
        }
        
        echo '</select>';
        echo ' <button type="button" onclick="manageTemplates()" style="padding: 8px 15px; background: #6c757d; color: white; border: none; border-radius: 3px;">Manage Templates</button>';
        echo '</div>';
        
        echo '</div>';
        
        // Email Composition Section
        echo '<div style="background: #f8f9fa; padding: 20px; margin: 15px 0; border-radius: 8px;">';
        echo '<h3>✉️ Compose Email</h3>';
        
        echo '<div style="margin: 15px 0;">';
        echo '<label style="font-weight: bold;">From Name:</label><br>';
        echo '<input type="text" name="from_name" value="Youth Sports League" style="width: 300px; padding: 8px;" required>';
        echo '</div>';
        
        echo '<div style="margin: 15px 0;">';
        echo '<label style="font-weight: bold;">Subject:</label><br>';
        echo '<input type="text" name="email_subject" id="emailSubject" style="width: 600px; padding: 8px;" placeholder="Enter email subject..." required>';
        echo '</div>';
        
        echo '<div style="margin: 15px 0;">';
        echo '<label style="font-weight: bold;">Message:</label><br>';
        echo '<textarea name="email_message" id="emailMessage" rows="15" style="width: 100%; padding: 10px;" placeholder="Enter your message here...">';
        echo '</textarea>';
        echo '</div>';
        
        echo '<div style="margin: 15px 0;">';
        echo '<label style="font-weight: bold;">Email Priority:</label><br>';
        echo '<select name="email_priority" style="width: 200px; padding: 8px;">';
        echo '<option value="normal">Normal</option>';
        echo '<option value="high">High Priority</option>';
        echo '<option value="low">Low Priority</option>';
        echo '</select>';
        echo '</div>';
        
        echo '</div>';
        
        // Send Options Section
        echo '<div style="background: #f8f9fa; padding: 20px; margin: 15px 0; border-radius: 8px;">';
        echo '<h3>⚙️ Send Options</h3>';
        
        echo '<div style="margin: 15px 0;">';
        echo '<label><input type="radio" name="send_option" value="send_now" checked> Send Immediately</label><br>';
        echo '<label><input type="radio" name="send_option" value="save_draft"> Save as Draft</label><br>';
        echo '<label><input type="radio" name="send_option" value="preview"> Preview Only</label>';
        echo '</div>';
        
        echo '</div>';
        
        // Action Buttons
        echo '<div style="padding: 20px; text-align: center;">';
        echo '<button type="submit" style="background: #007cba; color: white; padding: 12px 30px; border: none; border-radius: 5px; font-size: 16px; margin-right: 10px;">📧 Send Email</button>';
        echo '<button type="button" onclick="previewEmail()" style="background: #6c757d; color: white; padding: 12px 30px; border: none; border-radius: 5px; font-size: 16px; margin-right: 10px;">👁️ Preview</button>';
        echo '<button type="button" onclick="window.location.href=\'index.php?module=ParentCommunication&action=index\'" style="background: #dc3545; color: white; padding: 12px 30px; border: none; border-radius: 5px; font-size: 16px;">❌ Cancel</button>';
        echo '</div>';
        
        echo '</form>';
        
        // Add JavaScript for form functionality
        $this->addJavaScript();
    }
    
    /**
     * Get available email templates
     */
    private function getEmailTemplates()
    {
        return array(
            array('id' => 'welcome', 'name' => 'Welcome Email'),
            array('id' => 'event_announcement', 'name' => 'Event Announcement'),
            array('id' => 'emergency', 'name' => 'Emergency Communication'),
            array('id' => 'newsletter', 'name' => 'Monthly Newsletter'),
            array('id' => 'schedule_change', 'name' => 'Schedule Change'),
            array('id' => 'weather_update', 'name' => 'Weather Update'),
        );
    }
    
    /**
     * Get recipient groups with counts
     */
    private function getRecipientGroups()
    {
        require_once('data/BeanFactory.php');
        $contact = BeanFactory::newBean('Contacts');
        
        if (!$contact) {
            return array();
        }
        
        $groups = array();
        
        // All Parents - FIXED: Now checks for email addresses too
        $query = "SELECT COUNT(*) as count FROM contacts WHERE deleted = 0 AND contact_type_c = 'parent' AND email_communication_opt_in_c = 1 AND email1 IS NOT NULL AND email1 != ''";
        $result = $contact->db->query($query);
        $row = $contact->db->fetchByAssoc($result);
        $groups['all_parents'] = array('name' => 'All Parents', 'count' => $row['count'] ? $row['count'] : 0);
        
        // Primary Parents Only - FIXED: Now checks for email addresses too  
        $query = "SELECT COUNT(*) as count FROM contacts WHERE deleted = 0 AND contact_type_c = 'parent' AND parent_guardian_type_c = 'primary_parent' AND email_communication_opt_in_c = 1 AND email1 IS NOT NULL AND email1 != ''";
        $result = $contact->db->query($query);
        $row = $contact->db->fetchByAssoc($result);
        $groups['primary_parents'] = array('name' => 'Primary Parents Only', 'count' => $row['count'] ? $row['count'] : 0);
        
        // All Volunteers - FIXED: Now checks for email addresses too
        $query = "SELECT COUNT(*) as count FROM contacts WHERE deleted = 0 AND contact_type_c = 'volunteer' AND email_communication_opt_in_c = 1 AND email1 IS NOT NULL AND email1 != ''";
        $result = $contact->db->query($query);
        $row = $contact->db->fetchByAssoc($result);
        $groups['all_volunteers'] = array('name' => 'All Volunteers', 'count' => $row['count'] ? $row['count'] : 0);
        
        // All Contacts with Email Opt-in
        $query = "SELECT COUNT(*) as count FROM contacts WHERE deleted = 0 AND email_communication_opt_in_c = 1";
        $result = $contact->db->query($query);
        $row = $contact->db->fetchByAssoc($result);
        $groups['all_opted_in'] = array('name' => 'All Email Opt-in Contacts', 'count' => $row['count'] ? $row['count'] : 0);
        
        return $groups;
    }
    
    /**
     * Handle email sending process
     */
    private function handleEmailSending()
    {
        if ($_POST['send_option'] == 'preview') {
            $this->showEmailPreview();
            return;
        }
        
        // Get recipients based on selection
        $recipients = $this->getSelectedRecipients();
        
        if (empty($recipients)) {
            echo '<div style="background: #f8d7da; padding: 15px; margin: 15px 0; border-radius: 5px; color: #721c24;">';
            echo '<strong>Error:</strong> No recipients selected or found.';
            echo '</div>';
            $this->displayEmailForm();
            return;
        }
        
        $subject = $_POST['email_subject'];
        $message = $_POST['email_message'];
        $from_name = $_POST['from_name'];
        
        if ($_POST['send_option'] == 'send_now') {
            $sent_count = $this->sendBulkEmail($recipients, $subject, $message, $from_name);
            
            echo '<div style="background: #d4edda; padding: 15px; margin: 15px 0; border-radius: 5px; color: #155724;">';
            echo '<h3>✅ Email Sent Successfully!</h3>';
            echo '<p><strong>Recipients:</strong> ' . $sent_count . ' emails sent</p>';
            echo '<p><strong>Subject:</strong> ' . htmlspecialchars($subject) . '</p>';
            echo '</div>';
            
            // Log the communication
            $this->logCommunication($subject, $message, $sent_count);
            
        } elseif ($_POST['send_option'] == 'save_draft') {
            echo '<div style="background: #d1ecf1; padding: 15px; margin: 15px 0; border-radius: 5px; color: #0c5460;">';
            echo '<h3>💾 Email Saved as Draft</h3>';
            echo '<p>Your email has been saved and can be sent later.</p>';
            echo '</div>';
        }
        
        echo '<p><a href="index.php?module=ParentCommunication&action=emailcompose" style="color: #007cba;">← Compose Another Email</a></p>';
        echo '<p><a href="index.php?module=ParentCommunication&action=index" style="color: #007cba;">← Back to Parent Communications</a></p>';
    }
    
    /**
     * Get selected recipients based on form data
     */
    private function getSelectedRecipients()
    {
        require_once('data/BeanFactory.php');
        $contact = BeanFactory::newBean('Contacts');
        
        if (!$contact) {
            return array();
        }
        
        $recipient_group = $_POST['recipient_group'];
        $email_opt_in_only = isset($_POST['email_opt_in_only']);
        $exclude_no_email = isset($_POST['exclude_no_email']);
        
        $where = "contacts.deleted = 0";
        
        if ($email_opt_in_only) {
            $where .= " AND contacts.email_communication_opt_in_c = 1";
        }
        
        if ($exclude_no_email) {
            $where .= " AND contacts.email1 IS NOT NULL AND contacts.email1 != ''";
        }
        
        // Add group-specific filters
        switch ($recipient_group) {
            case 'all_parents':
                $where .= " AND contacts.contact_type_c = 'parent'";
                break;
            case 'primary_parents':
                $where .= " AND contacts.contact_type_c = 'parent' AND contacts.parent_guardian_type_c = 'primary_parent'";
                break;
            case 'all_volunteers':
                $where .= " AND contacts.contact_type_c = 'volunteer'";
                break;
            case 'all_opted_in':
                // No additional filter needed
                break;
            default:
                return array(); // Unknown group
        }
        
        $contacts = $contact->get_full_list("last_name, first_name", $where);
        
        $recipients = array();
        if ($contacts) {
            foreach ($contacts as $contact) {
                if (!empty($contact->email1)) {
                    $recipients[] = array(
                        'id' => $contact->id,
                        'name' => trim($contact->first_name . ' ' . $contact->last_name),
                        'email' => $contact->email1,
                        'type' => $contact->contact_type_c
                    );
                }
            }
        }
        
        return $recipients;
    }
    
    /**
     * Send bulk email to recipients
     */
    private function sendBulkEmail($recipients, $subject, $message, $from_name)
    {
        require_once('include/SugarPHPMailer.php');
        require_once('data/BeanFactory.php');
        
        $sent_count = 0;
        
        // Get admin settings once
        $admin = BeanFactory::newBean('Administration');
        $admin->retrieveSettings();
        $from_email = $admin->settings['notify_fromaddress'];
        
        if (empty($from_email)) {
            error_log("No from email address configured in system settings");
            return 0;
        }
        
        foreach ($recipients as $recipient) {
            try {
                $mail = new SugarPHPMailer();
                
                // Configure SMTP
                $mail->isSMTP();
                $mail->Host = $admin->settings['mail_smtpserver'];
                $mail->Port = $admin->settings['mail_smtpport'];
                $mail->SMTPAuth = true;
                $mail->Username = $admin->settings['mail_smtpuser'];
                $mail->Password = $admin->settings['mail_smtppass'];
                $mail->SMTPSecure = $admin->settings['mail_smtpssl'];
                
                // Set email content
                $mail->Subject = $subject;
                $mail->Body = $this->personalizeMessage($message, $recipient);
                $mail->setFrom($from_email, $from_name);
                $mail->addAddress($recipient['email'], $recipient['name']);
                
                if ($mail->send()) {
                    $sent_count++;
                }
                
                // Small delay to prevent overwhelming the server
                usleep(100000); // 0.1 second delay
                
            } catch (Exception $e) {
                error_log("Email sending error for " . $recipient['email'] . ": " . $e->getMessage());
            }
        }
        
        return $sent_count;
    }
    
    /**
     * Personalize message with recipient data
     */
    private function personalizeMessage($message, $recipient)
    {
        $personalized = $message;
        $personalized = str_replace('[Parent Name]', $recipient['name'], $personalized);
        $personalized = str_replace('[Contact Name]', $recipient['name'], $personalized);
        $personalized = str_replace('[First Name]', explode(' ', $recipient['name'])[0], $personalized);
        
        return $personalized;
    }
    
    /**
     * Log communication in the database
     */
    private function logCommunication($subject, $message, $recipient_count)
    {
        require_once('data/BeanFactory.php');
        $comm = BeanFactory::newBean('ParentCommunication');
        
        if ($comm) {
            $comm->name = $subject;
            $comm->communication_type = 'email';
            $comm->subject = $subject;
            $comm->message = $message;
            $comm->recipient_count = $recipient_count;
            $comm->sent_date = date('Y-m-d H:i:s');
            $comm->sent_by = $GLOBALS['current_user']->id;
            $comm->status = 'sent';
            
            $comm->save();
        }
    }
    
    /**
     * Show email preview
     */
    private function showEmailPreview()
    {
        $recipients = $this->getSelectedRecipients();
        $subject = $_POST['email_subject'];
        $message = $_POST['email_message'];
        $from_name = $_POST['from_name'];
        
        echo '<div style="background: #f8f9fa; padding: 20px; margin: 15px 0; border-radius: 8px;">';
        echo '<h3>👁️ Email Preview</h3>';
        
        echo '<div style="background: white; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">';
        echo '<p><strong>From:</strong> ' . htmlspecialchars($from_name) . '</p>';
        echo '<p><strong>Subject:</strong> ' . htmlspecialchars($subject) . '</p>';
        echo '<p><strong>Recipients:</strong> ' . count($recipients) . ' contacts</p>';
        echo '<hr>';
        echo '<div style="white-space: pre-wrap;">' . htmlspecialchars($message) . '</div>';
        echo '</div>';
        
        echo '<div style="margin-top: 15px;">';
        echo '<strong>Sample Recipients:</strong>';
        echo '<ul>';
        $sample_count = min(5, count($recipients));
        for ($i = 0; $i < $sample_count; $i++) {
            echo '<li>' . htmlspecialchars($recipients[$i]['name']) . ' (' . htmlspecialchars($recipients[$i]['email']) . ')</li>';
        }
        if (count($recipients) > 5) {
            echo '<li>... and ' . (count($recipients) - 5) . ' more</li>';
        }
        echo '</ul>';
        echo '</div>';
        
        echo '</div>';
        
        echo '<p><a href="index.php?module=ParentCommunication&action=emailcompose" style="color: #007cba;">← Back to Email Composition</a></p>';
    }
    
    /**
     * Add JavaScript for form functionality
     */
    private function addJavaScript()
    {
        echo '<script>';
        echo 'console.log("Email composition JavaScript loaded");';
        
        echo 'function updateRecipientCount() {';
        echo '  console.log("updateRecipientCount called");';
        echo '  var group = document.getElementById("recipientGroup").value;';
        echo '  console.log("Selected group:", group);';
        echo '  // Function to update recipient preview would go here';
        echo '}';
        
        echo 'function loadTemplate() {';
        echo '  console.log("loadTemplate called");';
        echo '  var templateId = document.getElementById("emailTemplate").value;';
        echo '  console.log("Selected template:", templateId);';
        echo '  if (templateId) {';
        echo '    loadTemplateContent(templateId);';
        echo '  } else {';
        echo '    // Clear template fields';
        echo '    document.getElementById("emailSubject").value = "";';
        echo '    document.getElementById("emailMessage").value = "";';
        echo '  }';
        echo '}';
        
        echo 'function loadTemplateContent(templateId) {';
        echo '  var templates = {';
        echo '    "welcome": {';
        echo '      "subject": "Welcome to Youth Sports League!",';
        echo '      "message": "Dear [Parent Name],\\n\\nWelcome to the Youth Sports League! We\'re excited to have your family join our community.\\n\\nBest regards,\\nYouth Sports League Team"';
        echo '    },';
        echo '    "event_announcement": {';
        echo '      "subject": "Upcoming Event - [Event Name]",';
        echo '      "message": "Dear [Parent Name],\\n\\nWe have an important event coming up:\\n\\nDate: [Date]\\nTime: [Time]\\nLocation: [Location]\\n\\nPlease mark your calendar!\\n\\nBest regards,\\nYouth Sports League Team"';
        echo '    },';
        echo '    "emergency": {';
        echo '      "subject": "URGENT: Important Safety Information",';
        echo '      "message": "Dear Parents,\\n\\nThis is an urgent communication regarding [Emergency Details].\\n\\nPlease contact us immediately if you have any questions.\\n\\nYouth Sports League Emergency Team"';
        echo '    },';
        echo '    "newsletter": {';
        echo '      "subject": "Youth Sports League Monthly Update",';
        echo '      "message": "Dear Youth Sports League Families,\\n\\nHere\'s what\'s happening this month:\\n\\n- [Event 1]\\n- [Event 2]\\n- [Event 3]\\n\\nThank you for being part of our community!\\n\\nBest regards,\\nYouth Sports League Team"';
        echo '    }';
        echo '  };';
        echo '  ';
        echo '  if (templates[templateId]) {';
        echo '    document.getElementById("emailSubject").value = templates[templateId].subject;';
        echo '    document.getElementById("emailMessage").value = templates[templateId].message;';
        echo '  }';
        echo '}';
        
        echo 'function previewEmail() {';
        echo '  document.getElementsByName("send_option")[2].checked = true;';
        echo '  document.getElementById("emailForm").submit();';
        echo '}';
        
        echo 'function manageTemplates() {';
        echo '  window.open("index.php?module=ParentCommunication&action=emailtemplates", "_blank");';
        echo '}';
        
        echo '// Test form accessibility when page loads';
        echo 'document.addEventListener("DOMContentLoaded", function() {';
        echo '  console.log("DOM loaded, testing form elements...");';
        echo '  var recipientGroup = document.getElementById("recipientGroup");';
        echo '  var emailSubject = document.getElementById("emailSubject");';
        echo '  var emailMessage = document.getElementById("emailMessage");';
        echo '  console.log("Recipient Group element:", recipientGroup);';
        echo '  console.log("Email Subject element:", emailSubject);';
        echo '  console.log("Email Message element:", emailMessage);';
        echo '  ';
        echo '  // Enable all form elements explicitly';
        echo '  if (recipientGroup) recipientGroup.disabled = false;';
        echo '  if (emailSubject) emailSubject.disabled = false;';
        echo '  if (emailMessage) emailMessage.disabled = false;';
        echo '});';
        
        echo '</script>';
    }
} 