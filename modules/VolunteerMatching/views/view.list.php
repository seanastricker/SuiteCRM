<?php
/**
 * Feature 2: Simple Volunteer-Program Matching
 * List view for the VolunteerMatching module - redirects to dashboard
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Include the dashboard view directly
require_once('modules/VolunteerMatching/views/view.matchingdashboard.php');

class VolunteerMatchingViewList extends VolunteerMatchingViewMatchingdashboard
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