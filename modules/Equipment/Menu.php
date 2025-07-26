<?php

/**
 * Equipment Module Menu
 * 
 * Defines navigation menu items for the Equipment module.
 * 
 * @author SuiteCRM Development Team
 * @package Equipment
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $module_menu;

$module_menu = array(
    array(
        'index.php?module=Equipment&action=equipmentdashboard',
        $mod_strings['LNK_EQUIPMENT_DASHBOARD'],
        'Equipment',
        'Equipment'
    ),
    array(
        'index.php?module=Equipment&action=equipmentdashboard',
        $mod_strings['LNK_EQUIPMENT_CHECKOUT'],
        'Equipment',
        'Equipment'
    ),
); 