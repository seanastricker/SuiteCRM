<?php
/**
 * VolunteerHours Module - Recognition Dashboard View
 * 
 * This view displays volunteer hours statistics and recognition reports.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/View/SugarView.php');

class VolunteerHoursViewVolunteerhoursrecognition extends SugarView
{
    /**
     * Display the volunteer hours recognition dashboard
     */
    public function display()
    {
        global $mod_strings, $app_strings, $current_user;

        // Set page title
        echo '<div style="padding: 20px;">';
        echo '<h2>Volunteer Hours Recognition Dashboard</h2>';
        
        try {
            // Try to get basic statistics
            require_once('data/BeanFactory.php');
            $volunteerHours = BeanFactory::newBean('VolunteerHours');
            
            if ($volunteerHours) {
                // Get simple count
                $countQuery = "SELECT COUNT(*) as total_entries FROM volunteerhours WHERE deleted = 0";
                $result = $volunteerHours->db->query($countQuery);
                $row = $volunteerHours->db->fetchByAssoc($result);
                $totalEntries = $row['total_entries'] ? $row['total_entries'] : 0;
                
                echo '<div style="background: #f0f0f0; padding: 15px; margin: 10px 0; border-radius: 5px;">';
                echo '<h3>📊 Statistics</h3>';
                echo '<p><strong>Total Volunteer Hours Entries:</strong> ' . $totalEntries . '</p>';
                echo '</div>';
                
                // Get recent entries with proper volunteer names
                $recentQuery = "SELECT vh.name, vh.volunteer_id_c, vh.volunteer_name_c, vh.hours_logged_c, vh.activity_date_c, vh.activity_type_c, vh.program_name_c,
                                       c.first_name, c.last_name, CONCAT(c.first_name, ' ', c.last_name) as contact_name
                               FROM volunteerhours vh 
                               LEFT JOIN contacts c ON vh.volunteer_id_c = c.id
                               WHERE vh.deleted = 0 
                               ORDER BY vh.date_entered DESC 
                               LIMIT 5";
                $recentResult = $volunteerHours->db->query($recentQuery);
                
                echo '<div style="background: #f0f0f0; padding: 15px; margin: 10px 0; border-radius: 5px;">';
                echo '<h3>📋 Recent Entries</h3>';
                echo '<ul>';
                
                while ($entry = $volunteerHours->db->fetchByAssoc($recentResult)) {
                    // Try different sources for volunteer name
                    $volunteer = 'Unknown Volunteer';
                    if (!empty($entry['contact_name']) && trim($entry['contact_name']) != '') {
                        $volunteer = trim($entry['contact_name']);
                    } elseif (!empty($entry['volunteer_name_c'])) {
                        $volunteer = $entry['volunteer_name_c'];
                    } elseif (!empty($entry['first_name']) || !empty($entry['last_name'])) {
                        $volunteer = trim($entry['first_name'] . ' ' . $entry['last_name']);
                    }
                    
                    $hours = $entry['hours_logged_c'] ? $entry['hours_logged_c'] : '0';
                    $date = $entry['activity_date_c'] ? $entry['activity_date_c'] : 'No date';
                    $activity = $entry['activity_type_c'] ? ' (' . $entry['activity_type_c'] . ')' : '';
                    $program = $entry['program_name_c'] ? ' - ' . $entry['program_name_c'] : '';
                    
                    echo '<li><strong>' . htmlspecialchars($volunteer) . '</strong> - ' . $hours . ' hours (' . $date . ')' . $activity . $program . '</li>';
                }
                echo '</ul>';
                echo '</div>';
                
            } else {
                echo '<p>Unable to load volunteer hours data.</p>';
            }
            
        } catch (Exception $e) {
            echo '<div style="background: #ffeeee; padding: 15px; margin: 10px 0; border-radius: 5px; color: red;">';
            echo '<h3>⚠️ Error</h3>';
            echo '<p>Error loading dashboard: ' . $e->getMessage() . '</p>';
            echo '</div>';
        }
        
        // Quick Actions
        echo '<div style="background: #f0f0f0; padding: 15px; margin: 10px 0; border-radius: 5px;">';
        echo '<h3>🎯 Quick Actions</h3>';
        echo '<p>';
        echo '<a href="index.php?module=VolunteerHours&action=EditView" style="background: #007cba; color: white; padding: 8px 16px; text-decoration: none; margin-right: 10px; border-radius: 3px;">➕ Log New Hours</a>';
        echo '<a href="index.php?module=VolunteerHours&action=index" style="background: #666; color: white; padding: 8px 16px; text-decoration: none; border-radius: 3px;">📋 View All Entries</a>';
        echo '</p>';
        echo '</div>';
        
        echo '</div>';
    }
} 