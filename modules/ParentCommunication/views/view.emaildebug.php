<?php
/**
 * ParentCommunication Module - Email Debug View
 * 
 * This view helps debug email sending issues by providing detailed
 * information about recipients, SMTP configuration, and sending process.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/View/SugarView.php');

class ParentCommunicationViewEmaildebug extends SugarView
{
    public function display()
    {
        echo '<div style="padding: 20px;">';
        echo '<h2>🔍 Email System Debug Information</h2>';
        
        // Test 1: Check SMTP Configuration
        echo '<div style="background: #f8f9fa; padding: 15px; margin: 15px 0; border-radius: 5px;">';
        echo '<h3>📧 SMTP Configuration Test</h3>';
        $this->testSMTPConfig();
        echo '</div>';
        
        // Test 2: Check Contact Selection
        echo '<div style="background: #f8f9fa; padding: 15px; margin: 15px 0; border-radius: 5px;">';
        echo '<h3>👥 Contact Selection Test</h3>';
        $this->testContactSelection();
        echo '</div>';
        
        // Test 3: Send Test Email
        echo '<div style="background: #f8f9fa; padding: 15px; margin: 15px 0; border-radius: 5px;">';
        echo '<h3>✉️ Single Email Test</h3>';
        $this->testSingleEmail();
        echo '</div>';
        
        // Test 4: Check Email Fields
        echo '<div style="background: #f8f9fa; padding: 15px; margin: 15px 0; border-radius: 5px;">';
        echo '<h3>📋 Contact Email Fields Test</h3>';
        $this->testContactEmailFields();
        echo '</div>';
        
        echo '<p><a href="index.php?module=ParentCommunication&action=emailcompose" style="color: #007cba;">← Back to Email Composition</a></p>';
        echo '</div>';
    }
    
    /**
     * Test SMTP configuration
     */
    private function testSMTPConfig()
    {
        try {
            echo '<p><strong>Testing SMTP Configuration...</strong></p>';
            
            // Check admin settings directly - most reliable method
            require_once('data/BeanFactory.php');
            $admin = BeanFactory::newBean('Administration');
            $admin->retrieveSettings();
            
            echo '<p>🔍 Checking system email settings...</p>';
            echo '<p>📧 System Email: ' . htmlspecialchars($admin->settings['notify_fromaddress']) . '</p>';
            echo '<p>📤 System Name: ' . htmlspecialchars($admin->settings['notify_fromname']) . '</p>';
            echo '<p>🌐 SMTP Server: ' . htmlspecialchars($admin->settings['mail_smtpserver']) . '</p>';
            echo '<p>🔌 SMTP Port: ' . htmlspecialchars($admin->settings['mail_smtpport']) . '</p>';
            echo '<p>👤 SMTP User: ' . htmlspecialchars($admin->settings['mail_smtpuser']) . '</p>';
            echo '<p>🔒 SMTP Auth: ' . ($admin->settings['mail_smtpauth_req'] ? 'Required' : 'Not Required') . '</p>';
            echo '<p>🔐 SMTP SSL: ' . htmlspecialchars($admin->settings['mail_smtpssl']) . '</p>';
            
            // Check if configuration is complete
            $smtp_server = $admin->settings['mail_smtpserver'];
            $smtp_port = $admin->settings['mail_smtpport'];
            $from_email = $admin->settings['notify_fromaddress'];
            
            if (!empty($smtp_server) && !empty($smtp_port) && !empty($from_email)) {
                echo '<p>✅ SMTP configuration appears complete</p>';
            } else {
                echo '<p>❌ SMTP configuration appears incomplete</p>';
                
                if (empty($smtp_server)) echo '<p>⚠️ Missing SMTP Server</p>';
                if (empty($smtp_port)) echo '<p>⚠️ Missing SMTP Port</p>';
                if (empty($from_email)) echo '<p>⚠️ Missing From Email Address</p>';
            }
            
        } catch (Exception $e) {
            echo '<p>❌ SMTP Configuration Error: ' . $e->getMessage() . '</p>';
        }
    }
    
    /**
     * Test contact selection
     */
    private function testContactSelection()
    {
        try {
            require_once('data/BeanFactory.php');
            $contact = BeanFactory::newBean('Contacts');
            
            if (!$contact) {
                echo '<p>❌ Could not create Contact bean</p>';
                return;
            }
            
            echo '<p><strong>Testing Contact Selection...</strong></p>';
            
            // Test basic contact query
            $query = "SELECT COUNT(*) as count FROM contacts WHERE deleted = 0";
            $result = $contact->db->query($query);
            $row = $contact->db->fetchByAssoc($result);
            echo '<p>📊 Total Contacts: ' . ($row['count'] ? $row['count'] : 0) . '</p>';
            
            // Debug: Show actual contact types in database
            $query = "SELECT DISTINCT contact_type_c, COUNT(*) as count FROM contacts WHERE deleted = 0 GROUP BY contact_type_c";
            $result = $contact->db->query($query);
            echo '<p>🔍 <strong>Contact Types in Database:</strong></p>';
            while ($row = $contact->db->fetchByAssoc($result)) {
                $type = $row['contact_type_c'] ? $row['contact_type_c'] : '(empty)';
                echo '<p>   • ' . htmlspecialchars($type) . ': ' . $row['count'] . ' contacts</p>';
            }
            
            // Test parent contacts (try different possible values)
            $parent_queries = [
                "contact_type_c = 'parent'" => 'parent',
                "contact_type_c = 'Parent'" => 'Parent', 
                "contact_type_c = 'parent_guardian'" => 'parent_guardian',
                "contact_type_c = 'Parent/Guardian'" => 'Parent/Guardian',
                "contact_type_c LIKE '%parent%'" => 'containing "parent"'
            ];
            
            foreach ($parent_queries as $where_clause => $description) {
                $query = "SELECT COUNT(*) as count FROM contacts WHERE deleted = 0 AND " . $where_clause;
                $result = $contact->db->query($query);
                $row = $contact->db->fetchByAssoc($result);
                if ($row['count'] > 0) {
                    echo '<p>👨‍👩‍👧‍👦 Parent Contacts (' . $description . '): ' . $row['count'] . '</p>';
                }
            }
            
            // Test email opt-in contacts
            $query = "SELECT COUNT(*) as count FROM contacts WHERE deleted = 0 AND email_communication_opt_in_c = 1";
            $result = $contact->db->query($query);
            $row = $contact->db->fetchByAssoc($result);
            echo '<p>✅ Email Opt-in Contacts: ' . ($row['count'] ? $row['count'] : 0) . '</p>';
            
            // Test contacts with email addresses
            $query = "SELECT COUNT(*) as count FROM contacts WHERE deleted = 0 AND email1 IS NOT NULL AND email1 != ''";
            $result = $contact->db->query($query);
            $row = $contact->db->fetchByAssoc($result);
            echo '<p>📧 Contacts with Email Addresses: ' . ($row['count'] ? $row['count'] : 0) . '</p>';
            
            // Debug: Show specific contact details
            $query = "SELECT id, first_name, last_name, email1, contact_type_c, email_communication_opt_in_c FROM contacts WHERE deleted = 0 AND (first_name LIKE '%Sean%' OR last_name LIKE '%Stricker%')";
            $result = $contact->db->query($query);
            echo '<p>🔍 <strong>Sean Stricker Contact Details:</strong></p>';
            while ($row = $contact->db->fetchByAssoc($result)) {
                echo '<p>   • Name: ' . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . '</p>';
                echo '<p>   • Email: ' . htmlspecialchars($row['email1']) . '</p>';
                echo '<p>   • Type: ' . htmlspecialchars($row['contact_type_c']) . '</p>';
                echo '<p>   • Opt-in: ' . ($row['email_communication_opt_in_c'] ? 'Yes' : 'No') . '</p>';
            }
            
            // Test the exact query used by email composition (with corrected contact type)
            $where = "contacts.deleted = 0 AND contacts.email_communication_opt_in_c = 1 AND contacts.email1 IS NOT NULL AND contacts.email1 != ''";
            $contacts = $contact->get_full_list("last_name, first_name", $where);
            
            echo '<p>🎯 <strong>Contacts matching email criteria:</strong></p>';
            if ($contacts) {
                echo '<ul>';
                foreach ($contacts as $c) {
                    echo '<li>' . htmlspecialchars(trim($c->first_name . ' ' . $c->last_name)) . ' - ' . htmlspecialchars($c->email1) . ' (Type: ' . htmlspecialchars($c->contact_type_c) . ')</li>';
                }
                echo '</ul>';
                echo '<p>✅ Found ' . count($contacts) . ' contacts ready for email</p>';
            } else {
                echo '<p>❌ No contacts found matching email criteria</p>';
            }
            
        } catch (Exception $e) {
            echo '<p>❌ Contact Selection Error: ' . $e->getMessage() . '</p>';
        }
    }
    
    /**
     * Test sending a single email
     */
    private function testSingleEmail()
    {
        try {
            require_once('include/SugarPHPMailer.php');
            require_once('data/BeanFactory.php');
            
            echo '<p><strong>Testing Single Email Send...</strong></p>';
            
            // Get one contact with email
            $contact = BeanFactory::newBean('Contacts');
            $where = "contacts.deleted = 0 AND contacts.email1 IS NOT NULL AND contacts.email1 != ''";
            $contacts = $contact->get_full_list("last_name, first_name", $where, 0, 1);
            
            if (!$contacts || empty($contacts)) {
                echo '<p>❌ No contacts with email addresses found for testing</p>';
                return;
            }
            
            $test_contact = $contacts[0];
            echo '<p>🎯 Test Recipient: ' . htmlspecialchars(trim($test_contact->first_name . ' ' . $test_contact->last_name)) . ' (' . htmlspecialchars($test_contact->email1) . ')</p>';
            
            // Use SugarPHPMailer for sending
            $mail = new SugarPHPMailer();
            echo '<p>✅ SugarPHPMailer instantiated</p>';
            
            // Get admin settings for SMTP
            require_once('data/BeanFactory.php');
            $admin = BeanFactory::newBean('Administration');
            $admin->retrieveSettings();
            
            // Configure SMTP
            $mail->isSMTP();
            $mail->Host = $admin->settings['mail_smtpserver'];
            $mail->Port = $admin->settings['mail_smtpport'];
            $mail->SMTPAuth = true;
            $mail->Username = $admin->settings['mail_smtpuser'];
            $mail->Password = $admin->settings['mail_smtppass'];
            $mail->SMTPSecure = $admin->settings['mail_smtpssl'];
            
            echo '<p>✅ SMTP configuration applied</p>';
            
            // Set email content
            $mail->setFrom($admin->settings['notify_fromaddress'], $admin->settings['notify_fromname']);
            $mail->addAddress($test_contact->email1, trim($test_contact->first_name . ' ' . $test_contact->last_name));
            $mail->Subject = 'SuiteCRM Email Test - ' . date('Y-m-d H:i:s');
            $mail->Body = 'This is a test email from SuiteCRM Parent Communications.\n\nTime: ' . date('Y-m-d H:i:s') . '\nTest Contact: ' . trim($test_contact->first_name . ' ' . $test_contact->last_name);
            
            echo '<p>📧 Email content set</p>';
            echo '<p>📤 Attempting to send email...</p>';
            
            // Attempt to send
            if ($mail->send()) {
                echo '<p>✅ <strong>Email sent successfully!</strong></p>';
                echo '<p>📧 Check the email address: ' . htmlspecialchars($test_contact->email1) . '</p>';
            } else {
                echo '<p>❌ Email send failed</p>';
                echo '<p>Error: ' . $mail->ErrorInfo . '</p>';
            }
            
        } catch (Exception $e) {
            echo '<p>❌ Single Email Test Error: ' . $e->getMessage() . '</p>';
            echo '<p>Debug: ' . $e->getTraceAsString() . '</p>';
        }
    }
    
    /**
     * Test contact email fields
     */
    private function testContactEmailFields()
    {
        try {
            require_once('data/BeanFactory.php');
            $contact = BeanFactory::newBean('Contacts');
            
            echo '<p><strong>Testing Contact Email Fields...</strong></p>';
            
            // Get all your test contacts
            $query = "SELECT id, first_name, last_name, email1, contact_type_c, email_communication_opt_in_c, preferred_communication_method_c, email_notification_preferences_c FROM contacts WHERE deleted = 0 ORDER BY date_entered DESC LIMIT 15";
            $result = $contact->db->query($query);
            
            echo '<table style="border-collapse: collapse; width: 100%; font-size: 12px;">';
            echo '<tr style="background: #f0f0f0;">';
            echo '<th style="border: 1px solid #ddd; padding: 6px;">Name</th>';
            echo '<th style="border: 1px solid #ddd; padding: 6px;">Email</th>';
            echo '<th style="border: 1px solid #ddd; padding: 6px;">Type</th>';
            echo '<th style="border: 1px solid #ddd; padding: 6px;">Opt-in</th>';
            echo '<th style="border: 1px solid #ddd; padding: 6px;">Pref Comm</th>';
            echo '<th style="border: 1px solid #ddd; padding: 6px;">Email Notif</th>';
            echo '<th style="border: 1px solid #ddd; padding: 6px;">Status</th>';
            echo '</tr>';
            
            while ($row = $contact->db->fetchByAssoc($result)) {
                $name = trim($row['first_name'] . ' ' . $row['last_name']);
                $email = $row['email1'];
                $type = $row['contact_type_c'];
                $opt_in = $row['email_communication_opt_in_c'];
                $pref_comm = $row['preferred_communication_method_c'];
                $email_notif = $row['email_notification_preferences_c'];
                
                $status = '';
                if (empty($email)) {
                    $status = '❌ No Email';
                } elseif (!$opt_in) {
                    $status = '⚠️ Not Opted In';
                } else {
                    $status = '✅ Ready';
                }
                
                echo '<tr>';
                echo '<td style="border: 1px solid #ddd; padding: 6px;">' . htmlspecialchars($name) . '</td>';
                echo '<td style="border: 1px solid #ddd; padding: 6px;">' . htmlspecialchars($email) . '</td>';
                echo '<td style="border: 1px solid #ddd; padding: 6px;">' . htmlspecialchars($type) . '</td>';
                echo '<td style="border: 1px solid #ddd; padding: 6px;">' . ($opt_in ? 'Yes' : 'No') . '</td>';
                echo '<td style="border: 1px solid #ddd; padding: 6px;">' . htmlspecialchars($pref_comm) . '</td>';
                echo '<td style="border: 1px solid #ddd; padding: 6px;">' . htmlspecialchars($email_notif) . '</td>';
                echo '<td style="border: 1px solid #ddd; padding: 6px;">' . $status . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            
        } catch (Exception $e) {
            echo '<p>❌ Email Fields Test Error: ' . $e->getMessage() . '</p>';
        }
    }
} 