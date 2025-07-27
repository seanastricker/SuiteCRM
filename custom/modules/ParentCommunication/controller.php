<?php
/**
 * ParentCommunication Module - Enhanced Controller
 * 
 * This controller handles email composition, template management, and bulk email
 * functionality for parent communications.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/Controller/SugarController.php');

class ParentCommunicationController extends SugarController
{
    /**
     * Handle email composition action
     */
    public function action_emailcompose()
    {
        $this->view = 'emailcompose';
    }
    
    /**
     * Handle email template management action
     */
    public function action_emailtemplates()
    {
        $this->view = 'emailtemplates';
    }
    
    /**
     * Handle email sending action
     */
    public function action_sendemail()
    {
        $this->view = 'sendemail';
    }
    
    /**
     * Handle email history viewing action
     */
    public function action_emailhistory()
    {
        $this->view = 'emailhistory';
    }
    
    /**
     * Handle AJAX recipient loading
     */
    public function action_getrecipients()
    {
        $this->view = 'getrecipients';
    }
    
    /**
     * Handle AJAX template loading
     */
    public function action_loadtemplate()
    {
        $this->view = 'loadtemplate';
    }
    
    /**
     * Handle email debug action
     */
    public function action_emaildebug()
    {
        $this->view = 'emaildebug';
    }
} 