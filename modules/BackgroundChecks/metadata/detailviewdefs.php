<?php
/**
 * BackgroundChecks Module - Detail View Definitions
 * 
 * This file defines the layout for the detail view of the BackgroundChecks module.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$viewdefs['BackgroundChecks']['DetailView'] = array(
    'templateMeta' => array(
        'form' => array(
            'buttons' => array(
                'EDIT',
                'DUPLICATE',
                'DELETE',
                'FIND_DUPLICATES',
            )
        ),
        'maxColumns' => '2',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30')
        ),
        'useTabs' => false,
    ),
    'panels' => array(
        'default' => array(
            array(
                'name',
                'assigned_user_name',
            ),
            array(
                array(
                    'name' => 'volunteer_name_c',
                    'studio' => 'visible',
                    'label' => 'LBL_VOLUNTEER_NAME',
                ),
                array(
                    'name' => 'background_check_type_c',
                    'studio' => 'visible',
                    'label' => 'LBL_BACKGROUND_CHECK_TYPE',
                ),
            ),
            array(
                array(
                    'name' => 'check_date_c',
                    'label' => 'LBL_CHECK_DATE',
                ),
                array(
                    'name' => 'expiration_date_c',
                    'label' => 'LBL_EXPIRATION_DATE',
                ),
            ),
            array(
                array(
                    'name' => 'auto_calculated_status_c',
                    'studio' => 'visible',
                    'label' => 'LBL_AUTO_CALCULATED_STATUS',
                ),
                array(
                    'name' => 'status_c',
                    'studio' => 'visible',
                    'label' => 'LBL_STATUS',
                ),
            ),
            array(
                array(
                    'name' => 'provider_c',
                    'label' => 'LBL_PROVIDER',
                ),
                array(
                    'name' => 'certificate_number_c',
                    'label' => 'LBL_CERTIFICATE_NUMBER',
                ),
            ),
            array(
                array(
                    'name' => 'cost_c',
                    'label' => 'LBL_COST',
                ),
                array(
                    'name' => 'renewal_reminder_sent_c',
                    'label' => 'LBL_RENEWAL_REMINDER_SENT',
                ),
            ),
            array(
                array(
                    'name' => 'notes_c',
                    'studio' => 'visible',
                    'label' => 'LBL_NOTES',
                    'span' => 12,
                ),
            ),
            array(
                array(
                    'name' => 'description',
                    'comment' => 'Full text of the note',
                    'label' => 'LBL_DESCRIPTION',
                    'span' => 12,
                ),
            ),
            array(
                'date_entered',
                'date_modified',
            ),
        ),
    ),
); 