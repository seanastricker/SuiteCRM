<?php
$viewdefs ['Contacts'] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'hidden' => 
        array (
          0 => '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
          1 => '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
          2 => '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
          3 => '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
          4 => '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
        ),
      ),
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'LBL_EDITVIEW_PANEL1' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_CONTACT_INFORMATION' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_ADVANCED' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'contact_type_c',
            'comment' => 'Type of contact: Volunteer, Parent, Staff, Other',
            'studio' => 'visible',
            'label' => 'LBL_CONTACT_TYPE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'background_check_expiration_c',
            'comment' => 'Background check expiration date for volunteer compliance',
            'label' => 'LBL_BACKGROUND_CHECK_EXPIRATION',
          ),
          1 => 
          array (
            'name' => 'background_check_status_c',
            'comment' => 'Auto-calculated status based on expiration date (Valid, Expiring, Expired, Pending)',
            'studio' => 'visible',
            'label' => 'LBL_BACKGROUND_CHECK_STATUS',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'preferred_sports_c',
            'comment' => 'Sports the volunteer is interested in or has experience with',
            'studio' => 'visible',
            'label' => 'LBL_PREFERRED_SPORTS',
          ),
          1 => 
          array (
            'name' => 'preferred_age_groups_c',
            'comment' => 'Age groups the volunteer prefers to work with',
            'studio' => 'visible',
            'label' => 'LBL_PREFERRED_AGE_GROUPS',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'availability_days_c',
            'comment' => 'Days of the week the volunteer is available',
            'studio' => 'visible',
            'label' => 'LBL_AVAILABILITY_DAYS',
          ),
          1 => 
          array (
            'name' => 'volunteer_experience_level_c',
            'comment' => 'Experience level of the volunteer with youth sports',
            'studio' => 'visible',
            'label' => 'LBL_VOLUNTEER_EXPERIENCE_LEVEL',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'special_skills_c',
            'comment' => 'Special skills, certifications, or qualifications (CPR, First Aid, coaching licenses, etc.)',
            'studio' => 'visible',
            'label' => 'LBL_SPECIAL_SKILLS',
          ),
          1 => 
          array (
            'name' => 'volunteer_status_c',
            'comment' => 'Current status of the volunteer (Active, Inactive, Seasonal, etc.)',
            'studio' => 'visible',
            'label' => 'LBL_VOLUNTEER_STATUS',
          ),
        ),
      ),
      'lbl_contact_information' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'first_name',
            'customCode' => '{html_options name="salutation" id="salutation" options=$fields.salutation.options selected=$fields.salutation.value}&nbsp;<input name="first_name"  id="first_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
          ),
          1 => 
          array (
            'name' => 'last_name',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'phone_work',
            'comment' => 'Work phone number of the contact',
            'label' => 'LBL_OFFICE_PHONE',
          ),
          1 => 
          array (
            'name' => 'phone_mobile',
            'comment' => 'Mobile phone number of the contact',
            'label' => 'LBL_MOBILE_PHONE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'title',
            'comment' => 'The title of the contact',
            'label' => 'LBL_TITLE',
          ),
          1 => 'department',
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'account_name',
            'displayParams' => 
            array (
              'key' => 'billing',
              'copy' => 'primary',
              'billingKey' => 'primary',
              'additionalFields' => 
              array (
                'phone_office' => 'phone_work',
              ),
            ),
          ),
          1 => 
          array (
            'name' => 'phone_fax',
            'comment' => 'Contact fax number',
            'label' => 'LBL_FAX_PHONE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'email1',
            'studio' => 'false',
            'label' => 'LBL_EMAIL_ADDRESS',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'primary_address_street',
            'hideLabel' => true,
            'type' => 'address',
            'displayParams' => 
            array (
              'key' => 'primary',
              'rows' => 2,
              'cols' => 30,
              'maxlength' => 150,
            ),
          ),
          1 => 
          array (
            'name' => 'alt_address_street',
            'hideLabel' => true,
            'type' => 'address',
            'displayParams' => 
            array (
              'key' => 'alt',
              'copy' => 'primary',
              'rows' => 2,
              'cols' => 30,
              'maxlength' => 150,
            ),
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'LBL_DESCRIPTION',
          ),
          1 => '',
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
        ),
      ),
      'LBL_PANEL_ADVANCED' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'lead_source',
            'comment' => 'How did the contact come about',
            'label' => 'LBL_LEAD_SOURCE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'report_to_name',
            'label' => 'LBL_REPORTS_TO',
          ),
          1 => 'campaign_name',
        ),
      ),
    ),
  ),
);
;
?>
