<?php
/**
 * Email Communication Fields for Contacts Module
 * 
 * This file adds email communication preferences and management fields
 * to the Contacts module for the Youth Sports League CRM.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Email Communication Opt-in Field
$dictionary['Contact']['fields']['email_communication_opt_in_c'] = array(
    'name' => 'email_communication_opt_in_c',
    'vname' => 'LBL_EMAIL_COMMUNICATION_OPT_IN',
    'type' => 'bool',
    'default' => '1',
    'comment' => 'Whether the contact has opted in to receive email communications',
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

// Preferred Communication Method Field
$dictionary['Contact']['fields']['preferred_communication_method_c'] = array(
    'name' => 'preferred_communication_method_c',
    'vname' => 'LBL_PREFERRED_COMMUNICATION_METHOD',
    'type' => 'enum',
    'options' => 'communication_method_list',
    'len' => 50,
    'comment' => 'Preferred method of communication',
    'merge_filter' => 'disabled',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'required' => false,
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'studio' => 'visible',
);

// Parent/Guardian Type Field
$dictionary['Contact']['fields']['parent_guardian_type_c'] = array(
    'name' => 'parent_guardian_type_c',
    'vname' => 'LBL_PARENT_GUARDIAN_TYPE',
    'type' => 'enum',
    'options' => 'parent_guardian_type_list',
    'len' => 50,
    'comment' => 'Type of parent or guardian relationship',
    'merge_filter' => 'disabled',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'required' => false,
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'studio' => 'visible',
);

// Email Notification Preferences Field
$dictionary['Contact']['fields']['email_notification_preferences_c'] = array(
    'name' => 'email_notification_preferences_c',
    'vname' => 'LBL_EMAIL_NOTIFICATION_PREFERENCES',
    'type' => 'multienum',
    'options' => 'email_notification_types_list',
    'comment' => 'Types of email notifications the contact wants to receive',
    'merge_filter' => 'disabled',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'required' => false,
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'studio' => 'visible',
); 