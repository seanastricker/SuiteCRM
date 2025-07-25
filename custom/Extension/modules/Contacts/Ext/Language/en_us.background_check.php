<?php
/**
 * Contacts Module Language Extensions - Background Check Fields
 * 
 * This file defines language labels for the background check tracking fields
 * in the Contacts module for Youth Sports League volunteer management.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$mod_strings['LBL_BACKGROUND_CHECK_EXPIRATION'] = 'Background Check Expiration';
$mod_strings['LBL_BACKGROUND_CHECK_STATUS'] = 'Background Check Status';
$mod_strings['LBL_CONTACT_TYPE'] = 'Contact Type';

// Help text for fields
$mod_strings['LBL_BACKGROUND_CHECK_EXPIRATION_HELP'] = 'Date when background check expires. Status will auto-update based on this date.';
$mod_strings['LBL_BACKGROUND_CHECK_STATUS_HELP'] = 'Automatically calculated based on expiration date. Updates when contact is saved.';
$mod_strings['LBL_CONTACT_TYPE_HELP'] = 'Type of contact - used to determine who needs background checks.';

// Panel labels
$mod_strings['LBL_PANEL_VOLUNTEER_INFO'] = 'Volunteer Information';

// List view labels
$mod_strings['LBL_LIST_BACKGROUND_CHECK_STATUS'] = 'BG Check Status';
$mod_strings['LBL_LIST_CONTACT_TYPE'] = 'Type'; 