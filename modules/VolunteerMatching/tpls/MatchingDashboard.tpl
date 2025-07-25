{*
/**
 * Feature 2: Simple Volunteer-Program Matching
 * Smarty template for the volunteer matching dashboard
 * 
 * Integrates with SuiteCRM's theme system
 */
*}

<div class="moduleTitle">
    <h2>{$mod_strings.LBL_DASHBOARD_TITLE}</h2>
    <div class="clear"></div>
</div>

<div class="dashboardContainer">
    <div class="pod">
        <div class="hd">
            <h3>{$mod_strings.LBL_DASHBOARD_SUBTITLE}</h3>
        </div>
        <div class="bd">
            <!-- Program Selection Section -->
            <div class="program-selection-section">
                <h4>{$mod_strings.LBL_PROGRAMS_TITLE}</h4>
                <p>{$mod_strings.LBL_SELECT_PROGRAM}</p>
                
                <div class="program-grid">
                    {foreach from=$programs key=program_name item=requirements}
                    <div class="program-card" data-program="{$program_name}">
                        <div class="program-header">
                            <h5>{$program_name}</h5>
                        </div>
                        <div class="program-details">
                            <p><strong>{$mod_strings.LBL_REQUIRED_SKILLS}:</strong> 
                               {$requirements.required_skills|@implode:', '}</p>
                            <p><strong>{$mod_strings.LBL_MIN_EXPERIENCE}:</strong> 
                               {$requirements.min_experience}</p>
                            <p><strong>{$mod_strings.LBL_BACKGROUND_CHECK}:</strong> 
                               {if $requirements.background_check}{$mod_strings.LBL_YES}{else}{$mod_strings.LBL_NO}{/if}</p>
                            <p><strong>{$mod_strings.LBL_TIME_COMMITMENT}:</strong> 
                               {$requirements.time_commitment}</p>
                        </div>
                        <div class="program-actions">
                            <button type="button" class="button primary find-matches-btn" 
                                    data-program="{$program_name}">
                                {$mod_strings.LBL_BEST_MATCHES}
                            </button>
                        </div>
                    </div>
                    {/foreach}
                </div>
            </div>

            <!-- Volunteer Search Section -->
            <div class="volunteer-search-section">
                <h4>{$mod_strings.LBL_VOLUNTEER_SEARCH}</h4>
                <div class="search-filters">
                    <table class="tabForm">
                        <tr>
                            <td>
                                <label>{$mod_strings.LBL_FILTER_BY_SKILLS}</label>
                                <input type="text" id="filter-skills" placeholder="e.g., First Aid, Coaching">
                            </td>
                            <td>
                                <label>{$mod_strings.LBL_FILTER_BY_AVAILABILITY}</label>
                                <select id="filter-availability">
                                    <option value="">All</option>
                                    <option value="Weekends">Weekends</option>
                                    <option value="Weekday Evenings">Weekday Evenings</option>
                                    <option value="Flexible">Flexible</option>
                                </select>
                            </td>
                            <td>
                                <label>{$mod_strings.LBL_FILTER_BY_PROGRAM}</label>
                                <select id="filter-program">
                                    <option value="">All Programs</option>
                                    {foreach from=$programs key=program_name item=requirements}
                                    <option value="{$program_name}">{$program_name}</option>
                                    {/foreach}
                                </select>
                            </td>
                            <td style="vertical-align: bottom;">
                                <button type="button" class="button" id="search-volunteers-btn">
                                    {$mod_strings.LBL_SEARCH_BUTTON}
                                </button>
                                <button type="button" class="button" id="clear-filters-btn">
                                    {$mod_strings.LBL_CLEAR_FILTERS}
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Results Section -->
            <div class="results-section">
                <div id="matching-results" style="display: none;">
                    <h4 id="results-title">{$mod_strings.LBL_MATCHING_TITLE}</h4>
                    <div id="results-content"></div>
                </div>

                <!-- All Volunteers List -->
                <div class="volunteers-list-section">
                    <h4>{$mod_strings.LBL_VOLUNTEERS_TITLE}</h4>
                    <div class="volunteer-actions">
                        <button type="button" class="button" id="export-volunteers-btn">
                            {$mod_strings.LBL_EXPORT_LIST}
                        </button>
                        <button type="button" class="button" id="select-all-btn">
                            {$mod_strings.LBL_SELECT_ALL}
                        </button>
                        <button type="button" class="button" id="select-none-btn">
                            {$mod_strings.LBL_SELECT_NONE}
                        </button>
                    </div>
                    
                    <div id="volunteers-container">
                        {if $volunteers|@count > 0}
                        <div class="volunteers-grid">
                            {foreach from=$volunteers item=volunteer}
                            <div class="volunteer-card" data-volunteer-id="{$volunteer.id}">
                                <div class="volunteer-header">
                                    <input type="checkbox" class="volunteer-checkbox" value="{$volunteer.id}">
                                    <h5>{$volunteer.first_name} {$volunteer.last_name}</h5>
                                    <span class="volunteer-type">{$volunteer.contact_type_c}</span>
                                </div>
                                <div class="volunteer-details">
                                    <p><strong>{$mod_strings.LBL_VOLUNTEER_SKILLS}:</strong> 
                                       {if $volunteer.special_skills_c}{$volunteer.special_skills_c}{else}Not specified{/if}</p>
                                    <p><strong>{$mod_strings.LBL_VOLUNTEER_AVAILABILITY}:</strong> 
                                       {if $volunteer.availability_c}{$volunteer.availability_c}{else}Not specified{/if}</p>
                                    <p><strong>{$mod_strings.LBL_VOLUNTEER_EXPERIENCE}:</strong> 
                                       {if $volunteer.experience_level_c}{$volunteer.experience_level_c}{else}Not specified{/if}</p>
                                    <p><strong>{$mod_strings.LBL_VOLUNTEER_PROGRAMS}:</strong> 
                                       {if $volunteer.program_interest_c}{$volunteer.program_interest_c}{else}Not specified{/if}</p>
                                </div>
                                <div class="volunteer-actions">
                                    <button type="button" class="button view-profile-btn" 
                                            data-volunteer-id="{$volunteer.id}">
                                        {$mod_strings.LBL_VIEW_PROFILE}
                                    </button>
                                    <a href="index.php?module=Contacts&action=DetailView&record={$volunteer.id}" 
                                       class="button secondary" target="_blank">
                                        {$mod_strings.LBL_CONTACT_VOLUNTEER}
                                    </a>
                                </div>
                            </div>
                            {/foreach}
                        </div>
                        {else}
                        <div class="no-volunteers-message">
                            <p>{$mod_strings.LBL_NO_VOLUNTEERS_FOUND}</p>
                        </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading overlay -->
<div id="loading-overlay" style="display: none;">
    <div class="loading-content">
        <img src="themes/default/images/loading.gif" alt="{$mod_strings.LBL_LOADING}">
        <p>{$mod_strings.LBL_LOADING}</p>
    </div>
</div>

<!-- Volunteer Details Modal -->
<div id="volunteer-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modal-volunteer-name">{$mod_strings.LBL_VOLUNTEER_NAME}</h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body" id="modal-volunteer-details">
            <!-- Volunteer details will be loaded here via AJAX -->
        </div>
        <div class="modal-footer">
            <button type="button" class="button" id="close-modal-btn">Close</button>
        </div>
    </div>
</div> 