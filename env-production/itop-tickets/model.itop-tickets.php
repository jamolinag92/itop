						<?php
//
// File generated by ... on the 2018-01-29T11:45:07-0500
// Please do not edit manually
//

/**
 * Classes and menus for itop-tickets (version 2.3.0)
 *
 * @author      iTop compiler
 * @license     http://opensource.org/licenses/AGPL-3.0
 */
define('RESPONSE_TICKET_SLT_QUERY', 'SELECT SLT AS slt JOIN lnkSLAToSLT AS l1 ON l1.slt_id=slt.id JOIN SLA AS sla ON l1.sla_id=sla.id JOIN lnkCustomerContractToService AS l2 ON l2.sla_id=sla.id JOIN CustomerContract AS sc ON l2.customercontract_id=sc.id WHERE slt.metric = :metric AND l2.service_id = :this->service_id AND sc.org_id = :this->org_id AND slt.request_type = :request_type AND slt.priority = :this->priority');
define('PORTAL_POWER_USER_PROFILE', 'Portal power user');
define('PORTAL_SERVICECATEGORY_QUERY', 'SELECT Service AS s JOIN lnkCustomerContractToService AS l1 ON l1.service_id=s.id JOIN CustomerContract AS cc ON l1.customercontract_id=cc.id WHERE cc.org_id = :org_id AND s.status != \'obsolete\'');
define('PORTAL_SERVICE_SUBCATEGORY_QUERY', 'SELECT ServiceSubcategory WHERE service_id = :svc_id AND ServiceSubcategory.status != \'obsolete\'');
define('PORTAL_VALIDATE_SERVICECATEGORY_QUERY', 'SELECT Service AS s JOIN lnkCustomerContractToService AS l1 ON l1.service_id=s.id JOIN CustomerContract AS cc ON l1.customercontract_id=cc.id WHERE cc.org_id = :org_id AND s.id = :id AND s.status != \'obsolete\'');
define('PORTAL_VALIDATE_SERVICESUBCATEGORY_QUERY', 'SELECT ServiceSubcategory AS Sub JOIN Service AS Svc ON Sub.service_id = Svc.id WHERE Sub.id=:id AND Sub.status != \'obsolete\'');
define('PORTAL_ALL_PARAMS', 'from_service_id,org_id,caller_id,service_id,servicesubcategory_id,title,description,impact,emergency,moreinfo,caller_id,start_date,end_date,duration,impact_duration');
define('PORTAL_SET_TYPE_FROM', 'request_type');
define('PORTAL_TICKETS_SEARCH_CRITERIA', 'ref,start_date,close_date,service_id,caller_id');
define('PORTAL_TICKETS_SEARCH_FILTER_service_id', 'SELECT Service AS s JOIN lnkCustomerContractToService AS l1 ON l1.service_id=s.id JOIN CustomerContract AS cc ON l1.customercontract_id=cc.id WHERE cc.org_id = :org_id AND s.status != \'obsolete\'');
define('PORTAL_TICKETS_SEARCH_FILTER_caller_id', 'SELECT Person WHERE org_id = :org_id');


/**
 * Persistent classes for a CMDB
 *
 * @copyright   Copyright (C) 2010-2012 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */
abstract class Ticket extends _Ticket
{
	public static function Init()
	{
		$aParams = array
		(
			'category' => 'bizmodel,searchable,structure',
			'key_type' => 'autoincrement',
			'name_attcode' => array('ref'),
			'state_attcode' => '',
			'reconc_keys' => array('ref'),
			'db_table' => 'ticket',
			'db_key_field' => 'id',
			'db_finalclass_field' => 'finalclass',
		);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeMetaEnum("operational_status", array("allowed_values"=>new ValueSetEnum("ongoing,resolved,closed"), "sql"=>'operational_status', "default_value"=>'ongoing', "mapping"=>array (
  'Ticket' => 
  array (
    'attcode' => 'status',
    'values' => 
    array (
      'resolved' => 'resolved',
      'closed' => 'closed',
      'rejected' => 'closed',
    ),
  ),
), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeString("ref", array("allowed_values"=>null, "sql"=>'ref', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("org_id", array("targetclass"=>'Organization', "allowed_values"=>null, "sql"=>'org_id', "is_null_allowed"=>false, "on_target_delete"=>DEL_AUTO, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("org_name", array("allowed_values"=>null, "extkey_attcode"=>'org_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("caller_id", array("targetclass"=>'Person', "allowed_values"=>new ValueSetObjects("SELECT Person WHERE org_id = :this->org_id"), "sql"=>'caller_id', "is_null_allowed"=>true, "on_target_delete"=>DEL_AUTO, "depends_on"=>array('org_id'), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("caller_name", array("allowed_values"=>null, "extkey_attcode"=>'caller_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("team_id", array("targetclass"=>'Team', "allowed_values"=>new ValueSetObjects("SELECT Team AS t JOIN lnkDeliveryModelToContact AS l1 ON l1.contact_id=t.id JOIN DeliveryModel AS dm ON l1.deliverymodel_id=dm.id JOIN Organization AS o ON o.deliverymodel_id=dm.id WHERE o.id = :this->org_id"), "sql"=>'team_id', "is_null_allowed"=>true, "on_target_delete"=>DEL_AUTO, "depends_on"=>array('org_id'), "allow_target_creation"=>false, "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("team_name", array("allowed_values"=>null, "extkey_attcode"=>'team_id', "target_attcode"=>'email', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("agent_id", array("targetclass"=>'Person', "allowed_values"=>new ValueSetObjects("SELECT Person AS p JOIN lnkPersonToTeam AS l ON l.person_id=p.id JOIN Team AS t ON l.team_id=t.id WHERE t.id = :this->team_id"), "sql"=>'agent_id', "is_null_allowed"=>true, "on_target_delete"=>DEL_AUTO, "depends_on"=>array('team_id'), "allow_target_creation"=>false, "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("agent_name", array("allowed_values"=>null, "extkey_attcode"=>'agent_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeString("title", array("allowed_values"=>null, "sql"=>'title', "default_value"=>'', "is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeText("description", array("allowed_values"=>null, "sql"=>'description', "default_value"=>'', "is_null_allowed"=>false, "depends_on"=>array(), "format"=>'html', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeDateTime("start_date", array("allowed_values"=>null, "sql"=>'start_date', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>true)));
		MetaModel::Init_AddAttribute(new AttributeDateTime("end_date", array("allowed_values"=>null, "sql"=>'end_date', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeDateTime("last_update", array("allowed_values"=>null, "sql"=>'last_update', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false, "tracking_level"=>ATTRIBUTE_TRACKING_NONE)));
		MetaModel::Init_AddAttribute(new AttributeDateTime("close_date", array("allowed_values"=>null, "sql"=>'close_date', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeCaseLog("private_log", array("allowed_values"=>null, "sql"=>'private_log', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeLinkedSetIndirect("contacts_list", array("linked_class"=>'lnkContactToTicket', "ext_key_to_me"=>'ticket_id', "ext_key_to_remote"=>'contact_id', "allowed_values"=>null, "count_min"=>0, "count_max"=>0, "duplicates"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeLinkedSetIndirect("functionalcis_list", array("linked_class"=>'lnkFunctionalCIToTicket', "ext_key_to_me"=>'ticket_id', "ext_key_to_remote"=>'functionalci_id', "allowed_values"=>null, "count_min"=>0, "count_max"=>0, "duplicates"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeLinkedSet("workorders_list", array("linked_class"=>'WorkOrder', "ext_key_to_me"=>'ticket_id', "count_min"=>0, "count_max"=>0, "allowed_values"=>null, "depends_on"=>array(), "always_load_in_tables"=>false)));



		MetaModel::Init_SetZListItems('details', array (
  0 => 'ref',
  1 => 'org_id',
  2 => 'caller_id',
  3 => 'team_id',
  4 => 'agent_id',
  5 => 'title',
  6 => 'description',
  7 => 'operational_status',
  8 => 'start_date',
  9 => 'end_date',
  10 => 'last_update',
  11 => 'close_date',
  12 => 'private_log',
  13 => 'contacts_list',
  14 => 'functionalcis_list',
  15 => 'workorders_list',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'ref',
  1 => 'title',
  2 => 'description',
  3 => 'operational_status',
  4 => 'start_date',
  5 => 'end_date',
  6 => 'last_update',
  7 => 'close_date',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'ref',
  1 => 'org_id',
  2 => 'title',
  3 => 'caller_id',
  4 => 'team_id',
  5 => 'agent_id',
  6 => 'operational_status',
  7 => 'start_date',
));

	}




    public function DBInsertNoReload()
    {
          $oMutex = new iTopMutex('ticket_insert');
          $oMutex->Lock();
          $iNextId = MetaModel::GetNextKey(get_class($this));
          $sRef = $this->MakeTicketRef($iNextId);
          $this->Set('ref', $sRef);
          $iKey = parent::DBInsertNoReload();
          $oMutex->Unlock();
          return $iKey;
    }
        



        protected function MakeTicketRef($iNextId)
        {
                switch(get_class($this))
                {
                        case 'UserRequest':
                        $sFormat = 'R-%06d';
                        break;

                        case 'Incident':
                        $sFormat = 'I-%06d';
                        break;

                        case 'Change':
                        case 'RoutineChange':
                        case 'EmergencyChange':
                        case 'NormalChange':
                        $sFormat = 'C-%06d';
                        break;

                        case 'Problem':
                        $sFormat = 'P-%06d';
                        break;

                        default:
                        $sFormat = 'T-%06d';
                }
                return sprintf($sFormat, $iNextId);
        }
        

	/**
						* Instanciate an object of the relevant class, depending on the request type
						* @return DBObject
						*/
	static public function CreateFromServiceSubcategory($oServiceSubcategory)
	{
        $sType = $oServiceSubcategory->Get('request_type');
        if ($sType == 'incident')
        {
            if (!class_exists('Incident'))
            {
                throw new Exception('Could not create a ticket after the service '.$oServiceSubcategory->Get('friendlyname').' of type '.$sType.': unknown class "Incident"');
            }
            $oRet = new Incident();
        }
        else
        {
            if (!class_exists('UserRequest'))
            {
                throw new Exception('Could not create a ticket after the service '.$oServiceSubcategory->Get('friendlyname').' of type '.$sType.': unknown class "UserRequest"');
            }
            $oRet = new UserRequest();
        }
        return $oRet;
	}

}


class lnkContactToTicket extends cmdbAbstractObject
{
	public static function Init()
	{
		$aParams = array
		(
			'category' => 'bizmodel',
			'key_type' => 'autoincrement',
			'is_link' => true,
			'name_attcode' => array('ticket_id', 'contact_id'),
			'state_attcode' => '',
			'reconc_keys' => array('ticket_id', 'contact_id'),
			'db_table' => 'lnkcontacttoticket',
			'db_key_field' => 'id',
			'db_finalclass_field' => '',
		);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeExternalKey("ticket_id", array("targetclass"=>'Ticket', "allowed_values"=>null, "sql"=>'ticket_id', "is_null_allowed"=>false, "on_target_delete"=>DEL_AUTO, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("ticket_ref", array("allowed_values"=>null, "extkey_attcode"=>'ticket_id', "target_attcode"=>'ref', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("contact_id", array("targetclass"=>'Contact', "allowed_values"=>null, "sql"=>'contact_id', "is_null_allowed"=>false, "on_target_delete"=>DEL_AUTO, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("contact_email", array("allowed_values"=>null, "extkey_attcode"=>'contact_id', "target_attcode"=>'email', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeString("role", array("allowed_values"=>null, "sql"=>'role', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeEnum("role_code", array("allowed_values"=>new ValueSetEnum("manual,computed,do_not_notify"), "display_style"=>'list', "sql"=>'impact_code', "default_value"=>'manual', "is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));



		MetaModel::Init_SetZListItems('details', array (
  0 => 'ticket_id',
  1 => 'contact_id',
  2 => 'role_code',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'ticket_id',
  1 => 'contact_id',
  2 => 'role_code',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'ticket_id',
  1 => 'contact_id',
  2 => 'role_code',
));

	}


}


class lnkFunctionalCIToTicket extends cmdbAbstractObject
{
	public static function Init()
	{
		$aParams = array
		(
			'category' => 'bizmodel',
			'key_type' => 'autoincrement',
			'is_link' => true,
			'name_attcode' => array('ticket_id', 'functionalci_id'),
			'state_attcode' => '',
			'reconc_keys' => array('ticket_id', 'functionalci_id'),
			'db_table' => 'lnkfunctionalcitoticket',
			'db_key_field' => 'id',
			'db_finalclass_field' => '',
		);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeExternalKey("ticket_id", array("targetclass"=>'Ticket', "allowed_values"=>null, "sql"=>'ticket_id', "is_null_allowed"=>false, "on_target_delete"=>DEL_AUTO, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("ticket_ref", array("allowed_values"=>null, "extkey_attcode"=>'ticket_id', "target_attcode"=>'ref', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("ticket_title", array("allowed_values"=>null, "extkey_attcode"=>'ticket_id', "target_attcode"=>'title', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("functionalci_id", array("targetclass"=>'FunctionalCI', "allowed_values"=>null, "sql"=>'functionalci_id', "is_null_allowed"=>false, "on_target_delete"=>DEL_AUTO, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("functionalci_name", array("allowed_values"=>null, "extkey_attcode"=>'functionalci_id', "target_attcode"=>'name', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeString("impact", array("allowed_values"=>null, "sql"=>'impact', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeEnum("impact_code", array("allowed_values"=>new ValueSetEnum("manual,computed,not_impacted"), "display_style"=>'list', "sql"=>'impact_code', "default_value"=>'manual', "is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));



		MetaModel::Init_SetZListItems('details', array (
  0 => 'ticket_id',
  1 => 'functionalci_id',
  2 => 'impact_code',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'ticket_id',
  1 => 'functionalci_id',
  2 => 'impact_code',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'ticket_id',
  1 => 'functionalci_id',
  2 => 'impact_code',
));

	}


}


class WorkOrder extends cmdbAbstractObject
{
	public static function Init()
	{
		$aParams = array
		(
			'category' => 'bizmodel,searchable,incidentmgmt,requestmgmt,changemgmt,m2prequest',
			'key_type' => 'autoincrement',
			'name_attcode' => array('name'),
			'state_attcode' => 'status',
			'reconc_keys' => array('name', 'ticket_id'),
			'db_table' => 'workorder',
			'db_key_field' => 'id',
			'db_finalclass_field' => '',
			'icon' => utils::GetAbsoluteUrlModulesRoot().'itop-tickets/images/workorder.png',
		);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();
		MetaModel::Init_AddAttribute(new AttributeString("name", array("allowed_values"=>null, "sql"=>'name', "default_value"=>'', "is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeEnum("status", array("allowed_values"=>new ValueSetEnum("open,closed"), "display_style"=>'list', "sql"=>'status', "default_value"=>'open', "is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeText("description", array("allowed_values"=>null, "sql"=>'description', "default_value"=>'', "is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("ticket_id", array("targetclass"=>'Ticket', "allowed_values"=>null, "sql"=>'ticket_id', "is_null_allowed"=>false, "on_target_delete"=>DEL_AUTO, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("ticket_ref", array("allowed_values"=>null, "extkey_attcode"=>'ticket_id', "target_attcode"=>'ref', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("team_id", array("targetclass"=>'Team', "allowed_values"=>new ValueSetObjects("SELECT Team"), "sql"=>'team_id', "is_null_allowed"=>false, "on_target_delete"=>DEL_MANUAL, "depends_on"=>array(), "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("team_name", array("allowed_values"=>null, "extkey_attcode"=>'team_id', "target_attcode"=>'email', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalKey("agent_id", array("targetclass"=>'Person', "allowed_values"=>new ValueSetObjects("SELECT Person AS p JOIN lnkPersonToTeam AS l ON l.person_id=p.id JOIN Team AS t ON l.team_id=t.id WHERE t.id = :this->team_id"), "sql"=>'owner_id', "is_null_allowed"=>true, "on_target_delete"=>DEL_MANUAL, "depends_on"=>array('team_id'), "allow_target_creation"=>false, "display_style"=>'select', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeExternalField("agent_email", array("allowed_values"=>null, "extkey_attcode"=>'agent_id', "target_attcode"=>'email', "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeDateTime("start_date", array("allowed_values"=>null, "sql"=>'start_date', "default_value"=>'', "is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeDateTime("end_date", array("allowed_values"=>null, "sql"=>'end_date', "default_value"=>'', "is_null_allowed"=>false, "depends_on"=>array(), "always_load_in_tables"=>false)));
		MetaModel::Init_AddAttribute(new AttributeCaseLog("log", array("allowed_values"=>null, "sql"=>'log', "default_value"=>'', "is_null_allowed"=>true, "depends_on"=>array(), "always_load_in_tables"=>false)));

		// Lifecycle (status attribute: status)
		//
		MetaModel::Init_DefineStimulus(new StimulusUserAction("ev_close", array()));
		MetaModel::Init_DefineState(
			"open",
			array(
				"attribute_inherit" => '',
				"attribute_list" => array(
				),
			)
		);
		MetaModel::Init_DefineTransition("open", "ev_close", array("target_state"=>"closed", "actions"=>array(), "user_restriction"=>null));
		MetaModel::Init_DefineState(
			"closed",
			array(
				"attribute_inherit" => '',
				"attribute_list" => array(
				),
			)
		);


		MetaModel::Init_SetZListItems('details', array (
  0 => 'name',
  1 => 'status',
  2 => 'ticket_id',
  3 => 'team_id',
  4 => 'agent_id',
  5 => 'description',
  6 => 'start_date',
  7 => 'end_date',
));
		MetaModel::Init_SetZListItems('standard_search', array (
  0 => 'name',
  1 => 'status',
  2 => 'ticket_id',
  3 => 'team_id',
  4 => 'agent_id',
  5 => 'start_date',
  6 => 'end_date',
));
		MetaModel::Init_SetZListItems('list', array (
  0 => 'status',
  1 => 'ticket_id',
  2 => 'start_date',
  3 => 'end_date',
  4 => 'team_id',
  5 => 'agent_id',
));

	}



	public function UpdateParentTicketLog()
	{
		$oLog = $this->Get('log');
		$sLog = $oLog->GetModifiedEntry('html');
		if ($sLog != '')
		{
			$oTicket = MetaModel::GetObject('Ticket', $this->Get('ticket_id'), false);
			if ($oTicket)
			{
				$oTicket->Set('private_log', $sLog);
				$oTicket->DBUpdate();
			}
		}
	}


	protected function OnUpdate()
	{
		$this->UpdateParentTicketLog();
	}

}