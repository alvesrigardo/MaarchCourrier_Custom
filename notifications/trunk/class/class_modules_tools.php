<?php 
/**
* modules tools Class for physical archives
*
*  Contains all the functions to  modules tables for physical archives
*
* @package  maarch
* @version 3.0
* @since 10/2005
* @license GPL v3
* @author  Loic Vinet  <dev@maarch.org>
* 
*/

class notifications
{

/**
	* Build Maarch module tables into sessions vars with a xml configuration file
	*/
	function build_config($conf)
	{
		
		$xmlconfig = simplexml_load_file($conf);
		foreach($xmlconfig->CONFIG as $CONFIG)
		{
				$_SESSION['config']['databaseserver'] = utf8_decode((string) $CONFIG->databaseserver);
				$_SESSION['config']['databaseserverport'] = utf8_decode((string) $CONFIG->databaseserverport);
				$_SESSION['config']['databasename'] = utf8_decode((string) $CONFIG->databasename);
				$_SESSION['config']['databaseuser'] = utf8_decode((string) $CONFIG->databaseuser);
				$_SESSION['config']['databasetype'] = utf8_decode((string) $CONFIG->databasetype);
				$_SESSION['config']['databasepassword'] = utf8_decode((string) $CONFIG->databasepassword);
			
				$_SESSION['config']['businessapppath'] = (string) $CONFIG->businessapppath;
				$_SESSION['config']['businessappurl'] = (string) $CONFIG->businessappurl;
				$_SESSION['config']['MaarchDirectory'] = utf8_decode((string) $CONFIG->MaarchDirectory);
				
				$_SESSION['config']['lang'] = utf8_decode((string) $CONFIG->lang);
				$_SESSION['config']['mail'] = utf8_decode((string) $CONFIG->mailfrom);
				$_SESSION['config']['debug'] = utf8_decode((string) $CONFIG->debug);
				$_SESSION['config']['MaarchURL'] = utf8_decode((string) $CONFIG->MaarchURL);
				$_SESSION['config']['tag_when_send'] = utf8_decode((string) $CONFIG->tag_when_send);
		}

		$i=0;

		
		foreach($xmlconfig->COLLECTION as $COLLECTION)
		{
			$_SESSION['collection'][$i] = array(
												"id" => utf8_decode((string) $COLLECTION->id),
												"label" => utf8_decode((string) $COLLECTION->label),
												"table" => utf8_decode((string) $COLLECTION->table),
												"view" => utf8_decode((string) $COLLECTION->view)
												);
			$j=0;
			foreach($COLLECTION->extensions as $EXTENSIONS)
			{
					$_SESSION['collection'][$i]['extensions'][$j] = utf8_decode((string) $EXTENSIONS->table);
					$j++;
			}
			$i++;
		}
		
		
		//Use this value par default for Maarch LetterBox v3
		$_SESSION['used_table'] = $_SESSION['collection'][0]['table'];
		
		$_SESSION['ressources']['letterbox_view'] = $_SESSION['collection'][0]['view'];
		
		foreach($xmlconfig->TABLENAME as $TABLENAME)
		{
			$_SESSION['tablename']['doctypes'] = utf8_decode((string) $TABLENAME->doctypes);
			$_SESSION['tablename']['history'] = utf8_decode((string) $TABLENAME->history);
			$_SESSION['tablename']['listinstance'] = utf8_decode((string) $TABLENAME->listinstance);
			$_SESSION['tablename']['users'] = utf8_decode((string) $TABLENAME->users);
			$_SESSION['tablename']['user_abs'] = utf8_decode((string) $TABLENAME->user_abs);
			$_SESSION['tablename']['entities'] = utf8_decode((string) $TABLENAME->entities);
			$_SESSION['tablename']['ent_entities'] = utf8_decode((string) $TABLENAME->entities);
			$_SESSION['tablename']['ent_users_entities'] = utf8_decode((string) $TABLENAME->users_entities);
			$_SESSION['tablename']['contacts'] = utf8_decode((string) $TABLENAME->contacts);
			$_SESSION['tablename']['mlb_doctype_ext'] = utf8_decode((string) $TABLENAME->mlb_doctype_ext);
		}
		
		foreach($xmlconfig->TEMPLATES as $TEMPLATE)
		{
			$_SESSION['templates_directory'] = utf8_decode((string) $TEMPLATE->templates_directory);
			$_SESSION['templates']['notif'] = utf8_decode((string) $TEMPLATE->notif);
			$_SESSION['templates']['notif_copy'] = utf8_decode((string) $TEMPLATE->notif_copy);
			$_SESSION['templates']['alarm1'] = utf8_decode((string) $TEMPLATE->alarm1);
			$_SESSION['templates']['alarm1_copy'] = utf8_decode((string) $TEMPLATE->alarm1_copy);
			$_SESSION['templates']['alarm2'] = utf8_decode((string) $TEMPLATE->alarm2);
			$_SESSION['templates']['alarm2_copy'] = utf8_decode((string) $TEMPLATE->alarm2_copy);
			
		}
		
		foreach($xmlconfig->FEATURES as $FEATURES)
		{
			$_SESSION['features']['copy_for_notif'] = utf8_decode((string) $FEATURES->copy_for_notif);
			$_SESSION['features']['copy_for_alarm1'] = utf8_decode((string) $FEATURES->copy_for_alarm1);
			$_SESSION['features']['copy_for_alarm2'] = utf8_decode((string) $FEATURES->copy_for_alarm2);
		}
		foreach($xmlconfig->DEBUG as $DEBUG)
		{
			$_SESSION['debug']['send_mail'] = utf8_decode((string) $DEBUG->send_mail);
			$_SESSION['debug']['tag_when_send'] = utf8_decode((string) $DEBUG->tag_when_send);
			$_SESSION['debug']['console'] = utf8_decode((string) $DEBUG->console);
			
		}
	}
	
	function check_compatibility() 
	{
		if ($_SESSION['tablename']['mlb_doctype_ext'] == '') $_SESSION['tablename']['mlb_doctype_ext'] = "mlb_doctype_ext";
	}
	
	function build_modules_tables() 
	{
		
	}
	
	function load_module_var_session() 
	{
		
	}
}
