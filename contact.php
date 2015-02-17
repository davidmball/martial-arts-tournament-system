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

require 'utility.php';

$smarty->assign('current_menu', "Contact");

if(isset($_POST["Submit"])) {
	
		$user_input_passed = true;
	$user_input_passed = $user_input_passed & userinputcheckEmail($_POST["Email"]);
	
	if (!($_POST["Spam_Test"] == 9 || $_POST["Spam_Test"] == "nine"  || $_POST["Spam_Test"] == "Nine"  || $_POST["Spam_Test"] == "NINE")) {
		$smarty->append("error_string", "Failed the spam test.");
		$user_input_passed = false;
	}
	
	if (!$user_input_passed) {
		$primary = "Contacting or signing up did not work because: ";
		$smarty->assign(array('primary' => $primary, 'level' => "error")); 
	} else {
	
		global $from_address;
		ini_set('sendmail_from', $_POST["Email"]);
		
		$body_string = $_POST["Body"]."\n\n";
		$body_string .= "First Name: ".$_POST["First_Name"]."\n";
		$body_string .= "Last Name: ".$_POST["Last_Name"]."\n";		
		$body_string .= "Represents: ".$_POST["Represents"]."\n";	
		$body_string .= "Email: ".$_POST["Email"]."\n";
				
		if (!mail($from_address, $_POST["Subject"], addslashes(strip_tags($body_string))) ) {
			$primary = "Email has not been sent. Please email tournament@bairui.com";
			$smarty->assign(array('primary' => $primary, 'level' => "error")); 
		} else {
			$primary = "Email has been sent. You should get a reply within 48 hours.";
			$smarty->assign(array('primary' => $primary, 'level' => "success"));  
		}
		
		ini_restore('sendmail_from');
	}
	
}

	$command = "Signing up is for team managers/instructors only.</br>";
	$command .= "The account will be verified by an admin before it will be activated.</br>";
	$smarty->assign("command", $command); 


$smarty->display('contact.tpl');

?>