/**
 * VolunteerHours Module - JavaScript Functions
 * 
 * This file contains JavaScript functions for enhanced functionality
 * in the VolunteerHours module, including auto-name generation.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

/**
 * Auto-generate entry name when volunteer or hours change
 */
function updateVolunteerHoursName() {
    // Get form elements
    var volunteerField = document.getElementById('volunteer_name_c');
    var hoursField = document.getElementById('hours_logged_c');
    var dateField = document.getElementById('activity_date_c');
    var nameField = document.getElementById('name');
    
    if (!volunteerField || !hoursField || !dateField || !nameField) {
        return;
    }
    
    var volunteerName = volunteerField.value;
    var hours = hoursField.value;
    var activityDate = dateField.value;
    
    // Auto-generate name whenever we have volunteer name
    if (volunteerName) {
        // Format: "Volunteer Name - X hours (Date)"
        var displayHours = hours ? hours : '0';
        var displayDate = activityDate ? activityDate : new Date().toISOString().split('T')[0];
        
        var generatedName = volunteerName + ' - ' + displayHours + ' hours (' + displayDate + ')';
        nameField.value = generatedName;
        
        // Also update the display span if it exists
        var displaySpan = document.querySelector('.auto-generated-name');
        if (displaySpan) {
            displaySpan.textContent = generatedName;
        }
    }
}

/**
 * Set up event listeners when page loads
 */
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners for auto-name generation
    var volunteerField = document.getElementById('volunteer_name_c');
    var hoursField = document.getElementById('hours_logged_c');
    var dateField = document.getElementById('activity_date_c');
    
    if (volunteerField) {
        volunteerField.addEventListener('change', updateVolunteerHoursName);
        volunteerField.addEventListener('blur', updateVolunteerHoursName);
    }
    
    if (hoursField) {
        hoursField.addEventListener('change', updateVolunteerHoursName);
        hoursField.addEventListener('blur', updateVolunteerHoursName);
    }
    
    if (dateField) {
        dateField.addEventListener('change', updateVolunteerHoursName);
        dateField.addEventListener('blur', updateVolunteerHoursName);
    }
    
    // Set default approval status to pending if creating new record
    var approvalField = document.getElementById('approval_status_c');
    if (approvalField && !approvalField.value && window.location.href.indexOf('action=EditView') > -1) {
        approvalField.value = 'pending';
    }
});

/**
 * Validate hours field to ensure reasonable values
 */
function validateHours() {
    var hoursField = document.getElementById('hours_logged_c');
    if (!hoursField) return true;
    
    var hours = parseFloat(hoursField.value);
    
    if (isNaN(hours) || hours < 0) {
        alert('Please enter a valid number of hours (0 or greater).');
        hoursField.focus();
        return false;
    }
    
    if (hours > 24) {
        if (!confirm('You entered ' + hours + ' hours. Are you sure this is correct? This seems like a very long time.')) {
            hoursField.focus();
            return false;
        }
    }
    
    return true;
}

/**
 * Form validation before submission
 */
function validateVolunteerHoursForm() {
    return validateHours();
} 