<?php
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