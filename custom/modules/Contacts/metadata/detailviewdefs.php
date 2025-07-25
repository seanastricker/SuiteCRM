<?php
$viewdefs ['Contacts'] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          'SEND_CONFIRM_OPT_IN_EMAIL' => 
          array (
            'customCode' => '<input type="submit" class="button hidden" disabled="disabled" title="{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}" onclick="this.form.return_module.value=\'Contacts\'; this.form.return_action.value=\'Contacts\'; this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'sendConfirmOptInEmail\'; this.form.module.value=\'Contacts\'; this.form.module_tab.value=\'Contacts\';" name="send_confirm_opt_in_email" value="{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}"/>',
            'sugar_html' => 
            array (
              'type' => 'submit',
              'value' => '{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}',
              'htmlOptions' => 
              array (
                'class' => 'button hidden',
                'id' => 'send_confirm_opt_in_email',
                'title' => '{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}',
                'onclick' => 'this.form.return_module.value=\'Contacts\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'sendConfirmOptInEmail\'; this.form.module.value=\'Contacts\'; this.form.module_tab.value=\'Contacts\';',
                'name' => 'send_confirm_opt_in_email',
                'disabled' => true,
              ),
            ),
          ),
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 'FIND_DUPLICATES',
          4 => 
          array (
            'customCode' => '<input type="submit" class="button" title="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" onclick="this.form.return_module.value=\'Contacts\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\'; this.form.module_tab.value=\'Contacts\';" name="Manage Subscriptions" value="{$APP.LBL_MANAGE_SUBSCRIPTIONS}"/>',
            'sugar_html' => 
            array (
              'type' => 'submit',
              'value' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
              'htmlOptions' => 
              array (
                'class' => 'button',
                'id' => 'manage_subscriptions_button',
                'title' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
                'onclick' => 'this.form.return_module.value=\'Contacts\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\'; this.form.module_tab.value=\'Contacts\';',
                'name' => 'Manage Subscriptions',
              ),
            ),
          ),
          'AOS_GENLET' => 
          array (
            'customCode' => '<input type="button" class="button" onClick="showPopup();" value="{$APP.LBL_PRINT_AS_PDF}">',
          ),
          'AOP_CREATE' => 
          array (
            'customCode' => '{if !$fields.joomla_account_id.value && $AOP_PORTAL_ENABLED}<input type="submit" class="button" onClick="this.form.action.value=\'createPortalUser\';" value="{$MOD.LBL_CREATE_PORTAL_USER}"> {/if}',
            'sugar_html' => 
            array (
              'type' => 'submit',
              'value' => '{$MOD.LBL_CREATE_PORTAL_USER}',
              'htmlOptions' => 
              array (
                'title' => '{$MOD.LBL_CREATE_PORTAL_USER}',
                'class' => 'button',
                'onclick' => 'this.form.action.value=\'createPortalUser\';',
                'name' => 'buttonCreatePortalUser',
                'id' => 'createPortalUser_button',
              ),
              'template' => '{if !$fields.joomla_account_id.value && $AOP_PORTAL_ENABLED}[CONTENT]{/if}',
            ),
          ),
          'AOP_DISABLE' => 
          array (
            'customCode' => '{if $fields.joomla_account_id.value && !$fields.portal_account_disabled.value && $AOP_PORTAL_ENABLED}<input type="submit" class="button" onClick="this.form.action.value=\'disablePortalUser\';" value="{$MOD.LBL_DISABLE_PORTAL_USER}"> {/if}',
            'sugar_html' => 
            array (
              'type' => 'submit',
              'value' => '{$MOD.LBL_DISABLE_PORTAL_USER}',
              'htmlOptions' => 
              array (
                'title' => '{$MOD.LBL_DISABLE_PORTAL_USER}',
                'class' => 'button',
                'onclick' => 'this.form.action.value=\'disablePortalUser\';',
                'name' => 'buttonDisablePortalUser',
                'id' => 'disablePortalUser_button',
              ),
              'template' => '{if $fields.joomla_account_id.value && !$fields.portal_account_disabled.value && $AOP_PORTAL_ENABLED}[CONTENT]{/if}',
            ),
          ),
          'AOP_ENABLE' => 
          array (
            'customCode' => '{if $fields.joomla_account_id.value && $fields.portal_account_disabled.value && $AOP_PORTAL_ENABLED}<input type="submit" class="button" onClick="this.form.action.value=\'enablePortalUser\';" value="{$MOD.LBL_ENABLE_PORTAL_USER}"> {/if}',
            'sugar_html' => 
            array (
              'type' => 'submit',
              'value' => '{$MOD.LBL_ENABLE_PORTAL_USER}',
              'htmlOptions' => 
              array (
                'title' => '{$MOD.LBL_ENABLE_PORTAL_USER}',
                'class' => 'button',
                'onclick' => 'this.form.action.value=\'enablePortalUser\';',
                'name' => 'buttonENablePortalUser',
                'id' => 'enablePortalUser_button',
              ),
              'template' => '{if $fields.joomla_account_id.value && $fields.portal_account_disabled.value && $AOP_PORTAL_ENABLED}[CONTENT]{/if}',
            ),
          ),
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
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'modules/Contacts/Contact.js',
        ),
      ),
      'useTabs' => true,
      'tabDefs' => 
      array (
        'LBL_DETAILVIEW_PANEL3' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_CONTACT_INFORMATION' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_ADVANCED' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_ASSIGNMENT' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'lbl_detailview_panel3' => 
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
          1 => '',
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
        5 => 
        array (
          0 => 
          array (
            'name' => 'children_names_c',
            'comment' => 'Names of children enrolled in programs',
            'label' => 'LBL_CHILDREN_NAMES',
          ),
          1 => 
          array (
            'name' => 'children_ages_c',
            'comment' => 'Ages of children (e.g., "8, 12" for multiple children)',
            'label' => 'LBL_CHILDREN_AGES',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'programs_enrolled_c',
            'comment' => 'Programs children are enrolled in',
            'label' => 'LBL_PROGRAMS_ENROLLED',
          ),
          1 => 
          array (
            'name' => 'emergency_contact_name_c',
            'comment' => 'Emergency contact person name',
            'label' => 'LBL_EMERGENCY_CONTACT_NAME',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'emergency_contact_phone_c',
            'comment' => 'Emergency contact phone number',
            'label' => 'LBL_EMERGENCY_CONTACT_PHONE',
          ),
          1 => 
          array (
            'name' => 'emergency_contact_relation_c',
            'comment' => 'Relationship to emergency contact',
            'label' => 'LBL_EMERGENCY_CONTACT_RELATION',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'preferred_communication_c',
            'comment' => 'Preferred method of communication',
            'label' => 'LBL_PREFERRED_COMMUNICATION',
          ),
          1 => 
          array (
            'name' => 'communication_frequency_c',
            'comment' => 'How often parent wants to receive communications',
            'label' => 'LBL_COMMUNICATION_FREQUENCY',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'email_notifications_c',
            'comment' => 'Receive email notifications',
            'label' => 'LBL_EMAIL_NOTIFICATIONS',
          ),
          1 => 
          array (
            'name' => 'sms_notifications_c',
            'comment' => 'Receive SMS notifications (future feature)',
            'label' => 'LBL_SMS_NOTIFICATIONS',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'parent_notes_c',
            'comment' => 'Additional notes about parent or children',
            'label' => 'LBL_PARENT_NOTES',
          ),
          1 => 
          array (
            'name' => 'medical_info_c',
            'comment' => 'Important medical information or allergies',
            'label' => 'LBL_MEDICAL_INFO',
          ),
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'pickup_authorization_c',
            'comment' => 'List of people authorized to pick up children',
            'label' => 'LBL_PICKUP_AUTHORIZATION',
          ),
          1 => '',
        ),
      ),
      'lbl_contact_information' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'first_name',
            'comment' => 'First name of the contact',
            'label' => 'LBL_FIRST_NAME',
          ),
          1 => 
          array (
            'name' => 'last_name',
            'comment' => 'Last name of the contact',
            'label' => 'LBL_LAST_NAME',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'phone_work',
            'label' => 'LBL_OFFICE_PHONE',
          ),
          1 => 
          array (
            'name' => 'phone_mobile',
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
          1 => 
          array (
            'name' => 'department',
            'label' => 'LBL_DEPARTMENT',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'account_name',
            'label' => 'LBL_ACCOUNT_NAME',
          ),
          1 => 
          array (
            'name' => 'phone_fax',
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
            'label' => 'LBL_PRIMARY_ADDRESS',
            'type' => 'address',
            'displayParams' => 
            array (
              'key' => 'primary',
            ),
          ),
          1 => 
          array (
            'name' => 'alt_address_street',
            'label' => 'LBL_ALTERNATE_ADDRESS',
            'type' => 'address',
            'displayParams' => 
            array (
              'key' => 'alt',
            ),
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'comment' => 'Full text of the note',
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
          1 => 
          array (
            'name' => 'campaign_name',
            'label' => 'LBL_CAMPAIGN',
          ),
        ),
      ),
      'LBL_PANEL_ASSIGNMENT' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
            'label' => 'LBL_DATE_ENTERED',
          ),
          1 => 
          array (
            'name' => 'date_modified',
            'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
            'label' => 'LBL_DATE_MODIFIED',
          ),
        ),
      ),
    ),
  ),
);
;
?>
