<?php
/**
 * Feature 3: Basic Incident Reporting
 * Controller for the IncidentReporting module
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/Controller/SugarController.php');

class IncidentReportingController extends SugarController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function action_ReportingDashboard()
    {
        $this->view = 'reportingdashboard';
    }
    
    public function action_index()
    {
        // Default action goes directly to our dashboard
        $this->view = 'reportingdashboard';
    }
    
    public function action_ListView()
    {
        // If someone specifically wants the list view, redirect to dashboard
        $this->view = 'reportingdashboard';
    }
    
    protected function action_default()
    {
        // All default actions go to our dashboard
        $this->view = 'reportingdashboard';
    }
} 