<?php
/**
 * Background Check Monitor Logic Hook
 * 
 * This class implements automatic background check status calculation for
 * Youth Sports League volunteer management. Monitors expiration dates and
 * automatically updates status based on current date and business rules.
 * 
 * Status Rules:
 * - Valid: Expiration date > 30 days from now
 * - Expiring: Expiration date within 30 days
 * - Expired: Expiration date has passed
 * - Pending: No expiration date set for volunteers
 * - Not Required: Non-volunteer contacts
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class BackgroundCheckMonitor
{
    /**
     * Monitor and update background check status for contacts
     * 
     * This method runs before the contact is saved and automatically
     * calculates the background check status based on expiration date
     * and contact type.
     * 
     * @param SugarBean $bean The contact bean being saved
     * @param string $event The hook event (before_save)
     * @param array $arguments Additional hook arguments
     * @return void
     */
    public function updateBackgroundCheckStatus($bean, $event, $arguments)
    {
        global $sugar_config;
        
        // Only process Contact beans
        if ($bean->module_name !== 'Contacts') {
            return;
        }
        
        // Get contact type - determine if background check is required
        $contact_type = $bean->contact_type_c;
        $requires_background_check = $this->requiresBackgroundCheck($contact_type);
        
        // If background check not required, set status and return
        if (!$requires_background_check) {
            $bean->background_check_status_c = 'not_required';
            $this->logStatusUpdate($bean, 'not_required', 'Contact type does not require background check');
            return;
        }
        
        // Get expiration date
        $expiration_date = $bean->background_check_expiration_c;
        
        // Calculate status based on expiration date
        $new_status = $this->calculateStatus($expiration_date);
        
        // Update the status field
        $old_status = $bean->background_check_status_c;
        $bean->background_check_status_c = $new_status;
        
        // Log the status change for tracking
        if ($old_status !== $new_status) {
            $this->logStatusUpdate($bean, $new_status, "Status changed from '{$old_status}' to '{$new_status}'");
        }
    }
    
    /**
     * Determine if contact type requires background check
     * 
     * @param string $contact_type The contact type value
     * @return bool True if background check is required
     */
    private function requiresBackgroundCheck($contact_type)
    {
        // Contact types that require background checks
        $requires_check = array(
            'volunteer',
            'staff',
            'board_member',
            'coach',
            'official'
        );
        
        return in_array($contact_type, $requires_check);
    }
    
    /**
     * Calculate background check status based on expiration date
     * 
     * @param string $expiration_date The expiration date (YYYY-MM-DD format)
     * @return string The calculated status
     */
    private function calculateStatus($expiration_date)
    {
        // If no expiration date set, status is pending
        if (empty($expiration_date)) {
            return 'pending';
        }
        
        // Parse expiration date
        $expiration_timestamp = strtotime($expiration_date);
        if ($expiration_timestamp === false) {
            // Invalid date format
            return 'pending';
        }
        
        $current_timestamp = time();
        $days_until_expiration = ($expiration_timestamp - $current_timestamp) / (24 * 60 * 60);
        
        // Determine status based on days until expiration
        if ($days_until_expiration < 0) {
            // Already expired
            return 'expired';
        } elseif ($days_until_expiration <= 30) {
            // Expiring within 30 days
            return 'expiring';
        } else {
            // Valid for more than 30 days
            return 'valid';
        }
    }
    
    /**
     * Get list of contacts with expiring background checks
     * 
     * This method can be called by scheduled jobs to identify contacts
     * needing background check renewal reminders.
     * 
     * @param int $days_warning Number of days before expiration to warn (default: 30)
     * @return array Array of contact IDs with expiring checks
     */
    public static function getExpiringBackgroundChecks($days_warning = 30)
    {
        global $db;
        
        $warning_date = date('Y-m-d', strtotime("+{$days_warning} days"));
        $current_date = date('Y-m-d');
        
        $query = "
            SELECT id, first_name, last_name, email1, background_check_expiration_c 
            FROM contacts 
            WHERE deleted = 0 
            AND contact_type_c IN ('volunteer', 'staff', 'board_member', 'coach', 'official')
            AND background_check_expiration_c IS NOT NULL 
            AND background_check_expiration_c != ''
            AND background_check_expiration_c BETWEEN '{$current_date}' AND '{$warning_date}'
            ORDER BY background_check_expiration_c ASC
        ";
        
        $result = $db->query($query);
        $expiring_contacts = array();
        
        while ($row = $db->fetchByAssoc($result)) {
            $expiring_contacts[] = $row;
        }
        
        return $expiring_contacts;
    }
    
    /**
     * Log background check status updates for tracking and debugging
     * 
     * @param SugarBean $contact The contact bean
     * @param string $new_status The new status being set
     * @param string $reason Reason for the status change
     * @return void
     */
    private function logStatusUpdate($contact, $new_status, $reason)
    {
        $contact_name = trim($contact->first_name . ' ' . $contact->last_name);
        if (empty($contact_name)) {
            $contact_name = 'Unknown Contact';
        }
        
        $GLOBALS['log']->info(
            "BackgroundCheckMonitor: Updated status for contact '{$contact_name}' (ID: {$contact->id}) " .
            "to '{$new_status}'. Reason: {$reason}"
        );
    }
} 