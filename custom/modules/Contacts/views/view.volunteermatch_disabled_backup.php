<?php
/**
 * Volunteer-Program Matching View
 * 
 * This custom view provides a simple interface for the volunteer coordinator
 * to see programs that need volunteers and find matching volunteers.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/View/views/view.detail.php');

class ContactsViewVolunteermatch extends ViewDetail
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
        
        // Get programs that need volunteers
        $programs_needing_volunteers = $this->getProgramsNeedingVolunteers();
        
        // Get available volunteers
        $available_volunteers = $this->getAvailableVolunteers();
        
        echo "<div class='moduleTitle'>";
        echo "<h2>Volunteer-Program Matching Dashboard</h2>";
        echo "<p>Find and assign volunteers to sports programs that need help.</p>";
        echo "</div>";
        
        echo "<div style='display: flex; gap: 20px;'>";
        
        // Left panel - Programs needing volunteers
        echo "<div style='flex: 1; border: 1px solid #ccc; padding: 15px; border-radius: 5px;'>";
        echo "<h3>Programs Needing Volunteers</h3>";
        
        if (empty($programs_needing_volunteers)) {
            echo "<p><em>All programs are fully staffed!</em></p>";
        } else {
            foreach ($programs_needing_volunteers as $program) {
                $this->displayProgramCard($program);
            }
        }
        echo "</div>";
        
        // Right panel - Available volunteers
        echo "<div style='flex: 1; border: 1px solid #ccc; padding: 15px; border-radius: 5px;'>";
        echo "<h3>Available Volunteers</h3>";
        
        if (empty($available_volunteers)) {
            echo "<p><em>No volunteers currently available.</em></p>";
        } else {
            echo "<div style='max-height: 400px; overflow-y: auto;'>";
            foreach ($available_volunteers as $volunteer) {
                $this->displayVolunteerCard($volunteer);
            }
            echo "</div>";
        }
        echo "</div>";
        
        echo "</div>";
        
        // Quick matching section
        echo "<div style='margin-top: 20px; border: 1px solid #ccc; padding: 15px; border-radius: 5px; background-color: #f9f9f9;'>";
        echo "<h3>Quick Program Analysis</h3>";
        
        if (!empty($programs_needing_volunteers)) {
            $program = $programs_needing_volunteers[0]; // Take first program as example
            echo "<p><strong>Example: Finding volunteers for {$program['name']}</strong></p>";
            $this->displayMatchingVolunteers($program, $available_volunteers);
        } else {
            echo "<p>Select a program to see matching volunteers.</p>";
        }
        
        echo "</div>";
    }
    
    /**
     * Get programs that still need volunteers
     */
    private function getProgramsNeedingVolunteers()
    {
        global $db;
        
        $query = "
            SELECT sp.id, sp.name, sp.sport_type_c, sp.age_group_c, sp.meeting_days_c,
                   sp.volunteers_needed_c, sp.volunteers_assigned_c, sp.program_status_c,
                   sp.start_date_c, sp.meeting_location_c
            FROM sportprograms sp
            WHERE sp.deleted = 0 
            AND sp.program_status_c IN ('planning', 'recruiting', 'active')
            AND (sp.volunteers_assigned_c < sp.volunteers_needed_c OR sp.volunteers_assigned_c IS NULL)
            ORDER BY sp.start_date_c ASC, sp.name ASC
            LIMIT 5
        ";
        
        $result = $db->query($query);
        $programs = array();
        
        while ($row = $db->fetchByAssoc($result)) {
            $programs[] = $row;
        }
        
        return $programs;
    }
    
    /**
     * Get volunteers who are available for assignment
     */
    private function getAvailableVolunteers()
    {
        global $db;
        
        $query = "
            SELECT c.id, c.first_name, c.last_name, c.email1, c.phone_work,
                   c.preferred_sports_c, c.preferred_age_groups_c, c.availability_days_c,
                   c.volunteer_experience_level_c, c.volunteer_status_c, c.special_skills_c
            FROM contacts c
            WHERE c.deleted = 0 
            AND c.contact_type_c IN ('volunteer', 'coach', 'staff')
            AND c.volunteer_status_c IN ('active', 'available')
            AND c.background_check_status_c IN ('valid', 'expiring')
            ORDER BY c.volunteer_experience_level_c DESC, c.last_name ASC
            LIMIT 10
        ";
        
        $result = $db->query($query);
        $volunteers = array();
        
        while ($row = $db->fetchByAssoc($result)) {
            $volunteers[] = $row;
        }
        
        return $volunteers;
    }
    
    /**
     * Display a program card showing details and volunteer needs
     */
    private function displayProgramCard($program)
    {
        $needed = (int)$program['volunteers_needed_c'];
        $assigned = (int)$program['volunteers_assigned_c'];
        $remaining = $needed - $assigned;
        
        echo "<div style='border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-radius: 3px; background: white;'>";
        echo "<h4>{$program['name']}</h4>";
        echo "<p><strong>Sport:</strong> " . ucfirst($program['sport_type_c']) . " | ";
        echo "<strong>Age Group:</strong> {$program['age_group_c']}</p>";
        echo "<p><strong>Needs:</strong> {$remaining} more volunteer(s) (have {$assigned}, need {$needed})</p>";
        
        if (!empty($program['meeting_days_c'])) {
            $days = str_replace('^,^', ', ', trim($program['meeting_days_c'], '^'));
            echo "<p><strong>Meeting Days:</strong> {$days}</p>";
        }
        
        if (!empty($program['meeting_location_c'])) {
            echo "<p><strong>Location:</strong> {$program['meeting_location_c']}</p>";
        }
        
        echo "<p><em>Status: {$program['program_status_c']}</em></p>";
        echo "</div>";
    }
    
    /**
     * Display a volunteer card showing their profile and availability
     */
    private function displayVolunteerCard($volunteer)
    {
        $name = trim($volunteer['first_name'] . ' ' . $volunteer['last_name']);
        
        echo "<div style='border: 1px solid #ddd; padding: 8px; margin-bottom: 8px; border-radius: 3px; background: white; font-size: 12px;'>";
        echo "<strong>{$name}</strong><br>";
        
        if (!empty($volunteer['preferred_sports_c'])) {
            $sports = str_replace('^,^', ', ', trim($volunteer['preferred_sports_c'], '^'));
            echo "Sports: {$sports}<br>";
        }
        
        if (!empty($volunteer['preferred_age_groups_c'])) {
            $ages = str_replace('^,^', ', ', trim($volunteer['preferred_age_groups_c'], '^'));
            echo "Age Groups: {$ages}<br>";
        }
        
        if (!empty($volunteer['availability_days_c'])) {
            $days = str_replace('^,^', ', ', trim($volunteer['availability_days_c'], '^'));
            echo "Available: {$days}<br>";
        }
        
        echo "Experience: {$volunteer['volunteer_experience_level_c']}<br>";
        echo "</div>";
    }
    
    /**
     * Display volunteers that match a specific program
     */
    private function displayMatchingVolunteers($program, $volunteers)
    {
        require_once('custom/modules/SportPrograms/SportPrograms.php');
        
        $sport_program = new SportPrograms();
        $sport_program->sport_type_c = $program['sport_type_c'];
        $sport_program->age_group_c = $program['age_group_c'];
        $sport_program->meeting_days_c = $program['meeting_days_c'];
        
        $matches = array();
        
        foreach ($volunteers as $volunteer) {
            $match_result = $sport_program->calculateVolunteerMatch($volunteer);
            if ($match_result['score'] > 0) {
                $matches[] = array(
                    'volunteer' => $volunteer,
                    'match' => $match_result
                );
            }
        }
        
        // Sort by match score
        usort($matches, function($a, $b) {
            return $b['match']['score'] - $a['match']['score'];
        });
        
        if (empty($matches)) {
            echo "<p>No good matches found for this program.</p>";
            return;
        }
        
        echo "<div style='max-height: 300px; overflow-y: auto;'>";
        foreach (array_slice($matches, 0, 5) as $match) {
            $volunteer = $match['volunteer'];
            $match_info = $match['match'];
            $name = trim($volunteer['first_name'] . ' ' . $volunteer['last_name']);
            
            $color = '';
            if ($match_info['score'] >= 80) $color = 'background-color: #d4edda;'; // Green
            elseif ($match_info['score'] >= 60) $color = 'background-color: #fff3cd;'; // Yellow
            elseif ($match_info['score'] >= 40) $color = 'background-color: #f8d7da;'; // Light red
            
            echo "<div style='border: 1px solid #ddd; padding: 8px; margin-bottom: 5px; border-radius: 3px; {$color}'>";
            echo "<strong>{$name}</strong> - Match: {$match_info['match_level']} ({$match_info['score']}%)<br>";
            echo "<small>" . implode(', ', $match_info['reasons']) . "</small>";
            echo "</div>";
        }
        echo "</div>";
    }
} 