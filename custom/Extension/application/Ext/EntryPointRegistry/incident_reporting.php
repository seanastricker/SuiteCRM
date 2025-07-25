<?php
/**
 * Entry Point Registration for Feature 3: Quick Incident Reporting
 * 
 * Registers the incident_reporting entry point to make the dashboard accessible
 * via: index.php?entryPoint=incident_reporting
 */

$entry_point_registry['incident_reporting'] = array(
    'file' => 'custom/incident_reporting_dashboard.php',
    'auth' => true,
); 