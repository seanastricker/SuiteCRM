<?php
/**
 * Feature 2: Simple Volunteer-Program Matching
 * Index view for the VolunteerMatching module - shows dashboard directly
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Include the dashboard view directly
require_once('modules/VolunteerMatching/views/view.matchingdashboard.php');

class VolunteerMatchingViewIndex extends VolunteerMatchingViewMatchingdashboard
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