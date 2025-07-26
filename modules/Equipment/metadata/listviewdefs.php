<?php

/**
 * Equipment Module - ListView Field Definitions
 * 
 * Defines which fields are displayed in the Equipment ListView.
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$listViewDefs['Equipment'] = array(
    'NAME' => array(
        'width' => '20%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'EQUIPMENT_TYPE' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_EQUIPMENT_TYPE',
        'width' => '15%',
        'default' => true,
    ),
    'CHECKOUT_STATUS' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '12%',
        'default' => true,
    ),
    'CONDITION_STATUS' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_CONDITION',
        'width' => '10%',
        'default' => true,
    ),
    'CURRENT_LOCATION' => array(
        'type' => 'varchar',
        'label' => 'LBL_CURRENT_LOCATION',
        'width' => '15%',
        'default' => true,
    ),
    'CHECKED_OUT_BY' => array(
        'type' => 'varchar',
        'label' => 'LBL_CHECKED_OUT_BY',
        'width' => '12%',
        'default' => true,
    ),
    'DUE_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_DUE_DATE',
        'width' => '10%',
        'default' => true,
    ),
    'DATE_ENTERED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '6%',
        'default' => true,
    ),
); 