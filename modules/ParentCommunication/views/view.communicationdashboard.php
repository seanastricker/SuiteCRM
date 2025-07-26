<?php
/**
 * Feature 4: Basic Parent Notification System
 * Main dashboard view for the parent communication module
 * 
 * Integrates with SuiteCRM's MVC framework and theme
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/View/SugarView.php');

class ParentCommunicationViewCommunicationdashboard extends SugarView
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
            $this->ss->assign('MODULE_TITLE', 'Parent Communication Dashboard');
        }
    }

    public function display()
    {
        global $mod_strings, $app_strings, $current_user;
        
        // Form submissions are handled by the send_parent_email entry point
        
        // Initialize database connection
        require_once('include/database/DBManagerFactory.php');
        global $db;
        $db = DBManagerFactory::getInstance();
        
        // Use helper class for business logic
        require_once('modules/ParentCommunication/ParentCommunicationHelper.php');
        
        // Get filters from request
        $filters = array();
        if (!empty($_GET['email_enabled'])) $filters['email_enabled'] = $_GET['email_enabled'];
        if (!empty($_GET['program'])) $filters['program'] = $_GET['program'];
        if (!empty($_GET['frequency'])) $filters['frequency'] = $_GET['frequency'];
        
        // Get data
        $parents = ParentCommunicationHelper::getParents($filters);
        $stats = ParentCommunicationHelper::getParentStats();
        $templates = ParentCommunicationHelper::getMessageTemplates();
        $recent_communications = ParentCommunicationHelper::getRecentCommunications(10);
        $dropdown_options = ParentCommunicationHelper::getDropdownOptions();
        
        // Add inline CSS for styling
        echo '<style>
            .parent-dashboard {
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
            .parent-card {
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 15px;
                margin-bottom: 10px;
                background: white;
                transition: all 0.2s;
            }
            .parent-card:hover {
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .parent-card.selected {
                border-color: #007bff;
                background-color: #f8f9ff;
            }
            .parent-card input[type="checkbox"] {
                margin-right: 10px;
            }
            .email-enabled { border-left: 4px solid #28a745; }
            .email-disabled { border-left: 4px solid #dc3545; }
            .parent-meta {
                font-size: 12px;
                color: #666;
                margin-top: 10px;
            }
            .communication-card {
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 10px;
                margin-bottom: 8px;
                background: white;
            }
            .communication-meta {
                font-size: 11px;
                color: #666;
                margin-top: 5px;
            }
            .selected-count {
                background: #007bff;
                color: white;
                padding: 5px 10px;
                border-radius: 15px;
                font-size: 12px;
                font-weight: bold;
            }
            .template-preview {
                max-height: 200px;
                overflow-y: auto;
                background: #f8f9fa;
                border: 1px solid #dee2e6;
                padding: 10px;
                border-radius: 4px;
                margin-top: 10px;
                font-size: 12px;
            }
        </style>';
        
        // Output the dashboard HTML directly
        $this->renderDashboard($parents, $stats, $templates, $recent_communications, $dropdown_options, $filters);
    }

    /**
     * Render the parent communication dashboard HTML
     */
    private function renderDashboard($parents, $stats, $templates, $recent_communications, $dropdown_options, $filters)
    {
        ?>
        <div class="parent-dashboard">
            <!-- Statistics Panel -->
            <div class="stats-panel">
                <h3>Parent Communication Statistics</h3>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $stats['total_parents']; ?></div>
                        <div class="stat-label">Total Parents</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $stats['email_enabled']; ?></div>
                        <div class="stat-label">Email Enabled</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $stats['recent_communications']; ?></div>
                        <div class="stat-label">Recent Communications</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $stats['active_programs']; ?></div>
                        <div class="stat-label">Active Programs</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Email Composition Form -->
                <div class="col-md-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Send Broadcast Email</h3>
                        </div>
                        <div class="panel-body">
                            <form id="email-form">
                                <!-- Template Selection -->
                                <div class="form-group">
                                    <label>Message Template (Optional)</label>
                                    <select id="template-select" class="form-control">
                                        <option value="">Select a template...</option>
                                        <?php foreach ($templates as $key => $template): ?>
                                            <option value="<?php echo htmlspecialchars($key); ?>"
                                                    data-subject="<?php echo htmlspecialchars($template['subject']); ?>"
                                                    data-message="<?php echo htmlspecialchars($template['message']); ?>">
                                                <?php echo htmlspecialchars($template['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div id="template-preview" class="template-preview" style="display: none;"></div>
                                </div>
                                
                                <!-- Subject and Message -->
                                <div class="form-group">
                                    <label>Subject *</label>
                                    <input type="text" id="email-subject" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Message *</label>
                                    <textarea id="email-message" class="form-control" rows="8" required 
                                              placeholder="Enter your message. Use [PARENT_NAME] to personalize."></textarea>
                                </div>
                                
                                <!-- Selected Parents Count -->
                                <div class="form-group">
                                    <div id="selected-count" class="selected-count">No parents selected</div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <button type="submit" class="btn btn-primary" id="send-email-btn">
                                    <i class="fa fa-send"></i> Send Email
                                </button>
                                <button type="button" class="btn btn-default" id="clear-form-btn">
                                    Clear Form
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Parent Selection and Filtering -->
                <div class="col-md-7">
                    <!-- Filter Panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Filter Parents</h3>
                        </div>
                        <div class="panel-body">
                            <form id="filter-form" method="GET">
                                <input type="hidden" name="module" value="ParentCommunication">
                                <input type="hidden" name="action" value="CommunicationDashboard">
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Program</label>
                                            <select name="program" class="form-control">
                                                <option value="">All programs</option>
                                                <?php foreach ($dropdown_options['programs'] as $key => $value): ?>
                                                    <option value="<?php echo htmlspecialchars($key); ?>" 
                                                            <?php echo ($filters['program'] ?? '') === $key ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($value); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Communication Frequency</label>
                                            <select name="frequency" class="form-control">
                                                <option value="">All frequencies</option>
                                                <?php foreach ($dropdown_options['frequencies'] as $key => $value): ?>
                                                    <option value="<?php echo htmlspecialchars($key); ?>" 
                                                            <?php echo ($filters['frequency'] ?? '') === $key ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($value); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Email Notifications</label>
                                            <select name="email_enabled" class="form-control">
                                                <option value="">All parents</option>
                                                <option value="1" <?php echo ($filters['email_enabled'] ?? '') === '1' ? 'selected' : ''; ?>>
                                                    Email enabled only
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                                <button type="button" class="btn btn-default" id="clear-filters-btn">Clear</button>
                            </form>
                            
                            <!-- Selection Controls -->
                            <hr>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-default" id="select-all">Select All</button>
                                <button type="button" class="btn btn-sm btn-default" id="select-none">Select None</button>
                                <button type="button" class="btn btn-sm btn-default" id="select-email-enabled">Select Email Enabled</button>
                            </div>

                        </div>
                    </div>
                    
                    <!-- Parent List -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title" id="parent-count-title">Parents (<?php echo count($parents); ?>)</h3>
                        </div>
                        <div class="panel-body" style="max-height: 400px; overflow-y: auto;">
                            <?php if (empty($parents)): ?>
                                <div class="alert alert-info">
                                    <strong>No parents found.</strong> 
                                    <?php if (!empty($filters)): ?>
                                        Try adjusting your filters.
                                    <?php else: ?>
                                        Make sure you have parent contacts with contact type set to "Parent".
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div id="parents-list">
                                    <?php foreach ($parents as $parent): ?>
                                        <div class="parent-card <?php echo !empty($parent['email_notifications_c']) ? 'email-enabled' : 'email-disabled'; ?>" 
                                             data-parent-id="<?php echo htmlspecialchars($parent['id']); ?>"
                                             data-program="<?php echo htmlspecialchars($parent['programs_enrolled_c'] ?? ''); ?>"
                                             data-frequency="<?php echo htmlspecialchars($parent['communication_frequency_c'] ?? ''); ?>"
                                             data-email-enabled="<?php echo !empty($parent['email_notifications_c']) ? '1' : '0'; ?>">
                                            <label class="parent-checkbox-label">
                                                <input type="checkbox" class="parent-checkbox" 
                                                       value="<?php echo htmlspecialchars($parent['id']); ?>"
                                                       data-email="<?php echo htmlspecialchars($parent['email1']); ?>"
                                                       data-email-enabled="<?php echo !empty($parent['email_notifications_c']) ? '1' : '0'; ?>">
                                                <strong><?php echo htmlspecialchars(trim($parent['first_name'] . ' ' . $parent['last_name'])); ?></strong>
                                            </label>
                                            
                                            <div class="parent-details">
                                                <?php if (!empty($parent['email1'])): ?>
                                                    <div><i class="fa fa-envelope"></i> <?php echo htmlspecialchars($parent['email1']); ?></div>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($parent['children_names_c'])): ?>
                                                    <div><i class="fa fa-child"></i> Children: <?php echo htmlspecialchars($parent['children_names_c']); ?></div>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($parent['programs_enrolled_c'])): ?>
                                                    <div><i class="fa fa-soccer-ball-o"></i> Programs: <?php echo htmlspecialchars($parent['programs_enrolled_c']); ?></div>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($parent['phone_mobile'])): ?>
                                                    <div><i class="fa fa-phone"></i> <?php echo htmlspecialchars($parent['phone_mobile']); ?></div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="parent-meta">
                                                Email notifications: <?php echo !empty($parent['email_notifications_c']) ? 'Enabled' : 'Disabled'; ?>
                                                <?php if (!empty($parent['last_communication_date_c'])): ?>
                                                    | Last contact: <?php echo date('M j, Y', strtotime($parent['last_communication_date_c'])); ?>
                                                <?php endif; ?>
                                                <?php if (!empty($parent['communication_count_c'])): ?>
                                                    | Total communications: <?php echo $parent['communication_count_c']; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Communications -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Recent Communications (<?php echo count($recent_communications); ?>)</h3>
                        </div>
                        <div class="panel-body">
                            <?php if (empty($recent_communications)): ?>
                                <div class="alert alert-info">
                                    <strong>No recent communications found.</strong> 
                                    Send your first broadcast email using the form above.
                                </div>
                            <?php else: ?>
                                <div id="communications-list">
                                    <?php foreach ($recent_communications as $comm): ?>
                                        <div class="communication-card">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h5><?php echo htmlspecialchars($comm['subject']); ?></h5>
                                                    <p><?php echo htmlspecialchars($comm['name']); ?></p>
                                                    <?php if (!empty($comm['template_used'])): ?>
                                                        <span class="label label-info">Template: <?php echo htmlspecialchars($comm['template_used']); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-md-4 text-right">
                                                    <div><strong><?php echo $comm['recipient_count']; ?> recipients</strong></div>
                                                    <div class="communication-meta">
                                                        Sent: <?php echo date('M j, Y g:i A', strtotime($comm['sent_date'])); ?>
                                                        <br>By: <?php echo htmlspecialchars($comm['sent_by']); ?>
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

        <script>
        // Enhanced JavaScript for parent communication functionality
        console.log('Loading parent communication JavaScript...');
        
        try {
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM Content Loaded - initializing parent communication...');
                
                try {
                    initializeParentCommunication();
                    window.parentCommunicationInitialized = true;
                } catch (error) {
                    console.error('Error in DOMContentLoaded handler:', error);
                }
            });
        } catch (error) {
            console.error('Error setting up DOMContentLoaded listener:', error);
        }
        
        // Fallback initialization
        setTimeout(function() {
            if (!window.parentCommunicationInitialized) {
                console.log('Fallback: Initializing parent communication...');
                initializeParentCommunication();
            }
        }, 1000);
        
        window.parentCommunicationInitialized = false;
        
        function initializeParentCommunication() {
            try {
                console.log('initializeParentCommunication called');
                
                // Email form submission
                const emailForm = document.getElementById('email-form');
                if (emailForm) {
                    emailForm.onsubmit = function(e) {
                        e.preventDefault();
                        submitEmailForm();
                    };
                }
                
                // Template selection
                const templateSelect = document.getElementById('template-select');
                if (templateSelect) {
                    templateSelect.onchange = function() {
                        loadTemplate(this.value);
                    };
                }
                
                // Clear form button
                const clearFormBtn = document.getElementById('clear-form-btn');
                if (clearFormBtn) {
                    clearFormBtn.onclick = function() {
                        clearEmailForm();
                    };
                }
                
                // Filter form submission
                const filterForm = document.getElementById('filter-form');
                if (filterForm) {
                    filterForm.onsubmit = function(e) {
                        e.preventDefault();
                        filterParents();
                    };
                }
                
                // Clear filters button
                const clearFiltersBtn = document.getElementById('clear-filters-btn');
                if (clearFiltersBtn) {
                    clearFiltersBtn.onclick = function() {
                        clearFilters();
                    };
                }
                
                // Selection controls
                const selectAllBtn = document.getElementById('select-all');
                if (selectAllBtn) {
                    selectAllBtn.onclick = function() {
                        selectAllParents();
                    };
                }
                
                const selectNoneBtn = document.getElementById('select-none');
                if (selectNoneBtn) {
                    selectNoneBtn.onclick = function() {
                        selectNoParents();
                    };
                }
                
                const selectEmailEnabledBtn = document.getElementById('select-email-enabled');
                if (selectEmailEnabledBtn) {
                    selectEmailEnabledBtn.onclick = function() {
                        selectEmailEnabledParents();
                    };
                }
                
                // Parent checkbox changes
                const parentCheckboxes = document.querySelectorAll('.parent-checkbox');
                parentCheckboxes.forEach(function(checkbox) {
                    checkbox.onchange = function() {
                        updateParentSelection();
                        updateSelectedCount();
                    };
                });
                
                // Initial count update
                updateSelectedCount();
                
                console.log('Parent communication initialized successfully');
                
            } catch (error) {
                console.error('Error in initializeParentCommunication:', error);
            }
        }
        
        function submitEmailForm() {
            try {
                console.log('submitEmailForm called');
                
                const subject = document.getElementById('email-subject').value.trim();
                const message = document.getElementById('email-message').value.trim();
                
                if (!subject || !message) {
                    alert('Please fill in both subject and message fields.');
                    return;
                }
                
                const selectedParents = getSelectedParentIds();
                if (selectedParents.length === 0) {
                    alert('Please select at least one parent to send the email to.');
                    return;
                }
                
                const sendBtn = document.getElementById('send-email-btn');
                sendBtn.disabled = true;
                sendBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Sending...';
                
                const formData = new FormData();
                formData.append('parent_ids', selectedParents.join(','));
                formData.append('subject', subject);
                formData.append('message', message);
                
                const templateSelect = document.getElementById('template-select');
                if (templateSelect.value) {
                    formData.append('template_used', templateSelect.options[templateSelect.selectedIndex].text);
                }
                
                fetch('index.php?entryPoint=send_parent_email', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.text().then(text => {
                        console.log('Response text:', text);
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            console.error('Failed to parse JSON:', e);
                            throw new Error('Invalid JSON response: ' + text.substring(0, 100));
                        }
                    });
                })
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        clearEmailForm();
                        // Reload page to show new communication
                        window.location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error submitting email:', error);
                    alert('Error sending email: ' + error.message);
                })
                .finally(() => {
                    sendBtn.disabled = false;
                    sendBtn.innerHTML = '<i class="fa fa-send"></i> Send Email';
                });
                
            } catch (error) {
                console.error('Error in submitEmailForm:', error);
            }
        }
        
        function loadTemplate(templateKey) {
            const templateSelect = document.getElementById('template-select');
            const selectedOption = templateSelect.querySelector('option[value="' + templateKey + '"]');
            const preview = document.getElementById('template-preview');
            
            if (selectedOption && templateKey) {
                const subject = selectedOption.getAttribute('data-subject');
                const message = selectedOption.getAttribute('data-message');
                
                document.getElementById('email-subject').value = subject;
                document.getElementById('email-message').value = message;
                
                preview.innerHTML = '<strong>Preview:</strong><br>' + message.replace(/\n/g, '<br>');
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        }
        
        function clearEmailForm() {
            document.getElementById('email-subject').value = '';
            document.getElementById('email-message').value = '';
            document.getElementById('template-select').value = '';
            document.getElementById('template-preview').style.display = 'none';
        }
        
        function selectAllParents() {
            const checkboxes = document.querySelectorAll('.parent-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = true;
            });
            updateParentSelection();
            updateSelectedCount();
        }
        
        function selectNoParents() {
            const checkboxes = document.querySelectorAll('.parent-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
            updateParentSelection();
            updateSelectedCount();
        }
        
        function selectEmailEnabledParents() {
            const checkboxes = document.querySelectorAll('.parent-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = checkbox.getAttribute('data-email-enabled') === '1';
            });
            updateParentSelection();
            updateSelectedCount();
        }
        
        function updateParentSelection() {
            const checkboxes = document.querySelectorAll('.parent-checkbox');
            checkboxes.forEach(function(checkbox) {
                const parentCard = checkbox.closest('.parent-card');
                if (checkbox.checked) {
                    parentCard.classList.add('selected');
                } else {
                    parentCard.classList.remove('selected');
                }
            });
        }
        
        function updateSelectedCount() {
            const selectedParents = getSelectedParentIds();
            const countElement = document.getElementById('selected-count');
            
            if (selectedParents.length === 0) {
                countElement.textContent = 'No parents selected';
                countElement.className = 'selected-count';
            } else {
                countElement.textContent = 'Selected: ' + selectedParents.length + ' parents';
                countElement.className = 'selected-count';
            }
        }
        
        function getSelectedParentIds() {
            const checkboxes = document.querySelectorAll('.parent-checkbox:checked');
            const ids = [];
            checkboxes.forEach(function(checkbox) {
                ids.push(checkbox.value);
            });
            return ids;
        }
        
        function filterParents() {
            console.log('Filtering parents...');
            
            // Get filter values
            const programFilter = document.querySelector('select[name="program"]').value;
            const frequencyFilter = document.querySelector('select[name="frequency"]').value;
            const emailFilter = document.querySelector('select[name="email_enabled"]').value;
            
            console.log('Filter values:', {program: programFilter, frequency: frequencyFilter, email: emailFilter});
            
            // Get all parent cards
            const parentCards = document.querySelectorAll('.parent-card');
            let visibleCount = 0;
            
            parentCards.forEach(function(card) {
                let shouldShow = true;
                
                // Get parent data
                const parentProgram = card.getAttribute('data-program') || '';
                const parentFrequency = card.getAttribute('data-frequency') || '';
                const parentEmailEnabled = card.getAttribute('data-email-enabled') || '';
                
                console.log('Parent data:', {program: parentProgram, frequency: parentFrequency, email: parentEmailEnabled});
                
                // Filter by program (check if program is contained in programs list)
                if (programFilter && programFilter !== '') {
                    if (!parentProgram.includes(programFilter)) {
                        shouldShow = false;
                        console.log('Failed program filter:', programFilter, 'not in', parentProgram);
                    }
                }
                
                // Filter by frequency (handle data inconsistencies)
                if (frequencyFilter && frequencyFilter !== '') {
                    let frequencyMatch = false;
                    
                    // Exact match
                    if (parentFrequency === frequencyFilter) {
                        frequencyMatch = true;
                    }
                    // Handle emergency_only vs emergencies inconsistency
                    else if ((frequencyFilter === 'emergency_only' && parentFrequency === 'emergencies') ||
                             (frequencyFilter === 'emergencies' && parentFrequency === 'emergency_only')) {
                        frequencyMatch = true;
                    }
                    
                    if (!frequencyMatch) {
                        shouldShow = false;
                        console.log('Failed frequency filter:', frequencyFilter, 'does not match', parentFrequency);
                    }
                }
                
                // Filter by email enabled (exact match)
                if (emailFilter && emailFilter !== '') {
                    if (parentEmailEnabled !== emailFilter) {
                        shouldShow = false;
                        console.log('Failed email filter:', emailFilter, '!==', parentEmailEnabled);
                    }
                }
                
                // Show/hide the card
                if (shouldShow) {
                    card.style.display = 'block';
                    visibleCount++;
                    console.log('Showing parent card');
                } else {
                    card.style.display = 'none';
                    console.log('Hiding parent card');
                }
            });
            
            // Update the parent count
            const countElement = document.getElementById('parent-count-title');
            if (countElement) {
                countElement.textContent = 'Parents (' + visibleCount + ')';
            }
            
            console.log('Filter applied. Visible parents:', visibleCount);
        }
        
        function clearFilters() {
            console.log('Clearing filters...');
            
            // Reset filter form values
            document.querySelector('select[name="program"]').value = '';
            document.querySelector('select[name="frequency"]').value = '';
            document.querySelector('select[name="email_enabled"]').value = '';
            
            // Show all parent cards
            const parentCards = document.querySelectorAll('.parent-card');
            parentCards.forEach(function(card) {
                card.style.display = 'block';
            });
            
            // Update the parent count
            const totalParents = parentCards.length;
            const countElement = document.getElementById('parent-count-title');
            if (countElement) {
                countElement.textContent = 'Parents (' + totalParents + ')';
            }
            
            console.log('Filters cleared. Showing all', totalParents, 'parents');
        }
        </script>
        <?php
    }
} 