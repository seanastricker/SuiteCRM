<?php
/**
 * Feature 2: Simple Volunteer-Program Matching
 * List view definitions for VolunteerMatching module
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$listViewDefs['VolunteerMatching'] = array(
    'NAME' => array(
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'DATE_ENTERED' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => true,
    ),
    'DATE_MODIFIED' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_MODIFIED',
        'default' => true,
    ),
); 