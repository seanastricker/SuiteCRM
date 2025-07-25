<?php 
 //WARNING: The contents of this file are auto-generated


/**
 * Account Priority Level Custom Field
 * 
 * This extension adds a custom Priority Level dropdown field to the Accounts module.
 * Priority levels are: High, Medium, Low, Unassigned
 * 
 * @package SuiteCRM
 * @subpackage Custom
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$dictionary['Account']['fields']['priority_level_c'] = array(
    'name' => 'priority_level_c',
    'vname' => 'LBL_PRIORITY_LEVEL',
    'type' => 'enum',
    'options' => 'account_priority_levels_list',
    'len' => 50,
    'comment' => 'Account priority level based on annual revenue and other factors',
    'merge_filter' => 'disabled',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'required' => false,
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
); 

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

 // created: 2025-07-25 00:01:53
$dictionary['Account']['fields']['jjwg_maps_address_c']['inline_edit']=1;

 

 // created: 2025-07-25 00:01:53
$dictionary['Account']['fields']['jjwg_maps_geocode_status_c']['inline_edit']=1;

 

 // created: 2025-07-25 00:01:53
$dictionary['Account']['fields']['jjwg_maps_lat_c']['inline_edit']=1;

 

 // created: 2025-07-25 00:01:53
$dictionary['Account']['fields']['jjwg_maps_lng_c']['inline_edit']=1;

 
?>