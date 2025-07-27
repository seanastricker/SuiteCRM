/**
 * BackgroundChecks Module - JavaScript Functions
 * 
 * This file contains client-side JavaScript functions for the BackgroundChecks module
 * to handle form validation, auto-name generation, and user interactions.
 * 
 * @package SuiteCRM
 * @subpackage YouthSportsLeague
 */

/**
 * Update the background check name field automatically
 * Called when volunteer, check type, or expiration date changes
 */
function updateBackgroundCheckName() {
    try {
        // Get form elements
        var volunteerField = document.getElementById('volunteer_name_c');
        var checkTypeField = document.getElementById('background_check_type_c');
        var expirationField = document.getElementById('expiration_date_c');
        var nameField = document.getElementById('name');
        
        if (!volunteerField || !nameField) {
            console.log('BackgroundChecks: Required fields not found for name generation');
            return;
        }
        
        var volunteerName = volunteerField.value;
        var checkType = checkTypeField ? checkTypeField.options[checkTypeField.selectedIndex].text : '';
        var expirationDate = expirationField ? expirationField.value : '';
        
        // Auto-generate name whenever we have volunteer name
        if (volunteerName) {
            var displayCheckType = checkType && checkType !== '' ? checkType : 'Background Check';
            var displayExpiration = expirationDate ? expirationDate : 'No Expiration';
            var generatedName = volunteerName + ' - ' + displayCheckType + ' (Expires: ' + displayExpiration + ')';
            nameField.value = generatedName;
            
            // Also update the display span if it exists
            var displaySpan = document.querySelector('.auto-generated-name');
            if (displaySpan) {
                displaySpan.textContent = generatedName;
            }
        }
    } catch (e) {
        console.error('BackgroundChecks: Error in updateBackgroundCheckName:', e);
    }
}

/**
 * Validate expiration date is after check date
 */
function validateDates() {
    try {
        var checkDateField = document.getElementById('check_date_c');
        var expirationDateField = document.getElementById('expiration_date_c');
        
        if (!checkDateField || !expirationDateField) {
            return true; // Skip validation if fields not found
        }
        
        var checkDate = new Date(checkDateField.value);
        var expirationDate = new Date(expirationDateField.value);
        
        if (checkDate && expirationDate && expirationDate <= checkDate) {
            alert('Expiration date must be after the check date.');
            expirationDateField.focus();
            return false;
        }
        
        return true;
    } catch (e) {
        console.error('BackgroundChecks: Error in validateDates:', e);
        return true; // Allow form submission if validation fails
    }
}

/**
 * Validate cost field (ensure positive number)
 */
function validateCost() {
    try {
        var costField = document.getElementById('cost_c');
        
        if (!costField || !costField.value) {
            return true; // Cost is optional
        }
        
        var cost = parseFloat(costField.value);
        
        if (isNaN(cost) || cost < 0) {
            alert('Cost must be a positive number.');
            costField.focus();
            return false;
        }
        
        return true;
    } catch (e) {
        console.error('BackgroundChecks: Error in validateCost:', e);
        return true; // Allow form submission if validation fails
    }
}

/**
 * Main form validation function
 * Called before form submission
 */
function validateBackgroundCheckForm() {
    // Run all validation functions
    return validateDates() && validateCost();
}

/**
 * Initialize form events when document is ready
 */
document.addEventListener('DOMContentLoaded', function() {
    try {
        // Set up event listeners for auto-name generation
        var volunteerField = document.getElementById('volunteer_name_c');
        var checkTypeField = document.getElementById('background_check_type_c');
        var expirationField = document.getElementById('expiration_date_c');
        
        if (volunteerField) {
            volunteerField.addEventListener('change', updateBackgroundCheckName);
        }
        
        if (checkTypeField) {
            checkTypeField.addEventListener('change', updateBackgroundCheckName);
        }
        
        if (expirationField) {
            expirationField.addEventListener('change', function() {
                updateBackgroundCheckName();
                validateDates();
            });
        }
        
        // Set up cost validation
        var costField = document.getElementById('cost_c');
        if (costField) {
            costField.addEventListener('blur', validateCost);
        }
        
        // Set up form submission validation
        var editForm = document.getElementById('EditView');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                if (!validateBackgroundCheckForm()) {
                    e.preventDefault();
                    return false;
                }
            });
        }
        
        console.log('BackgroundChecks: JavaScript initialized successfully');
    } catch (e) {
        console.error('BackgroundChecks: Error initializing JavaScript:', e);
    }
});

/**
 * Called when volunteer is selected via popup
 * This is a callback function for the relate field
 */
function set_return_volunteer(popup_reply_data) {
    try {
        set_return_basic(popup_reply_data);
        // Trigger name update after volunteer selection
        setTimeout(updateBackgroundCheckName, 100);
    } catch (e) {
        console.error('BackgroundChecks: Error in set_return_volunteer:', e);
    }
} 