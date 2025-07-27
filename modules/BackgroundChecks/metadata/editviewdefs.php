<?php
/**
 * BackgroundChecks Module - Edit View Definitions
 * 
 * This file defines the layout for the edit view of the BackgroundChecks module.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$viewdefs['BackgroundChecks']['EditView'] = array(
    'templateMeta' => array(
        'maxColumns' => '2',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30')
        ),
        'includes' => array(
            array('file' => 'custom/modules/BackgroundChecks/BackgroundChecks.js'),
        ),
        'useTabs' => false,
        'tabDefs' => array(
            'DEFAULT' => array(
                'newTab' => false,
                'panelDefault' => 'expanded',
            ),
        ),
        'form' => array(
            'buttons' => array(
                'SAVE',
                'CANCEL',
            ),
        ),
    ),
    'panels' => array(
        'default' => array(
            array(
                array(
                    'name' => 'name',
                    'label' => 'LBL_NAME',
                    'displayParams' => array(
                        'readonly' => true,
                    ),
                    'customCode' => '<input type="hidden" name="name" id="name" value="{$fields.name.value}">
                                   <span style="color: #666; font-style: italic;">Auto-generated from volunteer and check details</span>',
                ),
                'assigned_user_name',
            ),
            array(
                array(
                    'name' => 'volunteer_name_c',
                    'studio' => 'visible',
                    'label' => 'LBL_VOLUNTEER_NAME',
                    'required' => true,
                    'displayParams' => array(
                        'required' => true,
                        'enableConnectors' => false,
                    ),
                ),
                array(
                    'name' => 'background_check_type_c',
                    'studio' => 'visible',
                    'label' => 'LBL_BACKGROUND_CHECK_TYPE',
                    'required' => true,
                ),
            ),
            array(
                array(
                    'name' => 'check_date_c',
                    'label' => 'LBL_CHECK_DATE',
                    'required' => true,
                ),
                array(
                    'name' => 'expiration_date_c',
                    'label' => 'LBL_EXPIRATION_DATE',
                    'required' => true,
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
                    'name' => 'status_c',
                    'studio' => 'visible',
                    'label' => 'LBL_STATUS',
                ),
            ),
            array(
                array(
                    'name' => 'auto_calculated_status_c',
                    'studio' => 'visible',
                    'label' => 'LBL_AUTO_CALCULATED_STATUS',
                    'displayParams' => array(
                        'readonly' => true,
                    ),
                ),
                array(
                    'name' => 'renewal_reminder_sent_c',
                    'label' => 'LBL_RENEWAL_REMINDER_SENT',
                    'displayParams' => array(
                        'readonly' => true,
                    ),
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
        ),
    ),
); 