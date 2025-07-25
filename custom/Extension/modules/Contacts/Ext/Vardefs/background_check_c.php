<?php
/**
 * Background Check Tracking Fields for Contacts Module
 * 
 * This extension adds background check tracking fields to the Contacts module
 * for Youth Sports League volunteer management. Tracks expiration dates and
 * automatically calculates status based on current date.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Background Check Expiration Date Field
$dictionary['Contact']['fields']['background_check_expiration_c'] = array(
    'name' => 'background_check_expiration_c',
    'vname' => 'LBL_BACKGROUND_CHECK_EXPIRATION',
    'type' => 'date',
    'comment' => 'Background check expiration date for volunteer compliance',
    'merge_filter' => 'disabled',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'required' => false,
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
);

// Background Check Status Field (Auto-calculated)
$dictionary['Contact']['fields']['background_check_status_c'] = array(
    'name' => 'background_check_status_c',
    'vname' => 'LBL_BACKGROUND_CHECK_STATUS',
    'type' => 'enum',
    'options' => 'background_check_status_list',
    'len' => 50,
    'comment' => 'Auto-calculated status based on expiration date (Valid, Expiring, Expired, Pending)',
    'merge_filter' => 'disabled',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'required' => false,
    'importable' => 'false', // Auto-calculated, don't allow import
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'studio' => 'visible',
);

// Volunteer Type Field to identify who needs background checks
$dictionary['Contact']['fields']['contact_type_c'] = array(
    'name' => 'contact_type_c',
    'vname' => 'LBL_CONTACT_TYPE',
    'type' => 'enum',
    'options' => 'contact_type_list',
    'len' => 50,
    'comment' => 'Type of contact: Volunteer, Parent, Staff, Other',
    'merge_filter' => 'disabled',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'required' => false,
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'studio' => 'visible',
); 