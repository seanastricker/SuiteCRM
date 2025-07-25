<?php
/**
 * Background Check and Contact Type Language Extensions
 * 
 * This file defines dropdown options and language labels for the
 * Youth Sports League volunteer management system.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Background Check Status dropdown options
$app_list_strings['background_check_status_list'] = array(
    '' => '',
    'valid' => 'Valid',
    'expiring' => 'Expiring Soon (30 days)',
    'expired' => 'Expired',
    'pending' => 'Pending Review',
    'not_required' => 'Not Required',
);

// Contact Type dropdown options  
$app_list_strings['contact_type_list'] = array(
    '' => '',
    'volunteer' => 'Volunteer',
    'parent' => 'Parent/Guardian',
    'staff' => 'Staff Member',
    'board_member' => 'Board Member',
    'coach' => 'Coach',
    'official' => 'Official/Referee',
    'other' => 'Other',
);

// Language labels for global use
$app_strings['LBL_BACKGROUND_CHECK_EXPIRATION'] = 'Background Check Expiration';
$app_strings['LBL_BACKGROUND_CHECK_STATUS'] = 'Background Check Status';
$app_strings['LBL_CONTACT_TYPE'] = 'Contact Type'; 