<?php
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