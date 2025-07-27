<?php
/**
 * VolunteerHours Module - Main Bean Class
 * 
 * This module tracks volunteer hours for youth sports league volunteers.
 * It allows logging of volunteer time and generates recognition reports.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 * @author Youth Sports League CRM
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('data/SugarBean.php');

class VolunteerHours extends SugarBean
{
    // Module Properties
    public $module_name = 'VolunteerHours';
    public $module_dir = 'VolunteerHours';
    public $object_name = 'VolunteerHours';
    public $table_name = 'volunteerhours';
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
    
    // Custom Fields for Volunteer Hours
    public $volunteer_id_c;
    public $volunteer_name_c;
    public $activity_date_c;
    public $hours_logged_c;
    public $activity_type_c;
    public $program_name_c;
    public $activity_description_c;
    public $approval_status_c;
    public $approved_by_c;
    public $approved_date_c;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }



    /**
     * Get total hours for a specific volunteer
     * 
     * @param string $volunteer_id The contact ID of the volunteer
     * @return float Total hours logged
     */
    public function getTotalHoursForVolunteer($volunteer_id)
    {
        $query = "SELECT SUM(hours_logged_c) as total_hours 
                  FROM {$this->table_name} 
                  WHERE volunteer_id_c = '{$volunteer_id}' 
                  AND deleted = 0 
                  AND approval_status_c = 'approved'";
        
        $result = $this->db->query($query);
        $row = $this->db->fetchByAssoc($result);
        
        return $row['total_hours'] ? (float)$row['total_hours'] : 0;
    }

    /**
     * Get hours for a specific time period
     * 
     * @param string $volunteer_id The contact ID of the volunteer
     * @param string $start_date Start date (YYYY-MM-DD format)
     * @param string $end_date End date (YYYY-MM-DD format)
     * @return float Hours logged in the period
     */
    public function getHoursForPeriod($volunteer_id, $start_date, $end_date)
    {
        $query = "SELECT SUM(hours_logged_c) as total_hours 
                  FROM {$this->table_name} 
                  WHERE volunteer_id_c = '{$volunteer_id}' 
                  AND activity_date_c >= '{$start_date}' 
                  AND activity_date_c <= '{$end_date}' 
                  AND deleted = 0 
                  AND approval_status_c = 'approved'";
        
        $result = $this->db->query($query);
        $row = $this->db->fetchByAssoc($result);
        
        return $row['total_hours'] ? (float)$row['total_hours'] : 0;
    }

    /**
     * Get top volunteers by hours
     * 
     * @param int $limit Number of top volunteers to return
     * @param string $period Period filter (this_month, this_year, all_time)
     * @return array Array of volunteer data with hours
     */
    public function getTopVolunteers($limit = 10, $period = 'all_time')
    {
        $date_filter = '';
        
        switch ($period) {
            case 'this_month':
                $date_filter = "AND activity_date_c >= DATE_FORMAT(NOW(), '%Y-%m-01')";
                break;
            case 'this_year':
                $date_filter = "AND activity_date_c >= DATE_FORMAT(NOW(), '%Y-01-01')";
                break;
            default:
                // all_time - no additional filter
                break;
        }
        
        $query = "SELECT vh.volunteer_id_c, vh.volunteer_name_c, SUM(vh.hours_logged_c) as total_hours
                  FROM {$this->table_name} vh
                  WHERE vh.deleted = 0 
                  AND vh.approval_status_c = 'approved'
                  {$date_filter}
                  GROUP BY vh.volunteer_id_c, vh.volunteer_name_c
                  ORDER BY total_hours DESC
                  LIMIT {$limit}";
        
        $result = $this->db->query($query);
        $volunteers = array();
        
        while ($row = $this->db->fetchByAssoc($result)) {
            $volunteers[] = $row;
        }
        
        return $volunteers;
    }

    /**
     * Before save hook to set the name field
     */
    function save($check_notify = false)
    {
        // Set the name field for better display
        if (empty($this->name)) {
            $date = !empty($this->activity_date_c) ? $this->activity_date_c : date('Y-m-d');
            $volunteer = !empty($this->volunteer_name_c) ? $this->volunteer_name_c : 'Unknown Volunteer';
            $hours = !empty($this->hours_logged_c) ? $this->hours_logged_c : '0';
            
            $this->name = "{$volunteer} - {$hours} hours ({$date})";
        }
        
        return parent::save($check_notify);
    }
} 