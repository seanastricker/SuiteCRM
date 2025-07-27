<?php
/**
 * BackgroundChecks Module - Dashboard View
 * 
 * This view provides a comprehensive dashboard for background check management,
 * showing key metrics, expiring checks, and quick actions.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/View/SugarView.php');

class BackgroundChecksViewBackgroundcheckdashboard extends SugarView
{
    public function display()
    {
        echo '<div style="padding: 20px;">';
        echo '<h2>🛡️ Background Check Management Dashboard</h2>';
        
        try {
            require_once('data/BeanFactory.php');
            $backgroundChecks = BeanFactory::newBean('BackgroundChecks');
            
            if ($backgroundChecks) {
                // Get key statistics
                $stats = $this->getBackgroundCheckStatistics($backgroundChecks);
                
                // Display overview statistics
                $this->displayStatistics($stats);
                
                // Display expiring checks alert
                $this->displayExpiringChecks($backgroundChecks);
                
                // Display recent background checks
                $this->displayRecentChecks($backgroundChecks);
                
                // Display cost summary
                $this->displayCostSummary($backgroundChecks);
                
                // Display quick actions
                $this->displayQuickActions();
                
            } else {
                echo '<p>Unable to load background check data.</p>';
            }
            
        } catch (Exception $e) {
            echo '<div style="background: #ffeeee; padding: 15px; margin: 10px 0; border-radius: 5px; color: red;">';
            echo '<h3>⚠️ Error</h3>';
            echo '<p>Error loading dashboard: ' . $e->getMessage() . '</p>';
            echo '</div>';
        }
        
        echo '</div>';
    }
    
    /**
     * Get comprehensive background check statistics
     */
    private function getBackgroundCheckStatistics($backgroundChecks)
    {
        $stats = array();
        
        try {
            // Total background checks
            $totalQuery = "SELECT COUNT(*) as total FROM background_checks WHERE deleted = 0";
            $result = $backgroundChecks->db->query($totalQuery);
            $row = $backgroundChecks->db->fetchByAssoc($result);
            $stats['total'] = $row['total'] ? $row['total'] : 0;
            
            // Checks by status
            $statusQuery = "SELECT auto_calculated_status_c, COUNT(*) as count 
                           FROM background_checks 
                           WHERE deleted = 0 AND auto_calculated_status_c IS NOT NULL
                           GROUP BY auto_calculated_status_c";
            $result = $backgroundChecks->db->query($statusQuery);
            
            $stats['valid'] = 0;
            $stats['expiring'] = 0;
            $stats['expired'] = 0;
            $stats['pending'] = 0;
            
            while ($row = $backgroundChecks->db->fetchByAssoc($result)) {
                $status = $row['auto_calculated_status_c'];
                $count = $row['count'];
                
                if ($status == 'valid') {
                    $stats['valid'] = $count;
                } elseif ($status == 'expiring') {
                    $stats['expiring'] = $count;
                } elseif ($status == 'expired') {
                    $stats['expired'] = $count;
                } elseif ($status == 'pending') {
                    $stats['pending'] = $count;
                }
            }
            
            // Checks by type
            $typeQuery = "SELECT background_check_type_c, COUNT(*) as count 
                         FROM background_checks 
                         WHERE deleted = 0 AND background_check_type_c IS NOT NULL
                         GROUP BY background_check_type_c
                         ORDER BY count DESC";
            $result = $backgroundChecks->db->query($typeQuery);
            
            $stats['by_type'] = array();
            while ($row = $backgroundChecks->db->fetchByAssoc($result)) {
                $stats['by_type'][] = array(
                    'type' => $row['background_check_type_c'],
                    'count' => $row['count']
                );
            }
            
        } catch (Exception $e) {
            error_log("Error getting background check statistics: " . $e->getMessage());
        }
        
        return $stats;
    }
    
    /**
     * Display key statistics cards
     */
    private function displayStatistics($stats)
    {
        echo '<div style="background: #f8f9fa; padding: 20px; margin: 15px 0; border-radius: 8px;">';
        echo '<h3>📊 Overview Statistics</h3>';
        
        echo '<div style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 15px;">';
        
        // Total checks card
        echo '<div style="background: #007cba; color: white; padding: 15px; border-radius: 5px; min-width: 150px; text-align: center;">';
        echo '<h4 style="margin: 0; font-size: 24px;">' . $stats['total'] . '</h4>';
        echo '<p style="margin: 5px 0 0 0;">Total Background Checks</p>';
        echo '</div>';
        
        // Valid checks card
        echo '<div style="background: #28a745; color: white; padding: 15px; border-radius: 5px; min-width: 150px; text-align: center;">';
        echo '<h4 style="margin: 0; font-size: 24px;">' . $stats['valid'] . '</h4>';
        echo '<p style="margin: 5px 0 0 0;">Valid Checks</p>';
        echo '</div>';
        
        // Expiring checks card
        echo '<div style="background: #ffc107; color: #333; padding: 15px; border-radius: 5px; min-width: 150px; text-align: center;">';
        echo '<h4 style="margin: 0; font-size: 24px;">' . $stats['expiring'] . '</h4>';
        echo '<p style="margin: 5px 0 0 0;">Expiring Soon (30 days)</p>';
        echo '</div>';
        
        // Expired checks card
        echo '<div style="background: #dc3545; color: white; padding: 15px; border-radius: 5px; min-width: 150px; text-align: center;">';
        echo '<h4 style="margin: 0; font-size: 24px;">' . $stats['expired'] . '</h4>';
        echo '<p style="margin: 5px 0 0 0;">Expired Checks</p>';
        echo '</div>';
        
        // Pending checks card
        echo '<div style="background: #6c757d; color: white; padding: 15px; border-radius: 5px; min-width: 150px; text-align: center;">';
        echo '<h4 style="margin: 0; font-size: 24px;">' . $stats['pending'] . '</h4>';
        echo '<p style="margin: 5px 0 0 0;">Pending/No Date</p>';
        echo '</div>';
        
        echo '</div>';
        
        // Check types breakdown
        if (!empty($stats['by_type'])) {
            echo '<div style="margin-top: 20px;">';
            echo '<h4>📋 Checks by Type</h4>';
            echo '<ul style="columns: 2; column-gap: 30px;">';
            foreach ($stats['by_type'] as $typeData) {
                $typeLabel = $this->getCheckTypeLabel($typeData['type']);
                echo '<li><strong>' . htmlspecialchars($typeLabel) . ':</strong> ' . $typeData['count'] . '</li>';
            }
            echo '</ul>';
            echo '</div>';
        }
        
        echo '</div>';
    }
    
    /**
     * Display expiring checks alert section
     */
    private function displayExpiringChecks($backgroundChecks)
    {
        $warning_date = date('Y-m-d', strtotime('+30 days'));
        $current_date = date('Y-m-d');
        
        $expiringQuery = "
            SELECT bc.*, c.first_name, c.last_name, CONCAT(c.first_name, ' ', c.last_name) as volunteer_name
            FROM background_checks bc
            LEFT JOIN contacts c ON bc.volunteer_id_c = c.id
            WHERE bc.deleted = 0 
            AND bc.expiration_date_c IS NOT NULL 
            AND bc.expiration_date_c != ''
            AND bc.expiration_date_c BETWEEN '{$current_date}' AND '{$warning_date}'
            ORDER BY bc.expiration_date_c ASC
            LIMIT 10
        ";
        
        $result = $backgroundChecks->db->query($expiringQuery);
        $expiringChecks = array();
        
        while ($row = $backgroundChecks->db->fetchByAssoc($result)) {
            $expiringChecks[] = $row;
        }
        
        if (!empty($expiringChecks)) {
            echo '<div style="background: #fff3cd; border: 2px solid #ffc107; padding: 20px; margin: 15px 0; border-radius: 8px;">';
            echo '<h3>⚠️ Background Checks Expiring Soon (Next 30 Days)</h3>';
            echo '<div style="overflow-x: auto;">';
            echo '<table style="width: 100%; border-collapse: collapse; margin-top: 10px;">';
            echo '<thead>';
            echo '<tr style="background: #f8f9fa;">';
            echo '<th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Volunteer</th>';
            echo '<th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Check Type</th>';
            echo '<th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Expiration Date</th>';
            echo '<th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Days Until Expiration</th>';
            echo '<th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Action</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            
            foreach ($expiringChecks as $check) {
                $volunteer_name = !empty($check['volunteer_name']) ? $check['volunteer_name'] : 'Unknown Volunteer';
                $check_type = $this->getCheckTypeLabel($check['background_check_type_c']);
                $expiration_date = $check['expiration_date_c'];
                $days_until = floor((strtotime($expiration_date) - time()) / (24 * 60 * 60));
                
                $urgency_color = '';
                if ($days_until <= 7) {
                    $urgency_color = 'background: #f8d7da;'; // Red for urgent
                } elseif ($days_until <= 14) {
                    $urgency_color = 'background: #fff3cd;'; // Yellow for soon
                }
                
                echo '<tr style="' . $urgency_color . '">';
                echo '<td style="padding: 10px; border: 1px solid #ddd;">' . htmlspecialchars($volunteer_name) . '</td>';
                echo '<td style="padding: 10px; border: 1px solid #ddd;">' . htmlspecialchars($check_type) . '</td>';
                echo '<td style="padding: 10px; border: 1px solid #ddd;">' . $expiration_date . '</td>';
                echo '<td style="padding: 10px; border: 1px solid #ddd;">' . $days_until . ' days</td>';
                echo '<td style="padding: 10px; border: 1px solid #ddd;">';
                echo '<a href="index.php?module=BackgroundChecks&action=DetailView&record=' . $check['id'] . '" style="color: #007cba;">View</a>';
                echo '</td>';
                echo '</tr>';
            }
            
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
        }
    }
    
    /**
     * Display recent background checks
     */
    private function displayRecentChecks($backgroundChecks)
    {
        $recentQuery = "
            SELECT bc.*, c.first_name, c.last_name, CONCAT(c.first_name, ' ', c.last_name) as volunteer_name
            FROM background_checks bc
            LEFT JOIN contacts c ON bc.volunteer_id_c = c.id
            WHERE bc.deleted = 0
            ORDER BY bc.date_entered DESC
            LIMIT 5
        ";
        
        $result = $backgroundChecks->db->query($recentQuery);
        
        echo '<div style="background: #f8f9fa; padding: 20px; margin: 15px 0; border-radius: 8px;">';
        echo '<h3>📋 Recent Background Checks</h3>';
        echo '<ul style="list-style: none; padding: 0;">';
        
        while ($check = $backgroundChecks->db->fetchByAssoc($result)) {
            $volunteer_name = !empty($check['volunteer_name']) ? $check['volunteer_name'] : 'Unknown Volunteer';
            $check_type = $this->getCheckTypeLabel($check['background_check_type_c']);
            $check_date = $check['check_date_c'] ? $check['check_date_c'] : $check['date_entered'];
            $status = $check['auto_calculated_status_c'] ? $check['auto_calculated_status_c'] : 'pending';
            
            $status_color = $this->getStatusColor($status);
            
            echo '<li style="margin: 10px 0; padding: 10px; background: white; border-radius: 5px; border-left: 4px solid ' . $status_color . ';">';
            echo '<strong>' . htmlspecialchars($volunteer_name) . '</strong> - ' . htmlspecialchars($check_type);
            echo '<br><small>Check Date: ' . $check_date . ' | Status: ' . ucfirst($status) . '</small>';
            echo '<a href="index.php?module=BackgroundChecks&action=DetailView&record=' . $check['id'] . '" style="float: right; color: #007cba;">View Details</a>';
            echo '</li>';
        }
        
        echo '</ul>';
        echo '</div>';
    }
    
    /**
     * Display cost summary
     */
    private function displayCostSummary($backgroundChecks)
    {
        $costQuery = "
            SELECT 
                COUNT(*) as total_checks,
                SUM(cost_c) as total_cost,
                AVG(cost_c) as avg_cost,
                background_check_type_c,
                SUM(cost_c) as type_cost
            FROM background_checks 
            WHERE deleted = 0 AND cost_c IS NOT NULL AND cost_c > 0
        ";
        
        $result = $backgroundChecks->db->query($costQuery);
        $costData = $backgroundChecks->db->fetchByAssoc($result);
        
        if ($costData && $costData['total_cost']) {
            echo '<div style="background: #e7f3ff; padding: 20px; margin: 15px 0; border-radius: 8px;">';
            echo '<h3>💰 Cost Summary</h3>';
            
            echo '<div style="display: flex; flex-wrap: wrap; gap: 15px;">';
            
            echo '<div style="background: white; padding: 15px; border-radius: 5px; min-width: 150px; text-align: center;">';
            echo '<h4 style="margin: 0; color: #007cba;">$' . number_format($costData['total_cost'], 2) . '</h4>';
            echo '<p style="margin: 5px 0 0 0;">Total Costs</p>';
            echo '</div>';
            
            echo '<div style="background: white; padding: 15px; border-radius: 5px; min-width: 150px; text-align: center;">';
            echo '<h4 style="margin: 0; color: #007cba;">$' . number_format($costData['avg_cost'], 2) . '</h4>';
            echo '<p style="margin: 5px 0 0 0;">Average Cost</p>';
            echo '</div>';
            
            echo '<div style="background: white; padding: 15px; border-radius: 5px; min-width: 150px; text-align: center;">';
            echo '<h4 style="margin: 0; color: #007cba;">' . $costData['total_checks'] . '</h4>';
            echo '<p style="margin: 5px 0 0 0;">Paid Checks</p>';
            echo '</div>';
            
            echo '</div>';
            echo '</div>';
        }
    }
    
    /**
     * Display quick actions
     */
    private function displayQuickActions()
    {
        echo '<div style="background: #f8f9fa; padding: 20px; margin: 15px 0; border-radius: 8px;">';
        echo '<h3>🎯 Quick Actions</h3>';
        echo '<p>';
        echo '<a href="index.php?module=BackgroundChecks&action=EditView" style="background: #007cba; color: white; padding: 10px 20px; text-decoration: none; margin-right: 10px; border-radius: 5px; display: inline-block;">➕ Add New Background Check</a>';
        echo '<a href="index.php?module=BackgroundChecks&action=index" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; margin-right: 10px; border-radius: 5px; display: inline-block;">📋 View All Checks</a>';
        echo '<a href="index.php?module=Contacts&action=index" style="background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">👥 Manage Volunteers</a>';
        echo '</p>';
        echo '</div>';
    }
    
    /**
     * Get human-readable label for check type
     */
    private function getCheckTypeLabel($type)
    {
        $types = array(
            'criminal_history' => 'Criminal History Check',
            'sex_offender_registry' => 'Sex Offender Registry',
            'child_abuse_registry' => 'Child Abuse Registry',
            'reference_check' => 'Reference Check',
            'driving_record' => 'Driving Record',
            'comprehensive' => 'Comprehensive Check',
            'volunteer_screening' => 'Volunteer Screening',
            'coach_certification' => 'Coach Certification',
            'other' => 'Other'
        );
        
        return isset($types[$type]) ? $types[$type] : ucfirst(str_replace('_', ' ', $type));
    }
    
    /**
     * Get color for status display
     */
    private function getStatusColor($status)
    {
        switch ($status) {
            case 'valid':
                return '#28a745';
            case 'expiring':
                return '#ffc107';
            case 'expired':
                return '#dc3545';
            case 'pending':
                return '#6c757d';
            default:
                return '#007cba';
        }
    }
} 