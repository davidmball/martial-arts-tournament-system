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

require_once('DB/DataObject.php');
require 'configDB.php';
require 'utility.php';

if ($user_access == "admin" || $user_access == "manager" || $user_access == "steward") {

	if (isset($_POST["Submit_Update"])) {
	 //DB_DataObject::debugLevel(5);
	
		// checks first
		$user_input_passed = true;
		$user_input_passed = $user_input_passed & userinputcheckEmail($_POST["Email"]);
		$user_input_passed = $user_input_passed & userinputcheckPassword($_POST["New_Password"]);
	
		if (!$user_input_passed) {
			$primary = "Your details have not been updated because: ";
			$smarty->assign(array('primary' => $primary, 'level' => "error")); 
		} else {
			$user = DB_DataObject::factory('auth');
			$user->get($_POST["ID"]);
			$user->first_name = strip_tags($_POST["First_Name"]);
			$user->last_name = strip_tags($_POST["Last_Name"]);
			$user->email = strip_tags($_POST["Email"]);		
			$user->last_updated = date("Y-m-d H:i:s");
			if (!$user->update()) {
				$primary = "User (".$_POST["USERNAME"].") has not been updated";
				$smarty->assign(array('primary' => $primary, 'level' => "error")); 
			} else {
				if ($_POST["New_Password"] == "" && $_POST["New_Password_Repeat"] == "") {
					$primary = "User (".$_POST["USERNAME"].") has been updated";
					$smarty->assign(array('primary' => $primary, 'level' => "success"));
					EmailDetailsToUser($user, false, false); 
				} else {
					if ($_POST["New_Password"] != $_POST["New_Password_Repeat"]) {
						$primary = "The same new password was not entered.";
						$smarty->assign(array('primary' => $primary, 'level' => "error")); 
					} elseif (!$a->changePassword($username, $_POST["New_Password"])) {
						$primary = "User (".$_POST["USERNAME"].") password has not been updated";
						$smarty->assign(array('primary' => $primary, 'level' => "error"));
					} else {
						$primary = "User (".$_POST["USERNAME"].") has been updated including password.";
						$smarty->assign(array('primary' => $primary, 'level' => "success"));
					} 							
						
				}
			}
		}
	} 

	$user = DB_DataObject::factory('auth');
	$user->whereAdd("username = '".$user->escape($username)."'");

	$user->find();
	$user->fetch();
	
	$smarty->assign('user', array(
		  'ID'				=> $user->user_id,
          'USERNAME'        => $user->username,
          'ACCESS' 			=> $user->access,     
          'EMAIL'  			=> $user->email,     
          'FIRST_NAME' 		=> $user->first_name,
          'LAST_NAME'  		=> $user->last_name,
          'ACTIVE' 			=> $user->active,
          'LAST_UPDATED'	=> $user->last_updated 
       ));


} else {

	if (isset($_POST["Submit_Reset"])) {
		
		$user = DB_DataObject::factory('auth');
		$user->whereAdd("username = '".$_POST["USERNAME"]."'");
		$user->whereAdd("email = '".$_POST["Email"]."'");			
		if(!$user->find()) {
			$primary = "Username and/or email address do not match database records.";
			$smarty->assign(array('primary' => $primary, 'level' => "error")); 			
		} else {
			$user->fetch();

			$a = new Auth("DB", $auth_options, "loginFunction");
			$a->start();
			$a->setAuth($_POST["USERNAME"]);
			
			// generate random password
			$new_password = strrand(8);
			
			if  (!$a->changePassword($user->username, $new_password)) {
				$primary = "Error with resetting password.";
				$smarty->assign(array('primary' => $primary, 'level' => "error")); 				
			} else {
				EmailDetailsToUser($user, false, $new_password); 				
				$primary = "Password for (".$_POST["USERNAME"].") has been reset and emailed.";
				$smarty->assign(array('primary' => $primary, 'level' => "success"));
			}
			$a->logout();
		}	
	
	}


}
	$smarty->display('my_account.tpl');
?>
