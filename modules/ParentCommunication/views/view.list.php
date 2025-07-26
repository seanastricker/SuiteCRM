<?php
/**
 * Feature 4: Basic Parent Notification System
 * List view for the ParentCommunication module - redirects to dashboard
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Include the dashboard view directly
require_once('modules/ParentCommunication/views/view.communicationdashboard.php');

class ParentCommunicationViewList extends ParentCommunicationViewCommunicationdashboard
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function display()
    {
        // Use the same display logic as the dashboard
        parent::display();
    }
} 