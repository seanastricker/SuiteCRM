<?php
/**
 * Feature 2: Simple Volunteer-Program Matching
 * Main bean class for the VolunteerMatching module
 * 
 * Simplified bean to prevent memory issues
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('data/SugarBean.php');

class VolunteerMatching extends SugarBean
{
    /**
     * Module properties
     */
    public $module_dir = 'VolunteerMatching';
    public $object_name = 'VolunteerMatching';
    public $table_name = 'volunteer_matching';
    public $new_schema = true;
    public $module_name = 'VolunteerMatching';
    public $importable = false;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
} 