<?php

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