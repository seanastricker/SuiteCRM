<?php
/**
 * Feature 2: Simple Volunteer-Program Matching
 * Custom view for the volunteer matching dashboard
 * 
 * Integrates with SuiteCRM's MVC framework and theme
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/View/SugarView.php');

class VolunteerMatchingViewMatchingdashboard extends SugarView
{
    public function __construct()
    {
        parent::__construct();
        $this->options['show_header'] = true;
        $this->options['show_subpanels'] = false;
        $this->options['show_search'] = false;
    }

    public function preDisplay()
    {
        parent::preDisplay();
        
        // Set page title
        global $mod_strings;
        if (isset($this->ss)) {
            $this->ss->assign('MODULE_TITLE', 'Volunteer Matching Dashboard');
        }
    }

    public function display()
    {
        global $mod_strings, $app_strings, $current_user;
        
        // Handle AJAX requests for dynamic matching
        if (!empty($_GET['ajax']) && $_GET['ajax'] == '1') {
            $this->handleAjaxRequest();
            return;
        }
        
        // Use helper class for business logic
        require_once('modules/VolunteerMatching/VolunteerMatchingHelper.php');
        
        // Get volunteers and program requirements  
        $volunteers = VolunteerMatchingHelper::getVolunteers();
        $programs = VolunteerMatchingHelper::getProgramRequirements();
        
        // Include CSS (remove non-existent JS file reference)
        echo '<link rel="stylesheet" type="text/css" href="modules/VolunteerMatching/css/volunteer-matching.css">';
        
        // Add inline CSS for modal
        echo '<style>
            #volunteerModal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.5);
                z-index: 1050;
                display: none;
            }
            #volunteerModal.show {
                display: block !important;
            }
            .modal-dialog {
                position: relative;
                margin: 50px auto;
                max-width: 600px;
            }
            .modal-content {
                background-color: white;
                border-radius: 6px;
                padding: 20px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
        </style>';
        
        // Output the dashboard HTML directly
        $this->renderDashboard($volunteers, $programs);
    }
    
    /**
     * Handle AJAX requests for dynamic volunteer matching
     */
    private function handleAjaxRequest()
    {
        header('Content-Type: application/json');
        
        require_once('modules/VolunteerMatching/VolunteerMatchingHelper.php');
        
        $action = $_GET['ajax_action'] ?? '';
        $response = array('success' => false, 'data' => array());
        
        switch ($action) {
            case 'match_volunteers':
                $program = $_GET['program'] ?? '';
                if ($program) {
                    $matches = VolunteerMatchingHelper::matchVolunteersToProgram($program);
                    $response = array('success' => true, 'data' => $matches);
                }
                break;
                
            case 'filter_volunteers':
                $filters = array(
                    'skills' => $_GET['skills'] ?? '',
                    'availability' => $_GET['availability'] ?? '',
                    'program_interest' => $_GET['program_interest'] ?? ''
                );
                $filtered = VolunteerMatchingHelper::getVolunteers($filters);
                $response = array('success' => true, 'data' => $filtered);
                break;
                
            case 'get_volunteer_details':
                $volunteer_id = $_GET['volunteer_id'] ?? '';
                if ($volunteer_id) {
                    require_once('data/BeanFactory.php');
                    $contact = BeanFactory::getBean('Contacts', $volunteer_id);
                    if ($contact) {
                        $details = array(
                            'id' => $contact->id,
                            'name' => $contact->first_name . ' ' . $contact->last_name,
                            'email' => $contact->email1,
                            'phone' => $contact->phone_work ?: $contact->phone_mobile,
                            'skills' => $contact->special_skills_c,
                            'availability' => $contact->availability_c,
                            'experience' => $contact->experience_level_c,
                            'background_check' => $contact->background_check_c
                        );
                        $response = array('success' => true, 'data' => $details);
                    }
                }
                break;
        }
        
        echo json_encode($response);
        exit;
    }
    
    /**
     * Render the volunteer matching dashboard HTML
     */
    private function renderDashboard($volunteers, $programs)
    {
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2>Volunteer Matching Dashboard</h2>
                    <p class="text-muted">Match volunteers to programs based on skills, availability, and preferences.</p>
                </div>
            </div>

            <div class="row">
                <!-- Program Selection -->
                <div class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Select Program</h3>
                        </div>
                        <div class="panel-body">
                            <select id="program-select" class="form-control">
                                <option value="">Choose a program...</option>
                                <?php foreach ($programs as $program): ?>
                                    <option value="<?php echo htmlspecialchars($program['id']); ?>">
                                        <?php echo htmlspecialchars($program['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            
                            <div id="program-details" style="margin-top: 15px; display: none;">
                                <h4>Program Requirements:</h4>
                                <div id="program-requirements"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Volunteer Filters -->
                <div class="col-md-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Filter Volunteers</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Skills:</label>
                                <input type="text" id="skills-filter" class="form-control" placeholder="e.g., coaching, first aid">
                            </div>
                            
                            <div class="form-group">
                                <label>Availability:</label>
                                <select id="availability-filter" class="form-control">
                                    <option value="">Any availability</option>
                                    <option value="weekends">Weekends (Sat/Sun)</option>
                                    <option value="weekdays">Weekdays (Mon-Fri)</option>
                                    <option value="monday">Monday</option>
                                    <option value="tuesday">Tuesday</option>
                                    <option value="wednesday">Wednesday</option>
                                    <option value="thursday">Thursday</option>
                                    <option value="friday">Friday</option>
                                    <option value="saturday">Saturday</option>
                                    <option value="sunday">Sunday</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Experience Level:</label>
                                <select id="experience-filter" class="form-control">
                                    <option value="">Any experience</option>
                                    <option value="beginner">Beginner</option>
                                    <option value="some_experience">Some Experience</option>
                                    <option value="experienced">Experienced</option>
                                    <option value="expert">Expert</option>
                                    <option value="professional">Professional</option>
                                </select>
                            </div>
                            
                            <button type="button" id="apply-filters" class="btn btn-primary">Apply Filters</button>
                            <button type="button" id="clear-filters" class="btn btn-default">Clear</button>
                        </div>
                    </div>
                </div>

                <!-- Results -->
                <div class="col-md-4">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title">Matching Results</h3>
                        </div>
                        <div class="panel-body">
                            <div id="matching-results">
                                <p class="text-muted">Select a program and apply filters to see matching volunteers.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Volunteer List -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Available Volunteers (<?php echo count($volunteers); ?>)</h3>
                        </div>
                        <div class="panel-body">
                            <div id="volunteers-list" class="row">
                                <?php if (empty($volunteers)): ?>
                                    <div class="col-md-12">
                                        <div class="alert alert-info">
                                            <strong>No volunteers found.</strong> 
                                            <a href="index.php?module=Contacts&action=EditView&contact_type=volunteer">Create a volunteer contact</a> 
                                            to see them here.
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($volunteers as $volunteer): ?>
                                        <div class="col-md-6 col-lg-4 volunteer-card" 
                                             data-volunteer-id="<?php echo htmlspecialchars($volunteer['id']); ?>"
                                             data-skills="<?php echo htmlspecialchars($volunteer['skills'] ?? 'No skills listed'); ?>"
                                             data-availability="<?php echo htmlspecialchars($volunteer['availability'] ?? 'Not specified'); ?>"
                                             data-experience="<?php echo htmlspecialchars($volunteer['experience'] ?? 'Not specified'); ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <h4><?php echo htmlspecialchars($volunteer['name']); ?></h4>
                                                    <p><strong>Email:</strong> <?php echo htmlspecialchars($volunteer['email']); ?></p>
                                                    <p><strong>Skills:</strong> <?php echo htmlspecialchars($volunteer['skills']); ?></p>
                                                    <p><strong>Availability:</strong> <?php echo htmlspecialchars($volunteer['availability']); ?></p>
                                                    <p><strong>Experience:</strong> <?php echo htmlspecialchars($volunteer['experience']); ?></p>
                                                    <button type="button" class="btn btn-sm btn-primary volunteer-details" 
                                                            data-volunteer-id="<?php echo htmlspecialchars($volunteer['id']); ?>">
                                                        View Details
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for volunteer details -->
        <div class="modal fade" id="volunteerModal" tabindex="-1" role="dialog" onclick="closeVolunteerModal(event)">
            <div class="modal-dialog" role="document">
                <div class="modal-content" onclick="event.stopPropagation()">
                    <div class="modal-header">
                        <h4 class="modal-title" id="volunteerModalLabel">Volunteer Details</h4>
                        <button type="button" class="close" onclick="closeVolunteerModal()">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="volunteerModalBody">
                        Loading...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" onclick="closeVolunteerModal()">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
        // Enhanced JavaScript for interactivity
        console.log('Loading volunteer matching JavaScript...');
        
        try {
            console.log('About to add DOMContentLoaded listener...');
            
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM Content Loaded - initializing event handlers...');
                
                try {
            
            // Apply filters
            const applyFiltersBtn = document.getElementById('apply-filters');
            if (applyFiltersBtn) {
                console.log('Adding click handler to apply-filters button');
                applyFiltersBtn.addEventListener('click', function() {
                    console.log('Apply filters button clicked');
                    const skills = document.getElementById('skills-filter').value;
                    const availability = document.getElementById('availability-filter').value;
                    const experience = document.getElementById('experience-filter').value;
                    console.log('Filter values:', {skills, availability, experience});
                    
                    const cards = document.querySelectorAll('.volunteer-card');
                    let visibleCount = 0;
                    
                    cards.forEach(function(card) {
                        let show = true;
                        
                        if (skills && !card.dataset.skills.toLowerCase().includes(skills.toLowerCase())) {
                            show = false;
                        }
                        
                        // Smart availability filtering
                        if (availability) {
                            const cardAvailability = card.dataset.availability.toLowerCase();
                            let availabilityMatch = false;
                            
                            if (availability === 'weekends') {
                                // Match if contains saturday OR sunday
                                availabilityMatch = cardAvailability.includes('saturday') || cardAvailability.includes('sunday');
                            } else if (availability === 'weekdays') {
                                // Match if contains any weekday
                                availabilityMatch = cardAvailability.includes('monday') || 
                                                  cardAvailability.includes('tuesday') || 
                                                  cardAvailability.includes('wednesday') || 
                                                  cardAvailability.includes('thursday') || 
                                                  cardAvailability.includes('friday');
                            } else {
                                // Direct match for specific days
                                availabilityMatch = cardAvailability.includes(availability.toLowerCase());
                            }
                            
                            if (!availabilityMatch) {
                                show = false;
                            }
                        }
                        
                        if (experience && !card.dataset.experience.toLowerCase().includes(experience.toLowerCase())) {
                            show = false;
                        }
                        
                        if (show) {
                            card.style.display = 'block';
                            visibleCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });
                    
                    document.getElementById('matching-results').innerHTML = 
                        '<p><strong>' + visibleCount + '</strong> volunteers match your criteria.</p>';
                });
            } else {
                console.error('apply-filters button not found');
            }
            
            // Clear filters
            const clearFiltersBtn = document.getElementById('clear-filters');
            if (clearFiltersBtn) {
                console.log('Adding click handler to clear-filters button');
                clearFiltersBtn.addEventListener('click', function() {
                    console.log('Clear filters button clicked');
                    
                    document.getElementById('skills-filter').value = '';
                    document.getElementById('availability-filter').value = '';
                    document.getElementById('experience-filter').value = '';
                    
                    const cards = document.querySelectorAll('.volunteer-card');
                    cards.forEach(function(card) {
                        card.style.display = 'block';
                    });
                    
                    document.getElementById('matching-results').innerHTML = 
                        '<p class="text-muted">Select a program and apply filters to see matching volunteers.</p>';
                });
            } else {
                console.error('clear-filters button not found');
            }
            
            // Handle View Details buttons
            document.addEventListener('click', function(e) {
                console.log('Document click detected, target:', e.target);
                if (e.target.classList.contains('volunteer-details')) {
                    console.log('View Details button clicked');
                    const volunteerId = e.target.getAttribute('data-volunteer-id');
                    showVolunteerDetails(volunteerId);
                }
            });
            
            // Program selection handling
            const programSelect = document.getElementById('program-select');
            if (programSelect) {
                console.log('Adding change handler to program-select');
                programSelect.addEventListener('change', function() {
                    console.log('Program selection changed');
                    const selectedProgram = this.value;
                    if (selectedProgram) {
                        document.getElementById('program-details').style.display = 'block';
                        document.getElementById('program-requirements').innerHTML = 
                            '<p class="text-info">Program selected: <strong>' + this.options[this.selectedIndex].text + '</strong></p>';
                    } else {
                        document.getElementById('program-details').style.display = 'none';
                    }
                });
            } else {
                console.error('program-select element not found');
            }
            
            console.log('All event handlers initialized');
            window.volunteerMatchingInitialized = true;
                    
                } catch (error) {
                    console.error('Error in DOMContentLoaded handler:', error);
                }
            });
            
        } catch (error) {
            console.error('Error setting up DOMContentLoaded listener:', error);
        }
        
        // Fallback: Try to initialize after a short delay if DOMContentLoaded fails
        console.log('Setting up fallback initialization...');
        setTimeout(function() {
            console.log('Fallback: Checking if initialization is needed...');
            if (!window.volunteerMatchingInitialized) {
                console.log('Fallback: Initializing event handlers...');
                initializeEventHandlers();
            }
        }, 1000);
        
        // Mark as initialized
        window.volunteerMatchingInitialized = false;
        
        // Function to initialize event handlers
        function initializeEventHandlers() {
            try {
                console.log('initializeEventHandlers called');
                
                // Apply filters
                const applyFiltersBtn = document.getElementById('apply-filters');
                if (applyFiltersBtn) {
                    console.log('Setting up Apply Filters button');
                    applyFiltersBtn.onclick = function() {
                        console.log('Apply Filters clicked (via onclick)');
                        filterVolunteers();
                    };
                } else {
                    console.error('apply-filters button not found in initializeEventHandlers');
                }
                
                // Clear filters  
                const clearFiltersBtn = document.getElementById('clear-filters');
                if (clearFiltersBtn) {
                    console.log('Setting up Clear Filters button');
                    clearFiltersBtn.onclick = function() {
                        console.log('Clear Filters clicked (via onclick)');
                        clearFilters();
                    };
                } else {
                    console.error('clear-filters button not found in initializeEventHandlers');
                }
                
                // View Details buttons (use event delegation)
                document.onclick = function(e) {
                    if (e.target && e.target.classList.contains('volunteer-details')) {
                        console.log('View Details clicked (via document.onclick)');
                        const volunteerId = e.target.getAttribute('data-volunteer-id');
                        showVolunteerDetails(volunteerId);
                    }
                };
                
                window.volunteerMatchingInitialized = true;
                console.log('Event handlers initialized successfully');
                
            } catch (error) {
                console.error('Error in initializeEventHandlers:', error);
            }
        }
        
        // Function to filter volunteers
        function filterVolunteers() {
            try {
                console.log('filterVolunteers called');
                
                const skills = document.getElementById('skills-filter').value;
                const availability = document.getElementById('availability-filter').value;  
                const experience = document.getElementById('experience-filter').value;
                console.log('Filter values:', {skills, availability, experience});
                
                const cards = document.querySelectorAll('.volunteer-card');
                let visibleCount = 0;
                
                cards.forEach(function(card) {
                    let show = true;
                    
                    if (skills && !card.dataset.skills.toLowerCase().includes(skills.toLowerCase())) {
                        show = false;
                    }
                    
                    if (availability) {
                        const cardAvailability = card.dataset.availability.toLowerCase();
                        let availabilityMatch = false;
                        
                        if (availability === 'weekends') {
                            availabilityMatch = cardAvailability.includes('saturday') || cardAvailability.includes('sunday');
                        } else if (availability === 'weekdays') {
                            availabilityMatch = cardAvailability.includes('monday') || 
                                              cardAvailability.includes('tuesday') || 
                                              cardAvailability.includes('wednesday') || 
                                              cardAvailability.includes('thursday') || 
                                              cardAvailability.includes('friday');
                        } else {
                            availabilityMatch = cardAvailability.includes(availability.toLowerCase());
                        }
                        
                        if (!availabilityMatch) {
                            show = false;
                        }
                    }
                    
                    if (experience && !card.dataset.experience.toLowerCase().includes(experience.toLowerCase())) {
                        show = false;
                    }
                    
                    if (show) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                document.getElementById('matching-results').innerHTML = 
                    '<p><strong>' + visibleCount + '</strong> volunteers match your criteria.</p>';
                    
            } catch (error) {
                console.error('Error in filterVolunteers:', error);
            }
        }
        
        // Function to clear filters
        function clearFilters() {
            try {
                console.log('clearFilters called');
                
                document.getElementById('skills-filter').value = '';
                document.getElementById('availability-filter').value = '';
                document.getElementById('experience-filter').value = '';
                
                const cards = document.querySelectorAll('.volunteer-card');
                cards.forEach(function(card) {
                    card.style.display = 'block';
                });
                
                document.getElementById('matching-results').innerHTML = 
                    '<p class="text-muted">Select a program and apply filters to see matching volunteers.</p>';
                    
            } catch (error) {
                console.error('Error in clearFilters:', error);
            }
        }
        
        // Function to show volunteer details in modal
        function showVolunteerDetails(volunteerId) {
            console.log('showVolunteerDetails called with ID:', volunteerId);
            
            // Find the volunteer card to get the data
            const volunteerCard = document.querySelector('[data-volunteer-id="' + volunteerId + '"]');
            if (!volunteerCard) {
                console.error('Volunteer card not found for ID:', volunteerId);
                return;
            }
            
            const name = volunteerCard.querySelector('h4').textContent;
            const email = volunteerCard.querySelector('p:nth-child(2)').textContent.replace('Email: ', '');
            const skills = volunteerCard.dataset.skills || 'No skills listed';
            const availability = volunteerCard.dataset.availability || 'Not specified';
            const experience = volunteerCard.dataset.experience || 'Not specified';
            
            console.log('Volunteer data:', {name, email, skills, availability, experience});
            
            const modalBody = document.getElementById('volunteerModalBody');
            modalBody.innerHTML = 
                '<div class="row">' +
                    '<div class="col-md-12">' +
                        '<h4>' + name + '</h4>' +
                        '<hr>' +
                        '<p><strong>Email:</strong> ' + email + '</p>' +
                        '<p><strong>Skills & Certifications:</strong> ' + skills + '</p>' +
                        '<p><strong>Availability:</strong> ' + availability + '</p>' +
                        '<p><strong>Experience Level:</strong> ' + experience + '</p>' +
                        '<hr>' +
                        '<p><strong>Volunteer ID:</strong> ' + volunteerId + '</p>' +
                        '<p class="text-muted">' +
                            '<a href="index.php?module=Contacts&action=DetailView&record=' + volunteerId + '" target="_blank">' +
                                'View Full Contact Record' +
                            '</a>' +
                        '</p>' +
                    '</div>' +
                '</div>';
            
            // Show the modal using plain JavaScript
            const modal = document.getElementById('volunteerModal');
            modal.style.display = 'block';
            modal.style.opacity = '1';
            modal.classList.add('show');
            
            console.log('Modal should be visible now');
        }
        
        // Function to close the volunteer modal
        function closeVolunteerModal(event) {
            console.log('closeVolunteerModal called');
            
            // If event is passed and it's clicking inside modal content, don't close
            if (event && event.target.closest('.modal-content')) {
                return;
            }
            
            const modal = document.getElementById('volunteerModal');
            modal.style.display = 'none';
            modal.style.opacity = '0';
            modal.classList.remove('show');
            
            console.log('Modal should be hidden now');
        }
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('volunteerModal');
                if (modal && modal.style.display === 'block') {
                    closeVolunteerModal();
                }
            }
        });
        </script>
        <?php
    }
} 