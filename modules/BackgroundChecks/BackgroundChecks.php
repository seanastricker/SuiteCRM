<?php
/**
 * BackgroundChecks Module - Main Bean Class
 * 
 * This module manages background check tracking for youth sports league volunteers.
 * It tracks expiration dates, status, and provides automated monitoring and alerts.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 * @author Youth Sports League CRM
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('data/SugarBean.php');

class BackgroundChecks extends SugarBean
{
    // Module Properties
    public $module_name = 'BackgroundChecks';
    public $module_dir = 'BackgroundChecks';
    public $object_name = 'BackgroundChecks';
    public $table_name = 'background_checks';
    public $new_schema = true;
    public $process_save_dates = true;
    public $importable = true;
    public $disable_row_level_security = true;

    // Standard SugarBean Fields
    public $id;
    public $name;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $modified_by_name;
    public $created_by;
    public $created_by_name;
    public $description;
    public $deleted;
    public $assigned_user_id;
    public $assigned_user_name;
    
    // Custom Fields for Background Checks
    public $volunteer_id_c;
    public $volunteer_name_c;
    public $background_check_type_c;
    public $check_date_c;
    public $expiration_date_c;
    public $status_c;
    public $provider_c;
    public $certificate_number_c;
    public $cost_c;
    public $notes_c;
    public $renewal_reminder_sent_c;
    public $auto_calculated_status_c;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Before save hook to auto-generate name and calculate status
     */
    public function save($check_notify = false)
    {
        // Auto-generate name if empty
        if (empty($this->name)) {
            $volunteer_name = !empty($this->volunteer_name_c) ? $this->volunteer_name_c : 'Unknown Volunteer';
            $check_type = !empty($this->background_check_type_c) ? $this->background_check_type_c : 'Background Check';
            $expiration = !empty($this->expiration_date_c) ? $this->expiration_date_c : 'No Expiration';
            
            $this->name = "{$volunteer_name} - {$check_type} (Expires: {$expiration})";
        }
        
        // Auto-calculate status based on expiration date
        $this->auto_calculated_status_c = $this->calculateStatus();
        
        return parent::save($check_notify);
    }

    /**
     * Calculate background check status based on expiration date
     * 
     * @return string The calculated status
     */
    public function calculateStatus()
    {
        if (empty($this->expiration_date_c)) {
            return 'pending';
        }
        
        $expiration_timestamp = strtotime($this->expiration_date_c);
        if ($expiration_timestamp === false) {
            return 'pending';
        }
        
        $current_timestamp = time();
        $days_until_expiration = ($expiration_timestamp - $current_timestamp) / (24 * 60 * 60);
        
        if ($days_until_expiration < 0) {
            return 'expired';
        } elseif ($days_until_expiration <= 30) {
            return 'expiring';
        } else {
            return 'valid';
        }
    }

    /**
     * Get all background checks expiring within specified days
     * 
     * @param int $days_warning Number of days before expiration
     * @return array Array of expiring background checks
     */
    public static function getExpiringChecks($days_warning = 30)
    {
        global $db;
        
        $warning_date = date('Y-m-d', strtotime("+{$days_warning} days"));
        $current_date = date('Y-m-d');
        
        $query = "
            SELECT bc.*, c.first_name, c.last_name, c.email1
            FROM background_checks bc
            LEFT JOIN contacts c ON bc.volunteer_id_c = c.id
            WHERE bc.deleted = 0 
            AND bc.expiration_date_c IS NOT NULL 
            AND bc.expiration_date_c != ''
            AND bc.expiration_date_c BETWEEN '{$current_date}' AND '{$warning_date}'
            ORDER BY bc.expiration_date_c ASC
        ";
        
        $result = $db->query($query);
        $expiring_checks = array();
        
        while ($row = $db->fetchByAssoc($result)) {
            $expiring_checks[] = $row;
        }
        
        return $expiring_checks;
    }

    /**
     * Get total cost of background checks for reporting
     * 
     * @param string $start_date Optional start date for filtering
     * @param string $end_date Optional end date for filtering
     * @return float Total cost
     */
    public static function getTotalCost($start_date = null, $end_date = null)
    {
        global $db;
        
        $query = "SELECT SUM(cost_c) as total_cost FROM background_checks WHERE deleted = 0";
        
        if ($start_date && $end_date) {
            $query .= " AND check_date_c BETWEEN '{$start_date}' AND '{$end_date}'";
        }
        
        $result = $db->query($query);
        $row = $db->fetchByAssoc($result);
        
        return $row['total_cost'] ? (float)$row['total_cost'] : 0.0;
    }

    /**
     * Bean Details
     */
    public function bean_implements($interface)
    {
        switch($interface) {
            case 'ACL':
                return true;
        }
        return false;
    }
} 