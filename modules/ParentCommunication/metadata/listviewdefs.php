<?php
/**
 * Feature 4: Basic Parent Notification System
 * List view definitions for ParentCommunication module
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$listViewDefs['ParentCommunication'] = array(
    'NAME' => array(
        'width' => '25%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'SUBJECT' => array(
        'width' => '20%',
        'label' => 'LBL_SUBJECT',
        'default' => true,
    ),
    'COMMUNICATION_TYPE' => array(
        'width' => '15%',
        'label' => 'LBL_COMMUNICATION_TYPE',
        'default' => true,
    ),
    'RECIPIENT_COUNT' => array(
        'width' => '10%',
        'label' => 'LBL_RECIPIENT_COUNT',
        'default' => true,
    ),
    'STATUS' => array(
        'width' => '10%',
        'label' => 'LBL_STATUS',
        'default' => true,
    ),
    'SENT_DATE' => array(
        'width' => '15%',
        'label' => 'LBL_SENT_DATE',
        'default' => true,
    ),
    'CREATED_BY' => array(
        'width' => '5%',
        'label' => 'LBL_CREATED',
        'default' => false,
    ),
); 