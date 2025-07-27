<?php
// WARNING: The contents of this file are auto-generated


/**
 * Account Priority Levels Language Extensions
 * 
 * This file defines the dropdown options and language labels for the
 * custom Priority Level field in the Accounts module.
 * 
 * @package SuiteCRM
 * @subpackage Custom
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Dropdown list options for account priority levels
$app_list_strings['account_priority_levels_list'] = array(
    '' => '',
    'high' => 'High Priority',
    'medium' => 'Medium Priority', 
    'low' => 'Low Priority',
    'unassigned' => 'Unassigned',
);

// Language labels
$app_strings['LBL_PRIORITY_LEVEL'] = 'Priority Level'; 

/**
 * Background Check Dropdown Lists
 * 
 * This file defines dropdown options for the BackgroundChecks module
 * in the Youth Sports League CRM.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Background Check Types dropdown
$app_list_strings['background_check_type_list'] = array(
    '' => '',
    'criminal_history' => 'Criminal History Check',
    'sex_offender_registry' => 'Sex Offender Registry Check', 
    'child_abuse_registry' => 'Child Abuse Registry Check',
    'reference_check' => 'Reference Check',
    'driving_record' => 'Driving Record Check',
    'comprehensive' => 'Comprehensive Background Check',
    'volunteer_screening' => 'Volunteer Screening',
    'coach_certification' => 'Coach Certification Check',
    'other' => 'Other',
);

// Background Check Status dropdown (updating existing list)
$app_list_strings['background_check_status_list'] = array(
    '' => '',
    'valid' => 'Valid',
    'expiring' => 'Expiring Soon (30 days)',
    'expired' => 'Expired',
    'pending' => 'Pending Review',
    'not_required' => 'Not Required',
    'in_progress' => 'In Progress',
    'failed' => 'Failed/Rejected',
    'cancelled' => 'Cancelled',
);

// Background Check Providers (common providers for reference)
$app_list_strings['background_check_provider_list'] = array(
    '' => '',
    'sterling_volunteers' => 'Sterling Volunteers',
    'verified_volunteers' => 'Verified Volunteers',
    'good_hire' => 'GoodHire',
    'background_check_com' => 'BackgroundCheck.com',
    'accurate_background' => 'Accurate Background',
    'local_police' => 'Local Police Department',
    'state_bureau' => 'State Bureau of Investigation',
    'fbi_check' => 'FBI Background Check',
    'youth_protection' => 'Youth Protection Screening',
    'other' => 'Other Provider',
); 

/**
 * Feature 1: Background Check Expiration Tracker
 * Global application language strings for BackgroundChecks module
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Global application strings for navigation
$app_strings['LBL_MODULE_NAME_BACKGROUNDCHECKS'] = 'Background Checks';
$app_strings['LBL_MODULE_NAME_SINGULAR_BACKGROUNDCHECKS'] = 'Background Check';

// Module list strings  
$app_list_strings['moduleList']['BackgroundChecks'] = 'Background Checks';
$app_list_strings['moduleListSingular']['BackgroundChecks'] = 'Background Check'; 

/**
 * Background Check and Contact Type Language Extensions
 * 
 * This file defines dropdown options and language labels for the
 * Youth Sports League volunteer management system.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Background Check Status dropdown options
$app_list_strings['background_check_status_list'] = array(
    '' => '',
    'valid' => 'Valid',
    'expiring' => 'Expiring Soon (30 days)',
    'expired' => 'Expired',
    'pending' => 'Pending Review',
    'not_required' => 'Not Required',
);

// Contact Type dropdown options  
$app_list_strings['contact_type_list'] = array(
    '' => '',
    'volunteer' => 'Volunteer',
    'parent' => 'Parent/Guardian',
    'staff' => 'Staff Member',
    'board_member' => 'Board Member',
    'coach' => 'Coach',
    'official' => 'Official/Referee',
    'other' => 'Other',
);

// Language labels for global use
$app_strings['LBL_BACKGROUND_CHECK_EXPIRATION'] = 'Background Check Expiration';
$app_strings['LBL_BACKGROUND_CHECK_STATUS'] = 'Background Check Status';
$app_strings['LBL_CONTACT_TYPE'] = 'Contact Type'; 

/**
 * Email Communication Dropdown Lists
 * 
 * This file defines dropdown options for email communication fields
 * in the Contacts module.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Communication Method dropdown
$app_list_strings['communication_method_list'] = array(
    '' => '',
    'email' => 'Email',
    'phone' => 'Phone Call',
    'text' => 'Text Message',
    'mail' => 'Postal Mail',
    'in_person' => 'In Person',
);

// Parent/Guardian Type dropdown
$app_list_strings['parent_guardian_type_list'] = array(
    '' => '',
    'primary_parent' => 'Primary Parent',
    'secondary_parent' => 'Secondary Parent',
    'guardian' => 'Legal Guardian',
    'emergency_contact' => 'Emergency Contact',
    'grandparent' => 'Grandparent',
    'other_family' => 'Other Family Member',
);

// Email Notification Types (multi-select)
$app_list_strings['email_notification_types_list'] = array(
    'general_announcements' => 'General Announcements',
    'event_notifications' => 'Event Notifications',
    'emergency_alerts' => 'Emergency Alerts',
    'volunteer_opportunities' => 'Volunteer Opportunities',
    'safety_incidents' => 'Safety Incident Reports',
    'background_check_reminders' => 'Background Check Reminders',
    'volunteer_recognition' => 'Volunteer Recognition',
    'newsletter' => 'Monthly Newsletter',
    'schedule_changes' => 'Schedule Changes',
    'weather_updates' => 'Weather-Related Updates',
);

// Update existing contact type list to include email-relevant types
$app_list_strings['contact_type_list'] = array(
    '' => '',
    'volunteer' => 'Volunteer',
    'parent' => 'Parent/Guardian',
    'staff' => 'Staff Member',
    'board_member' => 'Board Member',
    'coach' => 'Coach',
    'official' => 'Official/Referee',
    'emergency_contact' => 'Emergency Contact',
    'vendor' => 'Vendor/Supplier',
    'other' => 'Other',
); 


/**
 * Equipment Module - Global Language Strings
 * 
 * Global application language strings for Equipment module navigation.
 * 
 * @author SuiteCRM Development Team
 * @package Equipment
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$app_list_strings['moduleList']['Equipment'] = 'Equipment';
$app_list_strings['moduleListSingular']['Equipment'] = 'Equipment';

// Equipment dropdown options
$app_list_strings['equipment_type_list'] = array(
    'football' => 'Football Equipment',
    'soccer' => 'Soccer Equipment', 
    'basketball' => 'Basketball Equipment',
    'tennis' => 'Tennis Equipment',
    'baseball' => 'Baseball Equipment',
    'volleyball' => 'Volleyball Equipment',
    'general' => 'General Sports Equipment',
    'safety' => 'Safety Equipment',
    'maintenance' => 'Maintenance Equipment',
);

$app_list_strings['equipment_condition_list'] = array(
    'excellent' => 'Excellent',
    'good' => 'Good',
    'fair' => 'Fair',
    'poor' => 'Poor',
    'damaged' => 'Damaged',
    'needs_repair' => 'Needs Repair',
);

$app_list_strings['equipment_status_list'] = array(
    'available' => 'Available',
    'checked_out' => 'Checked Out',
    'maintenance' => 'In Maintenance',
    'damaged' => 'Damaged',
    'retired' => 'Retired',
);

$app_list_strings['equipment_program_list'] = array(
    'Football U7' => 'Football U7',
    'Soccer U8' => 'Soccer U8', 
    'Basketball U12' => 'Basketball U12',
    'Tennis U10' => 'Tennis U10',
    'Baseball U9' => 'Baseball U9',
    'Volleyball U11' => 'Volleyball U11',
    'General' => 'General Use',
); 

/**
 * Feature 3: Basic Incident Reporting
 * Global application language strings for IncidentReporting module
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Global application strings for navigation
$app_strings['LBL_MODULE_NAME_INCIDENTREPORTING'] = 'Incident Reporting';
$app_strings['LBL_MODULE_NAME_SINGULAR_INCIDENTREPORTING'] = 'Incident Report';

// Module list strings  
$app_list_strings['moduleList']['IncidentReporting'] = 'Incident Reporting';
$app_list_strings['moduleListSingular']['IncidentReporting'] = 'Incident Report'; 

/**
 * Feature 4: Basic Parent Notification System
 * Dropdown Lists and Global Language Labels
 */

// Emergency Contact Relationship Options
$app_list_strings['emergency_contact_relation_list'] = array(
    '' => '',
    'spouse' => 'Spouse/Partner',
    'grandparent' => 'Grandparent',
    'sibling' => 'Sibling',
    'aunt_uncle' => 'Aunt/Uncle',
    'family_friend' => 'Family Friend',
    'neighbor' => 'Neighbor',
    'babysitter' => 'Babysitter/Caregiver',
    'other' => 'Other',
);

// Communication Method Options
$app_list_strings['communication_method_list'] = array(
    '' => '',
    'email' => 'Email',
    'phone' => 'Phone Call',
    'text' => 'Text Message',
    'app' => 'Mobile App',
    'letter' => 'Letter/Note',
    'in_person' => 'In Person',
);

// Communication Frequency Options
$app_list_strings['communication_frequency_list'] = array(
    '' => '',
    'daily' => 'Daily Updates',
    'weekly' => 'Weekly Summary',
    'as_needed' => 'As Needed Only',
    'emergencies' => 'Emergencies Only',
    'never' => 'No Communications',
);

// Global App Strings for Parent Fields
$app_strings['LBL_CHILDREN_NAMES'] = 'Children Names';
$app_strings['LBL_CHILDREN_AGES'] = 'Children Ages';
$app_strings['LBL_PROGRAMS_ENROLLED'] = 'Programs Enrolled';
$app_strings['LBL_EMERGENCY_CONTACT_NAME'] = 'Emergency Contact Name';
$app_strings['LBL_EMERGENCY_CONTACT_PHONE'] = 'Emergency Contact Phone';
$app_strings['LBL_EMERGENCY_CONTACT_RELATION'] = 'Emergency Contact Relation';
$app_strings['LBL_PREFERRED_COMMUNICATION'] = 'Preferred Communication';
$app_strings['LBL_COMMUNICATION_FREQUENCY'] = 'Communication Frequency';
$app_strings['LBL_EMAIL_NOTIFICATIONS'] = 'Email Notifications';
$app_strings['LBL_SMS_NOTIFICATIONS'] = 'SMS Notifications';
$app_strings['LBL_PARENT_NOTES'] = 'Parent Notes';
$app_strings['LBL_PICKUP_AUTHORIZATION'] = 'Pickup Authorization';
$app_strings['LBL_MEDICAL_INFO'] = 'Medical Information';
$app_strings['LBL_LAST_COMMUNICATION_DATE'] = 'Last Communication Date';
$app_strings['LBL_COMMUNICATION_COUNT'] = 'Communication Count'; 

/**
 * Feature 4: Basic Parent Notification System
 * Global application language strings for ParentCommunication module
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Global application strings for navigation
$app_strings['LBL_MODULE_NAME_PARENTCOMMUNICATION'] = 'Parent Communication';
$app_strings['LBL_MODULE_NAME_SINGULAR_PARENTCOMMUNICATION'] = 'Parent Communication';

// Module list strings  
$app_list_strings['moduleList']['ParentCommunication'] = 'Parent Communication';
$app_list_strings['moduleListSingular']['ParentCommunication'] = 'Parent Communication'; 

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

/**
 * SportPrograms Module Language Extensions
 * 
 * This file defines dropdown options and language labels for the
 * SportPrograms module in the Youth Sports League system.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Program Status List - Single select options
$app_list_strings['program_status_list'] = array(
    '' => '',
    'planning' => 'Planning - Program being organized',
    'recruiting' => 'Recruiting - Looking for volunteers',
    'ready' => 'Ready - Fully staffed and ready to start',
    'active' => 'Active - Currently running',
    'on_hold' => 'On Hold - Temporarily suspended',
    'completed' => 'Completed - Program finished',
    'cancelled' => 'Cancelled - Program was cancelled',
);

// Season List - Single select options
$app_list_strings['season_list'] = array(
    '' => '',
    'spring' => 'Spring (March - May)',
    'summer' => 'Summer (June - August)',
    'fall' => 'Fall (September - November)',
    'winter' => 'Winter (December - February)',
    'year_round' => 'Year Round',
);

// Global language labels for SportPrograms
$app_strings['LBL_SPORT_TYPE'] = 'Sport Type';
$app_strings['LBL_AGE_GROUP'] = 'Age Group';
$app_strings['LBL_MEETING_DAYS'] = 'Meeting Days';
$app_strings['LBL_VOLUNTEERS_NEEDED'] = 'Volunteers Needed';
$app_strings['LBL_VOLUNTEERS_ASSIGNED'] = 'Volunteers Assigned';
$app_strings['LBL_PROGRAM_STATUS'] = 'Program Status';
$app_strings['LBL_SEASON'] = 'Season';
$app_strings['LBL_START_DATE'] = 'Start Date';
$app_strings['LBL_END_DATE'] = 'End Date';
$app_strings['LBL_MEETING_LOCATION'] = 'Meeting Location'; 

/**
 * Feature 6: Volunteer Hours & Recognition Tracker
 * Dropdown Lists for VolunteerHours module
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Volunteer Activity Type List
$app_list_strings['volunteer_activity_type_list'] = array(
    '' => '',
    'coaching' => 'Coaching',
    'refereeing' => 'Refereeing/Umpiring',
    'equipment_setup' => 'Equipment Setup/Cleanup',
    'event_coordination' => 'Event Coordination',
    'fundraising' => 'Fundraising',
    'registration' => 'Registration/Check-in',
    'concessions' => 'Concessions',
    'transportation' => 'Transportation',
    'first_aid' => 'First Aid/Medical',
    'photography' => 'Photography/Videography',
    'field_maintenance' => 'Field Maintenance',
    'administrative' => 'Administrative',
    'mentoring' => 'Mentoring/Training',
    'special_events' => 'Special Events',
    'other' => 'Other',
);

// Volunteer Hours Approval Status List
$app_list_strings['volunteer_hours_approval_status_list'] = array(
    '' => '',
    'pending' => 'Pending Approval',
    'approved' => 'Approved',
    'rejected' => 'Rejected',
    'needs_review' => 'Needs Review',
);

// Sport Programs List - Using same programs as Equipment module
$app_list_strings['volunteer_sport_programs_list'] = array(
    '' => '',
    'Football U7' => 'Football U7',
    'Soccer U8' => 'Soccer U8',
    'Basketball U12' => 'Basketball U12',
    'Tennis U10' => 'Tennis U10',
    'Baseball U9' => 'Baseball U9',
    'Volleyball U11' => 'Volleyball U11',
    'Soccer U10' => 'Soccer U10',
    'Basketball U8' => 'Basketball U8',
    'Football U12' => 'Football U12',
    'Baseball U12' => 'Baseball U12',
    'Swimming U9' => 'Swimming U9',
    'Track & Field U11' => 'Track & Field U11',
    'General' => 'General Activities',
    'Multiple' => 'Multiple Programs',
); 

/**
 * Feature 6: Volunteer Hours & Recognition Tracker
 * Global application language strings for VolunteerHours module
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Global application strings for navigation
$app_strings['LBL_MODULE_NAME_VOLUNTEERHOURS'] = 'Volunteer Hours';
$app_strings['LBL_MODULE_NAME_SINGULAR_VOLUNTEERHOURS'] = 'Volunteer Hours Entry';

// Module list strings  
$app_list_strings['moduleList']['VolunteerHours'] = 'Volunteer Hours';
$app_list_strings['moduleListSingular']['VolunteerHours'] = 'Volunteer Hours Entry'; 

/**
 * Feature 2: Simple Volunteer-Program Matching
 * Global application language strings for VolunteerMatching module
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Global application strings for navigation
$app_strings['LBL_MODULE_NAME_VOLUNTEERMATCHING'] = 'Volunteer Matching';
$app_strings['LBL_MODULE_NAME_SINGULAR_VOLUNTEERMATCHING'] = 'Volunteer Matching';

// Module list strings  
$app_list_strings['moduleList']['VolunteerMatching'] = 'Volunteer Matching';
$app_list_strings['moduleListSingular']['VolunteerMatching'] = 'Volunteer Matching'; 

/**
 * Volunteer Profile Language Extensions
 * 
 * This file defines dropdown options and language labels for the
 * volunteer profile fields used in Youth Sports League volunteer matching.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Sports List - Multi-select options
$app_list_strings['sports_list'] = array(
    'soccer' => 'Soccer',
    'basketball' => 'Basketball', 
    'baseball' => 'Baseball',
    'softball' => 'Softball',
    'football' => 'Football',
    'tennis' => 'Tennis',
    'volleyball' => 'Volleyball',
    'track_field' => 'Track & Field',
    'swimming' => 'Swimming',
    'wrestling' => 'Wrestling',
    'gymnastics' => 'Gymnastics',
    'lacrosse' => 'Lacrosse',
    'hockey' => 'Hockey',
    'golf' => 'Golf',
    'cross_country' => 'Cross Country',
    'cheerleading' => 'Cheerleading',
    'martial_arts' => 'Martial Arts',
    'other' => 'Other Sport',
);

// Age Groups List - Multi-select options
$app_list_strings['age_groups_list'] = array(
    '5_7' => '5-7 years (T-Ball/Mini)',
    '8_10' => '8-10 years (Little League)',
    '11_13' => '11-13 years (Junior)',
    '14_16' => '14-16 years (High School JV)',
    '17_18' => '17-18 years (High School Varsity)',
    'adult' => 'Adult Programs',
    'all_ages' => 'All Age Groups',
);

// Days of Week List - Multi-select options
$app_list_strings['days_of_week_list'] = array(
    'monday' => 'Monday',
    'tuesday' => 'Tuesday',
    'wednesday' => 'Wednesday',
    'thursday' => 'Thursday',
    'friday' => 'Friday',
    'saturday' => 'Saturday',
    'sunday' => 'Sunday',
);

// Experience Level List - Single select options
$app_list_strings['experience_level_list'] = array(
    '' => '',
    'beginner' => 'Beginner - New to volunteering',
    'some_experience' => 'Some Experience - Occasional volunteer',
    'experienced' => 'Experienced - Regular volunteer',
    'expert' => 'Expert - Leadership/coaching experience',
    'professional' => 'Professional - Sports industry background',
);

// Volunteer Status List - Single select options
$app_list_strings['volunteer_status_list'] = array(
    '' => '',
    'active' => 'Active - Currently volunteering',
    'available' => 'Available - Ready to volunteer',
    'inactive' => 'Inactive - Not currently available',
    'seasonal' => 'Seasonal - Available certain times of year',
    'on_hold' => 'On Hold - Temporarily unavailable',
    'retired' => 'Retired - No longer volunteering',
);

// Global language labels
$app_strings['LBL_PREFERRED_SPORTS'] = 'Preferred Sports';
$app_strings['LBL_PREFERRED_AGE_GROUPS'] = 'Preferred Age Groups';
$app_strings['LBL_AVAILABILITY_DAYS'] = 'Available Days';
$app_strings['LBL_VOLUNTEER_EXPERIENCE_LEVEL'] = 'Experience Level';
$app_strings['LBL_SPECIAL_SKILLS'] = 'Special Skills & Certifications';
$app_strings['LBL_VOLUNTEER_STATUS'] = 'Volunteer Status'; 
