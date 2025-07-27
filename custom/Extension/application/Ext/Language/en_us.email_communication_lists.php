<?php
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