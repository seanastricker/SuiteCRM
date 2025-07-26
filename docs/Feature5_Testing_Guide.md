# Feature 5 Equipment Check-Out Tracker - Testing Guide

## 🎯 **Testing Overview**

This guide provides comprehensive testing procedures for Feature 5 (Equipment Check-Out Tracker) to ensure all functionality works correctly.

## 📋 **Part 1: Equipment Creation Testing**

### **Access Points:**
- **Equipment Creation Form**: `http://localhost/suitecrm/index.php?entryPoint=create_equipment_form`
- **Equipment Dashboard**: `http://localhost/suitecrm/index.php?module=Equipment&action=equipmentdashboard`

### **Test Case 1.1: Basic Equipment Types**
Create equipment with different types to test dropdown functionality:

1. **Soccer Equipment**
   - Name: "Premium Soccer Balls Set"
   - Type: Soccer
   - Status: Available
   - Condition: Excellent
   - Location: Equipment Storage
   - Brand: Nike
   - Model: Official Match Ball

2. **Basketball Equipment**
   - Name: "Indoor Basketball Court Net"
   - Type: Basketball  
   - Status: Available
   - Condition: Good
   - Location: Gymnasium
   - Brand: Spalding

3. **Baseball Equipment**
   - Name: "Youth Baseball Glove Set"
   - Type: Baseball
   - Status: Available
   - Condition: Fair
   - Location: Sports Closet
   - Brand: Rawlings

4. **General Equipment**
   - Name: "Portable Sound System"
   - Type: General
   - Status: Available
   - Condition: Excellent
   - Location: Main Office

### **Test Case 1.2: Different Status & Conditions**
Create equipment with varying statuses and conditions:

5. **Checked Out Equipment**
   - Name: "Youth Football Helmet"
   - Type: Football
   - Status: Checked Out
   - Condition: Good
   - Checked Out By: "John Smith"
   - Due Date: [Tomorrow's date]
   - Checkout Notes: "For weekend practice"

6. **Maintenance Required**
   - Name: "Volleyball Net (Damaged)"
   - Type: Volleyball
   - Status: Maintenance
   - Condition: Poor
   - Location: Maintenance Room
   - Description: "Net has several tears, needs replacement"

7. **Missing Equipment (Retired)**
   - Name: "Missing Tennis Racket"
   - Type: Tennis
   - Status: Retired
   - Condition: Poor
   - Description: "Last seen at summer camp - missing"

### **Test Case 1.3: Complete Field Testing**
Create equipment with all optional fields filled:

8. **Comprehensive Equipment Record**
   - Name: "Professional Camera Equipment Kit"
   - Type: General
   - Status: Available
   - Condition: Excellent
   - Location: Media Center
   - Brand: Canon
   - Model: EOS R5
   - Serial Number: "CR5-2024-001"
   - Purchase Date: [Recent date]
   - Purchase Price: $2500.00
   - Program Association: Special Events
   - Description: "Complete photography kit for events"

## 📊 **Part 2: Dashboard Functionality Testing**

### **Test Case 2.1: Summary Statistics Verification**
After creating test equipment, verify dashboard shows:

- ✅ **Total Equipment Count**: Should match number created
- ✅ **Available Count**: Should show available items
- ✅ **Checked Out Count**: Should show checked out items  
- ✅ **Maintenance Count**: Should show maintenance items
- ✅ **Overdue Count**: Should show overdue items (if any)

### **Test Case 2.2: Filtering Functionality**
Test each filter option:

1. **Filter by Equipment Type**
   - Test: Select "Soccer" → Should show only soccer equipment
   - Test: Select "Basketball" → Should show only basketball equipment
   - Test: Select "All Types" → Should show all equipment

 2. **Filter by Status**
    - Test: Select "Available" → Should show only available equipment
    - Test: Select "Checked Out" → Should show only checked out equipment
    - Test: Select "In Maintenance" → Should show only maintenance equipment
    - Test: Select "Damaged" → Should show only damaged equipment
    - Test: Select "Retired" → Should show only retired equipment
    - Test: Select "All Statuses" → Should show all equipment

3. **Filter by Condition**
   - Test: Select "Excellent" → Should show only excellent condition
   - Test: Select "Good" → Should show only good condition
   - Test: Select "Fair" → Should show only fair condition
   - Test: Select "Poor" → Should show only poor condition

4. **Filter by Program**
   - Test: Select specific program → Should show only equipment for that program
   - Test: Select "All Programs" → Should show all equipment

5. **Filter by Location**
   - Test: Select specific location → Should show only equipment at that location
   - Test: Select "All Locations" → Should show all equipment

6. **Combined Filtering**
   - Test: Apply multiple filters simultaneously
   - Verify: Results match all selected criteria

### **Test Case 2.3: Equipment Card Display**
For each equipment card, verify display shows:

- ✅ **Equipment Name** (clearly visible)
- ✅ **Equipment Type** badge/indicator
- ✅ **Status** with appropriate color coding
- ✅ **Condition** with appropriate styling
- ✅ **Current Location**
- ✅ **Action Buttons** (appropriate for status)

### **Test Case 2.4: Equipment Actions Testing**

#### **Check-Out Functionality**
1. **Select Available Equipment**
   - Click "Check Out" button on available equipment
   - Verify checkout modal opens

2. **Fill Check-Out Form**
   - Who Checking Out: "Test User"
   - Due Back Date: [Future date]
   - Program: Select from dropdown
   - Current Location: "Test Location"
   - Purpose/Notes: "Testing checkout functionality"

3. **Process Checkout**
   - Click "Check Out" button
   - Verify success message appears
   - Verify equipment status changes to "Checked Out"
   - Verify equipment card updates with checkout info

#### **Return Functionality**
1. **Select Checked Out Equipment**
   - Click "Return" button on checked out equipment
   - Verify return modal opens

2. **Fill Return Form**
   - Return Condition: Select condition
   - Return Location: "Equipment Storage"
   - Return Notes: "Returned in good condition"

3. **Process Return**
   - Click "Return" button
   - Verify success message appears
   - Verify equipment status changes to "Available"
   - Verify checkout information is cleared

#### **Maintenance Actions**
1. **Mark for Maintenance**
   - Click "Maintenance" button on equipment
   - Verify status changes to "Maintenance"

2. **Return from Maintenance**
   - Use return functionality on maintenance equipment
   - Verify equipment returns to "Available" status

### **Test Case 2.5: Reports and Notifications**

#### **Overdue Equipment Testing**
1. **Create Overdue Equipment**
   - Check out equipment with past due date
   - OR modify existing checkout to have past due date

2. **Verify Overdue Display**
   - Check summary shows overdue count
   - Verify overdue section highlights properly
   - Click "View Details" for overdue equipment

3. **Send Overdue Notifications**
   - Click "Send Reminders" button
   - Verify notification process works
   - Check for success/error messages

#### **Report Generation**
1. **Generate Full Report**
   - Click "📄 Generate Full Report" button
   - Verify report displays correctly
   - Check all equipment appears in report

2. **Export Data**
   - Click "📊 Export Data" button
   - Verify export functionality works
   - Check exported data format and content

### **Test Case 2.6: Search and Advanced Features**

#### **Search Functionality**
If search is implemented:
1. **Search by Equipment Name**
   - Enter partial equipment name
   - Verify matching results appear

2. **Search by Brand/Model**
   - Search for specific brand or model
   - Verify correct equipment appears

#### **Equipment Details Modal**
1. **View Equipment Details**
   - Click on equipment card or "View Details"
   - Verify detailed information displays
   - Check all field values are correct

## 🔍 **Part 3: Edge Case Testing**

### **Test Case 3.1: Data Validation**
1. **Required Field Validation**
   - Try creating equipment without required fields
   - Verify appropriate error messages appear

2. **Date Validation**
   - Try setting due date in the past
   - Try invalid date formats

### **Test Case 3.2: Concurrent Operations**
1. **Multiple User Simulation**
   - Have multiple browser windows/tabs open
   - Test checkout from different sessions
   - Verify data consistency

### **Test Case 3.3: Data Persistence**
1. **Browser Refresh**
   - Perform actions and refresh browser
   - Verify all changes persist correctly

2. **Session Testing**
   - Logout and login again
   - Verify all equipment data remains accurate

## ✅ **Testing Checklist**

### **Equipment Creation** ✓
- [ ] Basic equipment types (soccer, basketball, etc.)
- [ ] Different statuses (available, checked out, in maintenance, damaged, retired)
- [ ] Different conditions (excellent, good, fair, poor)
- [ ] Complete field testing with all optional fields
- [ ] Required field validation

### **Dashboard Display** ✓
- [ ] Summary statistics accuracy
- [ ] Equipment cards display properly
- [ ] Status color coding works
- [ ] Action buttons appear correctly

### **Filtering System** ✓
- [ ] Filter by equipment type
- [ ] Filter by status
- [ ] Filter by condition  
- [ ] Filter by program
- [ ] Filter by location
- [ ] Combined filtering works
- [ ] "All" options reset filters properly

### **Equipment Actions** ✓
- [ ] Check-out functionality works
- [ ] Return functionality works
- [ ] Maintenance marking works
- [ ] Status updates properly after actions
- [ ] Form validation in modals

### **Reports & Notifications** ✓
- [ ] Overdue equipment detection
- [ ] Overdue details modal
- [ ] Send reminder notifications
- [ ] Generate full report
- [ ] Export data functionality

### **Advanced Features** ✓
- [ ] Equipment details modal
- [ ] Search functionality (if implemented)
- [ ] Data persistence after refresh
- [ ] Error handling and user feedback

## 🚨 **Issues to Report**

During testing, document any issues found:

1. **Functionality Issues**
   - Features that don't work as expected
   - Error messages or failed operations
   - Incorrect data display

2. **UI/UX Issues**
   - Layout problems
   - Confusing interface elements
   - Missing labels or unclear text

3. **Data Issues**
   - Incorrect calculations
   - Data not saving properly
   - Inconsistent information display

## 📝 **Test Results Documentation**

For each test case, record:
- ✅ **PASS** - Feature works as expected
- ❌ **FAIL** - Feature has issues (describe problem)
- ⚠️ **PARTIAL** - Feature works but has minor issues

**Example:**
```
Test Case 2.1: Summary Statistics
- Total Equipment Count: ✅ PASS - Shows correct count
- Available Count: ❌ FAIL - Shows 0 when should show 3
- Overdue Count: ✅ PASS - Correctly shows 1 overdue item
```

## 🎯 **Success Criteria**

Feature 5 testing is successful when:
- ✅ All equipment creation methods work reliably
- ✅ Dashboard displays accurate information
- ✅ All filtering options work correctly
- ✅ Check-out and return processes function properly
- ✅ Reports and notifications operate as expected
- ✅ Data persists correctly across sessions
- ✅ User interface is intuitive and responsive 