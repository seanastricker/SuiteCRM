# Email Implementation Plan for Youth Sports League CRM

## Overview
This document outlines the implementation plan for adding email functionality to the Youth Sports League SuiteCRM project, with primary focus on Parent Communications (Feature 4) and supporting other features.

## Project Context
- **Environment**: Development/Project (not production)
- **Email Volume**: Low volume testing with 3 test email accounts
- **Primary Focus**: Parent Communications functionality
- **SMTP Solution**: Gmail SMTP (easiest setup for testing)
- **Timeline**: ~4-5 hours total implementation

## Why Email is Critical

### Primary Beneficiaries
- **Feature 4 (Parent Communication)** - Bulk emails, newsletters, alerts ⭐ **PRIORITY**
- **Feature 1 (Background Checks)** - Expiration warnings, renewal reminders
- **Feature 3 (Safety Incidents)** - Incident notifications to parents/coordinators
- **Feature 6 (Volunteer Hours)** - Recognition emails, hour confirmations
- **General System** - User notifications, password resets, system alerts

## Gmail SMTP Implementation Plan

### Phase 1: Gmail SMTP Setup (30 minutes)

#### Prerequisites
1. Gmail account with 2-factor authentication enabled
2. Generate Gmail App Password:
   - Google Account → Security → 2-Step Verification → App Passwords
   - Generate password for "SuiteCRM" application
   - Save the 16-character app password

#### SuiteCRM Configuration
**Location**: Admin → Email Settings → Outbound Email

**Settings**:
```
SMTP Server: smtp.gmail.com
Port: 587 (TLS)
Username: your-gmail@gmail.com
Password: [16-character app password]
Security: TLS enabled
From Name: "Youth Sports League"
From Email: your-gmail@gmail.com
```

#### Testing
1. Use SuiteCRM's "Send Test Email" function
2. Verify email delivery to test accounts
3. Check email formatting and sender information

### Phase 2: Contact Email Management (1 hour)

#### Contact Module Enhancements
Add new custom fields to Contacts module:

**New Fields**:
- `email_communication_opt_in_c` (checkbox) - "Email Communications Opt-in"
- `preferred_communication_method_c` (dropdown) - "Preferred Communication Method"
  - Options: Email, Phone, Text, Mail
- `parent_guardian_type_c` (dropdown) - "Parent/Guardian Type"
  - Options: Primary Parent, Secondary Parent, Guardian, Emergency Contact

#### Email List Management
**Create Custom List Views**:
- "All Parent Emails" - Filtered by contact type
- "Email Opt-in Contacts" - Where opt-in is checked
- "By Sport Program" - Email lists per program

#### Test Contact Setup
Create test contacts using 3 available email addresses:
1. **Email 1**: Primary Parent for Football program
2. **Email 2**: Secondary Parent for Soccer program  
3. **Email 3**: Volunteer (for testing cross-feature emails)

### Phase 3: Parent Communications Module Enhancement (2 hours)

#### Email Composition Interface
**Features to Build**:
- Rich text email editor
- Subject line input
- Recipient selection and filtering
- Send immediately or schedule options
- Email preview functionality

#### Recipient Selection Options
- **All Parents** - Bulk email to all parent contacts
- **By Sport Program** - Filter by specific sports programs
- **By Contact Type** - Parents vs Volunteers vs Staff
- **Individual Selection** - Manual contact selection
- **Opt-in Only** - Respect communication preferences

#### Email Templates System
Create template management for common communications:
- Template library
- Variable placeholders (names, dates, programs)
- Template categories (Welcome, Events, Emergency, General)

### Phase 4: Email Templates (1 hour)

#### Template 1: Welcome Email
```
Subject: Welcome to [Sport Program] - Important Information

Dear [Parent Name],

Welcome to the Youth Sports League [Sport Program]! 
We're excited to have [Child Name] join our team.

Important upcoming dates:
- First practice: [Date]
- Equipment pickup: [Date]
- Season opener: [Date]

Please don't hesitate to contact us with any questions.

Best regards,
Youth Sports League Coordination Team
```

#### Template 2: Event Announcement
```
Subject: [Event Type] - [Date] for [Sport Program]

Dear [Sport Program] Parents,

We have an important [Event Type] scheduled:

Date: [Date]
Time: [Time]  
Location: [Location]
Details: [Event Details]

Please reply to confirm attendance or contact us with questions.

Thank you,
[Coordinator Name]
Youth Sports League
```

#### Template 3: Emergency Communication
```
Subject: URGENT: [Emergency Type] - [Sport Program]

Dear Parents,

This is an urgent communication regarding [Emergency Details].

Immediate Actions Required:
- [Action 1]
- [Action 2]
- [Action 3]

For questions, please contact:
Emergency Hotline: [Phone Number]
Email: [Emergency Email]

Youth Sports League Emergency Team
```

#### Template 4: General Newsletter
```
Subject: Youth Sports League Monthly Update - [Month Year]

Dear Youth Sports League Families,

Here's what's happening in our league this month:

UPCOMING EVENTS:
- [Event 1]: [Date and Time]
- [Event 2]: [Date and Time]

PROGRAM UPDATES:
- [Update 1]
- [Update 2]

VOLUNTEER OPPORTUNITIES:
- [Opportunity 1]
- [Opportunity 2]

Thank you for being part of our league family!

Best regards,
[Coordinator Name]
```

### Phase 5: Testing & Refinement (30 minutes)

#### Test Scenarios
1. **Single Email Test** - Send to one test account
2. **Bulk Email Test** - Send to all 3 test accounts
3. **Template Test** - Use each template with variables
4. **Filter Test** - Send to specific contact types
5. **Formatting Test** - Verify HTML formatting and plain text fallback

#### Validation Checklist
- [ ] Emails deliver to all test accounts
- [ ] From name appears correctly
- [ ] Subject lines populate correctly
- [ ] Email body formatting is proper
- [ ] Variable placeholders substitute correctly
- [ ] Recipient filtering works accurately
- [ ] Opt-in preferences are respected

## Technical Implementation Details

### File Structure
```
custom/modules/ParentCommunication/
├── ParentCommunication.php (enhanced with email)
├── controller.php (email actions)
├── views/
│   ├── view.emailcompose.php
│   ├── view.emailtemplates.php
│   └── view.emailhistory.php
├── metadata/
│   └── (existing view definitions)
└── language/
    └── en_us.lang.php (email labels)

custom/Extension/modules/Contacts/Ext/Vardefs/
└── email_communication_c.php (new email fields)

custom/Extension/application/Ext/Language/
└── en_us.email_templates.php (template strings)
```

### Database Tables
**Existing Tables Enhanced**:
- `contacts` - Add email communication fields
- `parent_communication` - Add email tracking fields

**New Email Log Table** (if needed):
- Track sent emails
- Monitor delivery status
- Store email history

### Email Integration Points

#### Outbound Email System
- Use SuiteCRM's built-in email system
- Leverage existing SMTP configuration
- Integrate with contact management

#### Email Templates
- Store templates in database
- Support variable substitution
- Version control for templates

#### Scheduled Emails
- Integration with SuiteCRM scheduler
- Automated reminder systems
- Bulk email queue management

## Future Feature Integration

### Background Checks (Feature 1)
**Email Alerts**:
- 30-day expiration warnings
- 7-day urgent reminders
- Renewal confirmation emails

**Implementation**: Add scheduled job to check expiration dates and send alerts

### Safety Incidents (Feature 3)
**Notification Emails**:
- Immediate parent notification for incidents
- Coordinator alerts
- Follow-up communications

**Implementation**: Logic hook on incident creation to trigger email

### Volunteer Hours (Feature 6)
**Recognition Emails**:
- Monthly volunteer recognition
- Hour confirmation receipts
- Achievement milestone emails

**Implementation**: Scheduled monthly emails and logic hooks on hour approval

## Security & Best Practices

### Gmail SMTP Security
- Use app passwords, never main account password
- Store credentials securely in SuiteCRM config
- Monitor email sending logs
- Respect Gmail's sending limits (500 emails/day)

### Email Privacy
- Respect opt-in preferences
- Provide unsubscribe options
- Store minimal personal data
- Use BCC for bulk emails when appropriate

### Testing Safety
- Use only test email addresses during development
- Implement "test mode" to prevent accidental sends
- Log all email activities for debugging

## Success Metrics

### Immediate Goals
- [ ] Gmail SMTP successfully configured
- [ ] Test emails deliver to all 3 accounts
- [ ] Parent Communication email interface functional
- [ ] Email templates working with variables
- [ ] Recipient filtering operational

### Long-term Goals
- [ ] Integration with Background Checks alerts
- [ ] Safety Incident notifications
- [ ] Volunteer recognition emails
- [ ] Automated reminder systems

## Troubleshooting Guide

### Common Issues
1. **Gmail Authentication Fails**
   - Verify 2FA is enabled
   - Regenerate app password
   - Check username/password format

2. **Emails Not Delivering**
   - Check spam folders
   - Verify recipient email addresses
   - Review SMTP logs in SuiteCRM

3. **Template Variables Not Substituting**
   - Check variable syntax
   - Verify data source fields
   - Test with simple variables first

4. **Bulk Emails Failing**
   - Check Gmail sending limits
   - Verify recipient list format
   - Test with smaller batches

### Support Resources
- SuiteCRM Email Documentation
- Gmail SMTP Configuration Guide
- PHP mail() function documentation

## Implementation Timeline

### Week 1: Core Setup
- Day 1: Gmail SMTP configuration and testing
- Day 2: Contact module email field enhancements
- Day 3: Basic email composition interface

### Week 2: Advanced Features
- Day 1: Email template system
- Day 2: Recipient filtering and bulk sending
- Day 3: Testing and refinement

### Week 3: Integration
- Day 1: Background check email alerts
- Day 2: Safety incident notifications
- Day 3: Volunteer recognition emails

## Conclusion

This email implementation provides a solid foundation for all communication needs across the Youth Sports League CRM features. Starting with Gmail SMTP and Parent Communications ensures a practical, testable solution that can be expanded to support all six features effectively.

The modular approach allows for incremental implementation and testing, reducing risk while building comprehensive email capabilities for the entire system. 