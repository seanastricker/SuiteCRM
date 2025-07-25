<?php
/**
 * SafetyIncidents Dropdown Lists
 * Feature 3: Quick Incident Reporting Form
 * 
 * Defines dropdown options for safety incident reporting
 */

// Incident Type Options
$app_list_strings['incident_type_list'] = array(
    '' => '',
    'injury_minor' => 'Minor Injury',
    'injury_major' => 'Major Injury', 
    'injury_head' => 'Head Injury',
    'behavioral' => 'Behavioral Incident',
    'equipment_failure' => 'Equipment Failure',
    'facility_issue' => 'Facility Issue',
    'weather_related' => 'Weather Related',
    'collision' => 'Player Collision',
    'fall' => 'Fall',
    'allergic_reaction' => 'Allergic Reaction',
    'illness' => 'Illness/Medical Emergency',
    'lost_child' => 'Lost/Missing Child',
    'unauthorized_person' => 'Unauthorized Person',
    'property_damage' => 'Property Damage',
    'other' => 'Other',
);

// Severity Level Options
$app_list_strings['severity_level_list'] = array(
    '' => '',
    'minor' => 'Minor - No medical attention needed',
    'moderate' => 'Moderate - First aid required',
    'severe' => 'Severe - Medical professional required',
    'critical' => 'Critical - Emergency services required',
);

// Incident Status Options
$app_list_strings['incident_status_list'] = array(
    '' => '',
    'reported' => 'Reported',
    'under_review' => 'Under Review',
    'investigated' => 'Investigated',
    'follow_up_required' => 'Follow-up Required',
    'closed' => 'Closed',
    'escalated' => 'Escalated to Management',
);

// Reporter Role Options
$app_list_strings['reporter_role_list'] = array(
    '' => '',
    'coach' => 'Coach',
    'volunteer' => 'Volunteer',
    'staff' => 'Staff Member',
    'parent' => 'Parent/Guardian',
    'referee' => 'Referee/Official',
    'witness' => 'Witness',
    'administrator' => 'Administrator',
    'other' => 'Other',
);

// Global Language Labels for SafetyIncidents
$app_strings['LBL_INCIDENT_DATE'] = 'Incident Date';
$app_strings['LBL_INCIDENT_TIME'] = 'Incident Time';
$app_strings['LBL_PROGRAM_NAME'] = 'Program Name';
$app_strings['LBL_CHILD_NAME'] = 'Child/Participant Name';
$app_strings['LBL_CHILD_AGE'] = 'Child Age';
$app_strings['LBL_INCIDENT_TYPE'] = 'Incident Type';
$app_strings['LBL_SEVERITY_LEVEL'] = 'Severity Level';
$app_strings['LBL_INCIDENT_DESCRIPTION'] = 'Incident Description';
$app_strings['LBL_IMMEDIATE_ACTION'] = 'Immediate Action Taken';
$app_strings['LBL_INCIDENT_STATUS'] = 'Status';
$app_strings['LBL_REPORTER_NAME'] = 'Reporter Name';
$app_strings['LBL_REPORTER_ROLE'] = 'Reporter Role';
$app_strings['LBL_MEDICAL_ATTENTION'] = 'Medical Attention Required';
$app_strings['LBL_PARENT_NOTIFIED'] = 'Parent/Guardian Notified';
$app_strings['LBL_FOLLOWUP_REQUIRED'] = 'Follow-up Required';
$app_strings['LBL_FOLLOWUP_NOTES'] = 'Follow-up Notes'; 