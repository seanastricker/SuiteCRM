<?php
/**
 * Account Priority Levels Language Extensions
 * 
 * This file defines the dropdown options and language labels for the
 * custom Priority Level field in the Accounts module.
 * 
 * @package SuiteCRM
 * @subpackage Custom
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Dropdown list options for account priority levels
$app_list_strings['account_priority_levels_list'] = array(
    '' => '',
    'high' => 'High Priority',
    'medium' => 'Medium Priority', 
    'low' => 'Low Priority',
    'unassigned' => 'Unassigned',
);

// Language labels
$app_strings['LBL_PRIORITY_LEVEL'] = 'Priority Level'; 