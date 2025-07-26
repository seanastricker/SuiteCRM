<?php
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