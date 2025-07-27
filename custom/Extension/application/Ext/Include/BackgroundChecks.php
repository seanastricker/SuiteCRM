<?php
/**
 * BackgroundChecks Module Registration
 * 
 * This file registers the BackgroundChecks module with SuiteCRM's core system.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Register the module bean
$beanFiles['BackgroundChecks'] = 'custom/modules/BackgroundChecks/BackgroundChecks.php';
$beanList['BackgroundChecks'] = 'BackgroundChecks';

// Add to module list
$moduleList[] = 'BackgroundChecks'; 