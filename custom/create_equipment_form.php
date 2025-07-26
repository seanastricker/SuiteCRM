<?php

/**
 * Equipment Creation Form - Custom Entry Point
 * 
 * Provides a safe, comprehensive form for creating new equipment records
 * without conflicting with SuiteCRM's standard view system.
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

require_once('include/entryPoint.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Suppress all output and start clean buffer
    error_reporting(0);
    ini_set('display_errors', 0);
    ob_start();
    ob_clean();
    header('Content-Type: application/json');
    
    try {
        global $db, $current_user;
        
        // Validate required fields
        $required_fields = ['name', 'equipment_type', 'checkout_status', 'condition_status'];
        $errors = array();
        
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                $errors[] = "Field '$field' is required";
            }
        }
        
        if (!empty($errors)) {
            ob_clean();
            echo json_encode(array('success' => false, 'errors' => $errors));
            ob_end_flush();
            exit;
        }
        
        // Create equipment record
        $equipment = BeanFactory::getBean('Equipment');
        if (!$equipment) {
            throw new Exception('Could not create Equipment bean');
        }
        
        // Set all form fields
        $equipment->name = $_POST['name'];
        $equipment->equipment_type = $_POST['equipment_type'];
        $equipment->checkout_status = $_POST['checkout_status'];
        $equipment->condition_status = $_POST['condition_status'];
        $equipment->current_location = $_POST['current_location'] ?? '';
        $equipment->program_association = $_POST['program_association'] ?? '';
        $equipment->brand = $_POST['brand'] ?? '';
        $equipment->model = $_POST['model'] ?? '';
        $equipment->serial_number = $_POST['serial_number'] ?? '';
        $equipment->purchase_date = $_POST['purchase_date'] ?? '';
        $equipment->purchase_price = !empty($_POST['purchase_price']) ? (float)$_POST['purchase_price'] : 0;
        $equipment->description = $_POST['description'] ?? '';
        
        // Set standard fields
        $equipment->id = create_guid();
        $equipment->date_entered = date('Y-m-d H:i:s');
        $equipment->date_modified = date('Y-m-d H:i:s');
        $equipment->deleted = 0;
        
        if (!empty($current_user) && !empty($current_user->id)) {
            $equipment->created_by = $current_user->id;
            $equipment->modified_user_id = $current_user->id;
        }
        
        // Save equipment
        $save_result = $equipment->save();
        
        // Verify the save worked by checking the database
        global $db;
        $verify_result = $db->query("SELECT COUNT(*) as count FROM equipment WHERE id = '" . $equipment->id . "' AND deleted = 0");
        $verify_count = 0;
        if ($verify_result && $row = $db->fetchByAssoc($verify_result)) {
            $verify_count = $row['count'];
        }
        
        echo json_encode(array(
            'success' => true,
            'message' => 'Equipment created successfully!',
            'equipment_id' => $equipment->id,
            'equipment_name' => $equipment->name,
            'save_result' => $save_result,
            'verified_in_db' => $verify_count > 0,
            'debug_info' => array(
                'equipment_type' => $equipment->equipment_type,
                'checkout_status' => $equipment->checkout_status,
                'deleted' => $equipment->deleted
            )
        ));
        ob_end_flush();
        exit;
        
    } catch (Exception $e) {
        ob_clean();
        echo json_encode(array(
            'success' => false,
            'message' => 'Error creating equipment: ' . $e->getMessage()
        ));
        ob_end_flush();
        exit;
    }
}

// Load dropdown options
require_once('modules/Equipment/EquipmentHelper.php');
$dropdown_options = EquipmentHelper::getDropdownOptions();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Equipment - Youth Sports League</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 300;
        }
        
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
        
        .form-container {
            padding: 40px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .required {
            color: #e74c3c;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5a67d8;
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .container {
                margin: 10px;
            }
            
            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏈 Create New Equipment</h1>
            <p>Add equipment to your sports program inventory</p>
        </div>
        
        <div class="form-container">
            <div id="message-container"></div>
            
            <form id="equipment-form" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Equipment Name <span class="required">*</span></label>
                        <input type="text" id="name" name="name" required placeholder="e.g., Soccer Goals (Portable)">
                    </div>
                    
                    <div class="form-group">
                        <label for="equipment_type">Equipment Type <span class="required">*</span></label>
                        <select id="equipment_type" name="equipment_type" required>
                            <option value="">Select Type</option>
                            <?php foreach ($dropdown_options['equipment_types'] as $key => $value): ?>
                                <option value="<?php echo htmlspecialchars($key); ?>"><?php echo htmlspecialchars($value); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="checkout_status">Status <span class="required">*</span></label>
                        <select id="checkout_status" name="checkout_status" required>
                            <option value="">Select Status</option>
                            <?php foreach ($dropdown_options['equipment_statuses'] as $key => $value): ?>
                                <option value="<?php echo htmlspecialchars($key); ?>" <?php echo $key === 'available' ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($value); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="condition_status">Condition <span class="required">*</span></label>
                        <select id="condition_status" name="condition_status" required>
                            <option value="">Select Condition</option>
                            <?php foreach ($dropdown_options['equipment_conditions'] as $key => $value): ?>
                                <option value="<?php echo htmlspecialchars($key); ?>" <?php echo $key === 'good' ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($value); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="current_location">Current Location</label>
                        <input type="text" id="current_location" name="current_location" placeholder="e.g., Equipment Storage Room" value="Equipment Storage">
                    </div>
                    
                    <div class="form-group">
                        <label for="program_association">Program Association</label>
                        <select id="program_association" name="program_association">
                            <option value="">Select Program</option>
                            <?php foreach ($dropdown_options['programs'] as $key => $value): ?>
                                <option value="<?php echo htmlspecialchars($key); ?>"><?php echo htmlspecialchars($value); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="brand">Brand/Manufacturer</label>
                        <input type="text" id="brand" name="brand" placeholder="e.g., Nike, Adidas, Spalding">
                    </div>
                    
                    <div class="form-group">
                        <label for="model">Model</label>
                        <input type="text" id="model" name="model" placeholder="e.g., Pro Series 2024">
                    </div>
                    
                    <div class="form-group">
                        <label for="serial_number">Serial Number</label>
                        <input type="text" id="serial_number" name="serial_number" placeholder="e.g., ABC123456">
                    </div>
                    
                    <div class="form-group">
                        <label for="purchase_date">Purchase Date</label>
                        <input type="date" id="purchase_date" name="purchase_date">
                    </div>
                    
                    <div class="form-group">
                        <label for="purchase_price">Purchase Price ($)</label>
                        <input type="number" id="purchase_price" name="purchase_price" min="0" step="0.01" placeholder="0.00">
                    </div>
                </div>
                
                <div class="form-group full-width">
                    <label for="description">Description/Notes</label>
                    <textarea id="description" name="description" placeholder="Additional details about this equipment item..."></textarea>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn btn-primary" id="submit-btn">
                        🏈 Create Equipment
                    </button>
                    <a href="index.php?module=Equipment&action=equipmentdashboard" class="btn btn-secondary">
                        📊 Back to Dashboard
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('equipment-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const submitBtn = document.getElementById('submit-btn');
            const messageContainer = document.getElementById('message-container');
            
            // Show loading state
            submitBtn.textContent = '⏳ Creating...';
            submitBtn.disabled = true;
            form.classList.add('loading');
            messageContainer.innerHTML = '';
            
            // Collect form data
            const formData = new FormData(form);
            
            // Submit form using bulletproof save method
            fetch('index.php?entryPoint=force_equipment_save', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let debugInfo = '';
                    if (data.debug_info) {
                        debugInfo = `<br><small>Debug: Save result: ${data.save_result}, In DB: ${data.verified_in_db}, Type: ${data.debug_info.equipment_type}, Status: ${data.debug_info.checkout_status}, Deleted: ${data.debug_info.deleted}</small>`;
                    }
                    
                    messageContainer.innerHTML = `
                        <div class="success-message">
                            <strong>✅ Success!</strong> ${data.message}<br>
                            Equipment ID: ${data.equipment_id}${debugInfo}
                        </div>
                    `;
                    
                    // Reset form
                    form.reset();
                    
                    // Reset status and condition to defaults
                    document.getElementById('checkout_status').value = 'available';
                    document.getElementById('condition_status').value = 'good';
                    document.getElementById('current_location').value = 'Equipment Storage';
                    
                    // Show success message with redirect option
                    setTimeout(() => {
                        if (confirm('Equipment created successfully!\\n\\nGo to Equipment Dashboard to view it?')) {
                            window.location.href = 'index.php?module=Equipment&action=equipmentdashboard';
                        }
                    }, 1000);
                    
                } else {
                    let errorMessage = '<div class="error-message"><strong>❌ Error:</strong><br>';
                    if (data.errors && Array.isArray(data.errors)) {
                        errorMessage += data.errors.join('<br>');
                    } else {
                        errorMessage += data.message || 'Unknown error occurred';
                    }
                    errorMessage += '</div>';
                    messageContainer.innerHTML = errorMessage;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageContainer.innerHTML = `
                    <div class="error-message">
                        <strong>❌ Error:</strong> Failed to create equipment. Please try again.
                    </div>
                `;
            })
            .finally(() => {
                // Reset button state
                submitBtn.textContent = '🏈 Create Equipment';
                submitBtn.disabled = false;
                form.classList.remove('loading');
            });
        });
    </script>
</body>
</html> 