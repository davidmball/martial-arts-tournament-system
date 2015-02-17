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
if ($user_access != "admin" && $user_access != "manager") {
	$smarty->display('denied.tpl');
	exit;
}
$smarty->assign('current_menu', "Registration");
require 'utility.php';

//DB_DataObject::debugLevel(5);
// need to test that this person is a manager and can see/edit this persons details
// ie for if they attempt to edit the url
if ($user_access == "manager" && isset($_GET["ID"]) && $_GET["ID"] != "new") {
	
	$competitors = DB_DataObject::factory('competitors');
	$competitors->whereAdd("tournament_id = ".$competitors->escape($active_tournament->tournament_id));
	$competitors->competitor_id = $competitors->escape($_GET["ID"]);
	$competitors->find();
	$competitors->fetch();
	
	$auth_represents_connection = DB_DataObject::factory('auth_represents_connection');
 	
 	$auth_represents_connection->whereAdd("represents_id = ".$competitors->represents_id);
 	$auth_represents_connection->whereAdd("tournament_id = ".$active_tournament->tournament_id); 	// zzz
	$auth_represents_connection->whereAdd("user_id = '".$user_id."'");
 	if ($auth_represents_connection->find() == 0) {
 		$smarty->assign('access_denied', "You do not have permission to edit this competitor's details.");	
 	}

}

// need to check if the user is a manager and editing has been disabled for managers
if ($user_access == "manager" && !$active_tournament->allow_managers_to_edit) {
	$smarty->assign('access_denied', "Managers are currently not allowed to edit competitor details.");	
}

$delete_success = false;
	
	$user_input_passed = true;	
		
$smarty->assign('DOB_end', date("Y") - 1);
$smarty->assign('DOB_start', date("Y") - 100);		
		
if(isset($_POST["Submit"])) {

	$smarty->clear_cache('registration.tpl');

//	$user_input_passed = $user_input_passed & userinputcheckWeight($_POST["Weight"]);
//	$user_input_passed = $user_input_passed & userinputcheckHeight($_POST["Height"]);
//	$user_input_passed = $user_input_passed & userinputcheckFirstName($_POST["First_Name"]);
//	$user_input_passed = $user_input_passed & userinputcheckLastName($_POST["Last_Name"]);
//	$user_input_passed = $user_input_passed & userinputcheckPhoneNumber($_POST["Last_Name"]);
	
	if (!$user_input_passed) {
		$primary = "Competitor has not been added/updated because: ";
		$smarty->assign(array('primary' => $primary, 'level' => "error")); 
	} else if ($_POST["ID"] == "new") {
		$competitor = DB_DataObject::factory('competitors');
		$competitor->tournament_id = $active_tournament->tournament_id;
		$competitor->enrolment = "Registered";
		$competitor->title = strip_tags($_POST["Title"]);
		$competitor->first_name = strip_tags($_POST["First_Name"]);
		$competitor->middle_name = strip_tags($_POST["Middle_Name"]);		
		$competitor->last_name = strip_tags($_POST["Last_Name"]);
		$competitor->DOB = $_POST["DOB_Year"]."-".$_POST["DOB_Month"]."-".$_POST["DOB_Day"];
		$competitor->weight = strip_tags($_POST["Weight"]);
		$competitor->height = strip_tags($_POST["Height"]);
		$competitor->rank_id = strip_tags($_POST["Rank"]);
		$competitor->phone = strip_tags($_POST["Phone"]);
		$competitor->gender = $_POST["Gender"];
		$competitor->represents_id = strip_tags($_POST["Represents"]);
		$competitor->comments = strip_tags($_POST["Comments"]);
		$competitor->red_card = strip_tags($_POST["RedCard"]);		
		$competitor->last_updated = date("Y-m-d H:i:s");
		
		$competitor->competitor_count = 0;	// this means it is an individual
		$competitor->team_competitor_id1 = 0;
		$competitor->team_competitor_id2 = 0;
		$competitor->team_competitor_id3 = 0;
		$competitor->team_competitor_id4 = 0;
		$competitor->team_competitor_id5 = 0;
		$competitor->team_competitor_id6 = 0;				
								
		$competitor->paid_amount = $_POST["Paid_Amount"];	
		
		$competitor->overall_place = 0;
		$competitor->overall_description = "";
//	DB_DataObject::debugLevel(5);						
		if (!($new_id = $competitor->insert())) {
			$primary = "Competitor has not been added";
			$smarty->assign(array('primary' => $primary, 'level' => "error")); 
		} else {
			$primary = "Competitor (".$new_id.") has been added";
			$smarty->assign(array('primary' => $primary, 'level' => "success"));  
		}	
//	DB_DataObject::debugLevel(0);
	} else {
		$competitor = DB_DataObject::factory('competitors');
		$competitor->get($_POST["ID"]);
		$competitor->enrolment = $_POST["Enrolment"];
		$competitor->title = strip_tags($_POST["Title"]);
		$competitor->first_name = strip_tags($_POST["First_Name"]);
		$competitor->middle_name = strip_tags($_POST["Middle_Name"]);		
		$competitor->last_name = strip_tags($_POST["Last_Name"]);
		$competitor->DOB = $_POST["DOB_Year"]."-".$_POST["DOB_Month"]."-".$_POST["DOB_Day"];
		$competitor->weight = strip_tags($_POST["Weight"]);
		$competitor->height = strip_tags($_POST["Height"]);
		$competitor->rank_id = strip_tags($_POST["Rank"]);
		$competitor->phone = strip_tags($_POST["Phone"]);
		$competitor->gender = $_POST["Gender"];
		$competitor->represents_id = strip_tags($_POST["Represents"]);
		$competitor->comments = strip_tags($_POST["Comments"]);
		$competitor->red_card = strip_tags($_POST["RedCard"]);		
		$competitor->last_updated = date("Y-m-d H:i:s");

		$competitor->competitor_count = 0;	// this means it is an individual
		$competitor->team_competitor_id1 = 0;
		$competitor->team_competitor_id2 = 0;
		$competitor->team_competitor_id3 = 0;
		$competitor->team_competitor_id4 = 0;
		$competitor->team_competitor_id5 = 0;
		$competitor->team_competitor_id6 = 0;

		$competitor->paid_amount = $_POST["Paid_Amount"];			
					
		if (!$competitor->update()) {
			$primary = "Competitor (".$_POST["ID"].") has not been updated";
			$smarty->assign(array('primary' => $primary, 'level' => "error")); 
		} else {
			$primary = "Competitor (".$_POST["ID"].") has been updated";
			$smarty->assign(array('primary' => $primary, 'level' => "success"));  
		}	
		
	}

	// write the user selected events to an array
	// for all events in this tournament
	//   if it was user selected 
	//     if not in the table
	//		 create entry
	//   else
	//     if in the table
	//       remove entry
	if ($_POST["ID"] == "new") {
		$edit_id = $new_id;
	} else {
		$edit_id = $_POST["ID"];
	}
	$user_events = array();
	while(current($_POST["Events"])) {
		$user_events[current($_POST["Events"])] = true; 
		next($_POST["Events"]);
	}		
	
	$tournament_events_list = DB_DataObject::factory('tournament_events');
	$tournament_events_list->tournament_id = $active_tournament->tournament_id;
	$tournament_events_list->find();
	
	while ($tournament_events_list->fetch()) {
		if (isset($user_events[$tournament_events_list->event_id])) {
			$competitor_events = DB_DataObject::factory('competitor_events');	
			$competitor_events->query("SELECT * FROM {$competitor_events->__table} WHERE competitor_id = '".$edit_id."' AND event_id = '".$tournament_events_list->event_id."'");
			if (!$competitor_events->fetch()) {
				$competitor_events = DB_DataObject::factory('competitor_events');	
				$competitor_events->competitor_id = $edit_id;
				$competitor_events->event_id = $tournament_events_list->event_id;
				$competitor_events->division_id = 0;	
				$competitor_events->insert();				
			}
		} else {
			$competitor_events = DB_DataObject::factory('competitor_events');	
			$competitor_events->query("SELECT * FROM {$competitor_events->__table} WHERE competitor_id = ".$edit_id." AND event_id = ".$tournament_events_list->event_id);
			if ($competitor_events->fetch()) {
				
				// don't delete the event if it is a team event
				$events = DB_DataObject::factory('events');
				$events->event_id = $tournament_events_list->event_id;
				$events->find();
				$events->fetch();
				if ($events->max_competitors == 1) {

				
					// if the event is no longer selected AND the competitor was in this event then need to 
					// remove them from the division list and reinit the division
					// note this function checks to see if they were only in the unassigned list
					Remove_Competitor_And_Init_Division($edit_id, $tournament_events_list->event_id);
					
					$competitor_events->delete();					
				}
			}				
		}
		
		if ($_POST["Enrolment"] == "Scratched") {

			Remove_Competitor_And_Init_Division($edit_id, $tournament_events_list->event_id);
		}
	}

			

} elseif (isset($_POST["Delete"])) {
	
	$smarty->clear_cache('registration.tpl');
	
	$competitor = DB_DataObject::factory('competitors');
	$competitor->get($_POST["ID"]);
	if (!$competitor->delete()) {
		$primary = "Competitor (".$_POST["ID"].") has not been deleted";
		$smarty->assign(array('primary' => $primary, 'level' => "error")); 			
	} else {
		$delete_success = true;
		$primary = "Competitor (".$_POST["ID"].") has been deleted";
		$smarty->assign(array('primary' => $primary, 'level' => "success")); 		
	}
 
}

if (isset($_POST["Delete"]) && $delete_success == true) {

	$smarty->assign('delete_success', $delete_success);
	
	$tournament_events_list = DB_DataObject::factory('tournament_events');
	$tournament_events_list->tournament_id = $active_tournament->tournament_id;
	$tournament_events_list->find();
	
	while ($tournament_events_list->fetch()) {
		Remove_Competitor_And_Init_Division($_POST["ID"], $tournament_events_list->event_id);
	}
	
	// also need to remove them from any teams
	// TODO: Check to see if this makes the team empty and warn the user
	for ($id = 1; $id < 7; $id++) {
		$competitors = DB_DataObject::factory('competitors');
		$competitors->query("UPDATE {$competitors->__table} SET team_competitor_id".(string)$id." = 0 WHERE team_competitor_id".(string)$id." = ".$_POST["ID"]);
	}
	
} elseif ((isset($_GET["ID"]) && $_GET["ID"] == "new") || (!$user_input_passed)) {
	
	$command = "Enter details for a new competitor.";
	$smarty->assign("command", $command); 
	$smarty->assign('competitor', array('ID' => "new"));
	
} else {
//	if(!isset($_POST["Submit"])) {
		$command = "Edit details and submit, delete, or <a href=\"edit_competitor.php?ID=new\">add new competitor</a>.";
		$smarty->assign("command", $command); 
//	}
	$competitor = DB_DataObject::factory('competitors');
	if (isset($_POST["ID"]) && $_POST["ID"] == "new") {
		$competitor->competitor_id = $new_id;
	} else {
		$competitor->competitor_id = $_REQUEST["ID"];		
	}
	$competitor->find();
	$competitor->fetch();
	
	// check that this manager_id is allowed this to see this competitor details
	// else error
	
	$smarty->assign('competitor', array(
	      'ID'        		=> $competitor->competitor_id,
	      'ENROLMENT'		=> $competitor->enrolment,
	      'TITLE'			=> stripslashes($competitor->title),
	      'FIRST_NAME'		=> stripslashes($competitor->first_name),
	      'MIDDLE_NAME'		=> stripslashes($competitor->middle_name),
	      'LAST_NAME' 		=> stripslashes($competitor->last_name),
	      'DOB'				=> $competitor->DOB,
	      'WEIGHT'			=> $competitor->weight,
	      'HEIGHT'			=> $competitor->height,
	      'PHONE'			=> $competitor->phone,
	      'GENDER'			=> $competitor->gender,
	      'COMMENTS'		=> stripslashes($competitor->comments),
	      'RED_CARD'		=> $competitor->red_card,
	      'PAID_AMOUNT'		=> $competitor->paid_amount,
	      'OWED_AMOUNT'		=> Get_Payment_Amount($active_tournament->payment_id, $competitor->competitor_id, $competitor->DOB, $active_tournament->tournament_id, $active_tournament->date_from),	      		      	      	      
		  'LAST_UPDATED' 	=> $competitor->last_updated  
	       ));
	
//     if (!(isset($_POST["ID"]) && $_POST["ID"] == "new")) {
		$competitor_events = DB_DataObject::factory('competitor_events');
		$competitor_events->competitor_id = $competitor->competitor_id;
		$competitor_events->find();
		$temp_selection_array = array();
		while ($competitor_events->fetch())  { 	
			$temp_selection_array[$competitor_events->event_id] = $competitor_events->event_id;
		}	
		
		// what team events are they in
		$i = 0;
		$competitor_events = DB_DataObject::factory('competitor_events'); 		
		while (isset($active_tournament_events_id[$i])) {	
			if ($temp_selection_team_event[$i]) {		
				$team_competitor = DB_DataObject::factory('competitors');
				$team_competitor->tournament_id = $active_tournament->tournament_id;
				$team_competitor->whereAdd("competitor_count > 0");
				$team_competitor->find();	
				while ($team_competitor->fetch()) {	
					$competitor_event = clone $competitor_events;
					$competitor_event->competitor_id = $team_competitor->competitor_id;
					$competitor_event->event_id = $active_tournament_events_id[$i];
					if ($competitor_event->find()) {

						if ($team_competitor->team_competitor_id1 == $competitor->competitor_id) $temp_selection_array[$active_tournament_events_id[$i]] =$active_tournament_events_id[$i];
						if ($team_competitor->team_competitor_id2 == $competitor->competitor_id) $temp_selection_array[$active_tournament_events_id[$i]] =$active_tournament_events_id[$i];
						if ($team_competitor->team_competitor_id3 == $competitor->competitor_id) $temp_selection_array[$active_tournament_events_id[$i]] =$active_tournament_events_id[$i];
						if ($team_competitor->team_competitor_id4 == $competitor->competitor_id) $temp_selection_array[$active_tournament_events_id[$i]] =$active_tournament_events_id[$i];
						if ($team_competitor->team_competitor_id5 == $competitor->competitor_id) $temp_selection_array[$active_tournament_events_id[$i]] =$active_tournament_events_id[$i];
						if ($team_competitor->team_competitor_id6 == $competitor->competitor_id) $temp_selection_array[$active_tournament_events_id[$i]] =$active_tournament_events_id[$i];
					}		
				}
			}
			$i++;
		}
		
		$smarty->assign('events_selection', $temp_selection_array);		
} 		
   
if (isset($competitor))  {
   	$smarty->assign('rank_selection', $competitor->rank_id);       
	$smarty->assign('represents_selection', $competitor->represents_id);
} else {
   	$smarty->assign('rank_selection', 0);       
	$smarty->assign('represents_selection', 0);	
}

  	$temp_array = array();
  	$temp_array_team = array();
 	$tournament_events_list = DB_DataObject::factory('tournament_events');
 	$tournament_events_list->tournament_id = $active_tournament->tournament_id;


	$events = DB_DataObject::factory('events');
	$tournament_events_list->selectAs();
	$tournament_events_list->joinAdd($events, "INNER", 'events', 'event_id');
	$tournament_events_list->selectAs($events, 'events_%s'); 	
  	$tournament_events_list->find();
 
  	
  	 		
 	while ($tournament_events_list->fetch()) {
 		if ($tournament_events_list->events_max_competitors == 1) {
 			$temp_array[$tournament_events_list->event_id] = $tournament_events_list->events_name;
 		} else {
 			$temp_array_team[$tournament_events_list->event_id] = $tournament_events_list->events_name;
 		}
 	}
 	
   $smarty->assign('events_list', $temp_array);  
   $smarty->assign('team_events_list', $temp_array_team); 
   
	// the rank combo box

  	$temp_array = array();
 	$rank_list = DB_DataObject::factory('rank');
 	$rank_list->orderBy('rank_id');
 	$rank_list->find();
 	while ($rank_list->fetch())
 		$temp_array[$rank_list->rank_id] = $rank_list->name;
   $smarty->assign('rank_list', $temp_array);
   
 
 		// gets a list of possible represents
		$auth_represents_connection = DB_DataObject::factory('auth_represents_connection');
 		$auth_represents_connection->whereAdd("tournament_id = ".$active_tournament->tournament_id); 	// zzz		
		$represents = DB_DataObject::factory('represents');
		$auth_represents_connection->selectAs();
		$auth_represents_connection->joinAdd($represents, "INNER", 'represents', 'represents_id');
		$auth_represents_connection->selectAs($represents, 'represents_%s');
	
		if ($user_access == "manager")
			$auth_represents_connection->user_id = $user_id;
		
		$auth_represents_connection->orderBy('represents_name');
		$auth_represents_connection->find();
		$temp_list_array = array();
		while ($auth_represents_connection->fetch())  { 	
			$temp_list_array[$auth_represents_connection->represents_id] = $auth_represents_connection->represents_name;
		}
		$smarty->assign('represents_list', $temp_list_array); 
		



$smarty->display('edit_competitor.tpl');

?>