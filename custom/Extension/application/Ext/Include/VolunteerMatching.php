<?php
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