<?php
/**
 * BackgroundChecks Module - Controller
 * 
 * This controller handles custom actions for the BackgroundChecks module,
 * including the background check dashboard view.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/Controller/SugarController.php');

class BackgroundChecksController extends SugarController
{
    /**
     * Handle the background check dashboard action
     */
    public function action_backgroundcheckdashboard()
    {
        $this->view = 'backgroundcheckdashboard';
    }
} 