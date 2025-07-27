<?php
/**
 * VolunteerHours Module - Edit View Definitions
 * 
 * This file defines the layout for the edit view of volunteer hours entries.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$viewdefs['VolunteerHours']['EditView'] = array(
    'templateMeta' => array(
        'maxColumns' => '2',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30'),
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
                                   <span style="color: #666; font-style: italic;">Auto-generated from volunteer and hours</span>',
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
                    'name' => 'activity_date_c',
                    'label' => 'LBL_ACTIVITY_DATE',
                    'required' => true,
                ),
            ),
            array(
                array(
                    'name' => 'hours_logged_c',
                    'label' => 'LBL_HOURS_LOGGED',
                    'required' => true,
                ),
                array(
                    'name' => 'activity_type_c',
                    'studio' => 'visible',
                    'label' => 'LBL_ACTIVITY_TYPE',
                ),
            ),
            array(
                array(
                    'name' => 'program_name_c',
                    'studio' => 'visible',
                    'label' => 'LBL_PROGRAM_NAME',
                ),
                array(
                    'name' => 'approval_status_c',
                    'studio' => 'visible',
                    'label' => 'LBL_APPROVAL_STATUS',
                ),
            ),
            array(
                array(
                    'name' => 'activity_description_c',
                    'studio' => 'visible',
                    'label' => 'LBL_ACTIVITY_DESCRIPTION',
                    'span' => 12,
                ),
            ),
        ),
    ),
); 