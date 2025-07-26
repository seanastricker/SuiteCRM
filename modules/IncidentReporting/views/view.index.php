<?php
/**
 * Feature 3: Basic Incident Reporting
 * Index view for the IncidentReporting module - shows dashboard directly
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Include the dashboard view directly
require_once('modules/IncidentReporting/views/view.reportingdashboard.php');

class IncidentReportingViewIndex extends IncidentReportingViewReportingdashboard
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