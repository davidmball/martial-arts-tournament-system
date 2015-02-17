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

echo "<br><br><br><br>";

		
if(isset($_POST["Submit"])) {


	if ($_POST["ID"] == "new") {
		$section = DB_DataObject::factory('sections');
		$section->name = strip_tags($_POST["Name"]);
		$section->part = strip_tags($_POST["Part"]);
		$section->tournament_id = $active_tournament->tournament_id;					
		$section->date = $_POST["Date_Year"]."-".$_POST["Date_Month"]."-".$_POST["Date_Day"];		
		if (!($new_id = $section->insert())) {
			$primary = "section has not been added.";
			$smarty->assign(array('primary' => $primary, 'level' => "error")); 
		} else {
			$primary = "section (".$new_id.") has been added.";
			$smarty->assign(array('primary' => $primary, 'level' => "success"));  
		}	
					
	} else {
		$section = DB_DataObject::factory('sections');
		$section->get($_POST["ID"]);
		$section->tournament_id = $active_tournament->tournament_id;		
		$section->name = strip_tags($_POST["Name"]);	
		$section->part = strip_tags($_POST["Part"]);
		$section->date = $_POST["Date_Year"]."-".$_POST["Date_Month"]."-".$_POST["Date_Day"];			
		if (!$section->update()) {
			$primary = "section (".$_POST["ID"].") has not been updated";
			$smarty->assign(array('primary' => $primary, 'level' => "error")); 
		} else {
			$primary = "section (".$_POST["ID"].") has been updated";
			$smarty->assign(array('primary' => $primary, 'level' => "success"));  
		}
		
	}

} elseif (isset($_POST["Delete"])) {
	
	$section = DB_DataObject::factory('sections');
	$section->get($_POST["ID"]);
	if (!$section->delete()) {
		$primary = "section (".$_POST["ID"].") has not been deleted";
		$smarty->assign(array('primary' => $primary, 'level' => "error")); 			
	} else {
		$delete_success = true;
		$primary = "section (".$_POST["ID"].") has been deleted";
		$smarty->assign(array('primary' => $primary, 'level' => "success")); 		
	}
}

if (isset($_POST["Delete"]) && $delete_success == true) {

	$smarty->assign('delete_success', $delete_success);
	
} elseif (isset($_GET["ID"]) && $_GET["ID"] == "new") {
	
	$command = "Enter details for a new section.";
	$smarty->assign("command", $command); 
	$smarty->assign('section', array('ID' => "new"));
	
} else {

		$command = "Edit details and submit or delete.";
		$smarty->assign("command", $command); 


	$section = DB_DataObject::factory('sections');
	if (isset($_POST["ID"]) && $_POST["ID"] == "new") {
		$section->section_id = $new_id;
	} else {
		$section->section_id = $_REQUEST["ID"];	
	}
	$section->find();
	$section->fetch();

	$smarty->assign('section', array(
		  'ID'				=> $section->section_id,  
          'NAME'     		=> $section->name,
		  'DATE'			=> $section->date,
		  'PART'			=> $section->part,
       ));
    
    
}

$smarty->display('edit_sections.tpl');

?>

