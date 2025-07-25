<?php
/**
 * Simplified Volunteer Matching Dashboard
 * 
 * This view provides volunteer matching functionality using just
 * the Contacts module with volunteer profile fields.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/View/views/view.detail.php');

class ContactsViewVolunteermatching extends ViewDetail
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display the volunteer matching interface
     */
    public function display()
    {
        global $mod_strings, $app_strings, $current_user;
        
        // Get volunteer contacts
        $volunteers = $this->getVolunteers();
        
        // Get sport/age group combinations from volunteers
        $programs_needed = $this->generateProgramsFromVolunteers($volunteers);
        
        echo "<div class='moduleTitle'>";
        echo "<h2>🏆 Volunteer-Program Matching Dashboard</h2>";
        echo "<p>Analyze volunteer preferences and suggest program assignments.</p>";
        echo "</div>";
        
        // Statistics panel
        echo "<div style='background: #f9f9f9; padding: 15px; margin-bottom: 20px; border-radius: 5px;'>";
        echo "<h3>📊 Current Statistics</h3>";
        echo "<div style='display: flex; gap: 30px;'>";
        echo "<div><strong>Total Volunteers:</strong> " . count($volunteers) . "</div>";
        echo "<div><strong>Available:</strong> " . $this->countByStatus($volunteers, ['active', 'available']) . "</div>";
        echo "<div><strong>Valid Background Checks:</strong> " . $this->countByBackgroundCheck($volunteers, ['valid', 'expiring']) . "</div>";
        echo "</div></div>";
        
        echo "<div style='display: flex; gap: 20px;'>";
        
        // Left panel - Available volunteers
        echo "<div style='flex: 1; border: 1px solid #ccc; padding: 15px; border-radius: 5px;'>";
        echo "<h3>👥 Available Volunteers</h3>";
        
        if (empty($volunteers)) {
            echo "<p><em>No volunteers found.</em></p>";
        } else {
            echo "<div style='max-height: 500px; overflow-y: auto;'>";
            foreach ($volunteers as $volunteer) {
                $this->displayVolunteerCard($volunteer);
            }
            echo "</div>";
        }
        echo "</div>";
        
        // Right panel - Suggested programs
        echo "<div style='flex: 1; border: 1px solid #ccc; padding: 15px; border-radius: 5px;'>";
        echo "<h3>🎯 Suggested Programs</h3>";
        echo "<p><em>Based on volunteer preferences, here are programs you should consider creating:</em></p>";
        
        if (empty($programs_needed)) {
            echo "<p><em>Add more volunteers to see program suggestions.</em></p>";
        } else {
            foreach ($programs_needed as $program => $data) {
                $this->displayProgramSuggestion($program, $data);
            }
        }
        echo "</div>";
        
        echo "</div>";
        
        // Matching analysis section
        echo "<div style='margin-top: 20px; border: 1px solid #ccc; padding: 15px; border-radius: 5px; background-color: #f9f9f9;'>";
        echo "<h3>🔍 Volunteer Preference Analysis</h3>";
        $this->displayPreferenceAnalysis($volunteers);
        echo "</div>";
    }
    
    /**
     * Get volunteers with their profile information
     */
    private function getVolunteers()
    {
        global $db;
        
        $query = "
            SELECT c.id, c.first_name, c.last_name, c.email1, c.phone_work,
                   c.preferred_sports_c, c.preferred_age_groups_c, c.availability_days_c,
                   c.volunteer_experience_level_c, c.volunteer_status_c, c.special_skills_c,
                   c.background_check_status_c, c.background_check_expiration_c, c.contact_type_c
            FROM contacts c
            WHERE c.deleted = 0 
            AND c.contact_type_c IN ('volunteer', 'coach', 'staff')
            ORDER BY c.volunteer_status_c DESC, c.volunteer_experience_level_c DESC, c.last_name ASC
        ";
        
        $result = $db->query($query);
        $volunteers = array();
        
        while ($row = $db->fetchByAssoc($result)) {
            $volunteers[] = $row;
        }
        
        return $volunteers;
    }
    
    /**
     * Generate suggested programs based on volunteer preferences
     */
    private function generateProgramsFromVolunteers($volunteers)
    {
        $programs = array();
        
        foreach ($volunteers as $volunteer) {
            if (empty($volunteer['preferred_sports_c']) || empty($volunteer['preferred_age_groups_c'])) {
                continue;
            }
            
            $sports = explode('^,^', trim($volunteer['preferred_sports_c'], '^'));
            $ages = explode('^,^', trim($volunteer['preferred_age_groups_c'], '^'));
            
            foreach ($sports as $sport) {
                foreach ($ages as $age) {
                    if (empty($sport) || empty($age)) continue;
                    
                    $program_key = $sport . " - " . $age;
                    
                    if (!isset($programs[$program_key])) {
                        $programs[$program_key] = array(
                            'sport' => $sport,
                            'age_group' => $age,
                            'interested_volunteers' => array(),
                            'count' => 0
                        );
                    }
                    
                    $programs[$program_key]['interested_volunteers'][] = $volunteer;
                    $programs[$program_key]['count']++;
                }
            }
        }
        
        // Sort by volunteer interest (highest first)
        uasort($programs, function($a, $b) {
            return $b['count'] - $a['count'];
        });
        
        return array_slice($programs, 0, 10, true); // Top 10
    }
    
    /**
     * Display a volunteer card
     */
    private function displayVolunteerCard($volunteer)
    {
        $name = trim($volunteer['first_name'] . ' ' . $volunteer['last_name']);
        $status_color = $this->getStatusColor($volunteer['volunteer_status_c']);
        $bg_check_color = $this->getBackgroundCheckColor($volunteer['background_check_status_c']);
        
        echo "<div style='border: 1px solid #ddd; padding: 10px; margin-bottom: 8px; border-radius: 3px; background: white;'>";
        echo "<div style='display: flex; justify-content: space-between; align-items: start;'>";
        echo "<div>";
        echo "<strong>{$name}</strong>";
        echo "<div style='font-size: 11px; color: #666;'>";
        echo "Status: <span style='color: {$status_color};'>●</span> {$volunteer['volunteer_status_c']} | ";
        echo "Background: <span style='color: {$bg_check_color};'>●</span> {$volunteer['background_check_status_c']}";
        echo "</div>";
        echo "</div>";
        echo "<div style='font-size: 10px; color: #999;'>{$volunteer['volunteer_experience_level_c']}</div>";
        echo "</div>";
        
        if (!empty($volunteer['preferred_sports_c'])) {
            $sports = str_replace('^,^', ', ', trim($volunteer['preferred_sports_c'], '^'));
            echo "<div style='font-size: 11px; margin-top: 5px;'><strong>Sports:</strong> {$sports}</div>";
        }
        
        if (!empty($volunteer['preferred_age_groups_c'])) {
            $ages = str_replace('^,^', ', ', trim($volunteer['preferred_age_groups_c'], '^'));
            echo "<div style='font-size: 11px;'><strong>Ages:</strong> {$ages}</div>";
        }
        
        if (!empty($volunteer['availability_days_c'])) {
            $days = str_replace('^,^', ', ', trim($volunteer['availability_days_c'], '^'));
            echo "<div style='font-size: 11px;'><strong>Available:</strong> {$days}</div>";
        }
        
        echo "</div>";
    }
    
    /**
     * Display a program suggestion
     */
    private function displayProgramSuggestion($program_name, $data)
    {
        $priority = $data['count'] >= 3 ? 'High' : ($data['count'] >= 2 ? 'Medium' : 'Low');
        $priority_color = $data['count'] >= 3 ? '#28a745' : ($data['count'] >= 2 ? '#ffc107' : '#6c757d');
        
        echo "<div style='border: 1px solid #ddd; padding: 10px; margin-bottom: 8px; border-radius: 3px; background: white;'>";
        echo "<div style='display: flex; justify-content: space-between; align-items: center;'>";
        echo "<strong>{$program_name}</strong>";
        echo "<span style='background: {$priority_color}; color: white; padding: 2px 8px; border-radius: 10px; font-size: 10px;'>{$priority}</span>";
        echo "</div>";
        echo "<div style='font-size: 11px; color: #666; margin-top: 5px;'>";
        echo "<strong>{$data['count']} volunteers interested</strong>";
        echo "</div>";
        
        // Show first few interested volunteers
        $names = array();
        foreach (array_slice($data['interested_volunteers'], 0, 3) as $vol) {
            $names[] = trim($vol['first_name'] . ' ' . $vol['last_name']);
        }
        echo "<div style='font-size: 10px; color: #999;'>";
        echo implode(', ', $names);
        if (count($data['interested_volunteers']) > 3) {
            echo " + " . (count($data['interested_volunteers']) - 3) . " more";
        }
        echo "</div>";
        echo "</div>";
    }
    
    /**
     * Display preference analysis
     */
    private function displayPreferenceAnalysis($volunteers)
    {
        $sports_count = array();
        $ages_count = array();
        $days_count = array();
        
        foreach ($volunteers as $volunteer) {
            // Count sports
            if (!empty($volunteer['preferred_sports_c'])) {
                $sports = explode('^,^', trim($volunteer['preferred_sports_c'], '^'));
                foreach ($sports as $sport) {
                    if (!empty($sport)) {
                        $sports_count[$sport] = ($sports_count[$sport] ?? 0) + 1;
                    }
                }
            }
            
            // Count age groups
            if (!empty($volunteer['preferred_age_groups_c'])) {
                $ages = explode('^,^', trim($volunteer['preferred_age_groups_c'], '^'));
                foreach ($ages as $age) {
                    if (!empty($age)) {
                        $ages_count[$age] = ($ages_count[$age] ?? 0) + 1;
                    }
                }
            }
            
            // Count availability
            if (!empty($volunteer['availability_days_c'])) {
                $days = explode('^,^', trim($volunteer['availability_days_c'], '^'));
                foreach ($days as $day) {
                    if (!empty($day)) {
                        $days_count[$day] = ($days_count[$day] ?? 0) + 1;
                    }
                }
            }
        }
        
        echo "<div style='display: flex; gap: 20px;'>";
        
        echo "<div style='flex: 1;'>";
        echo "<h4>🏃 Most Popular Sports</h4>";
        arsort($sports_count);
        foreach (array_slice($sports_count, 0, 5, true) as $sport => $count) {
            echo "<div>{$sport}: <strong>{$count}</strong> volunteers</div>";
        }
        echo "</div>";
        
        echo "<div style='flex: 1;'>";
        echo "<h4>👶 Most Popular Age Groups</h4>";
        arsort($ages_count);
        foreach (array_slice($ages_count, 0, 5, true) as $age => $count) {
            echo "<div>{$age}: <strong>{$count}</strong> volunteers</div>";
        }
        echo "</div>";
        
        echo "<div style='flex: 1;'>";
        echo "<h4>📅 Most Available Days</h4>";
        arsort($days_count);
        foreach (array_slice($days_count, 0, 7, true) as $day => $count) {
            echo "<div>{$day}: <strong>{$count}</strong> volunteers</div>";
        }
        echo "</div>";
        
        echo "</div>";
    }
    
    /**
     * Helper functions
     */
    private function countByStatus($volunteers, $statuses)
    {
        $count = 0;
        foreach ($volunteers as $vol) {
            if (in_array($vol['volunteer_status_c'], $statuses)) {
                $count++;
            }
        }
        return $count;
    }
    
    private function countByBackgroundCheck($volunteers, $statuses)
    {
        $count = 0;
        foreach ($volunteers as $vol) {
            if (in_array($vol['background_check_status_c'], $statuses)) {
                $count++;
            }
        }
        return $count;
    }
    
    private function getStatusColor($status)
    {
        switch ($status) {
            case 'active': return '#28a745';
            case 'available': return '#17a2b8';
            case 'inactive': return '#6c757d';
            default: return '#ffc107';
        }
    }
    
    private function getBackgroundCheckColor($status)
    {
        switch ($status) {
            case 'valid': return '#28a745';
            case 'expiring': return '#ffc107';
            case 'expired': return '#dc3545';
            default: return '#6c757d';
        }
    }
} 