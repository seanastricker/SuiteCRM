<?php
/**
 * Feature 4: Basic Parent Notification System
 * Controller for the ParentCommunication module
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/Controller/SugarController.php');

class ParentCommunicationController extends SugarController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function action_CommunicationDashboard()
    {
        $this->view = 'communicationdashboard';
    }
    
    public function action_index()
    {
        // Default action goes directly to our dashboard
        $this->view = 'communicationdashboard';
    }
    
    public function action_ListView()
    {
        // If someone specifically wants the list view, redirect to dashboard
        $this->view = 'communicationdashboard';
    }
    
    protected function action_default()
    {
        // All default actions go to our dashboard
        $this->view = 'communicationdashboard';
    }
} 