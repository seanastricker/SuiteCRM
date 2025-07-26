<?php
/**
 * Feature 3: Basic Incident Reporting
 * Main bean class for the IncidentReporting module
 * 
 * This bean represents safety incidents in the youth sports league system.
 * Business logic is separated into IncidentReportingHelper.php to prevent memory issues.
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('data/SugarBean.php');

class IncidentReporting extends SugarBean
{
    public $table_name = 'safety_incidents';
    public $object_name = 'IncidentReporting';
    public $module_dir = 'IncidentReporting';
    public $module_name = 'IncidentReporting';
    
    public $id;
    public $name;
    public $date_entered;
    public $date_modified;
    public $created_by;
    public $modified_user_id;
    public $deleted;
    
    // Incident-specific fields
    public $incident_date;
    public $incident_time;
    public $program_name;
    public $child_name;
    public $child_age;
    public $incident_type;
    public $severity_level;
    public $incident_description;
    public $immediate_action;
    public $incident_status;
    public $reporter_name;
    public $reporter_role;
    public $medical_attention;
    public $parent_notified;
    public $followup_required;
    public $followup_notes;
    
    public function __construct()
    {
        parent::__construct();
        $this->disable_row_level_security = true;
    }
} 