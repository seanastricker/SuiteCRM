<?php
/**
 * VolunteerHours Module - Detail View Definitions
 * 
 * This file defines the layout for the detail view of volunteer hours entries.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$viewdefs['VolunteerHours']['DetailView'] = array(
    'templateMeta' => array(
        'form' => array(
            'buttons' => array(
                'EDIT',
                'DUPLICATE',
                'DELETE',
                array(
                    'customCode' => '<input title="{$APP.LBL_APPROVE_HOURS}" accessKey="{$APP.LBL_APPROVE_HOURS}" class="button" onclick="this.form.action.value=\'approve\'; this.form.submit();" type="submit" name="button" value="{$APP.LBL_APPROVE_HOURS}" id="approve_button">',
                    'sugar_html' => array(
                        'type' => 'submit',
                        'value' => '{$APP.LBL_APPROVE_HOURS}',
                        'htmlOptions' => array(
                            'title' => '{$APP.LBL_APPROVE_HOURS}',
                            'class' => 'button',
                            'onclick' => 'this.form.action.value=\'approve\'; this.form.submit();',
                            'name' => 'approve_button',
                            'id' => 'approve_button',
                        ),
                    ),
                ),
            ),
        ),
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
                    'name' => 'activity_date_c',
                    'label' => 'LBL_ACTIVITY_DATE',
                ),
            ),
            array(
                array(
                    'name' => 'hours_logged_c',
                    'label' => 'LBL_HOURS_LOGGED',
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
            array(
                'date_entered',
                'date_modified',
            ),
        ),
    ),
); 