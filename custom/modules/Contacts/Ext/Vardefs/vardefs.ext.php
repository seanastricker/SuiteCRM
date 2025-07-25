<?php 
 //WARNING: The contents of this file are auto-generated


/**
 * Background Check Tracking Fields for Contacts Module
 * 
 * This extension adds background check tracking fields to the Contacts module
 * for Youth Sports League volunteer management. Tracks expiration dates and
 * automatically calculates status based on current date.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Background Check Expiration Date Field
$dictionary['Contact']['fields']['background_check_expiration_c'] = array(
    'name' => 'background_check_expiration_c',
    'vname' => 'LBL_BACKGROUND_CHECK_EXPIRATION',
    'type' => 'date',
    'comment' => 'Background check expiration date for volunteer compliance',
    'merge_filter' => 'disabled',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'required' => false,
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
);

// Background Check Status Field (Auto-calculated)
$dictionary['Contact']['fields']['background_check_status_c'] = array(
    'name' => 'background_check_status_c',
    'vname' => 'LBL_BACKGROUND_CHECK_STATUS',
    'type' => 'enum',
    'options' => 'background_check_status_list',
    'len' => 50,
    'comment' => 'Auto-calculated status based on expiration date (Valid, Expiring, Expired, Pending)',
    'merge_filter' => 'disabled',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'required' => false,
    'importable' => 'false', // Auto-calculated, don't allow import
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'studio' => 'visible',
);

// Volunteer Type Field to identify who needs background checks
$dictionary['Contact']['fields']['contact_type_c'] = array(
    'name' => 'contact_type_c',
    'vname' => 'LBL_CONTACT_TYPE',
    'type' => 'enum',
    'options' => 'contact_type_list',
    'len' => 50,
    'comment' => 'Type of contact: Volunteer, Parent, Staff, Other',
    'merge_filter' => 'disabled',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'required' => false,
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'studio' => 'visible',
); 

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

/**
 * Volunteer Profile Fields for Contacts Module
 * 
 * This extension adds volunteer profile fields to the Contacts module
 * for Youth Sports League volunteer-to-program matching. Tracks volunteer
 * preferences, skills, and availability for optimal program assignments.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Preferred Sports - Multi-select field
$dictionary['Contact']['fields']['preferred_sports_c'] = array(
    'name' => 'preferred_sports_c',
    'vname' => 'LBL_PREFERRED_SPORTS',
    'type' => 'multienum',
    'options' => 'sports_list',
    'isMultiSelect' => true,
    'comment' => 'Sports the volunteer is interested in or has experience with',
    'merge_filter' => 'disabled',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'required' => false,
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'studio' => 'visible',
);

// Preferred Age Groups - Multi-select field
$dictionary['Contact']['fields']['preferred_age_groups_c'] = array(
    'name' => 'preferred_age_groups_c',
    'vname' => 'LBL_PREFERRED_AGE_GROUPS',
    'type' => 'multienum',
    'options' => 'age_groups_list',
    'isMultiSelect' => true,
    'comment' => 'Age groups the volunteer prefers to work with',
    'merge_filter' => 'disabled',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'required' => false,
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'studio' => 'visible',
);

// Availability Days - Multi-select field
$dictionary['Contact']['fields']['availability_days_c'] = array(
    'name' => 'availability_days_c',
    'vname' => 'LBL_AVAILABILITY_DAYS',
    'type' => 'multienum',
    'options' => 'days_of_week_list',
    'isMultiSelect' => true,
    'comment' => 'Days of the week the volunteer is available',
    'merge_filter' => 'disabled',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'required' => false,
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'studio' => 'visible',
);

// Volunteer Experience Level - Single select
$dictionary['Contact']['fields']['volunteer_experience_level_c'] = array(
    'name' => 'volunteer_experience_level_c',
    'vname' => 'LBL_VOLUNTEER_EXPERIENCE_LEVEL',
    'type' => 'enum',
    'options' => 'experience_level_list',
    'len' => 50,
    'comment' => 'Experience level of the volunteer with youth sports',
    'merge_filter' => 'disabled',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'required' => false,
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'studio' => 'visible',
);

// Special Skills/Certifications - Text field
$dictionary['Contact']['fields']['special_skills_c'] = array(
    'name' => 'special_skills_c',
    'vname' => 'LBL_SPECIAL_SKILLS',
    'type' => 'text',
    'comment' => 'Special skills, certifications, or qualifications (CPR, First Aid, coaching licenses, etc.)',
    'merge_filter' => 'disabled',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'required' => false,
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'studio' => 'visible',
    'rows' => 3,
    'cols' => 80,
);

// Volunteer Status - Track current availability
$dictionary['Contact']['fields']['volunteer_status_c'] = array(
    'name' => 'volunteer_status_c',
    'vname' => 'LBL_VOLUNTEER_STATUS',
    'type' => 'enum',
    'options' => 'volunteer_status_list',
    'len' => 50,
    'comment' => 'Current status of the volunteer (Active, Inactive, Seasonal, etc.)',
    'merge_filter' => 'disabled',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'required' => false,
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'studio' => 'visible',
); 

 // created: 2025-07-25 00:01:53
$dictionary['Contact']['fields']['jjwg_maps_address_c']['inline_edit']=1;

 

 // created: 2025-07-25 00:01:53
$dictionary['Contact']['fields']['jjwg_maps_geocode_status_c']['inline_edit']=1;

 

 // created: 2025-07-25 00:01:53
$dictionary['Contact']['fields']['jjwg_maps_lat_c']['inline_edit']=1;

 

 // created: 2025-07-25 00:01:53
$dictionary['Contact']['fields']['jjwg_maps_lng_c']['inline_edit']=1;

 
?>