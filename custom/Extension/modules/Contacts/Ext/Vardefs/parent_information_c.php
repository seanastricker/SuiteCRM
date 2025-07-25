<?php
/**
 * Feature 4: Basic Parent Notification System
 * Parent Information Fields for Contacts Module
 * 
 * Extends Contacts module with parent-specific fields for 
 * managing parent contact information and communication preferences
 */

// Child Information Fields
$dictionary['Contact']['fields']['children_names_c'] = array(
    'name' => 'children_names_c',
    'vname' => 'LBL_CHILDREN_NAMES',
    'type' => 'varchar',
    'len' => 255,
    'comment' => 'Names of children enrolled in programs',
    'audited' => true,
    'reportable' => true,
);

$dictionary['Contact']['fields']['children_ages_c'] = array(
    'name' => 'children_ages_c', 
    'vname' => 'LBL_CHILDREN_AGES',
    'type' => 'varchar',
    'len' => 100,
    'comment' => 'Ages of children (e.g., "8, 12" for multiple children)',
    'audited' => true,
    'reportable' => true,
);

$dictionary['Contact']['fields']['programs_enrolled_c'] = array(
    'name' => 'programs_enrolled_c',
    'vname' => 'LBL_PROGRAMS_ENROLLED', 
    'type' => 'text',
    'comment' => 'Programs children are enrolled in',
    'audited' => true,
    'reportable' => true,
);

// Emergency Contact Information
$dictionary['Contact']['fields']['emergency_contact_name_c'] = array(
    'name' => 'emergency_contact_name_c',
    'vname' => 'LBL_EMERGENCY_CONTACT_NAME',
    'type' => 'varchar',
    'len' => 100,
    'comment' => 'Emergency contact person name',
    'audited' => true,
    'reportable' => true,
);

$dictionary['Contact']['fields']['emergency_contact_phone_c'] = array(
    'name' => 'emergency_contact_phone_c',
    'vname' => 'LBL_EMERGENCY_CONTACT_PHONE',
    'type' => 'varchar', 
    'len' => 25,
    'comment' => 'Emergency contact phone number',
    'audited' => true,
    'reportable' => true,
);

$dictionary['Contact']['fields']['emergency_contact_relation_c'] = array(
    'name' => 'emergency_contact_relation_c',
    'vname' => 'LBL_EMERGENCY_CONTACT_RELATION',
    'type' => 'enum',
    'options' => 'emergency_contact_relation_list',
    'len' => 50,
    'comment' => 'Relationship to emergency contact',
    'audited' => true,
    'reportable' => true,
);

// Communication Preferences
$dictionary['Contact']['fields']['preferred_communication_c'] = array(
    'name' => 'preferred_communication_c',
    'vname' => 'LBL_PREFERRED_COMMUNICATION',
    'type' => 'enum',
    'options' => 'communication_method_list',
    'len' => 50,
    'comment' => 'Preferred method of communication',
    'audited' => true,
    'reportable' => true,
);

$dictionary['Contact']['fields']['communication_frequency_c'] = array(
    'name' => 'communication_frequency_c',
    'vname' => 'LBL_COMMUNICATION_FREQUENCY',
    'type' => 'enum',
    'options' => 'communication_frequency_list',
    'len' => 50,
    'comment' => 'How often parent wants to receive communications',
    'audited' => true,
    'reportable' => true,
);

$dictionary['Contact']['fields']['email_notifications_c'] = array(
    'name' => 'email_notifications_c',
    'vname' => 'LBL_EMAIL_NOTIFICATIONS',
    'type' => 'bool',
    'default' => true,
    'comment' => 'Receive email notifications',
    'audited' => true,
    'reportable' => true,
);

$dictionary['Contact']['fields']['sms_notifications_c'] = array(
    'name' => 'sms_notifications_c',
    'vname' => 'LBL_SMS_NOTIFICATIONS',
    'type' => 'bool',
    'default' => false,
    'comment' => 'Receive SMS notifications (future feature)',
    'audited' => true,
    'reportable' => true,
);

// Parent-Specific Notes and Information
$dictionary['Contact']['fields']['parent_notes_c'] = array(
    'name' => 'parent_notes_c',
    'vname' => 'LBL_PARENT_NOTES',
    'type' => 'text',
    'comment' => 'Additional notes about parent or children',
    'audited' => true,
    'reportable' => true,
);

$dictionary['Contact']['fields']['pickup_authorization_c'] = array(
    'name' => 'pickup_authorization_c',
    'vname' => 'LBL_PICKUP_AUTHORIZATION',
    'type' => 'text',
    'comment' => 'List of people authorized to pick up children',
    'audited' => true,
    'reportable' => true,
);

$dictionary['Contact']['fields']['medical_info_c'] = array(
    'name' => 'medical_info_c',
    'vname' => 'LBL_MEDICAL_INFO',
    'type' => 'text',
    'comment' => 'Important medical information or allergies',
    'audited' => true,
    'reportable' => true,
);

// Communication History Tracking
$dictionary['Contact']['fields']['last_communication_date_c'] = array(
    'name' => 'last_communication_date_c',
    'vname' => 'LBL_LAST_COMMUNICATION_DATE',
    'type' => 'datetime',
    'comment' => 'Date of last communication sent to this parent',
    'audited' => true,
    'reportable' => true,
);

$dictionary['Contact']['fields']['communication_count_c'] = array(
    'name' => 'communication_count_c',
    'vname' => 'LBL_COMMUNICATION_COUNT',
    'type' => 'int',
    'default' => 0,
    'comment' => 'Total number of communications sent to this parent',
    'audited' => true,
    'reportable' => true,
); 