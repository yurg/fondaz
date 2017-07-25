<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.7                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2017                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
 */

/**
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2017
 */
class CRM_Report_Form_Grant_Fondaz extends CRM_Report_Form_Grant_Detail {

  protected $_addressField = FALSE;

  protected $_customGroupExtends = array(
    'Grant', 'Contact'
  );



 /* 
Sezione lavoro membro convivente 1: civicrm_value_sezione_lavoro_2                        importo_percepito_16
Sezione lavoro membro convivente 2: civicrm_value_sezione_lavoro_membro_convivente_2_6    importo_percepito_23
Sezione lavoro – Richiedente:  civicrm_value_sezione_lavoro_richiedente_10                importo_percepito_44
Sezione lavoro membro convivente 3: civicrm_value_sezione_lavoro_membro_convivente_3_11   importo_percepito_49
Sezione lavoro membro convivente 4: civicrm_value_sezione_lavoro_membro_convivente_4_12   importo_percepito_53
Sezione lavoro membro convivente 5: civicrm_value_sezione_lavoro_membro_convivente_5_13   importo_percepito_59
Sezione lavoro membro convivente 6: civicrm_value_sezione_lavoro_membro_convivente_6_14   importo_percepito_64
Sezione lavoro membro convivente 7: civicrm_value_sezione_lavoro_membro_convivente_7_15   importo_percepito_69
Sezione lavoro membro convivente 8: civicrm_value_sezione_lavoro_membro_convivente_8_16   importo_percepito_74
*/

 protected $_s_l_m_c = array(
 'importo_percepito_16' => 'civicrm_value_sezione_lavoro_2',
 'importo_percepito_23' => 'civicrm_value_sezione_lavoro_membro_convivente_2_6',
 // 'importo_percepito_44' => 'civicrm_value_sezione_lavoro_richiedente_10', we use this as  "main" value
 'importo_percepito_49' => 'civicrm_value_sezione_lavoro_membro_convivente_3_11',
 'importo_percepito_53' => 'civicrm_value_sezione_lavoro_membro_convivente_4_12',
 'importo_percepito_59' => 'civicrm_value_sezione_lavoro_membro_convivente_5_13',
 'importo_percepito_64' => 'civicrm_value_sezione_lavoro_membro_convivente_6_14',
 'importo_percepito_69' => 'civicrm_value_sezione_lavoro_membro_convivente_7_15',
 'importo_percepito_74' => 'civicrm_value_sezione_lavoro_membro_convivente_8_16'
);


  /**
   * Class constructor.
   */

/*
 *  We're hide all columns since we've already commented out default columns query below    
 */

  public function __construct() {
    $this->_columns = array(
      'civicrm_contact' => array(
        'dao' => 'CRM_Contact_DAO_Contact',
        'fields' => array(
     /*     'id' => array(
            'title' => ts('Contact ID'),
            'no_display' => TRUE,
            'required' => TRUE,
            'no_repeat' => TRUE,
            ),
      */      
               'sort_name' => array(
            'title' => ts('Contact Name'),
            'required' => TRUE,            
          ),
        ),
        'grouping' => 'contact-fields',
        'filters' => array(
          'sort_name' => array(
            'title' => ts('Contact Name'),
            'operator' => 'like',
          ),
          'gender_id' => array(
            'title' => ts('Gender'),
            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
            'options' => CRM_Core_PseudoConstant::get('CRM_Contact_DAO_Contact', 'gender_id'),
          ),
        ),
      ),
      'civicrm_address' => array(
        'dao' => 'CRM_Core_DAO_Address',
        'filters' => array(
          'country_id' => array(
            'title' => ts('Country'),
            'type' => CRM_Utils_Type::T_INT,
            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
            'options' => CRM_Core_PseudoConstant::country(),
          ),
          'state_province_id' => array(
            'title' => ts('State/Province'),
            'type' => CRM_Utils_Type::T_INT,
            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
            'options' => CRM_Core_PseudoConstant::stateProvince(),
          ),
        ),
      ),
      'civicrm_grant' => array(
        'dao' => 'CRM_Grant_DAO_Grant',
        'fields' => array(
          'grant_type_id' => array(
            'name' => 'grant_type_id',
            'title' => ts('Grant Type'),
                   'no_display' => TRUE,
                   'required' => TRUE,
          ),
          'status_id' => array(
            'name' => 'status_id',
            'title' => ts('Grant Status'),
                   'no_display' => TRUE,
          ),
     /*
          'amount_total' => array(
            'name' => 'amount_total',
            'title' => ts('Amount Requested'),
            'type' => CRM_Utils_Type::T_MONEY,
                   'no_display' => TRUE,
          ),
          */
          'amount_granted' => array(
            'name' => 'amount_granted',
            'title' => ts('Amount Granted'),
                   'no_display' => TRUE,
          ),
          'application_received_date' => array(
            'name' => 'application_received_date',
            'title' => ts('Application Received'),
            'default' => TRUE,
                   'no_display' => TRUE,
          ),
          'money_transfer_date' => array(
            'name' => 'money_transfer_date',
            'title' => ts('Money Transfer Date'),
            'type' => CRM_Utils_Type::T_DATE,
                   'no_display' => TRUE,
          ),
          'grant_due_date' => array(
            'name' => 'grant_due_date',
            'title' => ts('Grant Report Due'),
            'type' => CRM_Utils_Type::T_DATE,
                   'no_display' => TRUE,
          ),
          'decision_date' => array(
            'name' => 'decision_date',
            'title' => ts('Grant Decision Date'),
            'type' => CRM_Utils_Type::T_DATE,
                   'no_display' => TRUE,
          ),
         /* 
          'rationale' => array(
            'name' => 'rationale',
            'title' => ts('Rationale'),
                   'no_display' => TRUE,
          ),
          */
          'grant_report_received' => array(
            'name' => 'grant_report_received',
            'title' => ts('Grant Report Received'),
                   'no_display' => TRUE,
          ),
        ),
        'filters' => array(
          'grant_type' => array(
            'name' => 'grant_type_id',
            'title' => ts('Grant Type'),
            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
            'options' => CRM_Core_PseudoConstant::get('CRM_Grant_DAO_Grant', 'grant_type_id'),
          ),
          'status_id' => array(
            'name' => 'status_id',
            'title' => ts('Grant Status'),
            'type' => CRM_Utils_Type::T_INT,
            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
            'options' => CRM_Core_PseudoConstant::get('CRM_Grant_DAO_Grant', 'status_id'),
          ),
          'amount_granted' => array(
            'title' => ts('Amount Granted'),
            'operatorType' => CRM_Report_Form::OP_INT,
          ),
          'amount_total' => array(
            'title' => ts('Amount Requested'),
            'operatorType' => CRM_Report_Form::OP_INT,
          ),
          'application_received_date' => array(
            'title' => ts('Application Received'),
            'operatorType' => CRM_Report_Form::OP_DATE,
            'type' => CRM_Utils_Type::T_DATE,
          ),
          'money_transfer_date' => array(
            'title' => ts('Money Transfer Date'),
            'operatorType' => CRM_Report_Form::OP_DATE,
            'type' => CRM_Utils_Type::T_DATE,
          ),
          'grant_due_date' => array(
            'title' => ts('Grant Report Due'),
            'operatorType' => CRM_Report_Form::OP_DATE,
            'type' => CRM_Utils_Type::T_DATE,
          ),
          'decision_date' => array(
            'title' => ts('Grant Decision Date'),
            'operatorType' => CRM_Report_Form::OP_DATE,
            'type' => CRM_Utils_Type::T_DATE,
          ),
        ),
        'group_bys' => array(
          'grant_type_id' => array(
            'title' => ts('Grant Type'),
          ),
          'status_id' => array(
            'title' => ts('Grant Status'),
          ),
          'amount_total' => array(
            'title' => ts('Amount Requested'),
          ),
          'amount_granted' => array(
            'title' => ts('Amount Granted'),
          ),
          'application_received_date' => array(
            'title' => ts('Application Received Date'),
          ),
          'money_transfer_date' => array(
            'title' => ts('Money Transfer Date'),
          ),
          'decision_date' => array(
            'title' => ts('Grant Decision Date'),
          ),
        ),
      ),
    );

    parent::__construct();
  }

  public function select() {
    $select = array();

  // $this->_columnHeaders = array();

/*
 *  Custom fields are here 
 *  On report /  Field label on CiviCRM  /  Field type / Field set
*/

 /*
  * 1.  Prot. / Numero protocollo / Custom - CiviGrant / Dettagli
  */

   $this->_columnHeaders['civicrm_value_dettagli_20_numero_protocollo_105'] = 
                  array ('title' => ts('Prot.*'),
        );
        $select[] = "value_dettagli_20_civireport.numero_protocollo_105 as civicrm_value_dettagli_20_numero_protocollo_105";


/*
*  2. Nome / Nome - Cognome / Core – Contact: Name and Surname
*/

   $this->_columnHeaders['civicrm_contact_sort_name'] = 
                  array (
                     'title' => ts('Nome *'),

        );
 $select[] = "contact_civireport.sort_name as civicrm_contact_sort_name";
   
/*
 *  Contact ID = hidden, we need it later on
 */
   $this->_columnHeaders['civicrm_contact_id'] = 
                  array (
                     'title' => ts('Contact ID *'),
                     'no_display' => TRUE,
        );
        $select[] = "contact_civireport.id as civicrm_contact_id";

/*
*  3. Età No field reference, it’s calculated  Age taken from Core - Contact birth date
*/

   $this->_columnHeaders['civicrm_contact_birth_date'] = 
                  array ('title' => ts('Età *'),
        );
        $select[] = "contact_civireport.birth_date as civicrm_contact_birth_date";

 
/*
 * 4  Val. / Grado di disagio / Custom - CiviGrant / Dettagli
*/

   $this->_columnHeaders['civicrm_value_dettagli_20_grado_di_disagio_103'] = 
                  array ('title' => ts('Val.*'),
        );
        $select[] = "value_dettagli_20_civireport.grado_di_disagio_103 as civicrm_value_dettagli_20_grado_di_disagio_103";


/*
 * 5  Nucleo / Membri Nucleo / Custom - CiviGrant / Sezione lavoro - Richiedente
*/

   $this->_columnHeaders['civicrm_value_sezione_lavoro_richiedente_10_membri_nucleo_106'] = 
                  array ('title' => ts('Nucleo *'),
        );
        $select[] = "value_sezione_lavoro_richiedente_10_civireport.membri_nucleo_106 as civicrm_value_sezione_lavoro_richiedente_10_membri_nucleo_106";

/* 6  disp. mens.  / Calculated: sum of field ”Importo percepito” content from 
 *     Sezione lavoro – Richiedente and all the fields ”Importo percepito” from Sezione lavoro – membro convivente from 1 to 8
 * 
 */
   $this->_columnHeaders['civicrm_value_sezione_lavoro_richiedente_10_importo_percepito_44'] = 
                  array ('title' => ts('disp. mens.'),
                    'type' => CRM_Utils_Type::T_MONEY,

        );
       $select[] = "value_sezione_lavoro_richiedente_10_civireport.importo_percepito_44 as civicrm_value_sezione_lavoro_richiedente_10_importo_percepito_44" ;
  

/* Run through all Importo percepito keys => values except  Sezione lavoro – Richiedente, which we used right above   */  
 foreach($this->_s_l_m_c as $k => $v) {
            $this->_columnHeaders[$v.'_'.$k] = 
                  array ('title' => ts($v),
                    'no_display' => TRUE,
        );
       $select[] = substr($v, 8)."_civireport.".$k." as " . $v."_".$k;
     }

/* 7.  ISEE / Importo ISEE Custom - CiviGrant / Sezione patrimoniale
 * 
 */
   $this->_columnHeaders['civicrm_value_sezione_patrimoniale_18_importo_isee_25'] = 
                  array ('title' => ts('ISEE'),

        );
       $select[] = "value_sezione_patrimoniale_18_civireport.importo_isee_25 as civicrm_value_sezione_patrimoniale_18_importo_isee_25" ;


/*
 *    8 descriz. criticità / Base logica / Core - CiviGrant grant_civireport.grant_type_id as civicrm_grant_grant_type_id 
 */

   $this->_columnHeaders['civicrm_grant_rationale'] = 
                  array ('title' => ts('descriz. criticità'),

        );
       $select[] = "grant_civireport.rationale as civicrm_grant_rationale" ;


/*
 *   9 imp. rich. Importo richiesto Core - CiviGrant (Amount total)
 */

   $this->_columnHeaders['civicrm_grant_amount_total'] = 
                  array ('title' => ts('imp. rich.'),
                    // 'no_display' => FALSE,
                        'type' => CRM_Utils_Type::T_MONEY,

        );
       $select[] = "grant_civireport.amount_total as civicrm_grant_amount_total" ;

/*
 *   10 imp. stanz. Importo richiesto (valuta originale) Core - CiviGrant (Amount requested)
 */

   $this->_columnHeaders['civicrm_grant_amount_requested'] = 
                  array ('title' => ts('imp. stanz.'),
                    // 'no_display' => FALSE,
                        'type' => CRM_Utils_Type::T_MONEY,

        );
  $select[] = "grant_civireport.amount_requested as civicrm_grant_amount_requested";


/*
 *   11 Cap. Difference: Importo richiesto (valuta originale) - Importo richiesto
 */

   $this->_columnHeaders['civicrm_grant_amount_requested_diff'] = 
                  array ('title' => ts('Cap. *'),
                    // 'no_display' => FALSE,
                      'type' => CRM_Utils_Type::T_MONEY,
        );
  $select[] = "grant_civireport.amount_total as civicrm_grant_amount_requested_diff";

/*
 *   12 imp. erog. Importo fornito Core - CiviGrant (Amount granted?)
 */

   $this->_columnHeaders['civicrm_grant_amount_granted_orig'] = 
                  array ('title' => ts('imp. erog.'),
                    // 'no_display' => FALSE,
                        'type' => CRM_Utils_Type::T_MONEY,

        );
  $select[] = "grant_civireport.amount_granted as civicrm_grant_amount_granted_orig";


/*
 *   13 Disp. eff. Difference: Importo richiesto (valuta originale) - Importo fornito
 */

   $this->_columnHeaders['civicrm_grant_amount_granted_diff'] = 
                  array ('title' => ts('Disp. eff.'),
                        'type' => CRM_Utils_Type::T_MONEY,

        );
  $select[] = "grant_civireport.amount_granted as civicrm_grant_amount_granted_diff";


/* 14 Notes 
 * 
 */

   $this->_columnHeaders['civicrm_value_documenti_ritirati_5_note_18'] = 
                  array ('title' => ts('Notes'),
        );
       $select[] = "value_documenti_ritirati_5_civireport.note_18 as civicrm_value_documenti_ritirati_5_note_18" ;


/* Default report fields  are commented out  */

/*
   foreach ($this->_columns as $tableName => $table) {

      if ($tableName == 'civicrm_address') {
        $this->_addressField = TRUE;
      }
      if (array_key_exists('fields', $table)) {
        foreach ($table['fields'] as $fieldName => $field) {
          if (!empty($field['required']) ||
            !empty($this->_params['fields'][$fieldName])
          ) {

            $select[] = "{$field['dbAlias']} as {$tableName}_{$fieldName}";

            $this->_columnHeaders["{$tableName}_{$fieldName}"]['title'] = $field['title'];
            $this->_columnHeaders["{$tableName}_{$fieldName}"]['type'] = CRM_Utils_Array::value('type', $field);
          }
        }
      }
    }

*/

    $this->_select = "SELECT " . implode(', ', $select) . " ";
  }

  public function from() {
    $this->_from = "
        FROM civicrm_grant {$this->_aliases['civicrm_grant']}
                        LEFT JOIN civicrm_contact {$this->_aliases['civicrm_contact']}
                    ON ({$this->_aliases['civicrm_grant']}.contact_id  = {$this->_aliases['civicrm_contact']}.id  ) ";
 

    if ($this->_addressField) {
      $this->_from .= "
                  LEFT JOIN civicrm_address {$this->_aliases['civicrm_address']}
                         ON {$this->_aliases['civicrm_contact']}.id =
                            {$this->_aliases['civicrm_address']}.contact_id AND
                            {$this->_aliases['civicrm_address']}.is_primary = 1\n";
    }


/*
 * Below are custom joins taken from civicrm_custom_group table: needed to catch custom fields
*/

    $this->_from .=  "
        LEFT JOIN civicrm_value_dettagli_20 value_dettagli_20_civireport 
        ON value_dettagli_20_civireport.entity_id = grant_civireport.id";           
   
   $this->_from .=  "
        LEFT JOIN  civicrm_value_sezione_lavoro_richiedente_10  value_sezione_lavoro_richiedente_10_civireport 
        ON value_sezione_lavoro_richiedente_10_civireport.entity_id = grant_civireport.id";    

   $this->_from .=  "
        LEFT JOIN  civicrm_value_sezione_patrimoniale_18  value_sezione_patrimoniale_18_civireport 
        ON value_sezione_patrimoniale_18_civireport.entity_id = grant_civireport.id";   

    $this->_from .=  "
        LEFT JOIN  civicrm_value_documenti_ritirati_5  value_documenti_ritirati_5_civireport 
        ON value_documenti_ritirati_5_civireport.entity_id = grant_civireport.id";      


foreach($this->_s_l_m_c as $k => $v) {
   $this->_from .=  "
        LEFT JOIN  ".$v." ".substr($v, 8)."_civireport  ON ".substr($v, 8)."_civireport.entity_id = grant_civireport.id";           
  }
}

  public function where() {
    $clauses = array();
    $this->_where = '';
    foreach ($this->_columns as $tableName => $table) {
      if (array_key_exists('filters', $table)) {
        foreach ($table['filters'] as $fieldName => $field) {

          $clause = NULL;
          if (CRM_Utils_Array::value('type', $field) & CRM_Utils_Type::T_DATE) {
            $relative = CRM_Utils_Array::value("{$fieldName}_relative", $this->_params);
            $from = CRM_Utils_Array::value("{$fieldName}_from", $this->_params);
            $to = CRM_Utils_Array::value("{$fieldName}_to", $this->_params);

            if ($relative || $from || $to) {
              $clause = $this->dateClause($field['name'], $relative, $from, $to, $field['type']);
            }
          }
          else {
            $op = CRM_Utils_Array::value("{$fieldName}_op", $this->_params);
            if ($op) {
              $clause = $this->whereClause($field,
                $op,
                CRM_Utils_Array::value("{$fieldName}_value", $this->_params),
                CRM_Utils_Array::value("{$fieldName}_min", $this->_params),
                CRM_Utils_Array::value("{$fieldName}_max", $this->_params)
              );
            }
          }
          if (!empty($clause)) {
            $clauses[] = $clause;
            $this->_where = "WHERE " . implode(' AND ', $clauses);
          }
        }
      }
    }
  }

  public function groupBy() {
    $this->_groupBy = "";
    if (!empty($this->_params['group_bys']) &&
      is_array($this->_params['group_bys']) &&
      !empty($this->_params['group_bys'])
    ) {
      foreach ($this->_columns as $tableName => $table) {
        if (array_key_exists('group_bys', $table)) {
          foreach ($table['group_bys'] as $fieldName => $field) {
            if (!empty($this->_params['group_bys'][$fieldName])) {
              $this->_groupBy[] = $field['dbAlias'];
            }
          }
        }
      }
    }
    if (!empty($this->_groupBy)) {
      $this->_groupBy = "ORDER BY " . implode(', ', $this->_groupBy) .
        ", {$this->_aliases['civicrm_contact']}.sort_name";
    }
    else {
      $this->_groupBy = "ORDER BY {$this->_aliases['civicrm_contact']}.sort_name";
    }
  }


  /**
   * Alter display of rows.
   *
   * Iterate through the rows retrieved via SQL and make changes for display purposes,
   * such as rendering contacts as links.
   *
   * @param array $rows
   *   Rows generated by SQL, with an array for each row.
   */


 public function alterDisplay(&$rows) {
    $entryFound = FALSE;

  foreach ($rows as $rowNum => $row) {


/*
 * Let us sum disp.mens / all importo percepitos
*/

$s = '';
 foreach($this->_s_l_m_c as $k => $v) {
    $s += $rows[$rowNum][$v."_".$k]; 
  }

if (array_key_exists('civicrm_value_sezione_lavoro_richiedente_10_importo_percepito_44', $row)) {
      if($value = $row['civicrm_value_sezione_lavoro_richiedente_10_importo_percepito_44']) {
       $rows[$rowNum]['civicrm_value_sezione_lavoro_richiedente_10_importo_percepito_44'] += $s ;
     } else {
       $rows[$rowNum]['civicrm_value_sezione_lavoro_richiedente_10_importo_percepito_44'] = $s;
     }
        $entryFound = TRUE;
}


/*
 *  Calculate the diff between requested and requested in orig. currency 
 */

     if (array_key_exists('civicrm_grant_amount_requested_diff', $row)) {
        if ($value = $row['civicrm_grant_amount_requested_diff']) {
          $rows[$rowNum]['civicrm_grant_amount_requested_diff'] = 
          $rows[$rowNum]['civicrm_grant_amount_total'] - $rows[$rowNum]['civicrm_grant_amount_requested'];
       }
        $entryFound = TRUE;
      }

/*
 *  Calculate the diff between requested and granted
 */

     if (array_key_exists('civicrm_grant_amount_granted_diff', $row)) {
        if ($value = $row['civicrm_grant_amount_granted_diff']) {
          $rows[$rowNum]['civicrm_grant_amount_granted_diff'] = 
          $rows[$rowNum]['civicrm_grant_amount_requested'] - $rows[$rowNum]['civicrm_grant_amount_granted_orig'];
        }
        $entryFound = TRUE;
      }


/*
 * Age calculator
*/
  if (array_key_exists('civicrm_contact_birth_date', $row)) {
      if ($value = $row['civicrm_contact_birth_date']) {
          //$rows[$rowNum]['civicrm_contact_birth_date']
$from = new DateTime($rows[$rowNum]['civicrm_contact_birth_date']);
$to   = new DateTime('today');

$rows[$rowNum]['civicrm_contact_birth_date'] = $from->diff($to)->y;
 }
}

      // convert display name to links

      if (array_key_exists('civicrm_contact_sort_name', $row) && array_key_exists('civicrm_contact_id', $row)
      ) {
        $url = CRM_Utils_System::url('civicrm/contact/view',
          'reset=1&cid=' . $row['civicrm_contact_id'],
          $this->_absoluteUrl
        );
        $rows[$rowNum]['civicrm_contact_sort_name_link'] = $url;
        $rows[$rowNum]['civicrm_contact_sort_name_hover'] = ts("View contact details for this record.");
        $entryFound = TRUE;
      }

      if (array_key_exists('civicrm_grant_grant_type_id', $row)) {
        if ($value = $row['civicrm_grant_grant_type_id']) {
          $rows[$rowNum]['civicrm_grant_grant_type_id'] = CRM_Core_PseudoConstant::getLabel('CRM_Grant_DAO_Grant', 'grant_type_id', $value);
        }
        $entryFound = TRUE;
      }      


      if (array_key_exists('civicrm_grant_status_id', $row)) {
        if ($value = $row['civicrm_grant_status_id']) {
          $rows[$rowNum]['civicrm_grant_status_id'] = CRM_Core_PseudoConstant::getLabel('CRM_Grant_DAO_Grant', 'status_id', $value);
        }
        $entryFound = TRUE;
      }
      if (array_key_exists('civicrm_grant_grant_report_received', $row)) {
        if ($value = $row['civicrm_grant_grant_report_received']) {
          if ($value == 1) {
            $value = 'Yes';
          }
          else {
            $value = 'No';
          }
          $rows[$rowNum]['civicrm_grant_grant_report_received'] = $value;
        }
        $entryFound = TRUE;
      }
      if (!$entryFound) {
        break;
      }

    }
  }
}