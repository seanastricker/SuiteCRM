<?php
/**
 * Feature 3: Basic Incident Reporting
 * List view for the IncidentReporting module - redirects to dashboard
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Include the dashboard view directly
require_once('modules/IncidentReporting/views/view.reportingdashboard.php');

class IncidentReportingViewList extends IncidentReportingViewReportingdashboard
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