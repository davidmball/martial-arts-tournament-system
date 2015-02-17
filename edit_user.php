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

$user_input_passed = true;
	
if(isset($_POST["Submit"])) {
 //DB_DataObject::debugLevel(5);

	// checks first

	$user_input_passed = true; //$user_input_passed & userinputcheckEmail($_POST["Email"]); this failed on  kbr08132@bigpond.net.au 
	
	if (!$user_input_passed) {
		$primary = "User has not been added because: ";
		$smarty->assign(array('primary' => $primary, 'level' => "error")); 
	} else if ($_POST["ID"] == "new") {
		$user = DB_DataObject::factory('auth');
		$user->username = strip_tags($_POST["USERNAME"]);
		$user->title = strip_tags($_POST["Title"]);
		$user->first_name = strip_tags($_POST["First_Name"]);
		$user->last_name = strip_tags($_POST["Last_Name"]);

		$user->email = strip_tags($_POST["Email"]);
		$user->access = strip_tags($_POST["Access"]);
		$user->active = isset($_POST["Active"]);		
		$user->last_updated = date("Y-m-d H:i:s");
		if (!($new_id = $user->insert())) {
			$primary = "User has not been added";
			$smarty->assign(array('primary' => $primary, 'level' => "error")); 
		} else {
			$primary = "User (".$new_id.") has been added";
			$smarty->assign(array('primary' => $primary, 'level' => "success"));  
		}	
		
		// generate random password
		$new_password = strrand(8);
		if (!$a->changePassword($user->username, $new_password)) {
			$primary = "User added but error with setting password.";
			$smarty->assign(array('primary' => $primary, 'level' => "error")); 				
		} else {
			EmailDetailsToUser($user, true, $new_password); 				
			$primary = "User added and password for (".$_POST["USERNAME"].") has been emailed.";
			$smarty->assign(array('primary' => $primary, 'level' => "success"));
		}

		$auth_represents_connection = DB_DataObject::factory('auth_represents_connection');
 		$auth_represents_connection->tournament_id = $active_tournament->tournament_id; // zzz
		$auth_represents_connection->user_id = $new_id;
		if (isset($_POST["Represents"])) {
			while ($temp_value = current($_POST["Represents"])) {
				$auth_represents_connection->represents_id = $temp_value;
				$auth_represents_connection->insert();
				next($_POST["Represents"]);
			}
		}
				
	} else {
		$auth_represents_connection = DB_DataObject::factory('auth_represents_connection');
 		$auth_represents_connection->tournament_id = $active_tournament->tournament_id; 	// zzz		
		$auth_represents_connection->user_id = $_POST["ID"];
		$auth_represents_connection->find();
		while ($auth_represents_connection->fetch()) {
			$auth_represents_connection->delete();	
		}
		$auth_represents_connection = DB_DataObject::factory('auth_represents_connection');
 		$auth_represents_connection->tournament_id = $active_tournament->tournament_id; // zzz
		$auth_represents_connection->user_id = $_POST["ID"];
		if (isset($_POST["Represents"])) {
			while ($temp_value = current($_POST["Represents"])) {
				$auth_represents_connection->represents_id = $temp_value;
				$auth_represents_connection->insert();
				next($_POST["Represents"]);
			}
		}
		
		$user = DB_DataObject::factory('auth');
		$user->get($_POST["ID"]);
		$user->username = strip_tags($_POST["USERNAME"]);
		$user->title = strip_tags($_POST["Title"]);		
		$user->first_name = strip_tags($_POST["First_Name"]);
		$user->last_name = strip_tags($_POST["Last_Name"]);
		$user->email = strip_tags($_POST["Email"]);
		$user->access = strip_tags($_POST["Access"]);
		$user->active = isset($_POST["Active"]);		
		$user->last_updated = date("Y-m-d H:i:s");
		if (!$user->update()) {
			$primary = "User (".$_POST["USERNAME"].") has not been updated";
			$smarty->assign(array('primary' => $primary, 'level' => "error")); 
		} else {
			$primary = "User (".$_POST["USERNAME"].") has been updated";
			$smarty->assign(array('primary' => $primary, 'level' => "success"));  
		}
	}

} elseif (isset($_POST["Delete"])) {
	$user = DB_DataObject::factory('auth');
	$user->get($_POST["ID"]);
	if (!$user->delete()) {
		$primary = "User (".$_POST["USERNAME"].") has not been deleted";
		$smarty->assign(array('primary' => $primary, 'level' => "error")); 			
	} else {
		$delete_success = true;
		$primary = "User (".$_POST["USERNAME"].") has been deleted";
		$smarty->assign(array('primary' => $primary, 'level' => "success")); 		
	}
 
}

if (isset($_POST["Delete"]) && $delete_success == true) {

	$smarty->assign('delete_success', $delete_success);

} elseif (isset($_GET["ID"]) && $_GET["ID"] == "new" || (!$user_input_passed)) {
	
	$command = "Enter details for a new user";
	$smarty->assign("command", $command); 
	$smarty->assign('user', array('ID' => "new"));
	
} else {

	$command = "Edit details and submit or delete <a href=\"edit_user.php?ID=new\">add new user</a>.";
	$smarty->assign("command", $command); 

	$user = DB_DataObject::factory('auth');
	if (isset($_POST["ID"]) && $_POST["ID"] == "new") {
		$user->user_id = $new_id;
	} else {
		$user->user_id = $_REQUEST["ID"];

	}
	$user->find();
	$user->fetch();
	
	$smarty->assign('user', array(
		  'ID'				=> $user->user_id,
          'USERNAME'        => $user->username,
          'ACCESS' 			=> $user->access,     
          'EMAIL'  			=> $user->email,     
  		  'TITLE'			=> $user->title,
          'FIRST_NAME' 		=> $user->first_name,
          'LAST_NAME'  		=> $user->last_name,
          'ACTIVE' 			=> $user->active,
          'LAST_UPDATED'	=> $user->last_updated 
       ));
  

		$auth_represents_connection = DB_DataObject::factory('auth_represents_connection');
 		$auth_represents_connection->tournament_id = $active_tournament->tournament_id; 	// zzz				
		$auth_represents_connection->user_id = $user->user_id;
		$auth_represents_connection->find();
		$temp_selection_array = array();
		while ($auth_represents_connection->fetch())  { 	
			$temp_selection_array[$auth_represents_connection->represents_id] = $auth_represents_connection->represents_id;
		}
		
		$smarty->assign('represents_selection', $temp_selection_array);

}

  	$temp_array = array();
 	$represents_list = DB_DataObject::factory('represents');
 	$represents_list->orderBy('name');
 	$represents_list->find();
 	while ($represents_list->fetch())
 		$temp_array[$represents_list->represents_id] = $represents_list->name;
   $smarty->assign('represents_list', $temp_array);  

$smarty->display('edit_user.tpl');

?>