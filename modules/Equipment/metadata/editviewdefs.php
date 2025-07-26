<?php

/**
 * Equipment Module - EditView Field Definitions
 * 
 * Defines the form layout for creating and editing equipment records.
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$viewdefs['Equipment']['EditView'] = array(
    'templateMeta' => array(
        'maxColumns' => '2',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30')
        ),
    ),
    'panels' => array(
        'default' => array(
            array(
                array(
                    'name' => 'name',
                    'label' => 'LBL_NAME',
                    'required' => true,
                ),
                array(
                    'name' => 'equipment_type',
                    'label' => 'LBL_EQUIPMENT_TYPE',
                    'required' => true,
                ),
            ),
            array(
                array(
                    'name' => 'checkout_status',
                    'label' => 'LBL_STATUS',
                    'required' => true,
                ),
                array(
                    'name' => 'condition_status',
                    'label' => 'LBL_CONDITION',
                    'required' => true,
                ),
            ),
            array(
                array(
                    'name' => 'current_location',
                    'label' => 'LBL_CURRENT_LOCATION',
                ),
                array(
                    'name' => 'program_association',
                    'label' => 'LBL_PROGRAM',
                ),
            ),
            array(
                array(
                    'name' => 'brand',
                    'label' => 'LBL_BRAND',
                ),
                array(
                    'name' => 'model',
                    'label' => 'LBL_MODEL',
                ),
            ),
            array(
                array(
                    'name' => 'serial_number',
                    'label' => 'LBL_SERIAL_NUMBER',
                ),
                array(
                    'name' => 'purchase_date',
                    'label' => 'LBL_PURCHASE_DATE',
                ),
            ),
            array(
                array(
                    'name' => 'purchase_price',
                    'label' => 'LBL_PURCHASE_PRICE',
                ),
                array(
                    'name' => 'checked_out_by',
                    'label' => 'LBL_CHECKED_OUT_BY',
                ),
            ),
            array(
                array(
                    'name' => 'checkout_date',
                    'label' => 'LBL_CHECKOUT_DATE',
                ),
                array(
                    'name' => 'due_date',
                    'label' => 'LBL_DUE_DATE',
                ),
            ),
            array(
                array(
                    'name' => 'description',
                    'label' => 'LBL_DESCRIPTION',
                    'displayParams' => array(
                        'rows' => 4,
                        'cols' => 60,
                    ),
                ),
                array(
                    'name' => 'checkout_notes',
                    'label' => 'LBL_CHECKOUT_NOTES',
                    'displayParams' => array(
                        'rows' => 4,
                        'cols' => 60,
                    ),
                ),
            ),
        ),
    ),
); 