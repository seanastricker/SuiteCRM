<?php

/**
 * Equipment Dashboard View
 * 
 * Main dashboard for equipment check-out tracking system.
 * Handles equipment inventory, check-out/return workflows, and overdue tracking.
 * 
 * @author SuiteCRM Development Team
 * @package Equipment
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/View/SugarView.php');
require_once('modules/Equipment/EquipmentHelper.php');

/**
 * Equipment Dashboard View Class
 */
class EquipmentViewEquipmentdashboard extends SugarView
{
    /**
     * Display the equipment dashboard
     */
    public function display()
    {
        global $mod_strings, $app_strings, $current_user;
        
        // Ensure equipment table exists
        EquipmentHelper::createEquipmentTable();
        
        // Get dashboard data
        $summary = EquipmentHelper::getEquipmentSummary();
        $equipment = EquipmentHelper::getEquipment();
        $dropdown_options = EquipmentHelper::getDropdownOptions();
        $reports = EquipmentHelper::generateReports();
        $usage_stats = EquipmentHelper::getUsageStatistics(30);
        
        // Debug: Log equipment count
        error_log("Equipment Dashboard Debug: Found " . count($equipment) . " equipment items");
        
        echo $this->renderDashboard($summary, $equipment, $dropdown_options, $reports, $usage_stats, $mod_strings);
    }
    
    /**
     * Render the complete dashboard HTML
     */
    private function renderDashboard($summary, $equipment, $dropdown_options, $reports, $usage_stats, $mod_strings)
    {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title><?php echo $mod_strings['LBL_DASHBOARD_TITLE']; ?></title>
            <style>
                /* Equipment Dashboard Styles */
                .equipment-dashboard {
                    margin: 20px;
                    font-family: 'Helvetica Neue', Arial, sans-serif;
                }
                
                .equipment-header {
                    background: linear-gradient(135deg, #2c3e50, #3498db);
                    color: white;
                    padding: 30px;
                    border-radius: 8px;
                    margin-bottom: 30px;
                    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                }
                
                .equipment-header h1 {
                    margin: 0;
                    font-size: 28px;
                    font-weight: 300;
                }
                
                .equipment-header p {
                    margin: 10px 0 0 0;
                    opacity: 0.9;
                    font-size: 16px;
                }
                
                .stats-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 20px;
                    margin-bottom: 30px;
                }
                
                .stat-card {
                    background: white;
                    padding: 25px;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    text-align: center;
                    border-left: 4px solid #3498db;
                    transition: transform 0.2s;
                }
                
                .stat-card:hover {
                    transform: translateY(-2px);
                }
                
                .stat-card.available { border-left-color: #27ae60; }
                .stat-card.checked-out { border-left-color: #e74c3c; }
                .stat-card.maintenance { border-left-color: #f39c12; }
                .stat-card.overdue { border-left-color: #c0392b; }
                
                .stat-number {
                    font-size: 36px;
                    font-weight: bold;
                    color: #2c3e50;
                    margin-bottom: 5px;
                }
                
                .stat-label {
                    color: #7f8c8d;
                    font-size: 14px;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                }
                
                .dashboard-section {
                    background: white;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    margin-bottom: 30px;
                    overflow: hidden;
                }
                
                .section-header {
                    background: #f8f9fa;
                    padding: 20px;
                    border-bottom: 1px solid #dee2e6;
                }
                
                .section-title {
                    margin: 0;
                    color: #2c3e50;
                    font-size: 20px;
                    font-weight: 500;
                }
                
                .section-content {
                    padding: 20px;
                }
                
                .filter-section {
                    background: #f8f9fa;
                    padding: 20px;
                    border-radius: 8px;
                    margin-bottom: 20px;
                }
                
                .filter-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 15px;
                    align-items: end;
                }
                
                .filter-group {
                    display: flex;
                    flex-direction: column;
                }
                
                .filter-group label {
                    margin-bottom: 5px;
                    font-weight: 500;
                    color: #2c3e50;
                    font-size: 14px;
                }
                
                .filter-group select {
                    padding: 8px 12px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    font-size: 14px;
                }
                
                .btn-group {
                    display: flex;
                    gap: 10px;
                }
                
                .btn {
                    padding: 8px 16px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    font-size: 14px;
                    transition: background-color 0.2s;
                }
                
                .btn-primary {
                    background: #3498db;
                    color: white;
                }
                
                .btn-primary:hover {
                    background: #2980b9;
                }
                
                .btn-secondary {
                    background: #95a5a6;
                    color: white;
                }
                
                .btn-secondary:hover {
                    background: #7f8c8d;
                }
                
                .btn-success {
                    background: #27ae60;
                    color: white;
                }
                
                .btn-success:hover {
                    background: #229954;
                }
                
                .btn-danger {
                    background: #e74c3c;
                    color: white;
                }
                
                .btn-danger:hover {
                    background: #c0392b;
                }
                
                .equipment-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
                    gap: 20px;
                }
                
                .equipment-card {
                    border: 1px solid #dee2e6;
                    border-radius: 8px;
                    padding: 20px;
                    transition: transform 0.2s, box-shadow 0.2s;
                    background: white;
                }
                
                .equipment-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
                }
                
                .equipment-card.available {
                    border-left: 4px solid #27ae60;
                }
                
                .equipment-card.checked-out {
                    border-left: 4px solid #e74c3c;
                }
                
                .equipment-card.maintenance {
                    border-left: 4px solid #f39c12;
                }
                
                .equipment-card.overdue {
                    border-left: 4px solid #c0392b;
                    background: #fff5f5;
                }
                
                .equipment-name {
                    font-size: 18px;
                    font-weight: 600;
                    color: #2c3e50;
                    margin-bottom: 10px;
                }
                
                .equipment-details {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 10px;
                    margin-bottom: 15px;
                    font-size: 14px;
                }
                
                .equipment-detail {
                    display: flex;
                    flex-direction: column;
                }
                
                .equipment-detail label {
                    font-weight: 500;
                    color: #7f8c8d;
                    margin-bottom: 2px;
                    font-size: 12px;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }
                
                .equipment-detail span {
                    color: #2c3e50;
                }
                
                .equipment-status {
                    display: inline-block;
                    padding: 4px 8px;
                    border-radius: 4px;
                    font-size: 12px;
                    font-weight: 500;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }
                
                .status-available {
                    background: #d5f4e6;
                    color: #27ae60;
                }
                
                .status-checked-out {
                    background: #fadbd8;
                    color: #e74c3c;
                }
                
                .status-maintenance {
                    background: #fef9e7;
                    color: #f39c12;
                }
                
                .status-overdue {
                    background: #fadbd8;
                    color: #c0392b;
                    animation: pulse 2s infinite;
                }
                
                @keyframes pulse {
                    0% { opacity: 1; }
                    50% { opacity: 0.7; }
                    100% { opacity: 1; }
                }
                
                .equipment-actions {
                    display: flex;
                    gap: 8px;
                    margin-top: 15px;
                }
                
                .equipment-actions .btn {
                    flex: 1;
                    text-align: center;
                    padding: 6px 12px;
                    font-size: 12px;
                }
                
                .no-equipment {
                    text-align: center;
                    padding: 40px;
                    color: #7f8c8d;
                    font-size: 16px;
                }
                
                .modal {
                    display: none;
                    position: fixed;
                    z-index: 1000;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0,0,0,0.5);
                }
                
                .modal-content {
                    background-color: white;
                    margin: 10% auto;
                    padding: 0;
                    border-radius: 8px;
                    width: 500px;
                    max-width: 90%;
                    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
                }
                
                .modal-header {
                    background: #3498db;
                    color: white;
                    padding: 20px;
                    border-radius: 8px 8px 0 0;
                }
                
                .modal-title {
                    margin: 0;
                    font-size: 18px;
                    font-weight: 500;
                }
                
                .modal-body {
                    padding: 20px;
                }
                
                .modal-footer {
                    padding: 15px 20px;
                    border-top: 1px solid #dee2e6;
                    display: flex;
                    justify-content: flex-end;
                    gap: 10px;
                }
                
                .form-group {
                    margin-bottom: 15px;
                }
                
                .form-group label {
                    display: block;
                    margin-bottom: 5px;
                    font-weight: 500;
                    color: #2c3e50;
                }
                
                .form-group input,
                .form-group select,
                .form-group textarea {
                    width: 100%;
                    padding: 8px 12px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    font-size: 14px;
                    box-sizing: border-box;
                }
                
                .form-group textarea {
                    height: 80px;
                    resize: vertical;
                }
                
                .close {
                    position: absolute;
                    right: 15px;
                    top: 15px;
                    color: white;
                    font-size: 24px;
                    font-weight: bold;
                    cursor: pointer;
                    background: none;
                    border: none;
                }
                
                .close:hover {
                    opacity: 0.7;
                }
                
                .alert {
                    padding: 12px;
                    margin-bottom: 20px;
                    border-radius: 4px;
                    font-size: 14px;
                }
                
                .alert-success {
                    background: #d5f4e6;
                    color: #27ae60;
                    border: 1px solid #27ae60;
                }
                
                .alert-error {
                    background: #fadbd8;
                    color: #e74c3c;
                    border: 1px solid #e74c3c;
                }
                
                @media (max-width: 768px) {
                    .equipment-dashboard {
                        margin: 10px;
                    }
                    
                    .equipment-grid {
                        grid-template-columns: 1fr;
                    }
                    
                    .filter-grid {
                        grid-template-columns: 1fr;
                    }
                    
                    .stats-grid {
                        grid-template-columns: repeat(2, 1fr);
                    }
                }
            </style>
        </head>
        <body>
            <div class="equipment-dashboard">
                <!-- Header -->
                <div class="equipment-header">
                    <h1><?php echo $mod_strings['LBL_DASHBOARD_TITLE']; ?></h1>
                    <p>Track equipment check-outs, returns, and inventory for your sports programs</p>
                </div>

                <!-- Overdue Alerts -->
                <?php if ($reports['overdue']['count'] > 0): ?>
                <div class="alert alert-error" style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <strong>⚠️ OVERDUE EQUIPMENT ALERT:</strong> 
                        <?php echo $reports['overdue']['count']; ?> item(s) are overdue for return. 
                        Immediate action required.
                    </div>
                    <div>
                        <button class="btn btn-danger" onclick="sendOverdueNotifications()" style="margin-left: 15px;">
                            Send Reminders
                        </button>
                        <button class="btn btn-secondary" onclick="showOverdueDetails()" style="margin-left: 5px;">
                            View Details
                        </button>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Summary Statistics -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $summary['total_equipment']; ?></div>
                        <div class="stat-label"><?php echo $mod_strings['LBL_TOTAL_EQUIPMENT']; ?></div>
                    </div>
                    <div class="stat-card available">
                        <div class="stat-number"><?php echo $summary['available']; ?></div>
                        <div class="stat-label"><?php echo $mod_strings['LBL_AVAILABLE']; ?></div>
                    </div>
                    <div class="stat-card checked-out">
                        <div class="stat-number"><?php echo $summary['checked_out']; ?></div>
                        <div class="stat-label"><?php echo $mod_strings['LBL_CHECKED_OUT']; ?></div>
                    </div>
                    <div class="stat-card maintenance">
                        <div class="stat-number"><?php echo $summary['maintenance']; ?></div>
                        <div class="stat-label"><?php echo $mod_strings['LBL_IN_MAINTENANCE']; ?></div>
                    </div>
                    <div class="stat-card overdue">
                        <div class="stat-number"><?php echo $summary['overdue']; ?></div>
                        <div class="stat-label"><?php echo $mod_strings['LBL_OVERDUE']; ?></div>
                    </div>
                </div>

                <!-- Equipment Inventory Section -->
                <div class="dashboard-section">
                    <div class="section-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <h2 class="section-title" id="equipment-count-title"><?php echo $mod_strings['LBL_EQUIPMENT_INVENTORY']; ?> (<?php echo count($equipment); ?>)</h2>
                        <div class="btn-group" style="margin-left: 15px;">
                            <a href="index.php?entryPoint=create_equipment_form" class="btn btn-success" style="text-decoration: none; color: white; margin-right: 10px;">
                                ➕ Create Equipment
                            </a>
                            <?php if (count($equipment) === 0): ?>
                            <button class="btn btn-primary" onclick="testMinimalInsert()" style="margin-right: 10px;">
                                ⚡ Add Sample Data
                            </button>
                            <?php endif; ?>
                            <button class="btn btn-info" onclick="checkDatabase()">
                                🔍 Check DB
                            </button>
                        </div>
                    </div>
                    <div class="section-content">
                        <!-- Filters -->
                        <div class="filter-section">
                            <form id="equipment-filter-form" onsubmit="return filterEquipment(event);">
                                <div class="filter-grid">
                                    <div class="filter-group">
                                        <label for="status-filter"><?php echo $mod_strings['LBL_FILTER_BY_STATUS']; ?></label>
                                        <select name="status" id="status-filter">
                                            <option value="">All Statuses</option>
                                            <?php foreach ($dropdown_options['equipment_statuses'] as $key => $value): ?>
                                                <option value="<?php echo htmlspecialchars($key); ?>"><?php echo htmlspecialchars($value); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="filter-group">
                                        <label for="type-filter"><?php echo $mod_strings['LBL_FILTER_BY_TYPE']; ?></label>
                                        <select name="type" id="type-filter">
                                            <option value="">All Types</option>
                                            <?php foreach ($dropdown_options['equipment_types'] as $key => $value): ?>
                                                <option value="<?php echo htmlspecialchars($key); ?>"><?php echo htmlspecialchars($value); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="filter-group">
                                        <label for="program-filter"><?php echo $mod_strings['LBL_FILTER_BY_PROGRAM']; ?></label>
                                        <select name="program" id="program-filter">
                                            <option value="">All Programs</option>
                                            <?php foreach ($dropdown_options['programs'] as $key => $value): ?>
                                                <option value="<?php echo htmlspecialchars($key); ?>"><?php echo htmlspecialchars($value); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="filter-group">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary"><?php echo $mod_strings['LBL_APPLY_FILTERS']; ?></button>
                                            <button type="button" class="btn btn-secondary" onclick="clearFilters()"><?php echo $mod_strings['LBL_CLEAR_FILTERS']; ?></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Equipment Grid -->
                        <div id="equipment-list">
                            <?php if (empty($equipment)): ?>
                                <div class="no-equipment">
                                    <p><?php echo $mod_strings['LBL_NO_EQUIPMENT_FOUND']; ?></p>
                                    <p>Start by adding some equipment items to your inventory.</p>
                                </div>
                            <?php else: ?>
                                <div class="equipment-grid">
                                    <?php foreach ($equipment as $item): ?>
                                        <div class="equipment-card <?php echo htmlspecialchars($item['checkout_status']); ?> <?php echo $item['is_overdue'] ? 'overdue' : ''; ?>"
                                             data-equipment-id="<?php echo htmlspecialchars($item['id']); ?>"
                                             data-status="<?php echo htmlspecialchars($item['checkout_status']); ?>"
                                             data-type="<?php echo htmlspecialchars($item['equipment_type']); ?>"
                                             data-program="<?php echo htmlspecialchars($item['program_association']); ?>">
                                            
                                            <div class="equipment-name"><?php echo htmlspecialchars($item['name']); ?></div>
                                            
                                            <div class="equipment-details">
                                                <div class="equipment-detail">
                                                    <label><?php echo $mod_strings['LBL_EQUIPMENT_TYPE']; ?></label>
                                                    <span><?php echo htmlspecialchars($item['equipment_type']); ?></span>
                                                </div>
                                                <div class="equipment-detail">
                                                    <label><?php echo $mod_strings['LBL_STATUS']; ?></label>
                                                    <span class="equipment-status status-<?php echo str_replace('_', '-', $item['checkout_status']); ?>">
                                                        <?php echo htmlspecialchars($dropdown_options['equipment_statuses'][$item['checkout_status']] ?? $item['checkout_status']); ?>
                                                    </span>
                                                </div>
                                                <div class="equipment-detail">
                                                    <label><?php echo $mod_strings['LBL_CONDITION']; ?></label>
                                                    <span><?php echo htmlspecialchars($dropdown_options['equipment_conditions'][$item['condition_status']] ?? $item['condition_status']); ?></span>
                                                </div>
                                                <div class="equipment-detail">
                                                    <label><?php echo $mod_strings['LBL_CURRENT_LOCATION']; ?></label>
                                                    <span><?php echo htmlspecialchars($item['current_location'] ?: 'Not specified'); ?></span>
                                                </div>
                                                <?php if ($item['checkout_status'] === 'checked_out'): ?>
                                                    <div class="equipment-detail">
                                                        <label><?php echo $mod_strings['LBL_CHECKED_OUT_BY']; ?></label>
                                                        <span><?php echo htmlspecialchars($item['checked_out_by']); ?></span>
                                                    </div>
                                                    <div class="equipment-detail">
                                                        <label><?php echo $mod_strings['LBL_DUE_DATE']; ?></label>
                                                        <span <?php echo $item['is_overdue'] ? 'style="color: #c0392b; font-weight: bold;"' : ''; ?>><?php echo htmlspecialchars($item['due_date']); ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="equipment-actions">
                                                <?php if ($item['checkout_status'] === 'available'): ?>
                                                    <button class="btn btn-primary" onclick="showCheckoutModal('<?php echo $item['id']; ?>', '<?php echo htmlspecialchars($item['name']); ?>')">
                                                        <?php echo $mod_strings['LBL_CHECK_OUT']; ?>
                                                    </button>
                                                <?php elseif ($item['checkout_status'] === 'checked_out'): ?>
                                                    <button class="btn btn-success" onclick="showReturnModal('<?php echo $item['id']; ?>', '<?php echo htmlspecialchars($item['name']); ?>')">
                                                        <?php echo $mod_strings['LBL_RETURN']; ?>
                                                    </button>
                                                <?php endif; ?>
                                                <button class="btn btn-secondary" onclick="showEquipmentDetails('<?php echo $item['id']; ?>')">
                                                    <?php echo $mod_strings['LBL_VIEW_DETAILS']; ?>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Reports & Analytics Section -->
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2 class="section-title"><?php echo $mod_strings['LBL_EQUIPMENT_REPORTS'] ?? 'Equipment Reports & Analytics'; ?></h2>
                    </div>
                    <div class="section-content">
                        <div class="stats-grid" style="margin-bottom: 30px;">
                            <!-- Utilization Report -->
                            <div class="stat-card <?php echo $reports['utilization']['severity']; ?>">
                                <div class="stat-number"><?php echo $reports['utilization']['utilization_rate']; ?>%</div>
                                <div class="stat-label">Equipment Utilization</div>
                                <div style="font-size: 11px; color: #7f8c8d; margin-top: 5px;">
                                    <?php echo $reports['utilization']['checked_out']; ?> of <?php echo $reports['utilization']['total_equipment']; ?> items in use
                                </div>
                            </div>

                            <!-- 30-Day Checkouts -->
                            <div class="stat-card">
                                <div class="stat-number"><?php echo $usage_stats['total_checkouts']; ?></div>
                                <div class="stat-label">Checkouts (30 days)</div>
                                <div style="font-size: 11px; color: #7f8c8d; margin-top: 5px;">
                                    <?php echo $usage_stats['total_returns']; ?> returns
                                </div>
                            </div>

                            <!-- Equipment Condition -->
                            <div class="stat-card <?php echo $reports['condition']['severity']; ?>">
                                <div class="stat-number">
                                    <?php 
                                    $good_condition = $reports['condition']['stats']['excellent'] + $reports['condition']['stats']['good'];
                                    echo $good_condition; 
                                    ?>
                                </div>
                                <div class="stat-label">Good Condition</div>
                                <div style="font-size: 11px; color: #7f8c8d; margin-top: 5px;">
                                    <?php 
                                    $needs_attention = $reports['condition']['stats']['damaged'] + $reports['condition']['stats']['needs_repair'];
                                    echo $needs_attention; 
                                    ?> need attention
                                </div>
                            </div>

                            <!-- Most Popular Equipment -->
                            <div class="stat-card">
                                <div class="stat-number">
                                    <?php echo !empty($usage_stats['most_popular_equipment']) ? $usage_stats['most_popular_equipment'][0]['count'] : 0; ?>
                                </div>
                                <div class="stat-label">Most Popular Type</div>
                                <div style="font-size: 11px; color: #7f8c8d; margin-top: 5px;">
                                    <?php echo !empty($usage_stats['most_popular_equipment']) ? ucfirst($usage_stats['most_popular_equipment'][0]['type']) : 'N/A'; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Reports Grid -->
                        <div class="equipment-grid" style="margin-bottom: 20px;">
                            <!-- Usage Statistics -->
                            <div class="equipment-card" style="padding: 20px;">
                                <div class="equipment-name">📊 Usage Statistics (30 Days)</div>
                                <div class="equipment-details">
                                    <div class="equipment-detail">
                                        <label>Total Checkouts</label>
                                        <span><?php echo $usage_stats['total_checkouts']; ?></span>
                                    </div>
                                    <div class="equipment-detail">
                                        <label>Total Returns</label>
                                        <span><?php echo $usage_stats['total_returns']; ?></span>
                                    </div>
                                </div>
                                
                                <?php if (!empty($usage_stats['most_popular_equipment'])): ?>
                                <div style="margin-top: 15px;">
                                    <strong style="color: #2c3e50; font-size: 14px;">Most Popular Equipment:</strong>
                                    <ul style="margin: 8px 0; padding-left: 20px; font-size: 12px;">
                                        <?php foreach (array_slice($usage_stats['most_popular_equipment'], 0, 3) as $item): ?>
                                            <li><?php echo ucfirst($item['type']); ?> (<?php echo $item['count']; ?> checkouts)</li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php endif; ?>
                                
                                <div class="equipment-actions">
                                    <button class="btn btn-primary" onclick="generateDetailedReport('usage')">
                                        Detailed Report
                                    </button>
                                </div>
                            </div>

                            <!-- Condition Report -->
                            <div class="equipment-card" style="padding: 20px;">
                                <div class="equipment-name">🔧 Equipment Condition Report</div>
                                <div class="equipment-details">
                                    <div class="equipment-detail">
                                        <label>Excellent/Good</label>
                                        <span style="color: #27ae60;">
                                            <?php echo $reports['condition']['stats']['excellent'] + $reports['condition']['stats']['good']; ?>
                                        </span>
                                    </div>
                                    <div class="equipment-detail">
                                        <label>Fair/Poor</label>
                                        <span style="color: #f39c12;">
                                            <?php echo $reports['condition']['stats']['fair'] + $reports['condition']['stats']['poor']; ?>
                                        </span>
                                    </div>
                                    <div class="equipment-detail">
                                        <label>Damaged/Repair</label>
                                        <span style="color: #e74c3c;">
                                            <?php echo $reports['condition']['stats']['damaged'] + $reports['condition']['stats']['needs_repair']; ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="equipment-actions">
                                    <button class="btn btn-primary" onclick="generateDetailedReport('condition')">
                                        Condition Report
                                    </button>
                                </div>
                            </div>

                            <!-- Overdue Equipment -->
                            <div class="equipment-card <?php echo $reports['overdue']['count'] > 0 ? 'overdue' : ''; ?>" style="padding: 20px;">
                                <div class="equipment-name">⏰ Overdue Equipment</div>
                                <div class="equipment-details">
                                    <div class="equipment-detail">
                                        <label>Overdue Items</label>
                                        <span style="color: <?php echo $reports['overdue']['count'] > 0 ? '#c0392b' : '#27ae60'; ?>;">
                                            <?php echo $reports['overdue']['count']; ?>
                                        </span>
                                    </div>
                                    <div class="equipment-detail">
                                        <label>Status</label>
                                        <span style="color: <?php echo $reports['overdue']['count'] > 0 ? '#c0392b' : '#27ae60'; ?>;">
                                            <?php echo $reports['overdue']['count'] > 0 ? 'Action Required' : 'All Current'; ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="equipment-actions">
                                    <?php if ($reports['overdue']['count'] > 0): ?>
                                        <button class="btn btn-danger" onclick="sendOverdueNotifications()">
                                            Send Reminders
                                        </button>
                                    <?php endif; ?>
                                    <button class="btn btn-secondary" onclick="generateDetailedReport('overdue')">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div style="text-align: center; margin-top: 20px;">
                            <button class="btn btn-primary" onclick="generateFullReport()" style="margin-right: 10px;">
                                📄 Generate Full Report
                            </button>
                            <button class="btn btn-secondary" onclick="exportEquipmentData()" style="margin-right: 10px;">
                                📊 Export Data
                            </button>
                            <button class="btn btn-success" onclick="sendOverdueNotifications()">
                                📧 Send Overdue Notifications
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Overdue Equipment Details Modal -->
                <div id="overdue-details-modal" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Overdue Equipment Details</h3>
                            <button class="close" onclick="closeModal('overdue-details-modal')">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div id="overdue-details-content">
                                <!-- Will be populated by JavaScript -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" onclick="sendOverdueNotifications()">Send Reminders</button>
                            <button type="button" class="btn btn-secondary" onclick="closeModal('overdue-details-modal')">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Check-Out Modal -->
            <div id="checkout-modal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Check Out Equipment</h3>
                        <button class="close" onclick="closeModal('checkout-modal')">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="checkout-form">
                            <input type="hidden" id="checkout-equipment-id" name="equipment_id">
                            <div id="checkout-equipment-name" style="font-weight: bold; margin-bottom: 15px; color: #2c3e50;"></div>
                            
                            <div class="form-group">
                                <label for="checkout-person"><?php echo $mod_strings['LBL_WHO_CHECKING_OUT']; ?> *</label>
                                <input type="text" id="checkout-person" name="checked_out_by" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="checkout-due-date"><?php echo $mod_strings['LBL_DUE_BACK_DATE']; ?> *</label>
                                <input type="date" id="checkout-due-date" name="due_date" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="checkout-program"><?php echo $mod_strings['LBL_PROGRAM']; ?></label>
                                <select id="checkout-program" name="program_association">
                                    <option value="">Select Program</option>
                                    <?php foreach ($dropdown_options['programs'] as $key => $value): ?>
                                        <option value="<?php echo htmlspecialchars($key); ?>"><?php echo htmlspecialchars($value); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="checkout-location"><?php echo $mod_strings['LBL_CURRENT_LOCATION']; ?></label>
                                <input type="text" id="checkout-location" name="current_location" placeholder="Where will this equipment be used?">
                            </div>
                            
                            <div class="form-group">
                                <label for="checkout-notes"><?php echo $mod_strings['LBL_CHECKOUT_PURPOSE']; ?></label>
                                <textarea id="checkout-notes" name="checkout_notes" placeholder="Purpose or additional notes..."></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('checkout-modal')">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="processCheckout()">Check Out</button>
                    </div>
                </div>
            </div>

            <!-- Return Modal -->
            <div id="return-modal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Return Equipment</h3>
                        <button class="close" onclick="closeModal('return-modal')">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="return-form">
                            <input type="hidden" id="return-equipment-id" name="equipment_id">
                            <div id="return-equipment-name" style="font-weight: bold; margin-bottom: 15px; color: #2c3e50;"></div>
                            
                            <div class="form-group">
                                <label for="return-condition"><?php echo $mod_strings['LBL_RETURN_CONDITION']; ?></label>
                                <select id="return-condition" name="condition_status">
                                    <?php foreach ($dropdown_options['equipment_conditions'] as $key => $value): ?>
                                        <option value="<?php echo htmlspecialchars($key); ?>"><?php echo htmlspecialchars($value); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="return-location"><?php echo $mod_strings['LBL_RETURN_LOCATION']; ?></label>
                                <input type="text" id="return-location" name="current_location" value="Equipment Storage">
                            </div>
                            
                            <div class="form-group">
                                <label for="return-notes"><?php echo $mod_strings['LBL_RETURN_NOTES']; ?></label>
                                <textarea id="return-notes" name="return_notes" placeholder="Any issues or notes about the return..."></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('return-modal')">Cancel</button>
                        <button type="button" class="btn btn-success" onclick="processReturn()">Return Equipment</button>
                    </div>
                </div>
            </div>

            <!-- Equipment Details Modal -->
            <div id="details-modal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Equipment Details</h3>
                        <button class="close" onclick="closeModal('details-modal')">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="equipment-details-content">
                            <!-- Details will be populated by JavaScript -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('details-modal')">Close</button>
                    </div>
                </div>
            </div>

            <script>
                console.log('Loading equipment dashboard JavaScript...');
                
                // Initialize dashboard on page load
                document.addEventListener('DOMContentLoaded', function() {
                    console.log('Equipment dashboard initialized');
                    
                    // Set default due date to 7 days from now
                    const defaultDueDate = new Date();
                    defaultDueDate.setDate(defaultDueDate.getDate() + 7);
                    document.getElementById('checkout-due-date').value = defaultDueDate.toISOString().split('T')[0];
                });
                
                /**
                 * Filter equipment based on selected criteria
                 */
                function filterEquipment(event) {
                    if (event) event.preventDefault();
                    
                    console.log('Filtering equipment...');
                    
                    // Get filter values
                    const statusFilter = document.getElementById('status-filter').value;
                    const typeFilter = document.getElementById('type-filter').value;
                    const programFilter = document.getElementById('program-filter').value;
                    
                    console.log('Filter values:', {status: statusFilter, type: typeFilter, program: programFilter});
                    
                    // Get all equipment cards
                    const equipmentCards = document.querySelectorAll('.equipment-card');
                    let visibleCount = 0;
                    
                    equipmentCards.forEach(function(card) {
                        let shouldShow = true;
                        
                        // Get equipment data
                        const equipmentStatus = card.getAttribute('data-status') || '';
                        const equipmentType = card.getAttribute('data-type') || '';
                        const equipmentProgram = card.getAttribute('data-program') || '';
                        
                        // Filter by status
                        if (statusFilter && statusFilter !== '') {
                            if (equipmentStatus !== statusFilter) {
                                shouldShow = false;
                            }
                        }
                        
                        // Filter by type
                        if (typeFilter && typeFilter !== '') {
                            if (equipmentType !== typeFilter) {
                                shouldShow = false;
                            }
                        }
                        
                        // Filter by program
                        if (programFilter && programFilter !== '') {
                            if (equipmentProgram !== programFilter) {
                                shouldShow = false;
                            }
                        }
                        
                        // Show/hide the card
                        if (shouldShow) {
                            card.style.display = 'block';
                            visibleCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });
                    
                    // Update the equipment count
                    const countElement = document.getElementById('equipment-count-title');
                    if (countElement) {
                        const baseTitle = countElement.textContent.split(' (')[0];
                        countElement.textContent = baseTitle + ' (' + visibleCount + ')';
                    }
                    
                    console.log('Filter applied. Visible equipment:', visibleCount);
                    return false;
                }
                
                /**
                 * Clear all filters
                 */
                function clearFilters() {
                    document.getElementById('status-filter').value = '';
                    document.getElementById('type-filter').value = '';
                    document.getElementById('program-filter').value = '';
                    
                    // Show all equipment cards
                    const equipmentCards = document.querySelectorAll('.equipment-card');
                    const totalCount = equipmentCards.length;
                    
                    equipmentCards.forEach(function(card) {
                        card.style.display = 'block';
                    });
                    
                    // Update count
                    const countElement = document.getElementById('equipment-count-title');
                    if (countElement) {
                        const baseTitle = countElement.textContent.split(' (')[0];
                        countElement.textContent = baseTitle + ' (' + totalCount + ')';
                    }
                    
                    console.log('Filters cleared. Showing all equipment:', totalCount);
                }
                
                /**
                 * Show checkout modal
                 */
                function showCheckoutModal(equipmentId, equipmentName) {
                    document.getElementById('checkout-equipment-id').value = equipmentId;
                    document.getElementById('checkout-equipment-name').textContent = 'Checking out: ' + equipmentName;
                    document.getElementById('checkout-modal').style.display = 'block';
                    
                    // Clear previous form data
                    document.getElementById('checkout-form').reset();
                    document.getElementById('checkout-equipment-id').value = equipmentId; // Restore after reset
                    
                    // Set default due date
                    const defaultDueDate = new Date();
                    defaultDueDate.setDate(defaultDueDate.getDate() + 7);
                    document.getElementById('checkout-due-date').value = defaultDueDate.toISOString().split('T')[0];
                }
                
                /**
                 * Show return modal
                 */
                function showReturnModal(equipmentId, equipmentName) {
                    document.getElementById('return-equipment-id').value = equipmentId;
                    document.getElementById('return-equipment-name').textContent = 'Returning: ' + equipmentName;
                    document.getElementById('return-modal').style.display = 'block';
                    
                    // Clear previous form data
                    document.getElementById('return-form').reset();
                    document.getElementById('return-equipment-id').value = equipmentId; // Restore after reset
                    document.getElementById('return-location').value = 'Equipment Storage'; // Set default
                }
                
                /**
                 * Show equipment details modal
                 */
                function showEquipmentDetails(equipmentId) {
                    // Find the equipment card
                    const card = document.querySelector('[data-equipment-id="' + equipmentId + '"]');
                    if (!card) return;
                    
                    // Extract equipment details from the card
                    const name = card.querySelector('.equipment-name').textContent;
                    const details = card.querySelectorAll('.equipment-detail');
                    
                    let detailsHtml = '<h4>' + name + '</h4><div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px;">';
                    
                    details.forEach(function(detail) {
                        const label = detail.querySelector('label').textContent;
                        const value = detail.querySelector('span').textContent;
                        detailsHtml += '<div><strong>' + label + ':</strong><br>' + value + '</div>';
                    });
                    
                    detailsHtml += '</div>';
                    
                    document.getElementById('equipment-details-content').innerHTML = detailsHtml;
                    document.getElementById('details-modal').style.display = 'block';
                }
                
                /**
                 * Close modal
                 */
                function closeModal(modalId) {
                    document.getElementById(modalId).style.display = 'none';
                }
                
                /**
                 * Process equipment checkout
                 */
                function processCheckout() {
                    const form = document.getElementById('checkout-form');
                    const formData = new FormData(form);
                    
                    // Validate required fields
                    if (!formData.get('checked_out_by') || !formData.get('due_date')) {
                        alert('Please fill in all required fields.');
                        return;
                    }
                    
                    // Show loading state
                    const button = event.target;
                    const originalText = button.textContent;
                    button.textContent = 'Processing...';
                    button.disabled = true;
                    
                    // Make AJAX request to checkout entry point
                    fetch('index.php?entryPoint=equipment_checkout', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message || 'Equipment checked out successfully!');
                            closeModal('checkout-modal');
                            location.reload(); // Refresh to show updated status
                        } else {
                            alert('Error: ' + (data.message || 'Failed to check out equipment'));
                            button.textContent = originalText;
                            button.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Checkout error:', error);
                        alert('Error: Failed to check out equipment');
                        button.textContent = originalText;
                        button.disabled = false;
                    });
                }
                
                /**
                 * Process equipment return
                 */
                function processReturn() {
                    const form = document.getElementById('return-form');
                    const formData = new FormData(form);
                    
                    // Show loading state
                    const button = event.target;
                    const originalText = button.textContent;
                    button.textContent = 'Processing...';
                    button.disabled = true;
                    
                    // Make AJAX request to return entry point
                    fetch('index.php?entryPoint=equipment_return', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message || 'Equipment returned successfully!');
                            closeModal('return-modal');
                            location.reload(); // Refresh to show updated status
                        } else {
                            alert('Error: ' + (data.message || 'Failed to return equipment'));
                            button.textContent = originalText;
                            button.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Return error:', error);
                        alert('Error: Failed to return equipment');
                        button.textContent = originalText;
                        button.disabled = false;
                    });
                }
                
                /**
                 * Send overdue notifications
                 */
                function sendOverdueNotifications() {
                    if (!confirm('Send overdue notifications to all people with overdue equipment?')) {
                        return;
                    }
                    
                    // Show loading state
                    const button = event.target;
                    const originalText = button.textContent;
                    button.textContent = 'Sending...';
                    button.disabled = true;
                    
                    fetch('index.php?entryPoint=equipment_notifications', {
                        method: 'GET'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Notifications sent successfully!\n\n' + data.message);
                        } else {
                            alert('Error sending notifications: ' + data.message);
                        }
                        
                        // Reset button
                        button.textContent = originalText;
                        button.disabled = false;
                    })
                    .catch(error => {
                        console.error('Notification error:', error);
                        alert('Error sending notifications');
                        button.textContent = originalText;
                        button.disabled = false;
                    });
                }
                
                /**
                 * Show overdue equipment details
                 */
                function showOverdueDetails() {
                    fetch('index.php?entryPoint=equipment_reports&type=overdue')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.data) {
                            let content = '<h4>Overdue Equipment Details</h4>';
                            
                            if (data.data.length === 0) {
                                content += '<p>No overdue equipment found.</p>';
                            } else {
                                content += '<div style="margin-top: 15px;">';
                                
                                data.data.forEach(function(item) {
                                    const daysOverdue = Math.floor((new Date() - new Date(item.due_date)) / (1000 * 60 * 60 * 24));
                                    content += '<div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 4px;">';
                                    content += '<strong>' + item.name + '</strong> (' + item.equipment_type + ')<br>';
                                    content += 'Checked out by: <strong>' + item.checked_out_by + '</strong><br>';
                                    content += 'Due date: ' + item.due_date + ' (<span style="color: #c0392b; font-weight: bold;">' + daysOverdue + ' days overdue</span>)<br>';
                                    if (item.program_association) {
                                        content += 'Program: ' + item.program_association + '<br>';
                                    }
                                    content += '</div>';
                                });
                                
                                content += '</div>';
                            }
                            
                            document.getElementById('overdue-details-content').innerHTML = content;
                            document.getElementById('overdue-details-modal').style.display = 'block';
                        } else {
                            alert('Error loading overdue equipment details');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading overdue details:', error);
                        alert('Error loading overdue equipment details');
                    });
                }
                
                /**
                 * Generate detailed report
                 */
                function generateDetailedReport(reportType) {
                    const button = event.target;
                    const originalText = button.textContent;
                    button.textContent = 'Generating...';
                    button.disabled = true;
                    
                    fetch('index.php?entryPoint=equipment_reports&type=' + reportType)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // For now, show alert with basic data
                            // In production, this would generate a PDF or open a detailed view
                            let message = 'Report Generated Successfully!\n\n';
                            
                            switch (reportType) {
                                case 'usage':
                                    message += 'Usage Statistics:\n';
                                    message += '- Total Checkouts: ' + data.data.total_checkouts + '\n';
                                    message += '- Total Returns: ' + data.data.total_returns + '\n';
                                    break;
                                case 'condition':
                                    message += 'Condition Report generated\n';
                                    break;
                                case 'overdue':
                                    message += 'Found ' + data.data.length + ' overdue items\n';
                                    break;
                            }
                            
                            message += '\nReport data logged to system logs.';
                            alert(message);
                        } else {
                            alert('Error generating report: ' + data.message);
                        }
                        
                        button.textContent = originalText;
                        button.disabled = false;
                    })
                    .catch(error => {
                        console.error('Report error:', error);
                        alert('Error generating report');
                        button.textContent = originalText;
                        button.disabled = false;
                    });
                }
                
                /**
                 * Generate full report
                 */
                function generateFullReport() {
                    const button = event.target;
                    const originalText = button.textContent;
                    button.textContent = 'Generating...';
                    button.disabled = true;
                    
                    fetch('index.php?entryPoint=equipment_reports&type=all')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Full Equipment Report Generated!\n\nReport includes:\n- Equipment Summary\n- Usage Statistics\n- Condition Reports\n- Overdue Items\n\nDetailed data has been logged to system logs.');
                        } else {
                            alert('Error generating full report: ' + data.message);
                        }
                        
                        button.textContent = originalText;
                        button.disabled = false;
                    })
                    .catch(error => {
                        console.error('Full report error:', error);
                        alert('Error generating full report');
                        button.textContent = originalText;
                        button.disabled = false;
                    });
                }
                
                /**
                 * Export equipment data (placeholder)
                 */
                function exportEquipmentData() {
                    // For now, show a message
                    // In production, this would generate CSV/Excel export
                    alert('Export functionality coming soon!\n\nThis feature will export equipment data to CSV/Excel format.');
                }
                
                /**
                 * Add sample equipment for testing
                 */
                function addSampleEquipment() {
                    if (!confirm('Add sample equipment items for testing?\n\nThis will create 8 sample equipment items including:\n- Soccer Goals\n- Football Cones\n- Basketball\n- Tennis Rackets\n- Baseball Helmets\n- Volleyball Net\n- First Aid Kit\n- Equipment Cart\n\nSome items will be checked out and overdue for testing purposes.')) {
                        return;
                    }
                    
                    // Show loading state
                    const button = event.target;
                    const originalText = button.textContent;
                    button.textContent = '⏳ Creating...';
                    button.disabled = true;
                    
                    fetch('index.php?entryPoint=add_sample_equipment', {
                        method: 'GET'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Sample Equipment Created Successfully!\n\n' + 
                                  'Created: ' + data.created_count + ' items\n' +
                                  'Total attempted: ' + data.total_attempted + ' items\n\n' +
                                  'The page will now refresh to show your equipment inventory.');
                            
                            // Refresh the page to show new equipment
                            location.reload();
                        } else {
                            alert('Error creating sample equipment:\n' + data.message);
                            button.textContent = originalText;
                            button.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Sample equipment error:', error);
                        alert('Error creating sample equipment. Please check the browser console for details.');
                        button.textContent = originalText;
                        button.disabled = false;
                    });
                }
                
                /**
                 * Add simple sample equipment for testing
                 */
                function addSampleEquipmentSimple() {
                    if (!confirm('Add simple sample equipment for testing?\n\nThis will create 5 basic equipment items:\n- Soccer Goals\n- Football Cones\n- Basketball (checked out)\n- Tennis Rackets\n- Baseball Helmets (checked out)')) {
                        return;
                    }
                    
                    // Show loading state
                    const button = event.target;
                    const originalText = button.textContent;
                    button.textContent = '⏳ Creating...';
                    button.disabled = true;
                    
                    fetch('index.php?entryPoint=simple_add_equipment', {
                        method: 'GET'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Simple Sample Equipment Created Successfully!\n\n' + 
                                  'Created: ' + data.created_count + ' items\n' +
                                  'Total attempted: ' + data.total_attempted + ' items\n\n' +
                                  'The page will now refresh to show your equipment inventory.');
                            
                            // Refresh the page to show new equipment
                            location.reload();
                        } else {
                            alert('Error creating sample equipment:\n' + data.message);
                            button.textContent = originalText;
                            button.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Simple sample equipment error:', error);
                        alert('Error creating sample equipment. Please check the browser console for details.');
                        button.textContent = originalText;
                        button.disabled = false;
                    });
                }
                
                /**
                 * Add ultra simple sample equipment (minimal fields)
                 */
                function addSampleEquipmentUltra() {
                    if (!confirm('Add ultra simple equipment for testing?\n\nThis will create 3 basic items with only essential fields:\n- Soccer Goals\n- Football Cones\n- Basketball')) {
                        return;
                    }
                    
                    const button = event.target;
                    const originalText = button.textContent;
                    button.textContent = '⏳ Creating...';
                    button.disabled = true;
                    
                    fetch('index.php?entryPoint=ultra_simple_equipment', {
                        method: 'GET'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Ultra Simple Equipment Created!\n\n' + 
                                  'Created: ' + data.created_count + ' items\n' +
                                  'Total attempted: ' + data.total_attempted + ' items\n' +
                                  'Database count: ' + data.verify_count + ' items\n\n' +
                                  'Refreshing page...');
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                            button.textContent = originalText;
                            button.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Ultra simple equipment error:', error);
                        alert('Error: ' + error.message);
                        button.textContent = originalText;
                        button.disabled = false;
                    });
                }
                
                /**
                 * Test minimal equipment insert
                 */
                function testMinimalInsert() {
                    const button = event.target;
                    const originalText = button.textContent;
                    button.textContent = '✅ Testing...';
                    button.disabled = true;
                    
                    fetch('index.php?entryPoint=minimal_equipment', {
                        method: 'GET'
                    })
                    .then(response => response.json())
                    .then(data => {
                        let message = 'MINIMAL INSERT TEST:\n\n';
                        message += 'Success: ' + data.success + '\n';
                        message += 'Start count: ' + data.start_count + '\n';
                        message += 'Final count: ' + data.final_count + '\n';
                        message += 'SQL: ' + data.sql + '\n';
                        if (data.error) message += 'Error: ' + data.error + '\n';
                        if (data.db_error) message += 'DB Error: ' + data.db_error + '\n';
                        message += '\nMessage: ' + data.message;
                        
                        alert(message);
                        
                        if (data.success && data.final_count > data.start_count) {
                            location.reload();
                        } else {
                            button.textContent = originalText;
                            button.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Test error:', error);
                        alert('Test failed: ' + error.message);
                        button.textContent = originalText;
                        button.disabled = false;
                    });
                }
                
                /**
                 * Check database directly to see equipment count
                 */
                function checkDatabase() {
                    fetch('index.php?entryPoint=debug_equipment', {
                        method: 'GET'
                    })
                    .then(response => response.text())
                    .then(html => {
                        // Open debug results in new window
                        const newWindow = window.open('', '_blank');
                        newWindow.document.write(html);
                        newWindow.document.close();
                    })
                    .catch(error => {
                        console.error('Database check error:', error);
                        alert('Error checking database: ' + error.message);
                    });
                }
                
                // Close modal when clicking outside
                window.addEventListener('click', function(event) {
                    const modals = document.querySelectorAll('.modal');
                    modals.forEach(function(modal) {
                        if (event.target === modal) {
                            modal.style.display = 'none';
                        }
                    });
                });
            </script>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
} 