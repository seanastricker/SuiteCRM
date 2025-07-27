<?php
/**
 * VolunteerHours Module - Controller
 * 
 * This controller handles custom actions for the VolunteerHours module.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/Controller/SugarController.php');

class VolunteerHoursController extends SugarController
{
    /**
     * Display the volunteer hours recognition dashboard
     */
    public function action_volunteerhoursrecognition()
    {
        $this->view = 'volunteerhoursrecognition';
    }
} 