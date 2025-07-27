<?php
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