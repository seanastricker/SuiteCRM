<?php
/**
 * Feature 4: Basic Parent Notification System
 * Entry point registration for parent email sending
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry['send_parent_email'] = array(
    'file' => 'custom/send_parent_email.php',
    'auth' => true,
); 