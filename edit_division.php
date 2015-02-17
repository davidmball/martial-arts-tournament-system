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
		$division = DB_DataObject::factory('divisions');
		$division->sequence = strip_tags($_POST["Sequence"]);		
		$division->name = strip_tags($_POST["Name"]);
		$division->tournament_id = $active_tournament->tournament_id;
		$division->rounds = strip_tags($_POST["Rounds"]);
		$division->round_min = strip_tags($_POST["Round_Min"]);
		$division->break_min = strip_tags($_POST["Break_Min"]);
		$division->minor_final = strip_tags($_POST["Minor_Final"]);
		$division->type = strip_tags($_POST["Type"]);
		$division->event_id = current($_POST["Event_ID"]);				
		$division->section_id = current($_POST["Section_ID"]);
		$division->technique1 = strip_tags($_POST["Technique1"]);
		$division->technique2 = strip_tags($_POST["Technique2"]);
		$division->technique3 = strip_tags($_POST["Technique3"]);
		$division->technique4 = strip_tags($_POST["Technique4"]);
		$division->technique5 = strip_tags($_POST["Technique5"]);
														
		if (!($new_id = $division->insert())) {
			$primary = "Division has not been added.";
			$smarty->assign(array('primary' => $primary, 'level' => "error")); 
		} else {
			$primary = "Division (".$new_id.") has been added.";
			$smarty->assign(array('primary' => $primary, 'level' => "success"));  
		}	

		if (strip_tags($_POST["Type"]) == "Repercharge" || strip_tags($_POST["Type"]) == "Elimination") {
			Clear_Results_And_Init_Division($_POST["ID"]);
		}
			
	} else {
		// store elements that we want to test to see if they change because they affect the draw
		$division = DB_DataObject::factory('divisions');
		$division->division_id = $_POST["ID"];
		$division->find();
		$division->fetch();
		$type = $division->type;
		$minor_final = $division->minor_final;
	
		$division = DB_DataObject::factory('divisions');
		$division->get($_POST["ID"]);
		$division->tournament_id = $active_tournament->tournament_id;
		$division->sequence= strip_tags($_POST["Sequence"]);				
		$division->name = strip_tags($_POST["Name"]);
		$division->rounds = strip_tags($_POST["Rounds"]);
		$division->round_min = strip_tags($_POST["Round_Min"]);
		$division->break_min = strip_tags($_POST["Break_Min"]);
		$division->minor_final = strip_tags($_POST["Minor_Final"]);
		$division->type = strip_tags($_POST["Type"]);				
		$division->event_id = current($_POST["Event_ID"]);
		$division->section_id = current($_POST["Section_ID"]);
		$division->technique1 = strip_tags($_POST["Technique1"]);
		$division->technique2 = strip_tags($_POST["Technique2"]);
		$division->technique3 = strip_tags($_POST["Technique3"]);
		$division->technique4 = strip_tags($_POST["Technique4"]);
		$division->technique5 = strip_tags($_POST["Technique5"]);
		if (!$division->update()) {
			$primary = "Division (".$_POST["ID"].") has not been updated";
			$smarty->assign(array('primary' => $primary, 'level' => "error")); 
		} else {
			$primary = "Division (".$_POST["ID"].") has been updated";
			$smarty->assign(array('primary' => $primary, 'level' => "success"));  
		}
		
		if (strip_tags($_POST["Type"]) == "Repercharge" || strip_tags($_POST["Type"]) == "Elimination") {
			// if any of the tested elements has changed then clear the results an reinit the division
			if ($type != $_POST["Type"] || $minor_final != $_POST["Minor_Final"]) {
				Clear_Results_And_Init_Division($_POST["ID"]);
			}
		}
	}

} elseif (isset($_POST["Delete"])) {
	
	$division = DB_DataObject::factory('divisions');
	$division->get($_POST["ID"]);
	if (!$division->delete()) {
		$primary = "Division (".$_POST["ID"].") has not been deleted";
		$smarty->assign(array('primary' => $primary, 'level' => "error")); 			
	} else {
		$delete_success = true;
		$primary = "Division (".$_POST["ID"].") has been deleted";
		$smarty->assign(array('primary' => $primary, 'level' => "success")); 		
	}
}

if (isset($_POST["Delete"]) && $delete_success == true) {

	$smarty->assign('delete_success', $delete_success);

	// we also need to set any competitors that are assigned to be unassigned
	Unassign_Division($_POST["ID"], current($_POST["Event_ID"]) );
	// AND we need to delete any results for this division.
	Clear_Results_And_Init_Division($_POST["ID"]);
	
} elseif (isset($_GET["ID"]) && $_GET["ID"] == "new") {
	
	$command = "Enter details for a new division.";
	$smarty->assign("command", $command); 
	$smarty->assign('division', array('ID' => "new"));
	
} else {

		$command = "Edit details and submit or delete.";
		$smarty->assign("command", $command); 


	$division = DB_DataObject::factory('divisions');
	if (isset($_POST["ID"]) && $_POST["ID"] == "new") {
		$division->division_id = $new_id;
	} else {
		$division->division_id = $_REQUEST["ID"];	
	}
	$division->find();
	$division->fetch();

	$smarty->assign('division', array(
		  'ID'				=> $division->division_id,
		  'SEQUENCE' => $division->sequence,  
          'NAME'     		=> $division->name,
			'ROUNDS'		=> $division->rounds,
			'ROUND_MIN'		=> $division->round_min,
			'BREAK_MIN'		=> $division->break_min,
			'MINOR_FINAL'	=> $division->minor_final,
			'TYPE'			=> $division->type,
			'EVENT_ID'		=> $division->event_id,
			'SECTION_ID'	=> $division->section_id,
			'TECHNIQUE1'	=> $division->technique1,
			'TECHNIQUE2'	=> $division->technique2,
			'TECHNIQUE3'	=> $division->technique3,
			'TECHNIQUE4'	=> $division->technique4,
			'TECHNIQUE5'	=> $division->technique5												
       ));
    
    
}
     $temp_array = array();
 	$events_list = DB_DataObject::factory('events');
 	$events_list->orderBy('name');
 	$events_list->find();
 	while ($events_list->fetch())
 		$temp_array[$events_list->event_id] = $events_list->name;
   $smarty->assign('events_list', $temp_array);  

     $temp_array2 = array();
 	$sections_list = DB_DataObject::factory('sections');
 	$sections_list->tournament_id = $active_tournament->tournament_id;
 	$sections_list->orderBy('name');
 	$sections_list->find();
 	while ($sections_list->fetch())
 		$temp_array2[$sections_list->section_id] = $sections_list->name;
   $smarty->assign('sections_list', $temp_array2); 

$smarty->display('edit_division.tpl');

?>