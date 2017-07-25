<?php
/**
 * @file
 * This file declares a managed database record of type "ReportTemplate".
 * The record will be automatically inserted, updated, or deleted from the
 * database as appropriate. For more details, see "hook_civicrm_managed" at:
 * http://wiki.civicrm.org/confluence/display/CRMDOC42/Hook+Reference
 */
 
return array(
  0 => array(
    'name' => 'CRM_Report_Form_Grant_Fondaz',
    'entity' => 'ReportTemplate',
    'params' => array(
      'version' => 3,
      'label' => 'Fondaz Report',
      'description' => 'Custom Fondaz Report. (Generated by the custom report extension: org.yurg.fondaz)',
      'class_name' => 'CRM_Report_Form_Grant_Fondaz',
      'report_url' => 'grant/fondaz',
      'component' => 'CiviGrant',
    ),
  ),
);
