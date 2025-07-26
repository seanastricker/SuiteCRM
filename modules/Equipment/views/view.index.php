<?php

/**
 * Equipment Module - Index View
 * 
 * Redirects to the equipment dashboard for the main module view.
 * 
 * @author SuiteCRM Development Team
 * @package Equipment
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('modules/Equipment/views/view.equipmentdashboard.php');

/**
 * Equipment Index View Class
 */
class EquipmentViewIndex extends EquipmentViewEquipmentdashboard
{
    /**
     * Constructor - inherit from dashboard view
     */
    public function __construct()
    {
        parent::__construct();
    }
} 