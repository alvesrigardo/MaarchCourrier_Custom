<?php

/**
* File : entity_up_db.php
*
* Modify entity in database after form
*
* @package  Maarch Framework 3.0
* @version 1
* @since 03/2009
* @license GPL
* @author  C�dric Ndoumba  <dev@maarch.org>
*/
//include('core/init.php');

//require_once("core/class/class_functions.php");

//require_once("core/class/class_db.php");
require_once('modules'.DIRECTORY_SEPARATOR.'entities'.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'class_manage_entities.php');

//require_once("core/class/class_core_tools.php");
$admin = new core_tools();

$admin->load_lang();
$admin->test_admin('manage_entities', 'entities');
$ent = new entity();

$ent->addupentity("up");
?>
