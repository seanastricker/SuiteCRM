<?php

/**
 * Equipment Module - Sports Equipment Management
 * 
 * Manages equipment inventory, check-out/return workflows, and tracking
 * for youth sports league operations.
 * 
 * @author SuiteCRM Development Team
 * @package Equipment
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('data/SugarBean.php');

/**
 * Equipment SugarBean class
 * 
 * Handles basic equipment data operations and relationships.
 * Business logic is separated into EquipmentHelper class to prevent memory issues.
 */
class Equipment extends SugarBean
{
    public $table_name = 'equipment';
    public $object_name = 'Equipment';
    public $module_dir = 'Equipment';
    public $new_schema = true;
    public $importable = true;
    public $disable_row_level_security = true;

    /**
     * Default constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get equipment summary for dashboard display
     */
    public function getEquipmentSummary()
    {
        // Delegate to helper class to avoid memory issues
        require_once('modules/Equipment/EquipmentHelper.php');
        return EquipmentHelper::getEquipmentSummary();
    }
} 