<?php
/**
 * Entry Point Registration for Feature 4: Basic Parent Notification System
 * 
 * Registers the parent_communication entry point to make the dashboard accessible
 * via: index.php?entryPoint=parent_communication
 */

$entry_point_registry['parent_communication'] = array(
    'file' => 'custom/parent_communication_dashboard.php',
    'auth' => true,
); 