<?php
/*
    Martial Arts Tournament System (MATS)
    Copyright (C) 2015 David Ball (davidmichaelball @ gmail . com) and Ruth Schulz

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>
*/
require_once('../../tournament_settings.php');
require '../libs/Smarty.class.php';
$smarty = new Smarty;
require 'loginlogout.php';
require 'configDB.php';
if ($user_access != "admin") {
	$smarty->display('denied.tpl');
	exit;
}
$smarty->assign('current_menu', "Admin");

require 'utility.php';

$delete_success = false;

		
if(isset($_POST["Submit"])) {
// DB_DataObject::debugLevel(5);

	if ($_POST["ID"] == "new") {
		$represent = DB_DataObject::factory('represents');
		$represent->name = strip_tags($_POST["Represents"]);
		$represent->active = isset($_POST["Active"]);		
		$represent->last_updated = date("Y-m-d H:i:s");
		if (!($new_id = $represent->insert())) {
			$primary = "Represents has not been added.";
			$smarty->assign(array('primary' => $primary, 'level' => "error")); 
		} else {
			$primary = "Represents (".$new_id.") has been added.";
			$smarty->assign(array('primary' => $primary, 'level' => "success"));  
		}	
				
	} else {
		$represent = DB_DataObject::factory('represents');
		$represent->get($_POST["ID"]);
		$represent->name = strip_tags($_POST["Represents"]);
		$represent->active = isset($_POST["Active"]);		
		$represent->last_updated = date("Y-m-d H:i:s");
		if (!$represent->update()) {
			$primary = "Represents (".$_POST["Represents"].") has not been updated";
			$smarty->assign(array('primary' => $primary, 'level' => "error")); 
		} else {
			$primary = "Represents (".$_POST["Represents"].") has been updated";
			$smarty->assign(array('primary' => $primary, 'level' => "success"));  
		}
	}

} elseif (isset($_POST["Delete"])) {
	$represent = DB_DataObject::factory('represents');
	$represent->get($_POST["ID"]);
	if (!$represent->delete()) {
		$primary = "Represents (".$_POST["Represents"].") has not been deleted";
		$smarty->assign(array('primary' => $primary, 'level' => "error")); 			
	} else {
		$delete_success = true;
		$primary = "Represents (".$_POST["Represents"].") has been deleted";
		$smarty->assign(array('primary' => $primary, 'level' => "success")); 		
	}
 
}

if (isset($_POST["Delete"]) && $delete_success == true) {

	$smarty->assign('delete_success', $delete_success);

} elseif (isset($_GET["ID"]) && $_GET["ID"] == "new") {
	
	$command = "Enter details for a new division.";
	$smarty->assign("command", $command); 
	$smarty->assign('represent', array('ID' => "new"));
	
} else {
//	if(!isset($_POST["Submit"])) {
		$command = "Edit details and submit or delete.";
		$smarty->assign("command", $command); 
//	}

	$represent = DB_DataObject::factory('represents');
	if (isset($_POST["ID"]) && $_POST["ID"] == "new") {
		$represent->represents_id = $new_id;
	} else {
		$represent->represents_id = $_REQUEST["ID"];	
	}
	$represent->find();
	$represent->fetch();
	
	$smarty->assign('represent', array(
		  'ID'				=> $represent->represents_id,  
          'REPRESENTS'     	=> $represent->name,
          'ACTIVE' 			=> $represent->active,
          'LAST_UPDATED'	=> $represent->last_updated 
       ));
    
}

$smarty->display('edit_represent.tpl');

?>