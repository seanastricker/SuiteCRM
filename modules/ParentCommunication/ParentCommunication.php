<?php
/**
 * Feature 4: Basic Parent Notification System
 * Main bean class for the ParentCommunication module
 * 
 * This bean represents parent communication management in the youth sports league system.
 * Business logic is separated into ParentCommunicationHelper.php to prevent memory issues.
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('data/SugarBean.php');

class ParentCommunication extends SugarBean
{
    public $table_name = 'parent_communications';
    public $object_name = 'ParentCommunication';
    public $module_dir = 'ParentCommunication';
    public $module_name = 'ParentCommunication';
    
    public $id;
    public $name;
    public $date_entered;
    public $date_modified;
    public $created_by;
    public $modified_user_id;
    public $deleted;
    
    // Communication-specific fields
    public $communication_type;
    public $subject;
    public $message;
    public $template_used;
    public $recipient_count;
    public $sent_date;
    public $sent_by;
    public $status;
    
    public function __construct()
    {
        parent::__construct();
        $this->disable_row_level_security = true;
    }
} 