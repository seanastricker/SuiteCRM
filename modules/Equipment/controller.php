<?php

/**
 * Equipment Module Controller
 * 
 * Handles routing and action delegation for the Equipment module.
 * Routes all main actions to the equipment dashboard.
 * 
 * @author SuiteCRM Development Team
 * @package Equipment
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/Controller/SugarController.php');

/**
 * Equipment Controller Class
 */
class EquipmentController extends SugarController
{
    /**
     * Default action - redirect to dashboard
     */
    public function action_index()
    {
        $this->action_equipmentdashboard();
    }
    
    /**
     * ListView action - redirect to dashboard
     */
    public function action_ListView()
    {
        $this->action_equipmentdashboard();
    }
    
    /**
     * Default fallback - redirect to dashboard
     */
    public function action_default()
    {
        $this->action_equipmentdashboard();
    }
    
    /**
     * Equipment Dashboard action
     */
    public function action_equipmentdashboard()
    {
        $this->view = 'equipmentdashboard';
    }
} 