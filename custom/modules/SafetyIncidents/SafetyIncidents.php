<?php
/**
 * SafetyIncidents Bean Class
 * Feature 3: Quick Incident Reporting Form
 * 
 * Main bean class for safety incident reporting in youth sports programs
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('data/SugarBean.php');

class SafetyIncidents extends SugarBean
{
    // Module Properties
    public $module_name = 'SafetyIncidents';
    public $module_dir = 'SafetyIncidents';
    public $object_name = 'SafetyIncidents';
    public $table_name = 'safety_incidents';
    public $new_schema = true;
    public $importable = true;
    public $disable_row_level_security = true;
    
    // Database Fields
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
    
    // Custom Fields
    public $incident_date_c;
    public $incident_time_c;
    public $program_name_c;
    public $child_name_c;
    public $child_age_c;
    public $incident_type_c;
    public $severity_level_c;
    public $incident_description_c;
    public $immediate_action_c;
    public $incident_status_c;
    public $reporter_name_c;
    public $reporter_role_c;
    public $medical_attention_c;
    public $parent_notified_c;
    public $followup_required_c;
    public $followup_notes_c;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Bean Details
     * @return array
     */
    public function bean_implements($interface)
    {
        switch($interface) {
            case 'ACL':
                return true;
        }
        return false;
    }

    /**
     * Get incident summary for list view display
     * @return string
     */
    public function get_summary_text()
    {
        $summary = '';
        if (!empty($this->incident_type_c)) {
            $summary .= $this->incident_type_c;
        }
        if (!empty($this->child_name_c)) {
            $summary .= ' - ' . $this->child_name_c;
        }
        if (!empty($this->incident_date_c)) {
            $summary .= ' (' . $this->incident_date_c . ')';
        }
        return $summary;
    }

    /**
     * Auto-populate name field for display
     */
    public function save($check_notify = false)
    {
        // Auto-generate name based on incident details
        if (empty($this->name)) {
            $this->name = $this->get_summary_text();
        }
        
        // Set default status if not set
        if (empty($this->incident_status_c)) {
            $this->incident_status_c = 'reported';
        }
        
        return parent::save($check_notify);
    }

    /**
     * Get incidents by status
     * @param string $status
     * @return array
     */
    public function get_incidents_by_status($status = '')
    {
        $query = "SELECT * FROM {$this->table_name} WHERE deleted = 0";
        
        if (!empty($status)) {
            $query .= " AND incident_status_c = " . $this->db->quoted($status);
        }
        
        $query .= " ORDER BY incident_date_c DESC, incident_time_c DESC";
        
        $result = $this->db->query($query);
        $incidents = array();
        
        while ($row = $this->db->fetchByAssoc($result)) {
            $incidents[] = $row;
        }
        
        return $incidents;
    }

    /**
     * Get recent incidents for dashboard
     * @param int $limit
     * @return array
     */
    public function get_recent_incidents($limit = 10)
    {
        $query = "SELECT * FROM {$this->table_name} 
                  WHERE deleted = 0 
                  ORDER BY date_entered DESC 
                  LIMIT " . (int)$limit;
        
        $result = $this->db->query($query);
        $incidents = array();
        
        while ($row = $this->db->fetchByAssoc($result)) {
            $incidents[] = $row;
        }
        
        return $incidents;
    }

    /**
     * Get incident statistics
     * @return array
     */
    public function get_incident_stats()
    {
        $stats = array();
        
        // Total incidents
        $query = "SELECT COUNT(*) as total FROM {$this->table_name} WHERE deleted = 0";
        $result = $this->db->query($query);
        $row = $this->db->fetchByAssoc($result);
        $stats['total'] = $row['total'];
        
        // By status
        $query = "SELECT incident_status_c, COUNT(*) as count 
                  FROM {$this->table_name} 
                  WHERE deleted = 0 
                  GROUP BY incident_status_c";
        $result = $this->db->query($query);
        
        $stats['by_status'] = array();
        while ($row = $this->db->fetchByAssoc($result)) {
            $stats['by_status'][$row['incident_status_c']] = $row['count'];
        }
        
        // By severity
        $query = "SELECT severity_level_c, COUNT(*) as count 
                  FROM {$this->table_name} 
                  WHERE deleted = 0 
                  GROUP BY severity_level_c";
        $result = $this->db->query($query);
        
        $stats['by_severity'] = array();
        while ($row = $this->db->fetchByAssoc($result)) {
            $stats['by_severity'][$row['severity_level_c']] = $row['count'];
        }
        
        return $stats;
    }
} 