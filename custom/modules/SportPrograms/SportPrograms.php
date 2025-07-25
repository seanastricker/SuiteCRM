<?php
/**
 * SportPrograms Module - Main Bean Class
 * 
 * This module manages sports programs for the Youth Sports League.
 * Each program represents a specific sport/age group combination
 * that needs volunteers assigned to it.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('data/SugarBean.php');

class SportPrograms extends SugarBean
{
    // Module Properties
    public $module_name = 'SportPrograms';
    public $module_dir = 'SportPrograms';
    public $object_name = 'SportPrograms';
    public $table_name = 'sportprograms';
    public $new_schema = true;
    public $process_save_dates = true;
    public $importable = true;
    public $disable_row_level_security = true;

    // Field Properties
    public $id;
    public $name;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $modified_by_name;
    public $created_by;
    public $created_by_name;
    public $description;
    public $deleted;
    public $assigned_user_id;
    public $assigned_user_name;
    
    // Custom Fields
    public $sport_type_c;
    public $age_group_c;
    public $meeting_days_c;
    public $volunteers_needed_c;
    public $volunteers_assigned_c;
    public $program_status_c;
    public $season_c;
    public $start_date_c;
    public $end_date_c;
    public $meeting_location_c;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Check if the program still needs volunteers
     * 
     * @return bool True if more volunteers are needed
     */
    public function needsVolunteers()
    {
        $needed = (int)$this->volunteers_needed_c;
        $assigned = (int)$this->volunteers_assigned_c;
        
        return $assigned < $needed;
    }

    /**
     * Check if a specific volunteer matches this program's requirements
     * 
     * @param array $volunteer_data Volunteer contact data
     * @return array Match score and reasons
     */
    public function calculateVolunteerMatch($volunteer_data)
    {
        $score = 0;
        $reasons = array();
        
        // Check sport preference match
        if (!empty($volunteer_data['preferred_sports_c'])) {
            $preferred_sports = explode('^,^', trim($volunteer_data['preferred_sports_c'], '^'));
            if (in_array($this->sport_type_c, $preferred_sports)) {
                $score += 40;
                $reasons[] = 'Matches preferred sport';
            }
        }
        
        // Check age group preference match
        if (!empty($volunteer_data['preferred_age_groups_c'])) {
            $preferred_ages = explode('^,^', trim($volunteer_data['preferred_age_groups_c'], '^'));
            if (in_array($this->age_group_c, $preferred_ages) || in_array('all_ages', $preferred_ages)) {
                $score += 30;
                $reasons[] = 'Matches preferred age group';
            }
        }
        
        // Check availability match
        if (!empty($volunteer_data['availability_days_c']) && !empty($this->meeting_days_c)) {
            $available_days = explode('^,^', trim($volunteer_data['availability_days_c'], '^'));
            $meeting_days = explode('^,^', trim($this->meeting_days_c, '^'));
            
            $matching_days = array_intersect($available_days, $meeting_days);
            if (!empty($matching_days)) {
                $score += 20;
                $reasons[] = 'Available on meeting days';
            }
        }
        
        // Check volunteer status
        if ($volunteer_data['volunteer_status_c'] === 'active' || $volunteer_data['volunteer_status_c'] === 'available') {
            $score += 10;
            $reasons[] = 'Currently available';
        }
        
        return array(
            'score' => $score,
            'reasons' => $reasons,
            'match_level' => $this->getMatchLevel($score)
        );
    }

    /**
     * Convert match score to readable level
     * 
     * @param int $score Match score
     * @return string Match level
     */
    private function getMatchLevel($score)
    {
        if ($score >= 80) return 'Excellent';
        if ($score >= 60) return 'Good';
        if ($score >= 40) return 'Fair';
        if ($score >= 20) return 'Poor';
        return 'No Match';
    }
} 