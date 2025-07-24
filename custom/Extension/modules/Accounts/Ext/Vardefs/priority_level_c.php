<?php
/**
 * Account Priority Level Custom Field
 * 
 * This extension adds a custom Priority Level dropdown field to the Accounts module.
 * Priority levels are: High, Medium, Low, Unassigned
 * 
 * @package SuiteCRM
 * @subpackage Custom
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$dictionary['Account']['fields']['priority_level_c'] = array(
    'name' => 'priority_level_c',
    'vname' => 'LBL_PRIORITY_LEVEL',
    'type' => 'enum',
    'options' => 'account_priority_levels_list',
    'len' => 50,
    'comment' => 'Account priority level based on annual revenue and other factors',
    'merge_filter' => 'disabled',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'required' => false,
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
); 