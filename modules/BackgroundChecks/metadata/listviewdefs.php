<?php
/**
 * BackgroundChecks Module - List View Definitions
 * 
 * This file defines the columns and layout for the list view
 * of the BackgroundChecks module.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$listViewDefs['BackgroundChecks'] = array(
    'NAME' => array(
        'width' => '25%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'VOLUNTEER_NAME_C' => array(
        'width' => '15%',
        'label' => 'LBL_LIST_VOLUNTEER_NAME',
        'default' => true,
        'type' => 'relate',
        'studio' => 'visible',
        'module' => 'Contacts',
        'id' => 'VOLUNTEER_ID_C',
        'link' => true,
        'related_fields' => array('volunteer_id_c'),
    ),
    'BACKGROUND_CHECK_TYPE_C' => array(
        'width' => '12%',
        'label' => 'LBL_LIST_BACKGROUND_CHECK_TYPE',
        'default' => true,
        'type' => 'enum',
    ),
    'EXPIRATION_DATE_C' => array(
        'width' => '10%',
        'label' => 'LBL_LIST_EXPIRATION_DATE',
        'default' => true,
        'type' => 'date',
    ),
    'AUTO_CALCULATED_STATUS_C' => array(
        'width' => '10%',
        'label' => 'LBL_LIST_AUTO_CALCULATED_STATUS',
        'default' => true,
        'type' => 'enum',
    ),
    'CHECK_DATE_C' => array(
        'width' => '10%',
        'label' => 'LBL_LIST_CHECK_DATE',
        'default' => true,
        'type' => 'date',
    ),
    'PROVIDER_C' => array(
        'width' => '12%',
        'label' => 'LBL_LIST_PROVIDER',
        'default' => false,
        'type' => 'varchar',
    ),
    'COST_C' => array(
        'width' => '8%',
        'label' => 'LBL_LIST_COST',
        'default' => false,
        'type' => 'currency',
        'currency_format' => true,
    ),
    'CERTIFICATE_NUMBER_C' => array(
        'width' => '12%',
        'label' => 'LBL_CERTIFICATE_NUMBER',
        'default' => false,
        'type' => 'varchar',
    ),
    'STATUS_C' => array(
        'width' => '10%',
        'label' => 'LBL_LIST_STATUS',
        'default' => false,
        'type' => 'enum',
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '10%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'default' => false,
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'related_fields' => array('assigned_user_id'),
    ),
    'DATE_ENTERED' => array(
        'width' => '10%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => false,
        'type' => 'datetime',
    ),
    'DATE_MODIFIED' => array(
        'width' => '10%',
        'label' => 'LBL_DATE_MODIFIED',
        'default' => false,
        'type' => 'datetime',
    ),
); 