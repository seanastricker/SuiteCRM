<?php
/**
 * Feature 2: Simple Volunteer-Program Matching
 * Controller for the VolunteerMatching module
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/Controller/SugarController.php');

class VolunteerMatchingController extends SugarController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function action_MatchingDashboard()
    {
        $this->view = 'matchingdashboard';
    }
    
    public function action_index()
    {
        // Default action goes directly to our dashboard
        $this->view = 'matchingdashboard';
    }
    
    public function action_ListView()
    {
        // If someone specifically wants the list view, redirect to dashboard
        $this->view = 'matchingdashboard';
    }
    
    protected function action_default()
    {
        // All default actions go to our dashboard
        $this->view = 'matchingdashboard';
    }
} 