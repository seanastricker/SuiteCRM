<?php
/**
 * Accounts Module Logic Hooks
 * 
 * This file registers custom logic hooks for the Accounts module.
 * 
 * @package SuiteCRM
 * @subpackage Custom
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$hook_version = 1;

$hook_array = array();

// Register the priority assignment hook to run before save
$hook_array['before_save'] = array();
$hook_array['before_save'][] = array(
    1,                                          // Processing order
    'Account Priority Assignment',              // Hook description
    'custom/modules/Accounts/AccountPriorityHook.php',  // Hook file path
    'AccountPriorityHook',                     // Hook class name
    'assignPriorityLevel'                      // Hook method name
);