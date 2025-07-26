<?php

/**
 * Equipment Full HTML Report Generator
 * 
 * Generates a comprehensive, print-friendly HTML report that opens in a new tab.
 * Combines usage statistics, condition reports, and detailed equipment data.
 * 
 * @author SuiteCRM Development Team
 * @package Equipment
 */

// Suppress PHP warnings for clean report display
error_reporting(E_ERROR);
ini_set('display_errors', 0);

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

require_once('include/entryPoint.php');
require_once('modules/Equipment/EquipmentHelper.php');

// Get report data
$summary = EquipmentHelper::getEquipmentSummary();
$equipment = EquipmentHelper::getEquipment();
$dropdown_options = EquipmentHelper::getDropdownOptions();
$reports = EquipmentHelper::generateReports();
$usage_stats = EquipmentHelper::getUsageStatistics(30);
$overdue_equipment = EquipmentHelper::getOverdueEquipment();

// Set proper HTML content type
header('Content-Type: text/html; charset=UTF-8');

?>
<!DOCTYPE html>
<html>
<head>
    <title>Equipment Management - Full Report</title>
    <meta charset="UTF-8">
    <style>
        /* Print-friendly and screen-friendly styles */
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f8f9fa;
            color: #2c3e50;
            line-height: 1.6;
        }
        
        .report-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .report-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid #3498db;
        }
        
        .report-title {
            font-size: 2.5em;
            color: #2c3e50;
            margin: 0;
            font-weight: bold;
        }
        
        .report-subtitle {
            font-size: 1.2em;
            color: #7f8c8d;
            margin: 10px 0 0 0;
        }
        
        .report-date {
            font-size: 1em;
            color: #95a5a6;
            margin-top: 10px;
        }
        
        .section {
            margin-bottom: 40px;
            page-break-inside: avoid;
        }
        
        .section-title {
            font-size: 1.8em;
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ecf0f1;
            display: flex;
            align-items: center;
        }
        
        .section-icon {
            margin-right: 10px;
            font-size: 1.2em;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #dee2e6;
        }
        
        .stat-number {
            font-size: 2.5em;
            font-weight: bold;
            color: #3498db;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 1em;
            color: #7f8c8d;
            text-transform: uppercase;
            font-weight: 500;
        }
        
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background: white;
        }
        
        .report-table th {
            background: #3498db;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        
        .report-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .report-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85em;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-available { background: #d4edda; color: #155724; }
        .status-checked-out { background: #cce5ff; color: #004085; }
        .status-maintenance { background: #fff3cd; color: #856404; }
        .status-damaged { background: #f8d7da; color: #721c24; }
        .status-retired { background: #e2e3e5; color: #383d41; }
        
        .condition-excellent { background: #d4edda; color: #155724; }
        .condition-good { background: #d1ecf1; color: #0c5460; }
        .condition-fair { background: #fff3cd; color: #856404; }
        .condition-poor { background: #f8d7da; color: #721c24; }
        .condition-damaged { background: #f5c6cb; color: #721c24; }
        
        .overdue { color: #dc3545; font-weight: bold; }
        
        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        .chart-placeholder {
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            border-radius: 8px;
        }
        
        /* Print styles */
        @media print {
            body {
                background: white;
                font-size: 12pt;
            }
            
            .report-container {
                box-shadow: none;
                border: none;
                padding: 0;
            }
            
            .section {
                page-break-inside: avoid;
            }
            
            .report-table {
                font-size: 10pt;
            }
            
            .stats-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #3498db;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .print-button:hover {
            background: #2980b9;
        }
        
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">🖨️ Print Report</button>
    
    <div class="report-container">
        <!-- Report Header -->
        <div class="report-header">
            <h1 class="report-title">Equipment Management Report</h1>
            <p class="report-subtitle">Comprehensive Equipment Inventory & Usage Analysis</p>
            <p class="report-date">Generated on <?php echo date('F j, Y \a\t g:i A'); ?></p>
        </div>

        <!-- Executive Summary -->
        <div class="section">
            <h2 class="section-title">
                <span class="section-icon">📊</span>
                Executive Summary
            </h2>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $summary['total_equipment']; ?></div>
                    <div class="stat-label">Total Equipment</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $summary['available']; ?></div>
                    <div class="stat-label">Available</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $summary['checked_out']; ?></div>
                    <div class="stat-label">Checked Out</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $summary['maintenance']; ?></div>
                    <div class="stat-label">In Maintenance</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $summary['overdue']; ?></div>
                    <div class="stat-label">Overdue</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo number_format($reports['utilization']['utilization_rate'] ?? 0, 1); ?>%</div>
                    <div class="stat-label">Utilization Rate</div>
                </div>
            </div>
        </div>

        <!-- Equipment Inventory Details -->
        <div class="section">
            <h2 class="section-title">
                <span class="section-icon">📋</span>
                Complete Equipment Inventory
            </h2>
            
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Equipment Name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Condition</th>
                        <th>Location</th>
                        <th>Checked Out By</th>
                        <th>Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($equipment as $item): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($item['name']); ?></strong></td>
                        <td><?php echo htmlspecialchars($dropdown_options['equipment_types'][$item['equipment_type']] ?? $item['equipment_type']); ?></td>
                        <td>
                            <span class="status-badge status-<?php echo str_replace(' ', '-', strtolower($item['checkout_status'])); ?>">
                                <?php echo htmlspecialchars($dropdown_options['equipment_statuses'][$item['checkout_status']] ?? $item['checkout_status']); ?>
                            </span>
                        </td>
                        <td>
                            <span class="status-badge condition-<?php echo strtolower($item['condition_status']); ?>">
                                <?php echo htmlspecialchars($dropdown_options['equipment_conditions'][$item['condition_status']] ?? $item['condition_status']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($item['current_location'] ?: 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($item['checked_out_by'] ?: 'N/A'); ?></td>
                        <td class="<?php echo $item['is_overdue'] ? 'overdue' : ''; ?>">
                            <?php echo htmlspecialchars($item['due_date'] ?: 'N/A'); ?>
                            <?php if ($item['is_overdue']): ?>
                                <strong>(OVERDUE)</strong>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Usage Statistics -->
        <div class="section">
            <h2 class="section-title">
                <span class="section-icon">📈</span>
                Usage Statistics (Last 30 Days)
            </h2>
            
            <div class="two-column">
                <div>
                    <h3>Equipment Utilization</h3>
                    <table class="report-table">
                        <tr>
                            <td><strong>Total Checkouts</strong></td>
                            <td><?php echo $usage_stats['total_checkouts']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Total Returns</strong></td>
                            <td><?php echo $usage_stats['total_returns']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Average Checkout Duration</strong></td>
                            <td><?php echo number_format($usage_stats['average_checkout_duration'] ?? 0, 1); ?> days</td>
                        </tr>
                        <tr>
                            <td><strong>Most Popular Type</strong></td>
                            <td><?php 
                                if (!empty($usage_stats['most_popular_equipment']) && is_array($usage_stats['most_popular_equipment'])) {
                                    echo htmlspecialchars($usage_stats['most_popular_equipment'][0]['type'] ?? 'N/A');
                                } else {
                                    echo 'N/A';
                                }
                            ?></td>
                        </tr>
                    </table>
                </div>
                
                <div>
                    <h3>Equipment by Type</h3>
                    <table class="report-table">
                        <?php 
                        $type_counts = array();
                        foreach ($equipment as $item) {
                            $type = $dropdown_options['equipment_types'][$item['equipment_type']] ?? $item['equipment_type'];
                            $type_counts[$type] = ($type_counts[$type] ?? 0) + 1;
                        }
                        arsort($type_counts);
                        ?>
                        <?php foreach ($type_counts as $type => $count): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($type); ?></strong></td>
                            <td><?php echo $count; ?> items</td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>

        <!-- Condition Reports -->
        <div class="section">
            <h2 class="section-title">
                <span class="section-icon">🔧</span>
                Equipment Condition Analysis
            </h2>
            
            <div class="two-column">
                <div>
                    <h3>Condition Summary</h3>
                    <table class="report-table">
                        <?php 
                        $condition_counts = array();
                        foreach ($equipment as $item) {
                            $condition = $dropdown_options['equipment_conditions'][$item['condition_status']] ?? $item['condition_status'];
                            $condition_counts[$condition] = ($condition_counts[$condition] ?? 0) + 1;
                        }
                        ?>
                        <?php foreach ($condition_counts as $condition => $count): ?>
                        <tr>
                            <td>
                                <span class="status-badge condition-<?php echo strtolower($condition); ?>">
                                    <?php echo htmlspecialchars($condition); ?>
                                </span>
                            </td>
                            <td><strong><?php echo $count; ?> items (<?php echo number_format(($count / count($equipment)) * 100, 1); ?>%)</strong></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                
                <div>
                    <h3>Maintenance Actions Needed</h3>
                    <?php 
                    $maintenance_needed = array_filter($equipment, function($item) {
                        return in_array($item['condition_status'], ['poor', 'damaged', 'needs_repair']) || $item['checkout_status'] === 'maintenance';
                    });
                    ?>
                    <?php if (count($maintenance_needed) > 0): ?>
                        <table class="report-table">
                            <?php foreach ($maintenance_needed as $item): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($item['name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($dropdown_options['equipment_conditions'][$item['condition_status']] ?? $item['condition_status']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php else: ?>
                        <p style="color: #27ae60; font-weight: bold;">✅ All equipment is in good condition!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Overdue Equipment -->
        <?php if (count($overdue_equipment) > 0): ?>
        <div class="section">
            <h2 class="section-title">
                <span class="section-icon">⚠️</span>
                Overdue Equipment (Action Required)
            </h2>
            
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Equipment</th>
                        <th>Checked Out By</th>
                        <th>Due Date</th>
                        <th>Days Overdue</th>
                        <th>Program</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($overdue_equipment as $item): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($item['name']); ?></strong></td>
                        <td><?php echo htmlspecialchars($item['checked_out_by']); ?></td>
                        <td class="overdue"><?php echo htmlspecialchars($item['due_date']); ?></td>
                        <td class="overdue">
                            <strong>
                                <?php 
                                $due_date = new DateTime($item['due_date']);
                                $today = new DateTime();
                                $days_overdue = $today->diff($due_date)->days;
                                echo $days_overdue;
                                ?> days
                            </strong>
                        </td>
                        <td><?php echo htmlspecialchars($item['program_association'] ?: 'N/A'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <!-- Report Footer -->
        <div class="section" style="border-top: 2px solid #ecf0f1; padding-top: 20px; margin-top: 40px;">
            <p style="text-align: center; color: #7f8c8d; font-size: 0.9em;">
                This report was automatically generated on <?php echo date('F j, Y \a\t g:i A'); ?> by the SuiteCRM Equipment Management System.<br>
                For questions or support, please contact your system administrator.
            </p>
        </div>
    </div>
</body>
</html> 