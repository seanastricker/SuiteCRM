<?php 
 //WARNING: The contents of this file are auto-generated


/**
 * Account Priority Level Edit View Definition
 * 
 * This file adds the Priority Level field to the edit view of the Accounts module.
 * The field will be placed in the Advanced panel near the annual_revenue field.
 * 
 * @package SuiteCRM
 * @subpackage Custom
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Add priority_level_c field to edit view in Advanced panel
// This will be processed by the Extension framework during Quick Repair
$viewdefs['Accounts']['EditView']['panels']['LBL_PANEL_ADVANCED'] = array(
    'priority_level_c' => array(
        'name' => 'priority_level_c',
        'label' => 'LBL_PRIORITY_LEVEL',
    ),
); 
?>