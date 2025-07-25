<?php
/**
 * Feature 2: Simple Volunteer-Program Matching
 * Helper class for volunteer matching business logic
 * 
 * Separated from bean to prevent memory issues
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class VolunteerMatchingHelper
{
    /**
     * Get volunteers with their skills and availability
     * 
     * @param array $filters Optional filters for volunteer search
     * @return array Array of volunteer data
     */
    public static function getVolunteers($filters = array())
    {
        // Use SuiteCRM's BeanFactory to query contacts
        require_once('data/BeanFactory.php');
        
        $contact = BeanFactory::newBean('Contacts');
        if (!$contact) {
            return array();
        }
        
        // Build the WHERE clause for volunteers
        $where = "contacts.deleted = 0";
        $where .= " AND (TRIM(LOWER(contacts.contact_type_c)) LIKE '%volunteer%' OR contacts.contact_type_c LIKE '%Volunteer%')";
        
        // Apply filters if provided
        if (!empty($filters['skills'])) {
            $where .= " AND contacts.special_skills_c LIKE '%" . $contact->db->quote($filters['skills']) . "%'";
        }
        
        if (!empty($filters['availability'])) {
            $availability = $filters['availability'];
            if ($availability === 'weekends') {
                // Match records with Saturday OR Sunday
                $where .= " AND (contacts.availability_days_c LIKE '%saturday%' OR contacts.availability_days_c LIKE '%sunday%')";
            } elseif ($availability === 'weekdays') {
                // Match records with any weekday
                $where .= " AND (contacts.availability_days_c LIKE '%monday%' OR " .
                         "contacts.availability_days_c LIKE '%tuesday%' OR " .
                         "contacts.availability_days_c LIKE '%wednesday%' OR " .
                         "contacts.availability_days_c LIKE '%thursday%' OR " .
                         "contacts.availability_days_c LIKE '%friday%')";
            } else {
                // Direct match for specific days
                $where .= " AND contacts.availability_days_c LIKE '%" . $contact->db->quote($availability) . "%'";
            }
        }
        
        if (!empty($filters['program_interest'])) {
            $where .= " AND contacts.program_interest_c LIKE '%" . $contact->db->quote($filters['program_interest']) . "%'";
        }
        
        // Use get_full_list to retrieve volunteers
        $volunteers = $contact->get_full_list("last_name, first_name", $where);
        
        $volunteer_data = array();
        
        if ($volunteers) {
            foreach ($volunteers as $volunteer_bean) {
                // Combine first and last name
                $full_name = trim($volunteer_bean->first_name . ' ' . $volunteer_bean->last_name);
                if (empty($full_name)) {
                    $full_name = 'Unknown Volunteer';
                }
                
                // Get email address - use retrieve() to ensure all fields are loaded
                $volunteer_bean->retrieve($volunteer_bean->id);
                $email = $volunteer_bean->email1 ?? '';
                if (empty($email)) {
                    // Try alternative email fields
                    $email = $volunteer_bean->email2 ?? '';
                }
                if (empty($email)) {
                    $email = 'No email provided';
                }
                
                $volunteer = array(
                    'id' => $volunteer_bean->id ?? '',
                    'name' => $full_name,
                    'email' => $email,
                    'first_name' => $volunteer_bean->first_name ?? '',
                    'last_name' => $volunteer_bean->last_name ?? '',
                    'contact_type_c' => $volunteer_bean->contact_type_c ?? '',
                    
                                    // Map custom fields to expected keys for display (using correct field names)
                'skills' => $volunteer_bean->special_skills_c ?? 'No skills listed',
                'availability' => $volunteer_bean->availability_days_c ?? 'Not specified',
                'experience' => $volunteer_bean->volunteer_experience_level_c ?? 'Not specified',
                
                // Keep original field names as well for compatibility
                'special_skills_c' => $volunteer_bean->special_skills_c ?? '',
                'availability_days_c' => $volunteer_bean->availability_days_c ?? '',
                'volunteer_experience_level_c' => $volunteer_bean->volunteer_experience_level_c ?? '',
                'program_interest_c' => $volunteer_bean->program_interest_c ?? '',
                    'background_check_c' => $volunteer_bean->background_check_c ?? '',
                    'emergency_contact_c' => $volunteer_bean->emergency_contact_c ?? '',
                );
                
                $volunteer_data[] = $volunteer;
            }
        }
        
        return $volunteer_data;
    }
    
    /**
     * Get program requirements for matching
     * 
     * @return array Array of program requirements
     */
    public static function getProgramRequirements()
    {
        // Since we don't have a separate programs module, return predefined requirements
        // Format: array with 'id' and 'name' for dropdown, plus requirements
        return array(
            array(
                'id' => 'football_u7',
                'name' => 'Football U7',
                'required_skills' => array('First Aid', 'Coaching'),
                'min_experience' => 'Beginner',
                'background_check' => true,
                'time_commitment' => 'Weekends'
            ),
            array(
                'id' => 'soccer_u8',
                'name' => 'Soccer U8',
                'required_skills' => array('Sports Knowledge'),
                'min_experience' => 'Beginner',
                'background_check' => true,
                'time_commitment' => 'Weekends'
            ),
            array(
                'id' => 'basketball_u12',
                'name' => 'Basketball U12',
                'required_skills' => array('Coaching', 'Sports Knowledge'),
                'min_experience' => 'Intermediate',
                'background_check' => true,
                'time_commitment' => 'Weekday Evenings'
            ),
            array(
                'id' => 'tennis_u10',
                'name' => 'Tennis U10',
                'required_skills' => array('Tennis', 'Coaching'),
                'min_experience' => 'Intermediate',
                'background_check' => true,
                'time_commitment' => 'Flexible'
            )
        );
    }
    
    /**
     * Match volunteers to programs based on skills and requirements
     * 
     * @param string $program_name Program to match volunteers for
     * @return array Array of matched volunteers
     */
    public static function matchVolunteersToProgram($program_name)
    {
        $volunteers = self::getVolunteers();
        $requirements = self::getProgramRequirements();
        
        if (!isset($requirements[$program_name])) {
            return array();
        }
        
        $program_req = $requirements[$program_name];
        $matched_volunteers = array();
        
        foreach ($volunteers as $volunteer) {
            $match_score = 0;
            $match_reasons = array();
            
            // Check skills match
            $volunteer_skills = explode(',', $volunteer['special_skills_c']);
            foreach ($program_req['required_skills'] as $required_skill) {
                foreach ($volunteer_skills as $skill) {
                    if (stripos(trim($skill), $required_skill) !== false) {
                        $match_score += 10;
                        $match_reasons[] = "Has skill: $required_skill";
                        break;
                    }
                }
            }
            
            // Check program interest
            if (stripos($volunteer['program_interest_c'], $program_name) !== false) {
                $match_score += 15;
                $match_reasons[] = "Interested in $program_name";
            }
            
            // Check background check if required
            if ($program_req['background_check'] && $volunteer['background_check_c'] == '1') {
                $match_score += 5;
                $match_reasons[] = "Background check completed";
            }
            
            // Only include volunteers with some match
            if ($match_score > 0) {
                $volunteer['match_score'] = $match_score;
                $volunteer['match_reasons'] = $match_reasons;
                $matched_volunteers[] = $volunteer;
            }
        }
        
        // Sort by match score (highest first)
        usort($matched_volunteers, function($a, $b) {
            return $b['match_score'] - $a['match_score'];
        });
        
        return $matched_volunteers;
    }
} 