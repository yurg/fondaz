{*
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
*}
{*include file="CRM/Report/Form.tpl"*}

{* this div is being used to apply special css *}
{if $section eq 1}
  <div class="crm-block crm-content-block crm-report-layoutGraph-form-block">
    {*include the graph*}
    {include file="CRM/Report/Form/Layout/Graph.tpl"}
  </div>
{elseif $section eq 2}
  <div class="crm-block crm-content-block crm-report-layoutTable-form-block">
    {*include the table layout*}
    {*include file="CRM/Report/Form/Layout/Table.tpl"*}
  </div>
{else}
  {if $criteriaForm OR $instanceForm OR $instanceFormError}
    <div class="crm-block crm-form-block crm-report-field-form-block">
      {include file="CRM/Report/Form/Fields.tpl"}
    </div>
  {/if}

  <div class="crm-block crm-content-block crm-report-form-block">
    {*include actions*}
    {include file="CRM/Report/Form/Actions.tpl"}

    {*Statistics at the Top of the page*}
    {*include file="CRM/Report/Form/Statistics.tpl" top=true*}

    {*include the graph*}
    {include file="CRM/Report/Form/Layout/Graph.tpl"}

{if (!$chartEnabled || !$chartSupported )&& $rows}
    {if $pager and $pager->_response and $pager->_response.numPages > 1}
        <div class="report-pager">
            {include file="CRM/common/pager.tpl" location="top"}
        </div>
    {/if}

{* Report header *}

<div style="width: 100%; text-align: center; margin: 0 auto; padding: 0;">
<h2>DETTAGLI CONTRIBUTO</h2>
</div>

<div style="width: 100%; text-align: left; margin: 0px; padding: 10px; font-size: 10px;">
LEGENDA:
<br> 1 Evidente situazione di necessità in condizioni di vita al limite del decoroso 
<br> 2 Situazione di difficoltà con scarse capacità di far fronte alle necessità 
<br> 3 Situazione di difficoltà moderata da condizioni di vita abbastanza decorose
<br> 4 In grado di condurre una vita dignitosa senza pretese
<br>
</div>

    <table id="fondaz" class="report-layout display" style="border: 1px solid #222; border-collapse: collapse; ">
        {capture assign="tableHeader"}
            {foreach from=$columnHeaders item=header key=field}
                {assign var=class value=""}
                {if $header.type eq 1024 OR $header.type eq 1 OR $header.type eq 512}
                {assign var=class value="class='reports-header-right'"}
                {else}
                    {assign var=class value="class='reports-header'"}
                {/if}
                {if !$skip}
                   {if $header.colspan}
                       <th style="background: #ccc; font-weight: bolder; border: 1px solid #222; color: #222; padding: 10px;" colspan={$header.colspan}>{$header.title}</th>
                      {assign var=skip value=true}
                      {assign var=skipCount value=`$header.colspan`}
                      {assign var=skipMade  value=1}
                   {else}
                       <th style="background: #ccc; font-weight: bolder; border: 1px solid #222; color: #222; padding: 10px;" {$class}>{$header.title}</th>
                   {assign var=skip value=false}
                   {/if}
                {else} {* for skip case *}
                   {assign var=skipMade value=`$skipMade+1`}
                   {if $skipMade >= $skipCount}{assign var=skip value=false}{/if}
                {/if}
            {/foreach}
        {/capture}

        {if !$sections} {* section headers and sticky headers aren't playing nice yet *}
            <thead class="sticky"  >
            <tr style="background: #ccc; font-weight: bolder;">
                {$tableHeader}
        </tr>
        </thead>
        {/if}

        {* pre-compile section header here, rather than doing it every time under foreach *}
        {capture assign=sectionHeaderTemplate}
            {assign var=columnCount value=$columnHeaders|@count}
            {assign var=l value=$smarty.ldelim}
            {assign var=r value=$smarty.rdelim}
            {assign var=pageBroke value=0}
            {foreach from=$sections item=section key=column name=sections}
                {counter assign="h"}
                {$l}isValueChange value=$row.{$column} key="{$column}" assign=isValueChanged{$r}
                {$l}if $isValueChanged{$r}

                    {$l}if $sections.{$column}.type & 4{$r}
                        {$l}assign var=printValue value=$row.{$column}|crmDate{$r}
                    {$l}elseif $sections.{$column}.type eq 1024{$r}
                        {$l}assign var=printValue value=$row.{$column}|crmMoney{$r}
                    {$l}else{$r}
                        {$l}assign var=printValue value=$row.{$column}{$r}
                    {$l}/if{$r}
                    {$l}if $rowid neq 0{$r}
                      {if $section.pageBreak}
                        {$l}if $pageBroke >= {$h} or $pageBroke == 0{$r}
                          </table>
                          <div class="page-break"></div>
                          <table class="report-layout display">
                        {$l}/if{$r}
                        {$l}assign var=pageBroke value={$h}{$r}
                      {/if}
                    {$l}/if{$r}
                    <tr class="crm-report-sectionHeader crm-report-sectionHeader-{$h}"><th colspan="{$columnCount}">

                        <h{$h}>{$section.title}: {$l}$printValue|default:"<em>none</em>"{$r}
                            ({$l}sectionTotal key=$row.{$column} depth={$smarty.foreach.sections.index}{$r})
                        </h{$h}>
                    </th></tr>
                    {if $smarty.foreach.sections.last}
                        <tr class="crm-report-sectionCols">{$l}$tableHeader{$r}</tr>
                    {/if}
                {$l}/if{$r}
            {/foreach}
        {/capture}

        {foreach from=$rows item=row key=rowid}
           {eval var=$sectionHeaderTemplate}
            <tr  class="{cycle values="odd-row,even-row"} {$row.class} crm-report" id="crm-report_{$rowid}">
                {foreach from=$columnHeaders item=header key=field}
  
                    {assign var=fieldLink value=$field|cat:"_link"}
                    {assign var=fieldHover value=$field|cat:"_hover"}
                    <td style="border: 1px solid #222; padding: 10px; border-collapse: collapse; margin: 0;" class="crm-report-{$field}{if $header.type eq 1024 OR $header.type eq 1 OR $header.type eq 512} report-contents-right{elseif $row.$field eq 'Subtotal'} report-label{/if}">
                       
                        {if $row.$fieldLink}
                            <a title="{$row.$fieldHover}" href="{$row.$fieldLink}">
                        {/if}

                        {if $row.$field eq 'Subtotal'}
                            {$row.$field}
                        {elseif $header.type & 4 OR $header.type & 256}
                            {if $header.group_by eq 'MONTH' or $header.group_by eq 'QUARTER'}
                                {$row.$field|crmDate:$config->dateformatPartial}
                            {elseif $header.group_by eq 'YEAR'}
                                {$row.$field|crmDate:$config->dateformatYear}
                            {else}
                                {if $header.type == 4}
                                   {$row.$field|truncate:10:''|crmDate}
                                {else}
                                   {$row.$field|crmDate}
                                {/if}
                            {/if}
                        {elseif $header.type eq 1024}
                            {if $currencyColumn}
                                <span class="nowrap">{$row.$field|crmMoney:$row.$currencyColumn}</span>
                            {else}
                                <span class="nowrap">{$row.$field|crmMoney}</span>
                           {/if}
                        {else}

                            {$row.$field}

                        {/if}

                        {if $row.$fieldLink}</a>{/if}
                    </td>
                {/foreach}
            </tr>
        {/foreach}


{* Totals *}

{foreach from=$rows item=row key=rowid}
<!--<pre>{*$row|@print_r*}</pre>-->
   {assign var=civicrm_grant_amount_granted_diff value=$row.civicrm_grant_amount_granted_diff+$civicrm_grant_amount_granted_diff}
   {assign var=civicrm_grant_amount_requested_diff value=$row.civicrm_grant_amount_requested_diff+$civicrm_grant_amount_requested_diff}
   {assign var=civicrm_grant_amount_granted_orig value=$row.civicrm_grant_amount_granted_orig+$civicrm_grant_amount_granted_orig}
   {assign var=civicrm_grant_amount_requested value=$row.civicrm_grant_amount_requested+$civicrm_grant_amount_requested}
   {assign var=civicrm_grant_amount_total value=$row.civicrm_grant_amount_total+$civicrm_grant_amount_total}
{/foreach}

    <tr style="background: #ccc; font-weight: bolder;" >
                {foreach from=$columnHeaders item=header key=field}
                   <td class="report-label" style="padding: 5px; border: 1px solid #222;">
                  {if $field eq 'civicrm_contact_sort_name'}
                    {*$field|@print_r*}
                     Total
                   {/if}

               {if $field eq 'civicrm_grant_amount_total'}    
                   {$civicrm_grant_amount_total|crmMoney}
               {/if}
             
               {if $field eq 'civicrm_grant_amount_requested'}    
                   {$civicrm_grant_amount_requested|crmMoney}
               {/if}
               
               {if $field eq 'civicrm_grant_amount_requested_diff'}    
                   {$civicrm_grant_amount_requested_diff|crmMoney}
               {/if}        

               {if $field eq 'civicrm_grant_amount_granted_orig'}    
                   {$civicrm_grant_amount_granted_orig|crmMoney}
               {/if}     

               {if $field eq 'civicrm_grant_amount_granted_diff'}    
                   {$civicrm_grant_amount_granted_diff|crmMoney}
               {/if}
             
                   </td>
                {/foreach}
            </tr> 

    </table>

    {if $pager and $pager->_response and $pager->_response.numPages > 1}
        <div class="report-pager">
            {include file="CRM/common/pager.tpl" }
        </div>
    {/if}
{/if}
 <br />
    {*Statistics at the bottom of the page*}
    {*include file="CRM/Report/Form/Statistics.tpl" bottom=true*}

DIFFERENZA STANZ. e EROG.: {$civicrm_grant_amount_requested-$civicrm_grant_amount_granted_orig|crmMoney}
    {include file="CRM/Report/Form/ErrorMessage.tpl"}
  </div>
{/if}
{if $outputMode == 'print'}
  <script type="text/javascript">
    window.print();
  </script>
{/if}