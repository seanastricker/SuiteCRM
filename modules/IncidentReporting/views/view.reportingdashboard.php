<?php
/**
 * Feature 3: Basic Incident Reporting
 * Main dashboard view for the incident reporting module
 * 
 * Integrates with SuiteCRM's MVC framework and theme
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/View/SugarView.php');

class IncidentReportingViewReportingdashboard extends SugarView
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
        if (isset($this->ss)) {
            $this->ss->assign('MODULE_TITLE', 'Safety Incident Reporting Dashboard');
        }
    }

    public function display()
    {
        global $mod_strings, $app_strings, $current_user;
        
        // Form submissions are now handled by the SaveIncident action
        
        // Initialize database connection
        require_once('include/database/DBManagerFactory.php');
        global $db;
        $db = DBManagerFactory::getInstance();
        
        // Use helper class for business logic
        require_once('modules/IncidentReporting/IncidentReportingHelper.php');
        
        // Get filters from request
        $filters = array();
        if (!empty($_GET['severity'])) $filters['severity'] = $_GET['severity'];
        if (!empty($_GET['status'])) $filters['status'] = $_GET['status'];
        if (!empty($_GET['type'])) $filters['type'] = $_GET['type'];
        if (!empty($_GET['date_from'])) $filters['date_from'] = $_GET['date_from'];
        if (!empty($_GET['date_to'])) $filters['date_to'] = $_GET['date_to'];
        
        // Get data
        $incidents = IncidentReportingHelper::getIncidents($filters);
        $stats = IncidentReportingHelper::getIncidentStats();
        $dropdown_options = IncidentReportingHelper::getDropdownOptions();
        
        // Add inline CSS for styling
        echo '<style>
            .incident-dashboard {
                margin: 20px 0;
            }
            .stats-panel {
                background: #f8f9fa;
                border: 1px solid #dee2e6;
                border-radius: 4px;
                padding: 15px;
                margin-bottom: 20px;
            }
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 15px;
            }
            .stat-item {
                text-align: center;
                padding: 10px;
                background: white;
                border-radius: 4px;
                border: 1px solid #e0e0e0;
            }
            .stat-number {
                font-size: 24px;
                font-weight: bold;
                color: #333;
            }
            .stat-label {
                font-size: 12px;
                color: #666;
                margin-top: 5px;
            }
            .incident-form {
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 20px;
                margin-bottom: 20px;
            }
            .incident-card {
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 15px;
                margin-bottom: 10px;
                background: white;
            }
            .severity-critical { border-left: 4px solid #dc3545; }
            .severity-high { border-left: 4px solid #fd7e14; }
            .severity-medium { border-left: 4px solid #ffc107; }
            .severity-low { border-left: 4px solid #28a745; }
            .incident-meta {
                font-size: 12px;
                color: #666;
                margin-top: 10px;
            }
            #incidentModal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.5);
                z-index: 1050;
                display: none;
            }
            #incidentModal.show {
                display: block !important;
            }
            .modal-dialog {
                position: relative;
                margin: 50px auto;
                max-width: 800px;
            }
            .modal-content {
                background-color: white;
                border-radius: 6px;
                padding: 20px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
        </style>';
        
        // Output the dashboard HTML directly
        $this->renderDashboard($incidents, $stats, $dropdown_options, $filters);
    }
    


    /**
     * Render the incident reporting dashboard HTML
     */
    private function renderDashboard($incidents, $stats, $dropdown_options, $filters)
    {
        ?>
        <div class="incident-dashboard">
            <!-- Statistics Panel -->
            <div class="stats-panel">
                <h3>Incident Statistics</h3>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $stats['total']; ?></div>
                        <div class="stat-label">Total Incidents</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $stats['today']; ?></div>
                        <div class="stat-label">Today</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $stats['this_week']; ?></div>
                        <div class="stat-label">This Week</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $stats['critical']; ?></div>
                        <div class="stat-label">Critical</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $stats['high']; ?></div>
                        <div class="stat-label">High Severity</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $stats['open']; ?></div>
                        <div class="stat-label">Open Cases</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Report New Incident Form -->
                <div class="col-md-6">
                    <div class="incident-form">
                        <h3>Report New Incident</h3>
                        <form id="incident-form">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Incident Date *</label>
                                        <input type="date" name="incident_date" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Incident Time</label>
                                        <input type="time" name="incident_time" class="form-control">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Program/Activity</label>
                                <input type="text" name="program_name" class="form-control">
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Child Involved</label>
                                        <input type="text" name="child_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Age</label>
                                        <input type="number" name="child_age" class="form-control" min="3" max="18">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Incident Type *</label>
                                        <select name="incident_type" class="form-control" required>
                                            <option value="">Select type...</option>
                                            <?php foreach ($dropdown_options['incident_types'] as $key => $value): ?>
                                                <option value="<?php echo htmlspecialchars($key); ?>"><?php echo htmlspecialchars($value); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Severity Level *</label>
                                        <select name="severity_level" class="form-control" required>
                                            <option value="">Select severity...</option>
                                            <?php foreach ($dropdown_options['severity_levels'] as $key => $value): ?>
                                                <option value="<?php echo htmlspecialchars($key); ?>"><?php echo htmlspecialchars($value); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Description of Incident</label>
                                <textarea name="incident_description" class="form-control" rows="3"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Immediate Action Taken</label>
                                <textarea name="immediate_action" class="form-control" rows="2"></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Reporter Name</label>
                                        <input type="text" name="reporter_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Reporter Role</label>
                                        <select name="reporter_role" class="form-control">
                                            <option value="">Select role...</option>
                                            <?php foreach ($dropdown_options['reporter_roles'] as $key => $value): ?>
                                                <option value="<?php echo htmlspecialchars($key); ?>"><?php echo htmlspecialchars($value); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" name="medical_attention" value="1"> Medical Attention Required
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" name="parent_notified" value="1"> Parents Notified
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" name="followup_required" value="1"> Follow-up Required
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Save Incident Report</button>
                            <button type="button" id="clear-form" class="btn btn-default">Clear Form</button>
                        </form>
                    </div>
                </div>

                <!-- Filters and Recent Incidents -->
                <div class="col-md-6">
                    <!-- Filter Panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Filter Incidents</h3>
                        </div>
                        <div class="panel-body">
                            <form id="filter-form" method="GET">
                                <input type="hidden" name="module" value="IncidentReporting">
                                <input type="hidden" name="action" value="ReportingDashboard">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Severity</label>
                                            <select name="severity" class="form-control">
                                                <option value="">All severities</option>
                                                <?php foreach ($dropdown_options['severity_levels'] as $key => $value): ?>
                                                    <option value="<?php echo htmlspecialchars($key); ?>" <?php echo ($filters['severity'] ?? '') === $key ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($value); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="">All statuses</option>
                                                <?php foreach ($dropdown_options['incident_statuses'] as $key => $value): ?>
                                                    <option value="<?php echo htmlspecialchars($key); ?>" <?php echo ($filters['status'] ?? '') === $key ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($value); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="type" class="form-control">
                                        <option value="">All types</option>
                                        <?php foreach ($dropdown_options['incident_types'] as $key => $value): ?>
                                            <option value="<?php echo htmlspecialchars($key); ?>" <?php echo ($filters['type'] ?? '') === $key ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($value); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>From Date</label>
                                            <input type="date" name="date_from" class="form-control" value="<?php echo htmlspecialchars($filters['date_from'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>To Date</label>
                                            <input type="date" name="date_to" class="form-control" value="<?php echo htmlspecialchars($filters['date_to'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                                <a href="index.php?module=IncidentReporting&action=ReportingDashboard" class="btn btn-default">Clear</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Incidents List -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Recent Incidents (<?php echo count($incidents); ?>)</h3>
                        </div>
                        <div class="panel-body">
                            <?php if (empty($incidents)): ?>
                                <div class="alert alert-info">
                                    <strong>No incidents found.</strong> 
                                    <?php if (!empty($filters)): ?>
                                        Try adjusting your filters.
                                    <?php else: ?>
                                        Use the form above to report the first incident.
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div id="incidents-list">
                                    <?php foreach ($incidents as $incident): ?>
                                        <div class="incident-card severity-<?php echo htmlspecialchars($incident['severity_level']); ?>" 
                                             data-incident-id="<?php echo htmlspecialchars($incident['id']); ?>">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h4><?php echo htmlspecialchars($incident['name']); ?></h4>
                                                    <p><strong>Date:</strong> <?php echo htmlspecialchars($incident['incident_date']); ?>
                                                       <?php if ($incident['incident_time']): ?>
                                                           at <?php echo htmlspecialchars($incident['incident_time']); ?>
                                                       <?php endif; ?>
                                                    </p>
                                                    <p><strong>Type:</strong> <?php echo htmlspecialchars($incident['incident_type']); ?> | 
                                                       <strong>Severity:</strong> <?php echo htmlspecialchars($incident['severity_level']); ?> | 
                                                       <strong>Status:</strong> <?php echo htmlspecialchars($incident['incident_status']); ?></p>
                                                    <?php if ($incident['child_name']): ?>
                                                        <p><strong>Child:</strong> <?php echo htmlspecialchars($incident['child_name']); ?>
                                                           <?php if ($incident['child_age']): ?>
                                                               (<?php echo htmlspecialchars($incident['child_age']); ?> years old)
                                                           <?php endif; ?>
                                                        </p>
                                                    <?php endif; ?>
                                                    <?php if ($incident['program_name']): ?>
                                                        <p><strong>Program:</strong> <?php echo htmlspecialchars($incident['program_name']); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-md-4 text-right">
                                                    <button type="button" class="btn btn-sm btn-primary incident-details" 
                                                            data-incident-id="<?php echo htmlspecialchars($incident['id']); ?>">
                                                        View Details
                                                    </button>
                                                    <div class="incident-meta">
                                                        Reported: <?php echo date('M j, Y', strtotime($incident['date_entered'])); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for incident details -->
        <div id="incidentModal" onclick="closeIncidentModal(event)">
            <div class="modal-dialog">
                <div class="modal-content" onclick="event.stopPropagation()">
                    <div class="modal-header">
                        <h4 class="modal-title">Incident Details</h4>
                        <button type="button" class="close" onclick="closeIncidentModal()">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="incidentModalBody">
                        Loading...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" onclick="closeIncidentModal()">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
        // Enhanced JavaScript for incident reporting functionality
        console.log('Loading incident reporting JavaScript...');
        
        try {
            console.log('About to add DOMContentLoaded listener...');
            
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM Content Loaded - initializing incident reporting...');
                
                try {
                    initializeIncidentReporting();
                    window.incidentReportingInitialized = true;
                } catch (error) {
                    console.error('Error in DOMContentLoaded handler:', error);
                }
            });
            
        } catch (error) {
            console.error('Error setting up DOMContentLoaded listener:', error);
        }
        
        // Fallback initialization
        setTimeout(function() {
            console.log('Fallback: Checking if initialization is needed...');
            if (!window.incidentReportingInitialized) {
                console.log('Fallback: Initializing incident reporting...');
                initializeIncidentReporting();
            }
        }, 1000);
        
        window.incidentReportingInitialized = false;
        
        function initializeIncidentReporting() {
            try {
                console.log('initializeIncidentReporting called');
                
                // Incident form submission
                const incidentForm = document.getElementById('incident-form');
                if (incidentForm) {
                    console.log('Setting up incident form submission');
                    incidentForm.onsubmit = function(e) {
                        e.preventDefault();
                        console.log('Incident form submitted');
                        submitIncidentForm();
                    };
                }
                
                // Clear form button
                const clearFormBtn = document.getElementById('clear-form');
                if (clearFormBtn) {
                    console.log('Setting up clear form button');
                    clearFormBtn.onclick = function() {
                        console.log('Clear form clicked');
                        document.getElementById('incident-form').reset();
                    };
                }
                
                // View Details buttons
                document.onclick = function(e) {
                    if (e.target && e.target.classList.contains('incident-details')) {
                        console.log('View Details clicked');
                        const incidentId = e.target.getAttribute('data-incident-id');
                        showIncidentDetails(incidentId);
                    }
                };
                
                console.log('Incident reporting initialized successfully');
                
            } catch (error) {
                console.error('Error in initializeIncidentReporting:', error);
            }
        }
        
        function submitIncidentForm() {
            try {
                console.log('submitIncidentForm called');
                
                const form = document.getElementById('incident-form');
                const formData = new FormData(form);
                
                fetch('index.php?entryPoint=save_incident', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers);
                    
                    // Get the response text to debug
                    return response.text().then(text => {
                        console.log('Response text:', text);
                        
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            console.error('Failed to parse JSON:', e);
                            console.error('Response text was:', text);
                            throw new Error('Invalid JSON response: ' + text.substring(0, 100));
                        }
                    });
                })
                .then(data => {
                    if (data.success) {
                        alert('Incident report saved successfully!');
                        form.reset();
                        // Reload page to show new incident
                        window.location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error submitting form:', error);
                    alert('Error submitting incident report: ' + error.message);
                });
                
            } catch (error) {
                console.error('Error in submitIncidentForm:', error);
            }
        }
        
        function showIncidentDetails(incidentId) {
            try {
                console.log('showIncidentDetails called with ID:', incidentId);
                
                // Find the incident card to get the data
                const incidentCard = document.querySelector('[data-incident-id="' + incidentId + '"]');
                if (!incidentCard) {
                    console.error('Incident card not found for ID:', incidentId);
                    return;
                }
                
                // Extract incident information from the card
                const title = incidentCard.querySelector('h4').textContent;
                const content = incidentCard.innerHTML;
                
                const modalBody = document.getElementById('incidentModalBody');
                modalBody.innerHTML = 
                    '<div class="incident-details-view">' +
                        '<h4>' + title + '</h4>' +
                        '<div>' + content + '</div>' +
                    '</div>';
                
                // Show the modal
                const modal = document.getElementById('incidentModal');
                modal.style.display = 'block';
                modal.classList.add('show');
                
                console.log('Modal should be visible now');
                
            } catch (error) {
                console.error('Error in showIncidentDetails:', error);
            }
        }
        
        function closeIncidentModal(event) {
            console.log('closeIncidentModal called');
            
            if (event && event.target.closest('.modal-content')) {
                return;
            }
            
            const modal = document.getElementById('incidentModal');
            modal.style.display = 'none';
            modal.classList.remove('show');
            
            console.log('Modal should be hidden now');
        }
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('incidentModal');
                if (modal && modal.style.display === 'block') {
                    closeIncidentModal();
                }
            }
        });
        </script>
        <?php
    }
} 