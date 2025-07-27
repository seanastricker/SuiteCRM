<?php
/**
 * VolunteerHours Module - List View Definitions
 * 
 * This file defines the columns and layout for the list view
 * of volunteer hours entries.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$listViewDefs['VolunteerHours'] = array(
    'NAME' => array(
        'width' => '20%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'VOLUNTEER_NAME_C' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_VOLUNTEER_NAME',
        'id' => 'VOLUNTEER_ID_C',
        'link' => true,
        'width' => '15%',
        'default' => true,
    ),
    'ACTIVITY_DATE_C' => array(
        'type' => 'date',
        'label' => 'LBL_ACTIVITY_DATE',
        'width' => '10%',
        'default' => true,
    ),
    'HOURS_LOGGED_C' => array(
        'type' => 'decimal',
        'label' => 'LBL_HOURS_LOGGED',
        'width' => '8%',
        'default' => true,
    ),
    'ACTIVITY_TYPE_C' => array(
        'type' => 'enum',
        'label' => 'LBL_ACTIVITY_TYPE',
        'width' => '12%',
        'default' => true,
    ),
    'PROGRAM_NAME_C' => array(
        'type' => 'enum',
        'label' => 'LBL_PROGRAM_NAME',
        'width' => '15%',
        'default' => true,
    ),
    'APPROVAL_STATUS_C' => array(
        'type' => 'enum',
        'label' => 'LBL_APPROVAL_STATUS',
        'width' => '10%',
        'default' => true,
    ),
    'DATE_ENTERED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => false,
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => false,
    ),
); 