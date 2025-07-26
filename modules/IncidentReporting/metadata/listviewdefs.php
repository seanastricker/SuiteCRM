<?php
/**
 * Feature 3: Basic Incident Reporting
 * List view definitions for IncidentReporting module
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$listViewDefs['IncidentReporting'] = array(
    'NAME' => array(
        'width' => '25%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'INCIDENT_DATE' => array(
        'width' => '15%',
        'label' => 'LBL_INCIDENT_DATE',
        'default' => true,
    ),
    'INCIDENT_TYPE' => array(
        'width' => '15%',
        'label' => 'LBL_INCIDENT_TYPE',
        'default' => true,
    ),
    'SEVERITY_LEVEL' => array(
        'width' => '10%',
        'label' => 'LBL_SEVERITY_LEVEL',
        'default' => true,
    ),
    'INCIDENT_STATUS' => array(
        'width' => '15%',
        'label' => 'LBL_INCIDENT_STATUS',
        'default' => true,
    ),
    'DATE_ENTERED' => array(
        'width' => '10%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => true,
    ),
    'CREATED_BY' => array(
        'width' => '10%',
        'label' => 'LBL_CREATED',
        'default' => false,
    ),
); 