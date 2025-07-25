<?php
/**
 * SportPrograms Module Menu Registration
 * 
 * This file registers the SportPrograms module with SuiteCRM's
 * navigation system and defines menu items.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $mod_strings;

$module_menu = Array(
    Array(
        "index.php?module=SportPrograms&action=EditView&return_module=SportPrograms&return_action=index",
        $mod_strings['LNK_NEW_RECORD'],
        "CreateSportPrograms",
        'SportPrograms'
    ),
    Array(
        "index.php?module=SportPrograms&action=index",
        $mod_strings['LNK_LIST'],
        "SportPrograms",
        'SportPrograms'
    ),
); 