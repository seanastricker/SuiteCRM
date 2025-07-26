<?php

/**
 * Equipment Helper Class
 * 
 * Handles all business logic for equipment management including:
 * - Equipment inventory tracking
 * - Check-out and return workflows  
 * - Overdue equipment monitoring
 * - Usage history and reports
 * 
 * @author SuiteCRM Development Team
 * @package Equipment
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/utils.php');

class EquipmentHelper
{
    /**
     * Get equipment summary statistics for dashboard
     */
    public static function getEquipmentSummary()
    {
        global $db;
        
        $summary = array(
            'total_equipment' => 0,
            'available' => 0,
            'checked_out' => 0,
            'maintenance' => 0,
            'overdue' => 0,
        );
        
        try {
            // Total equipment count
            $query = "SELECT COUNT(*) as total FROM equipment WHERE deleted = 0";
            $result = $db->query($query);
            if ($result && $row = $db->fetchByAssoc($result)) {
                $summary['total_equipment'] = (int)$row['total'];
            }
            
            // Equipment by status
            $query = "SELECT checkout_status, COUNT(*) as count 
                     FROM equipment 
                     WHERE deleted = 0 
                     GROUP BY checkout_status";
            $result = $db->query($query);
            if ($result) {
                while ($row = $db->fetchByAssoc($result)) {
                    $status = $row['checkout_status'];
                    $count = (int)$row['count'];
                    
                    switch ($status) {
                        case 'available':
                            $summary['available'] = $count;
                            break;
                        case 'checked_out':
                            $summary['checked_out'] = $count;
                            break;
                        case 'maintenance':
                            $summary['maintenance'] = $count;
                            break;
                    }
                }
            }
            
            // Overdue equipment
            $today = date('Y-m-d');
            $query = "SELECT COUNT(*) as overdue 
                     FROM equipment 
                     WHERE deleted = 0 
                     AND checkout_status = 'checked_out' 
                     AND due_date < '$today'";
            $result = $db->query($query);
            if ($result && $row = $db->fetchByAssoc($result)) {
                $summary['overdue'] = (int)$row['overdue'];
            }
            
        } catch (Exception $e) {
            error_log("Error getting equipment summary: " . $e->getMessage());
        }
        
        return $summary;
    }
    
    /**
     * Get all equipment with optional filtering
     */
    public static function getEquipment($filters = array())
    {
        $equipment = BeanFactory::getBean('Equipment');
        if (!$equipment) {
            error_log("EquipmentHelper: Could not load Equipment bean");
            return array();
        }
        
        $where = "equipment.deleted = 0";
        
        // Apply filters
        if (!empty($filters['status'])) {
            $status = $equipment->db->quote($filters['status']);
            $where .= " AND equipment.checkout_status = '$status'";
        }
        
        if (!empty($filters['type'])) {
            $type = $equipment->db->quote($filters['type']);
            $where .= " AND equipment.equipment_type = '$type'";
        }
        
        if (!empty($filters['program'])) {
            $program = $equipment->db->quote($filters['program']);
            $where .= " AND equipment.program_association = '$program'";
        }
        
        if (!empty($filters['overdue']) && $filters['overdue'] === 'yes') {
            $today = date('Y-m-d');
            $where .= " AND equipment.checkout_status = 'checked_out' AND equipment.due_date < '$today'";
        }
        
        // Use get_full_list to retrieve equipment
        $equipment_list = $equipment->get_full_list("equipment.name", $where);
        
        $equipment_data = array();
        
        if ($equipment_list) {
            foreach ($equipment_list as $eq_bean) {
                $equipment_data[] = array(
                    'id' => $eq_bean->id,
                    'name' => $eq_bean->name,
                    'equipment_type' => $eq_bean->equipment_type ?? '',
                    'brand' => $eq_bean->brand ?? '',
                    'model' => $eq_bean->model ?? '',
                    'serial_number' => $eq_bean->serial_number ?? '',
                    'condition_status' => $eq_bean->condition_status ?? 'good',
                    'checkout_status' => $eq_bean->checkout_status ?? 'available',
                    'current_location' => $eq_bean->current_location ?? '',
                    'purchase_date' => $eq_bean->purchase_date ?? '',
                    'purchase_price' => $eq_bean->purchase_price ?? 0,
                    'checkout_date' => $eq_bean->checkout_date ?? '',
                    'due_date' => $eq_bean->due_date ?? '',
                    'return_date' => $eq_bean->return_date ?? '',
                    'checked_out_by' => $eq_bean->checked_out_by ?? '',
                    'checkout_notes' => $eq_bean->checkout_notes ?? '',
                    'program_association' => $eq_bean->program_association ?? '',
                    'is_overdue' => self::isOverdue($eq_bean->due_date, $eq_bean->checkout_status),
                );
            }
        }
        
        return $equipment_data;
    }
    
    /**
     * Check out equipment to a person
     */
    public static function checkOutEquipment($equipment_id, $checkout_data)
    {
        try {
            $equipment = BeanFactory::getBean('Equipment', $equipment_id);
            if (!$equipment || !$equipment->id) {
                return array('success' => false, 'message' => 'Equipment not found');
            }
            
            // Validate equipment is available
            if ($equipment->checkout_status !== 'available') {
                return array('success' => false, 'message' => 'Equipment is not available for checkout');
            }
            
            // Validate required fields
            if (empty($checkout_data['checked_out_by'])) {
                return array('success' => false, 'message' => 'Please specify who is checking out the equipment');
            }
            
            if (empty($checkout_data['due_date'])) {
                return array('success' => false, 'message' => 'Please specify a due date');
            }
            
            // Update equipment record
            $equipment->checkout_status = 'checked_out';
            $equipment->checkout_date = date('Y-m-d H:i:s');
            $equipment->due_date = $checkout_data['due_date'];
            $equipment->checked_out_by = $checkout_data['checked_out_by'];
            $equipment->checkout_notes = $checkout_data['checkout_notes'] ?? '';
            $equipment->program_association = $checkout_data['program_association'] ?? '';
            $equipment->current_location = $checkout_data['current_location'] ?? 'Checked Out';
            
            // Clear return date
            $equipment->return_date = '';
            
            $equipment->save();
            
            // Log the checkout
            self::logEquipmentTransaction($equipment_id, 'checkout', $checkout_data);
            
            return array('success' => true, 'message' => 'Equipment checked out successfully');
            
        } catch (Exception $e) {
            error_log("Error checking out equipment: " . $e->getMessage());
            return array('success' => false, 'message' => 'Error checking out equipment: ' . $e->getMessage());
        }
    }
    
    /**
     * Return equipment
     */
    public static function returnEquipment($equipment_id, $return_data = array())
    {
        try {
            $equipment = BeanFactory::getBean('Equipment', $equipment_id);
            if (!$equipment || !$equipment->id) {
                return array('success' => false, 'message' => 'Equipment not found');
            }
            
            // Validate equipment is checked out
            if ($equipment->checkout_status !== 'checked_out') {
                return array('success' => false, 'message' => 'Equipment is not currently checked out');
            }
            
            // Update equipment record
            $equipment->checkout_status = 'available';
            $equipment->return_date = date('Y-m-d H:i:s');
            $equipment->current_location = $return_data['current_location'] ?? 'Equipment Storage';
            
            // Update condition if provided
            if (!empty($return_data['condition_status'])) {
                $equipment->condition_status = $return_data['condition_status'];
            }
            
            // Clear checkout fields
            $equipment->checked_out_by = '';
            $equipment->checkout_notes = '';
            $equipment->due_date = '';
            
            $equipment->save();
            
            // Log the return
            self::logEquipmentTransaction($equipment_id, 'return', $return_data);
            
            return array('success' => true, 'message' => 'Equipment returned successfully');
            
        } catch (Exception $e) {
            error_log("Error returning equipment: " . $e->getMessage());
            return array('success' => false, 'message' => 'Error returning equipment: ' . $e->getMessage());
        }
    }
    
    /**
     * Mark equipment for maintenance
     */
    public static function markForMaintenance($equipment_id, $maintenance_data = array())
    {
        try {
            $equipment = BeanFactory::getBean('Equipment', $equipment_id);
            if (!$equipment || !$equipment->id) {
                return array('success' => false, 'message' => 'Equipment not found');
            }
            
            // Validate equipment is available for maintenance
            if ($equipment->checkout_status === 'checked_out') {
                return array('success' => false, 'message' => 'Cannot mark checked out equipment for maintenance. Please return it first.');
            }
            
            if ($equipment->checkout_status === 'maintenance') {
                return array('success' => false, 'message' => 'Equipment is already marked for maintenance');
            }
            
            // Update equipment record
            $equipment->checkout_status = 'maintenance';
            $equipment->current_location = 'Maintenance Area';
            
            // Store maintenance info in description field for now
            if (!empty($maintenance_data['maintenance_notes'])) {
                $equipment->description = 'MAINTENANCE: ' . $maintenance_data['maintenance_notes'] . ' (Started: ' . date('Y-m-d H:i:s') . ')';
            } else {
                $equipment->description = 'MAINTENANCE: Marked for maintenance on ' . date('Y-m-d H:i:s');
            }
            
            // Clear any checkout information
            $equipment->checked_out_by = '';
            $equipment->checkout_notes = '';
            $equipment->due_date = '';
            
            $equipment->save();
            
            // Log the maintenance action
            self::logEquipmentTransaction($equipment_id, 'mark_maintenance', $maintenance_data);
            
            return array('success' => true, 'message' => 'Equipment marked for maintenance successfully');
            
        } catch (Exception $e) {
            error_log("Error marking equipment for maintenance: " . $e->getMessage());
            return array('success' => false, 'message' => 'Error marking equipment for maintenance: ' . $e->getMessage());
        }
    }
    
    /**
     * Return equipment from maintenance
     */
    public static function returnFromMaintenance($equipment_id, $return_data = array())
    {
        try {
            $equipment = BeanFactory::getBean('Equipment', $equipment_id);
            if (!$equipment || !$equipment->id) {
                return array('success' => false, 'message' => 'Equipment not found');
            }
            
            // Validate equipment is in maintenance
            if ($equipment->checkout_status !== 'maintenance') {
                return array('success' => false, 'message' => 'Equipment is not currently in maintenance');
            }
            
            // Update equipment record
            $equipment->checkout_status = 'available';
            $equipment->current_location = $return_data['current_location'] ?? 'Equipment Storage';
            
            // Update condition if provided
            if (!empty($return_data['condition_status'])) {
                $equipment->condition_status = $return_data['condition_status'];
            }
            
            // Clear maintenance info from description
            if (strpos($equipment->description, 'MAINTENANCE:') === 0) {
                $equipment->description = 'Returned from maintenance on ' . date('Y-m-d H:i:s');
            }
            
            $equipment->save();
            
            // Log the return from maintenance
            self::logEquipmentTransaction($equipment_id, 'return_from_maintenance', $return_data);
            
            return array('success' => true, 'message' => 'Equipment returned from maintenance successfully');
            
        } catch (Exception $e) {
            error_log("Error returning equipment from maintenance: " . $e->getMessage());
            return array('success' => false, 'message' => 'Error returning equipment from maintenance: ' . $e->getMessage());
        }
    }
    
    /**
     * Get overdue equipment
     */
    public static function getOverdueEquipment()
    {
        $filters = array('overdue' => 'yes');
        return self::getEquipment($filters);
    }
    
    /**
     * Check if equipment is overdue
     */
    private static function isOverdue($due_date, $checkout_status)
    {
        if ($checkout_status !== 'checked_out' || empty($due_date)) {
            return false;
        }
        
        $today = date('Y-m-d');
        return $due_date < $today;
    }
    
    /**
     * Log equipment transaction for history tracking
     */
    private static function logEquipmentTransaction($equipment_id, $action, $data)
    {
        global $db, $current_user;
        
        try {
            $user_id = !empty($current_user) ? $current_user->id : '';
            $user_name = !empty($current_user) ? $current_user->user_name : 'system';
            $transaction_date = date('Y-m-d H:i:s');
            $notes = '';
            
            if ($action === 'checkout') {
                $notes = "Checked out to: " . ($data['checked_out_by'] ?? 'Unknown');
                if (!empty($data['checkout_notes'])) {
                    $notes .= " | Notes: " . $data['checkout_notes'];
                }
            } elseif ($action === 'return') {
                $notes = "Equipment returned";
                if (!empty($data['condition_status'])) {
                    $notes .= " | Condition: " . $data['condition_status'];
                }
            }
            
            // Create equipment transaction log entry (could be expanded to separate table)
            error_log("Equipment Transaction: Equipment ID=$equipment_id, Action=$action, User=$user_name, Notes=$notes");
            
        } catch (Exception $e) {
            error_log("Error logging equipment transaction: " . $e->getMessage());
        }
    }
    
    /**
     * Send overdue equipment notifications
     */
    public static function sendOverdueNotifications()
    {
        $overdue_equipment = self::getOverdueEquipment();
        
        if (empty($overdue_equipment)) {
            return array('success' => true, 'message' => 'No overdue equipment found');
        }
        
        // Group overdue equipment by person who checked it out
        $overdue_by_person = array();
        $coordinator_list = array();
        
        foreach ($overdue_equipment as $equipment) {
            $person = $equipment['checked_out_by'];
            if (!isset($overdue_by_person[$person])) {
                $overdue_by_person[$person] = array();
            }
            $overdue_by_person[$person][] = $equipment;
            
            // Add to coordinator list for summary
            $coordinator_list[] = $equipment;
        }
        
        $sent_count = 0;
        $errors = array();
        
        // Send individual notifications (if email addresses available)
        foreach ($overdue_by_person as $person => $equipment_list) {
            $result = self::sendOverdueEmailToPerson($person, $equipment_list);
            if ($result['success']) {
                $sent_count++;
            } else {
                $errors[] = "Failed to notify $person: " . $result['message'];
            }
        }
        
        // Send coordinator summary
        $coordinator_result = self::sendOverdueSummaryToCoordinator($coordinator_list);
        if (!$coordinator_result['success']) {
            $errors[] = "Failed to send coordinator summary: " . $coordinator_result['message'];
        }
        
        // Log overdue notifications
        error_log("Equipment Overdue Notifications: Sent $sent_count individual notifications, " . count($coordinator_list) . " overdue items total");
        
        return array(
            'success' => true, 
            'message' => "Sent $sent_count notifications for " . count($coordinator_list) . " overdue items",
            'errors' => $errors
        );
    }
    
    /**
     * Send overdue notification to individual person
     */
    private static function sendOverdueEmailToPerson($person, $equipment_list)
    {
        // For demo purposes, we'll log the notification
        // In production, this would send actual emails
        
        $equipment_names = array_map(function($eq) { return $eq['name']; }, $equipment_list);
        $subject = "Equipment Return Reminder - " . count($equipment_names) . " Item(s) Overdue";
        
        $message = "Dear $person,\n\n";
        $message .= "This is a reminder that the following equipment is overdue for return:\n\n";
        
        foreach ($equipment_list as $equipment) {
            $days_overdue = self::getDaysOverdue($equipment['due_date']);
            $message .= "• {$equipment['name']} - Due: {$equipment['due_date']} ({$days_overdue} days overdue)\n";
        }
        
        $message .= "\nPlease return these items as soon as possible. ";
        $message .= "If you need an extension or have any questions, please contact the equipment coordinator.\n\n";
        $message .= "Thank you,\nEquipment Management System";
        
        // Log the notification (in production, use mail() function)
        error_log("Overdue Equipment Notification to $person: $subject");
        error_log("Message: " . str_replace("\n", " | ", $message));
        
        return array('success' => true, 'message' => 'Notification logged successfully');
    }
    
    /**
     * Send overdue summary to equipment coordinator
     */
    private static function sendOverdueSummaryToCoordinator($overdue_equipment)
    {
        global $current_user;
        
        $coordinator_email = !empty($current_user) ? $current_user->email1 : 'admin@example.com';
        $subject = "Equipment Overdue Summary - " . count($overdue_equipment) . " Items";
        
        $message = "Equipment Coordinator Summary:\n\n";
        $message .= "The following equipment is currently overdue:\n\n";
        
        foreach ($overdue_equipment as $equipment) {
            $days_overdue = self::getDaysOverdue($equipment['due_date']);
            $message .= "• {$equipment['name']} ({$equipment['equipment_type']})\n";
            $message .= "  Checked out by: {$equipment['checked_out_by']}\n";
            $message .= "  Due date: {$equipment['due_date']} ({$days_overdue} days overdue)\n";
            $message .= "  Program: {$equipment['program_association']}\n\n";
        }
        
        $message .= "Please follow up with the individuals listed above.\n\n";
        $message .= "Equipment Management System";
        
        // Log the coordinator summary (in production, use mail() function)
        error_log("Overdue Equipment Coordinator Summary: $subject");
        error_log("Summary: " . str_replace("\n", " | ", $message));
        
        return array('success' => true, 'message' => 'Coordinator summary logged successfully');
    }
    
    /**
     * Calculate days overdue
     */
    private static function getDaysOverdue($due_date)
    {
        $today = new DateTime();
        $due = new DateTime($due_date);
        $diff = $today->diff($due);
        
        return $diff->days;
    }
    
    /**
     * Get equipment usage statistics
     */
    public static function getUsageStatistics($period_days = 30)
    {
        global $db;
        
        $stats = array(
            'total_checkouts' => 0,
            'total_returns' => 0,
            'average_checkout_duration' => 0,
            'most_popular_equipment' => array(),
            'busiest_programs' => array(),
        );
        
        try {
            $period_start = date('Y-m-d', strtotime("-{$period_days} days"));
            
            // Total checkouts in period
            $query = "SELECT COUNT(*) as total 
                     FROM equipment 
                     WHERE deleted = 0 
                     AND checkout_date >= '$period_start'";
            $result = $db->query($query);
            if ($result && $row = $db->fetchByAssoc($result)) {
                $stats['total_checkouts'] = (int)$row['total'];
            }
            
            // Total returns in period
            $query = "SELECT COUNT(*) as total 
                     FROM equipment 
                     WHERE deleted = 0 
                     AND return_date >= '$period_start'";
            $result = $db->query($query);
            if ($result && $row = $db->fetchByAssoc($result)) {
                $stats['total_returns'] = (int)$row['total'];
            }
            
            // Most popular equipment types
            $query = "SELECT equipment_type, COUNT(*) as checkout_count 
                     FROM equipment 
                     WHERE deleted = 0 
                     AND checkout_date >= '$period_start'
                     GROUP BY equipment_type 
                     ORDER BY checkout_count DESC 
                     LIMIT 5";
            $result = $db->query($query);
            if ($result) {
                while ($row = $db->fetchByAssoc($result)) {
                    $stats['most_popular_equipment'][] = array(
                        'type' => $row['equipment_type'],
                        'count' => (int)$row['checkout_count']
                    );
                }
            }
            
            // Busiest programs
            $query = "SELECT program_association, COUNT(*) as checkout_count 
                     FROM equipment 
                     WHERE deleted = 0 
                     AND checkout_date >= '$period_start'
                     AND program_association != ''
                     GROUP BY program_association 
                     ORDER BY checkout_count DESC 
                     LIMIT 5";
            $result = $db->query($query);
            if ($result) {
                while ($row = $db->fetchByAssoc($result)) {
                    $stats['busiest_programs'][] = array(
                        'program' => $row['program_association'],
                        'count' => (int)$row['checkout_count']
                    );
                }
            }
            
            // Calculate average checkout duration for returned items
            $query = "SELECT AVG(DATEDIFF(return_date, checkout_date)) as avg_duration 
                     FROM equipment 
                     WHERE deleted = 0 
                     AND checkout_date >= '$period_start'
                     AND return_date IS NOT NULL 
                     AND return_date != ''";
            $result = $db->query($query);
            if ($result && $row = $db->fetchByAssoc($result)) {
                $stats['average_checkout_duration'] = round($row['avg_duration'] ?? 0, 1);
            }
            
        } catch (Exception $e) {
            error_log("Error getting equipment usage statistics: " . $e->getMessage());
        }
        
        return $stats;
    }
    
    /**
     * Get equipment history for a specific item
     */
    public static function getEquipmentHistory($equipment_id, $limit = 10)
    {
        // In a full implementation, this would query a separate transaction log table
        // For now, we'll return basic information from the main equipment record
        
        $equipment = BeanFactory::getBean('Equipment', $equipment_id);
        if (!$equipment || !$equipment->id) {
            return array();
        }
        
        $history = array();
        
        // Current status
        if ($equipment->checkout_status === 'checked_out') {
            $history[] = array(
                'date' => $equipment->checkout_date,
                'action' => 'Checked Out',
                'person' => $equipment->checked_out_by,
                'notes' => $equipment->checkout_notes,
                'due_date' => $equipment->due_date,
            );
        } elseif ($equipment->return_date) {
            $history[] = array(
                'date' => $equipment->return_date,
                'action' => 'Returned',
                'person' => 'Equipment Coordinator',
                'notes' => 'Equipment returned',
                'condition' => $equipment->condition_status,
            );
        }
        
        // Add creation record
        $history[] = array(
            'date' => $equipment->date_entered,
            'action' => 'Added to Inventory',
            'person' => 'System',
            'notes' => 'Equipment added to system',
        );
        
        return $history;
    }
    
    /**
     * Generate equipment reports
     */
    public static function generateReports()
    {
        $reports = array();
        
        // Overdue Equipment Report
        $overdue = self::getOverdueEquipment();
        $reports['overdue'] = array(
            'title' => 'Overdue Equipment',
            'count' => count($overdue),
            'items' => $overdue,
            'severity' => count($overdue) > 0 ? 'high' : 'low'
        );
        
        // Equipment Utilization Report
        $summary = self::getEquipmentSummary();
        $utilization_rate = $summary['total_equipment'] > 0 ? 
            round(($summary['checked_out'] / $summary['total_equipment']) * 100, 1) : 0;
        
        $reports['utilization'] = array(
            'title' => 'Equipment Utilization',
            'utilization_rate' => $utilization_rate,
            'total_equipment' => $summary['total_equipment'],
            'checked_out' => $summary['checked_out'],
            'available' => $summary['available'],
            'severity' => $utilization_rate > 80 ? 'high' : ($utilization_rate > 60 ? 'medium' : 'low')
        );
        
        // Equipment Condition Report
        $condition_stats = self::getEquipmentByCondition();
        $reports['condition'] = array(
            'title' => 'Equipment Condition',
            'stats' => $condition_stats,
            'severity' => ($condition_stats['damaged'] + $condition_stats['needs_repair']) > 0 ? 'medium' : 'low'
        );
        
        // Usage Statistics
        $usage_stats = self::getUsageStatistics(30);
        $reports['usage'] = array(
            'title' => '30-Day Usage Statistics',
            'stats' => $usage_stats,
            'severity' => 'info'
        );
        
        return $reports;
    }
    
    /**
     * Get equipment breakdown by condition
     */
    private static function getEquipmentByCondition()
    {
        global $db;
        
        $conditions = array(
            'excellent' => 0,
            'good' => 0,
            'fair' => 0,
            'poor' => 0,
            'damaged' => 0,
            'needs_repair' => 0,
        );
        
        try {
            $query = "SELECT condition_status, COUNT(*) as count 
                     FROM equipment 
                     WHERE deleted = 0 
                     GROUP BY condition_status";
            $result = $db->query($query);
            
            if ($result) {
                while ($row = $db->fetchByAssoc($result)) {
                    $condition = $row['condition_status'];
                    if (isset($conditions[$condition])) {
                        $conditions[$condition] = (int)$row['count'];
                    }
                }
            }
        } catch (Exception $e) {
            error_log("Error getting equipment condition stats: " . $e->getMessage());
        }
        
        return $conditions;
    }
    
    /**
     * Get dropdown options for equipment fields
     */
    public static function getDropdownOptions()
    {
        return array(
            'equipment_types' => array(
                'football' => 'Football Equipment',
                'soccer' => 'Soccer Equipment', 
                'basketball' => 'Basketball Equipment',
                'tennis' => 'Tennis Equipment',
                'baseball' => 'Baseball Equipment',
                'volleyball' => 'Volleyball Equipment',
                'general' => 'General Sports Equipment',
                'safety' => 'Safety Equipment',
                'maintenance' => 'Maintenance Equipment',
            ),
            'equipment_conditions' => array(
                'excellent' => 'Excellent',
                'good' => 'Good',
                'fair' => 'Fair',
                'poor' => 'Poor',
                'damaged' => 'Damaged',
                'needs_repair' => 'Needs Repair',
            ),
            'equipment_statuses' => array(
                'available' => 'Available',
                'checked_out' => 'Checked Out',
                'maintenance' => 'In Maintenance',
                'damaged' => 'Damaged',
                'retired' => 'Retired',
            ),
            'programs' => array(
                'Football U7' => 'Football U7',
                'Soccer U8' => 'Soccer U8', 
                'Basketball U12' => 'Basketball U12',
                'Tennis U10' => 'Tennis U10',
                'Baseball U9' => 'Baseball U9',
                'Volleyball U11' => 'Volleyball U11',
                'General' => 'General Use',
            ),
        );
    }
    
    /**
     * Create equipment table if it doesn't exist
     */
    public static function createEquipmentTable()
    {
        global $db;
        
        // Check if table exists
        $tables = $db->getTablesArray();
        if (in_array('equipment', $tables)) {
            return true; // Table already exists
        }
        
        $sql = "CREATE TABLE equipment (
            id char(36) NOT NULL PRIMARY KEY,
            name varchar(255) NOT NULL,
            date_entered datetime NULL,
            date_modified datetime NULL,
            modified_user_id char(36) NULL,
            created_by char(36) NULL,
            description text NULL,
            deleted tinyint(1) DEFAULT 0,
            equipment_type varchar(100) NOT NULL,
            brand varchar(100) NULL,
            model varchar(100) NULL,
            serial_number varchar(100) NULL,
            condition_status varchar(50) DEFAULT 'good',
            checkout_status varchar(50) DEFAULT 'available',
            current_location varchar(200) NULL,
            purchase_date date NULL,
            purchase_price decimal(10,2) NULL,
            checkout_date datetime NULL,
            due_date date NULL,
            return_date datetime NULL,
            checked_out_by varchar(100) NULL,
            checkout_notes text NULL,
            program_association varchar(100) NULL,
            INDEX idx_equipment_status (checkout_status),
            INDEX idx_equipment_type (equipment_type),
            INDEX idx_equipment_due_date (due_date),
            INDEX idx_equipment_deleted (deleted)
        )";
        
        try {
            $db->query($sql);
            return true;
        } catch (Exception $e) {
            error_log("Error creating equipment table: " . $e->getMessage());
            return false;
        }
    }
} 