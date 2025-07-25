<?php 
 //WARNING: The contents of this file are auto-generated


/**
 * SafetyIncidents Module Registration
 * Feature 3: Quick Incident Reporting Form
 * 
 * Registers SafetyIncidents module with SuiteCRM
 */

// TEMPORARILY DISABLED to avoid memory issues during repair
// Will implement as entry point dashboard instead
// Add to bean list
// $beanList['SafetyIncidents'] = 'SafetyIncidents';

// Add bean file path
// $beanFiles['SafetyIncidents'] = 'custom/modules/SafetyIncidents/SafetyIncidents.php';

// Add to module list for display
// $moduleList[] = 'SafetyIncidents'; 

/**
 * SportPrograms Module Registration - TEMPORARILY DISABLED
 * 
 * This file registers the SportPrograms module with SuiteCRM's
 * global module registry so it appears in the system.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// COMPLETELY DISABLED - SportPrograms causing memory issues
// Will implement Feature 2 using existing modules instead

// $beanList['SportPrograms'] = 'SportPrograms';
// $beanFiles['SportPrograms'] = 'custom/modules/SportPrograms/SportPrograms.php';
// $moduleList[] = 'SportPrograms'; 

/**
 * Feature 2: Simple Volunteer-Program Matching
 * Module registration for VolunteerMatching
 * 
 * Registers the VolunteerMatching module with SuiteCRM
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Add the VolunteerMatching module to the modules list
$moduleList[] = 'VolunteerMatching';

// Define the module bean mapping
$beanList['VolunteerMatching'] = 'VolunteerMatching';
$beanFiles['VolunteerMatching'] = 'modules/VolunteerMatching/VolunteerMatching.php';

// Add to module menu
$modInvisList[] = 'VolunteerMatching';

// Add to default module tabs (will appear in ALL tab)
$modules_exempt_from_availability_check[] = 'VolunteerMatching';

// Add module to tab groups
global $modListHeader;
$modListHeader[] = 'VolunteerMatching'; 
?>