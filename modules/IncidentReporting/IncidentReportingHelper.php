<?php
/**
 * Feature 3: Basic Incident Reporting
 * Helper class for incident reporting business logic
 * 
 * Contains all the business logic for managing safety incidents,
 * separated from the bean to prevent memory issues.
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class IncidentReportingHelper
{
    /**
     * Create the incidents table if it doesn't exist
     */
    public static function createIncidentsTable()
    {
        global $db;
        
        $sql = "CREATE TABLE IF NOT EXISTS safety_incidents (
            id VARCHAR(36) PRIMARY KEY,
            name VARCHAR(255),
            date_entered DATETIME,
            date_modified DATETIME,
            created_by VARCHAR(36),
            modified_user_id VARCHAR(36),
            deleted TINYINT(1) DEFAULT 0,
            
            incident_date DATE NOT NULL,
            incident_time TIME,
            program_name VARCHAR(255),
            child_name VARCHAR(255),
            child_age INT,
            incident_type VARCHAR(50),
            severity_level VARCHAR(20),
            incident_description TEXT,
            immediate_action TEXT,
            incident_status VARCHAR(20) DEFAULT 'reported',
            reporter_name VARCHAR(255),
            reporter_role VARCHAR(50),
            medical_attention TINYINT(1) DEFAULT 0,
            parent_notified TINYINT(1) DEFAULT 0,
            followup_required TINYINT(1) DEFAULT 0,
            followup_notes TEXT
        )";
        
        try {
            $db->query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Save a new incident to the database
     */
    public static function saveIncident($data)
    {
        global $db, $current_user;
        
        // Create table if needed
        self::createIncidentsTable();
        
        // Initialize global functions
        if (!function_exists('create_guid')) {
            require_once('include/utils.php');
        }
        
        $id = create_guid();
        $now = date('Y-m-d H:i:s');
        $user_id = !empty($current_user->id) ? $current_user->id : '';
        
        // Generate incident name
        $incident_name = sprintf("Incident %s - %s", 
            date('Y-m-d', strtotime($data['incident_date'])), 
            substr($data['incident_type'], 0, 20)
        );
        
        // Use direct INSERT with proper quoting
        $sql = sprintf("INSERT INTO safety_incidents (
            id, name, date_entered, date_modified, created_by, modified_user_id,
            incident_date, incident_time, program_name, child_name, child_age,
            incident_type, severity_level, incident_description, immediate_action,
            incident_status, reporter_name, reporter_role, medical_attention,
            parent_notified, followup_required, followup_notes
        ) VALUES (
            '%s', '%s', '%s', '%s', '%s', '%s',
            '%s', '%s', '%s', '%s', %d,
            '%s', '%s', '%s', '%s',
            '%s', '%s', '%s', %d,
            %d, %d, '%s'
        )",
            $db->quote($id),
            $db->quote($incident_name),
            $db->quote($now),
            $db->quote($now),
            $db->quote($user_id),
            $db->quote($user_id),
            $db->quote($data['incident_date']),
            $db->quote($data['incident_time'] ?? ''),
            $db->quote($data['program_name'] ?? ''),
            $db->quote($data['child_name'] ?? ''),
            intval($data['child_age'] ?? 0),
            $db->quote($data['incident_type']),
            $db->quote($data['severity_level']),
            $db->quote($data['incident_description'] ?? ''),
            $db->quote($data['immediate_action'] ?? ''),
            $db->quote($data['incident_status'] ?? 'reported'),
            $db->quote($data['reporter_name'] ?? ''),
            $db->quote($data['reporter_role'] ?? ''),
            intval($data['medical_attention'] ?? 0),
            intval($data['parent_notified'] ?? 0),
            intval($data['followup_required'] ?? 0),
            $db->quote($data['followup_notes'] ?? '')
        );
        
        try {
            $result = $db->query($sql);
            return $result ? $id : false;
        } catch (Exception $e) {
            error_log("Error saving incident: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get incidents with optional filtering
     */
    public static function getIncidents($filters = array())
    {
        global $db;
        
        // Ensure table exists
        self::createIncidentsTable();
        
        $where_conditions = array("deleted = 0");
        
        // Apply filters
        if (!empty($filters['severity'])) {
            $where_conditions[] = sprintf("severity_level = '%s'", $db->quote($filters['severity']));
        }
        
        if (!empty($filters['status'])) {
            $where_conditions[] = sprintf("incident_status = '%s'", $db->quote($filters['status']));
        }
        
        if (!empty($filters['type'])) {
            $where_conditions[] = sprintf("incident_type = '%s'", $db->quote($filters['type']));
        }
        
        if (!empty($filters['date_from'])) {
            $where_conditions[] = sprintf("incident_date >= '%s'", $db->quote($filters['date_from']));
        }
        
        if (!empty($filters['date_to'])) {
            $where_conditions[] = sprintf("incident_date <= '%s'", $db->quote($filters['date_to']));
        }
        
        $where_clause = implode(" AND ", $where_conditions);
        
        $sql = "SELECT * FROM safety_incidents 
                WHERE {$where_clause} 
                ORDER BY incident_date DESC, date_entered DESC 
                LIMIT 50";
        
        try {
            $result = $db->query($sql);
            $incidents = array();
            
            while ($row = $db->fetchByAssoc($result)) {
                // Format the data for display
                $incidents[] = array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'incident_date' => $row['incident_date'],
                    'incident_time' => $row['incident_time'],
                    'program_name' => $row['program_name'],
                    'child_name' => $row['child_name'],
                    'child_age' => $row['child_age'],
                    'incident_type' => $row['incident_type'],
                    'severity_level' => $row['severity_level'],
                    'incident_description' => $row['incident_description'],
                    'immediate_action' => $row['immediate_action'],
                    'incident_status' => $row['incident_status'],
                    'reporter_name' => $row['reporter_name'],
                    'reporter_role' => $row['reporter_role'],
                    'medical_attention' => $row['medical_attention'],
                    'parent_notified' => $row['parent_notified'],
                    'followup_required' => $row['followup_required'],
                    'followup_notes' => $row['followup_notes'],
                    'date_entered' => $row['date_entered'],
                );
            }
            
            return $incidents;
            
        } catch (Exception $e) {
            error_log("Error retrieving incidents: " . $e->getMessage());
            return array();
        }
    }
    
    /**
     * Get incident statistics for dashboard
     */
    public static function getIncidentStats()
    {
        global $db;
        
        self::createIncidentsTable();
        
        $stats = array(
            'total' => 0,
            'today' => 0,
            'this_week' => 0,
            'critical' => 0,
            'high' => 0,
            'open' => 0,
        );
        
        try {
            // Total incidents
            $result = $db->query("SELECT COUNT(*) as count FROM safety_incidents WHERE deleted = 0");
            $row = $db->fetchByAssoc($result);
            $stats['total'] = intval($row['count']);
            
            // Today's incidents
            $today = date('Y-m-d');
            $result = $db->query("SELECT COUNT(*) as count FROM safety_incidents WHERE deleted = 0 AND incident_date = '$today'");
            $row = $db->fetchByAssoc($result);
            $stats['today'] = intval($row['count']);
            
            // This week's incidents
            $week_start = date('Y-m-d', strtotime('monday this week'));
            $result = $db->query("SELECT COUNT(*) as count FROM safety_incidents WHERE deleted = 0 AND incident_date >= '$week_start'");
            $row = $db->fetchByAssoc($result);
            $stats['this_week'] = intval($row['count']);
            
            // Critical incidents
            $result = $db->query("SELECT COUNT(*) as count FROM safety_incidents WHERE deleted = 0 AND severity_level = 'critical'");
            $row = $db->fetchByAssoc($result);
            $stats['critical'] = intval($row['count']);
            
            // High severity incidents
            $result = $db->query("SELECT COUNT(*) as count FROM safety_incidents WHERE deleted = 0 AND severity_level = 'high'");
            $row = $db->fetchByAssoc($result);
            $stats['high'] = intval($row['count']);
            
            // Open incidents
            $result = $db->query("SELECT COUNT(*) as count FROM safety_incidents WHERE deleted = 0 AND incident_status IN ('reported', 'investigating', 'pending')");
            $row = $db->fetchByAssoc($result);
            $stats['open'] = intval($row['count']);
            
        } catch (Exception $e) {
            error_log("Error retrieving incident stats: " . $e->getMessage());
        }
        
        return $stats;
    }
    
    /**
     * Get dropdown options for incident fields
     */
    public static function getDropdownOptions()
    {
        return array(
            'incident_types' => array(
                'injury' => 'Injury',
                'collision' => 'Player Collision',
                'equipment' => 'Equipment Malfunction',
                'facility' => 'Facility Issue',
                'behavior' => 'Behavioral Incident',
                'weather' => 'Weather Related',
                'medical' => 'Medical Emergency',
                'other' => 'Other',
            ),
            'severity_levels' => array(
                'low' => 'Low',
                'medium' => 'Medium',
                'high' => 'High',
                'critical' => 'Critical',
            ),
            'incident_statuses' => array(
                'reported' => 'Reported',
                'investigating' => 'Under Investigation',
                'pending' => 'Pending Resolution',
                'resolved' => 'Resolved',
                'closed' => 'Closed',
            ),
            'reporter_roles' => array(
                'coach' => 'Coach',
                'volunteer' => 'Volunteer',
                'parent' => 'Parent',
                'referee' => 'Referee',
                'administrator' => 'Administrator',
                'medical_staff' => 'Medical Staff',
                'other' => 'Other',
            ),
        );
    }
} 