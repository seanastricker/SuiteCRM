<?php 
 //WARNING: The contents of this file are auto-generated


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


/**
 * Equipment Module Registration
 * 
 * Registers the Equipment module with SuiteCRM core system.
 * 
 * @author SuiteCRM Development Team
 * @package Equipment
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Add Equipment to module list
$moduleList[] = 'Equipment';

// Register Equipment bean
$beanList['Equipment'] = 'Equipment';
$beanFiles['Equipment'] = 'modules/Equipment/Equipment.php';

// Add to visible module list
$modInvisList[] = 'Equipment';

// Exempt from availability check
$modules_exempt_from_availability_check['Equipment'] = 'Equipment';

// Add to header module list for navigation
$modListHeader[] = 'Equipment'; 

/**
 * Feature 3: Basic Incident Reporting
 * Module registration for IncidentReporting
 * 
 * Registers the IncidentReporting module with SuiteCRM
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Add the IncidentReporting module to the modules list
$moduleList[] = 'IncidentReporting';

// Define the module bean mapping
$beanList['IncidentReporting'] = 'IncidentReporting';
$beanFiles['IncidentReporting'] = 'modules/IncidentReporting/IncidentReporting.php';

// Add to module menu
$modInvisList[] = 'IncidentReporting';

// Add to default module tabs (will appear in ALL tab)
$modules_exempt_from_availability_check[] = 'IncidentReporting';

// Add module to tab groups
global $modListHeader;
$modListHeader[] = 'IncidentReporting'; 

/**
 * Feature 4: Basic Parent Notification System
 * Module registration for ParentCommunication
 * 
 * Registers the ParentCommunication module with SuiteCRM
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Add the ParentCommunication module to the modules list
$moduleList[] = 'ParentCommunication';

// Define the module bean mapping
$beanList['ParentCommunication'] = 'ParentCommunication';
$beanFiles['ParentCommunication'] = 'modules/ParentCommunication/ParentCommunication.php';

// Add to module menu
$modInvisList[] = 'ParentCommunication';

// Add to default module tabs (will appear in ALL tab)
$modules_exempt_from_availability_check[] = 'ParentCommunication';

// Add module to tab groups
global $modListHeader;
$modListHeader[] = 'ParentCommunication'; 

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
 * Feature 6: Volunteer Hours & Recognition Tracker
 * Module registration for VolunteerHours
 * 
 * Registers the VolunteerHours module with SuiteCRM
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Add the VolunteerHours module to the modules list
$moduleList[] = 'VolunteerHours';

// Define the module bean mapping
$beanList['VolunteerHours'] = 'VolunteerHours';
$beanFiles['VolunteerHours'] = 'custom/modules/VolunteerHours/VolunteerHours.php';

// Add to module menu
$modInvisList[] = 'VolunteerHours';

// Add to default module tabs (will appear in ALL tab)
$modules_exempt_from_availability_check[] = 'VolunteerHours';

// Add module to tab groups
global $modListHeader;
$modListHeader[] = 'VolunteerHours'; 

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