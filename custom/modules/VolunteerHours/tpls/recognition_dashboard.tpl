{*
/**
 * VolunteerHours Module - Recognition Dashboard Template
 * 
 * This template displays volunteer hours statistics, top volunteers,
 * and recognition reports for the Youth Sports League.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */
*}

<link rel="stylesheet" type="text/css" href="themes/default/css/style.css"/>
<style>
.volunteer-dashboard {
    padding: 20px;
    font-family: Arial, sans-serif;
}

.stats-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    min-width: 200px;
    flex: 1;
}

.stat-number {
    font-size: 2.5em;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 1.1em;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.dashboard-section {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-bottom: 25px;
    overflow: hidden;
}

.section-header {
    background: #007bff;
    color: white;
    padding: 15px 20px;
    font-size: 1.2em;
    font-weight: bold;
}

.section-content {
    padding: 20px;
}

.volunteer-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.volunteer-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #eee;
}

.volunteer-item:last-child {
    border-bottom: none;
}

.volunteer-name {
    font-weight: bold;
    color: #333;
}

.volunteer-hours {
    background: #28a745;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.9em;
}

.recent-entry {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.recent-entry:last-child {
    border-bottom: none;
}

.entry-header {
    font-weight: bold;
    margin-bottom: 5px;
}

.entry-details {
    color: #666;
    font-size: 0.9em;
}

.status-pending {
    color: #ffc107;
    font-weight: bold;
}

.status-approved {
    color: #28a745;
    font-weight: bold;
}

.actions {
    margin-top: 20px;
    text-align: center;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    margin: 5px;
    background: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    border: none;
    cursor: pointer;
}

.btn:hover {
    background: #0056b3;
    color: white;
    text-decoration: none;
}

.btn-success {
    background: #28a745;
}

.btn-success:hover {
    background: #218838;
}

.activity-breakdown {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.activity-item {
    text-align: center;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 5px;
}

.activity-hours {
    font-size: 1.5em;
    font-weight: bold;
    color: #007bff;
}

.activity-type {
    margin-top: 5px;
    font-size: 0.9em;
    text-transform: capitalize;
}
</style>

<div class="volunteer-dashboard">
    <h1>{$MODULE_TITLE}</h1>
    
    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-number">{$TOTAL_HOURS}</div>
            <div class="stat-label">Total Hours</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{$MONTH_HOURS}</div>
            <div class="stat-label">{$CURRENT_MONTH}</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{$YEAR_HOURS}</div>
            <div class="stat-label">{$CURRENT_YEAR}</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{$PENDING_COUNT}</div>
            <div class="stat-label">Pending Approval</div>
        </div>
    </div>

    <!-- Top Volunteers All Time -->
    {if $TOP_VOLUNTEERS_ALL}
    <div class="dashboard-section">
        <div class="section-header">🏆 Top Volunteers - All Time</div>
        <div class="section-content">
            <ul class="volunteer-list">
                {foreach from=$TOP_VOLUNTEERS_ALL item=volunteer}
                <li class="volunteer-item">
                    <span class="volunteer-name">{$volunteer.volunteer_name_c}</span>
                    <span class="volunteer-hours">{$volunteer.total_hours} hours</span>
                </li>
                {/foreach}
            </ul>
        </div>
    </div>
    {/if}

    <!-- Split layout for This Year and This Month -->
    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        <!-- Top Volunteers This Year -->
        {if $TOP_VOLUNTEERS_YEAR}
        <div class="dashboard-section" style="flex: 1; min-width: 300px;">
            <div class="section-header">📅 Top Volunteers - {$CURRENT_YEAR}</div>
            <div class="section-content">
                <ul class="volunteer-list">
                    {foreach from=$TOP_VOLUNTEERS_YEAR item=volunteer}
                    <li class="volunteer-item">
                        <span class="volunteer-name">{$volunteer.volunteer_name_c}</span>
                        <span class="volunteer-hours">{$volunteer.total_hours} hours</span>
                    </li>
                    {/foreach}
                </ul>
            </div>
        </div>
        {/if}

        <!-- Top Volunteers This Month -->
        {if $TOP_VOLUNTEERS_MONTH}
        <div class="dashboard-section" style="flex: 1; min-width: 300px;">
            <div class="section-header">🌟 Top Volunteers - {$CURRENT_MONTH}</div>
            <div class="section-content">
                <ul class="volunteer-list">
                    {foreach from=$TOP_VOLUNTEERS_MONTH item=volunteer}
                    <li class="volunteer-item">
                        <span class="volunteer-name">{$volunteer.volunteer_name_c}</span>
                        <span class="volunteer-hours">{$volunteer.total_hours} hours</span>
                    </li>
                    {/foreach}
                </ul>
            </div>
        </div>
        {/if}
    </div>

    <!-- Recent Entries -->
    {if $RECENT_ENTRIES}
    <div class="dashboard-section">
        <div class="section-header">⏰ Recent Hour Entries</div>
        <div class="section-content">
            {foreach from=$RECENT_ENTRIES item=entry}
            <div class="recent-entry">
                <div class="entry-header">
                    {$entry.first_name} {$entry.last_name} - {$entry.hours_logged_c} hours
                    <span class="status-{$entry.approval_status_c}">[{$entry.approval_status_c|upper}]</span>
                </div>
                <div class="entry-details">
                    {$entry.activity_date_c} | {$entry.activity_type_c|replace:"_":" "|capitalize}
                    {if $entry.program_name} | {$entry.program_name}{/if}
                </div>
                {if $entry.activity_description_c}
                <div class="entry-details" style="font-style: italic; margin-top: 5px;">
                    "{$entry.activity_description_c}"
                </div>
                {/if}
            </div>
            {/foreach}
        </div>
    </div>
    {/if}

    <!-- Activity Breakdown -->
    {if $ACTIVITY_BREAKDOWN}
    <div class="dashboard-section">
        <div class="section-header">📊 Hours by Activity Type</div>
        <div class="section-content">
            <div class="activity-breakdown">
                {foreach from=$ACTIVITY_BREAKDOWN item=activity}
                {if $activity.activity_type_c}
                <div class="activity-item">
                    <div class="activity-hours">{$activity.total_hours}</div>
                    <div class="activity-type">{$activity.activity_type_c|replace:"_":" "}</div>
                    <div style="font-size: 0.8em; color: #666;">{$activity.entry_count} entries</div>
                </div>
                {/if}
                {/foreach}
            </div>
        </div>
    </div>
    {/if}

    <!-- Action Buttons -->
    <div class="actions">
        <a href="index.php?module=VolunteerHours&action=EditView" class="btn">➕ Log New Hours</a>
        <a href="index.php?module=VolunteerHours&action=index" class="btn">📋 View All Entries</a>
        {if $PENDING_COUNT > 0}
        <a href="index.php?module=VolunteerHours&action=index&approval_status_c=pending" class="btn btn-success">✅ Review Pending ({$PENDING_COUNT})</a>
        {/if}
        <a href="#" onclick="window.print();" class="btn">🖨️ Print Report</a>
    </div>

    <div style="margin-top: 30px; text-align: center; color: #666; font-size: 0.9em;">
        <p>Dashboard last updated: {$smarty.now|date_format:"%B %d, %Y at %I:%M %p"}</p>
        <p>Showing approved volunteer hours only. Pending entries require approval to be included in totals.</p>
    </div>
</div> 