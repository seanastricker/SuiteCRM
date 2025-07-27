<?php
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