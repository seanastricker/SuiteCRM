<?php
/**
 * Background Check Dropdown Lists
 * 
 * This file defines dropdown options for the BackgroundChecks module
 * in the Youth Sports League CRM.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Background Check Types dropdown
$app_list_strings['background_check_type_list'] = array(
    '' => '',
    'criminal_history' => 'Criminal History Check',
    'sex_offender_registry' => 'Sex Offender Registry Check', 
    'child_abuse_registry' => 'Child Abuse Registry Check',
    'reference_check' => 'Reference Check',
    'driving_record' => 'Driving Record Check',
    'comprehensive' => 'Comprehensive Background Check',
    'volunteer_screening' => 'Volunteer Screening',
    'coach_certification' => 'Coach Certification Check',
    'other' => 'Other',
);

// Background Check Status dropdown (updating existing list)
$app_list_strings['background_check_status_list'] = array(
    '' => '',
    'valid' => 'Valid',
    'expiring' => 'Expiring Soon (30 days)',
    'expired' => 'Expired',
    'pending' => 'Pending Review',
    'not_required' => 'Not Required',
    'in_progress' => 'In Progress',
    'failed' => 'Failed/Rejected',
    'cancelled' => 'Cancelled',
);

// Background Check Providers (common providers for reference)
$app_list_strings['background_check_provider_list'] = array(
    '' => '',
    'sterling_volunteers' => 'Sterling Volunteers',
    'verified_volunteers' => 'Verified Volunteers',
    'good_hire' => 'GoodHire',
    'background_check_com' => 'BackgroundCheck.com',
    'accurate_background' => 'Accurate Background',
    'local_police' => 'Local Police Department',
    'state_bureau' => 'State Bureau of Investigation',
    'fbi_check' => 'FBI Background Check',
    'youth_protection' => 'Youth Protection Screening',
    'other' => 'Other Provider',
); 