<?php
/**
 * Account Priority Level Edit View Extension
 * 
 * This file extends the Accounts editview to include the Priority Level field
 * in the MORE INFORMATION panel after the annual_revenue field.
 * 
 * @package SuiteCRM
 * @subpackage Custom
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Extend the edit view to include our priority field
$dictionary['Account']['fields']['priority_level_c']['studio'] = 'visible'; 