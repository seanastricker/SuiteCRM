<?php
// WARNING: The contents of this file are auto-generated


/**
 * Contacts Module Language Extensions - Background Check Fields
 * 
 * This file defines language labels for the background check tracking fields
 * in the Contacts module for Youth Sports League volunteer management.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$mod_strings['LBL_BACKGROUND_CHECK_EXPIRATION'] = 'Background Check Expiration';
$mod_strings['LBL_BACKGROUND_CHECK_STATUS'] = 'Background Check Status';
$mod_strings['LBL_CONTACT_TYPE'] = 'Contact Type';

// Help text for fields
$mod_strings['LBL_BACKGROUND_CHECK_EXPIRATION_HELP'] = 'Date when background check expires. Status will auto-update based on this date.';
$mod_strings['LBL_BACKGROUND_CHECK_STATUS_HELP'] = 'Automatically calculated based on expiration date. Updates when contact is saved.';
$mod_strings['LBL_CONTACT_TYPE_HELP'] = 'Type of contact - used to determine who needs background checks.';

// Panel labels
$mod_strings['LBL_PANEL_VOLUNTEER_INFO'] = 'Volunteer Information';

// List view labels
$mod_strings['LBL_LIST_BACKGROUND_CHECK_STATUS'] = 'BG Check Status';
$mod_strings['LBL_LIST_CONTACT_TYPE'] = 'Type'; 

/**
 * Feature 4: Basic Parent Notification System
 * Module-Specific Language Labels for Contacts Module
 */

// Field Labels
$mod_strings['LBL_CHILDREN_NAMES'] = 'Children Names';
$mod_strings['LBL_CHILDREN_AGES'] = 'Children Ages';
$mod_strings['LBL_PROGRAMS_ENROLLED'] = 'Programs Enrolled';
$mod_strings['LBL_EMERGENCY_CONTACT_NAME'] = 'Emergency Contact Name';
$mod_strings['LBL_EMERGENCY_CONTACT_PHONE'] = 'Emergency Contact Phone';
$mod_strings['LBL_EMERGENCY_CONTACT_RELATION'] = 'Emergency Contact Relation';
$mod_strings['LBL_PREFERRED_COMMUNICATION'] = 'Preferred Communication';
$mod_strings['LBL_COMMUNICATION_FREQUENCY'] = 'Communication Frequency';
$mod_strings['LBL_EMAIL_NOTIFICATIONS'] = 'Email Notifications';
$mod_strings['LBL_SMS_NOTIFICATIONS'] = 'SMS Notifications';
$mod_strings['LBL_PARENT_NOTES'] = 'Parent Notes';
$mod_strings['LBL_PICKUP_AUTHORIZATION'] = 'Pickup Authorization';
$mod_strings['LBL_MEDICAL_INFO'] = 'Medical Information';
$mod_strings['LBL_LAST_COMMUNICATION_DATE'] = 'Last Communication Date';
$mod_strings['LBL_COMMUNICATION_COUNT'] = 'Communication Count';

// Help Text
$mod_strings['LBL_CHILDREN_NAMES_HELP'] = 'Enter the names of all children separated by commas (e.g., "Sarah, Mike")';
$mod_strings['LBL_CHILDREN_AGES_HELP'] = 'Enter ages corresponding to children names (e.g., "8, 12")';
$mod_strings['LBL_PROGRAMS_ENROLLED_HELP'] = 'List all programs the children are enrolled in';
$mod_strings['LBL_EMERGENCY_CONTACT_HELP'] = 'Emergency contact to call if parent cannot be reached';
$mod_strings['LBL_PREFERRED_COMMUNICATION_HELP'] = 'How this parent prefers to receive communications';
$mod_strings['LBL_COMMUNICATION_FREQUENCY_HELP'] = 'How often this parent wants to receive updates';
$mod_strings['LBL_EMAIL_NOTIFICATIONS_HELP'] = 'Check to send email notifications to this parent';
$mod_strings['LBL_SMS_NOTIFICATIONS_HELP'] = 'Future feature: SMS notifications';
$mod_strings['LBL_PICKUP_AUTHORIZATION_HELP'] = 'List people authorized to pick up children (besides parent)';
$mod_strings['LBL_MEDICAL_INFO_HELP'] = 'Important medical conditions, allergies, or medications';

// Panel Labels
$mod_strings['LBL_PARENT_INFORMATION_PANEL'] = 'Parent Information';
$mod_strings['LBL_CHILDREN_INFORMATION_PANEL'] = 'Children Information';
$mod_strings['LBL_EMERGENCY_CONTACT_PANEL'] = 'Emergency Contact';
$mod_strings['LBL_COMMUNICATION_PREFERENCES_PANEL'] = 'Communication Preferences';
$mod_strings['LBL_SAFETY_INFORMATION_PANEL'] = 'Safety Information';
$mod_strings['LBL_COMMUNICATION_HISTORY_PANEL'] = 'Communication History';

// List View Labels
$mod_strings['LBL_LIST_CHILDREN_NAMES'] = 'Children';
$mod_strings['LBL_LIST_PROGRAMS_ENROLLED'] = 'Programs';
$mod_strings['LBL_LIST_PREFERRED_COMMUNICATION'] = 'Comm. Method';
$mod_strings['LBL_LIST_LAST_COMMUNICATION'] = 'Last Contact';
$mod_strings['LBL_LIST_EMAIL_NOTIFICATIONS'] = 'Email';

// Search Form Labels
$mod_strings['LBL_SEARCH_CHILDREN_NAMES'] = 'Search by Child Name';
$mod_strings['LBL_SEARCH_PROGRAMS_ENROLLED'] = 'Search by Program';
$mod_strings['LBL_SEARCH_COMMUNICATION_METHOD'] = 'Communication Method';

// Messages and Notifications
$mod_strings['MSG_PARENT_INFORMATION_SAVED'] = 'Parent information saved successfully';
$mod_strings['MSG_COMMUNICATION_SENT'] = 'Communication sent successfully';
$mod_strings['MSG_EMAIL_REQUIRED'] = 'Email address is required for email notifications';
$mod_strings['MSG_PHONE_REQUIRED'] = 'Phone number is required for SMS notifications';

// Action Labels
$mod_strings['LBL_SEND_COMMUNICATION'] = 'Send Communication';
$mod_strings['LBL_VIEW_COMMUNICATION_HISTORY'] = 'View Communication History';
$mod_strings['LBL_UPDATE_PREFERENCES'] = 'Update Communication Preferences';

// Feature 4 Specific Labels
$mod_strings['LBL_PARENT_COMMUNICATION_DASHBOARD'] = 'Parent Communication Dashboard';
$mod_strings['LBL_BROADCAST_MESSAGE'] = 'Broadcast Message';
$mod_strings['LBL_SELECT_RECIPIENTS'] = 'Select Recipients';
$mod_strings['LBL_MESSAGE_TEMPLATES'] = 'Message Templates'; 

/**
 * Contacts Module Language Extensions - Volunteer Profile Fields
 * 
 * This file defines language labels for the volunteer profile fields
 * in the Contacts module for Youth Sports League volunteer matching.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Field Labels
$mod_strings['LBL_PREFERRED_SPORTS'] = 'Preferred Sports';
$mod_strings['LBL_PREFERRED_AGE_GROUPS'] = 'Preferred Age Groups';
$mod_strings['LBL_AVAILABILITY_DAYS'] = 'Available Days';
$mod_strings['LBL_VOLUNTEER_EXPERIENCE_LEVEL'] = 'Experience Level';
$mod_strings['LBL_SPECIAL_SKILLS'] = 'Special Skills & Certifications';
$mod_strings['LBL_VOLUNTEER_STATUS'] = 'Volunteer Status';

// Help Text
$mod_strings['LBL_PREFERRED_SPORTS_HELP'] = 'Select sports the volunteer is interested in or has experience with. Used for program matching.';
$mod_strings['LBL_PREFERRED_AGE_GROUPS_HELP'] = 'Age groups the volunteer prefers to work with. Used to match with appropriate programs.';
$mod_strings['LBL_AVAILABILITY_DAYS_HELP'] = 'Days of the week the volunteer is typically available. Used for scheduling.';
$mod_strings['LBL_VOLUNTEER_EXPERIENCE_LEVEL_HELP'] = 'Experience level with youth sports volunteering. Helps determine appropriate assignments.';
$mod_strings['LBL_SPECIAL_SKILLS_HELP'] = 'Special skills, certifications, or qualifications (CPR, First Aid, coaching licenses, etc.)';
$mod_strings['LBL_VOLUNTEER_STATUS_HELP'] = 'Current availability status of the volunteer.';

// Panel Labels
$mod_strings['LBL_PANEL_VOLUNTEER_PROFILE'] = 'Volunteer Profile & Preferences';

// List View Labels (shortened for space)
$mod_strings['LBL_LIST_PREFERRED_SPORTS'] = 'Sports';
$mod_strings['LBL_LIST_PREFERRED_AGE_GROUPS'] = 'Age Groups';
$mod_strings['LBL_LIST_AVAILABILITY_DAYS'] = 'Available';
$mod_strings['LBL_LIST_VOLUNTEER_EXPERIENCE_LEVEL'] = 'Experience';
$mod_strings['LBL_LIST_VOLUNTEER_STATUS'] = 'Status';

// Search Labels
$mod_strings['LBL_SEARCH_VOLUNTEERS_BY_SPORT'] = 'Find Volunteers by Sport';
$mod_strings['LBL_SEARCH_VOLUNTEERS_BY_AGE_GROUP'] = 'Find Volunteers by Age Group';
$mod_strings['LBL_SEARCH_AVAILABLE_VOLUNTEERS'] = 'Find Available Volunteers'; 

// created: 2025-07-27 07:34:12
$mod_strings['LBL_EDITVIEW_PANEL1'] = 'Youth Sports League';
$mod_strings['LBL_DETAILVIEW_PANEL1'] = 'Youth Sports League';
$mod_strings['LBL_DETAILVIEW_PANEL2'] = 'New Panel 2';
$mod_strings['LBL_DETAILVIEW_PANEL3'] = 'Youth Sports League';
$mod_strings['LBL_EDITVIEW_PANEL2'] = 'Parents - Youth Sports League';

