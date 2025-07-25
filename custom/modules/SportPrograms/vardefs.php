<?php
/**
 * SportPrograms Module - SIMPLE Field Definitions
 * 
 * This is a minimal version to test and avoid memory issues.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$dictionary['SportPrograms'] = array(
    'table' => 'sportprograms',
    'audited' => false,
    'unified_search' => false,
    'duplicate_merge' => false,
    'comment' => 'Simple Sports Programs',
    'fields' => array(
        
        'id' => array(
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'id',
            'required' => true,
            'reportable' => true,
            'comment' => 'Unique identifier',
        ),
        
        'name' => array(
            'name' => 'name',
            'vname' => 'LBL_NAME',
            'type' => 'name',
            'dbType' => 'varchar',
            'len' => 100,
            'required' => true,
            'comment' => 'Name of the sports program',
        ),
        
        'date_entered' => array(
            'name' => 'date_entered',
            'vname' => 'LBL_DATE_ENTERED',
            'type' => 'datetime',
            'comment' => 'Date record created',
        ),
        
        'date_modified' => array(
            'name' => 'date_modified',
            'vname' => 'LBL_DATE_MODIFIED',
            'type' => 'datetime',
            'comment' => 'Date record last modified',
        ),
        
        'deleted' => array(
            'name' => 'deleted',
            'vname' => 'LBL_DELETED',
            'type' => 'bool',
            'default' => '0',
            'reportable' => false,
            'comment' => 'Record deletion indicator',
        ),
        
        'sport_type_c' => array(
            'name' => 'sport_type_c',
            'vname' => 'LBL_SPORT_TYPE',
            'type' => 'varchar',
            'len' => 50,
            'comment' => 'Type of sport for this program',
        ),
        
        'volunteers_needed_c' => array(
            'name' => 'volunteers_needed_c',
            'vname' => 'LBL_VOLUNTEERS_NEEDED',
            'type' => 'int',
            'len' => 11,
            'default' => 1,
            'comment' => 'Number of volunteers needed for this program',
        ),
    ),
    
    'indices' => array(
        array(
            'name' => 'idx_sportprograms_primary', 
            'type' => 'primary', 
            'fields' => array('id')
        ),
    ),
); 