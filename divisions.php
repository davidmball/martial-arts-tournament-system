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

$smarty->assign('current_menu', "Divisions");

echo "<br><br><br><br>";

if (isset($_GET["TYPE"])) {
	$smarty->assign("type", $_GET["TYPE"]);	
}

///////////// PUBLIC DRAWS //////////////
if (!$active_tournament->draws_public && $user_access != "admin") {
	$smarty->display('divisions.tpl');
	
//////////////// ADMIN ///////////////////
} else if ($user_access == "admin" && !isset($_GET["TYPE"])) {

	$smarty->assign('display_type', "interactive");

	if (isset($_POST["EVENT_SELECTED"])) {
		$event_selected = $_POST["EVENT_SELECTED"];	
	} else {
		$event_selected = 1; // sparring
	}
	$smarty->assign('current_event_selected', $event_selected);
	
	// this means a division needs to be sorted
	if (isset($_POST["SORT_SELECTED"])) {
		
		// sort the competitors in the order they are selected, then the rest randomly
		// I am sure there is a better way of doing this ... (but there is unlikely to ever be many competitors to sort at once)
		$division_selected = $from_division = $_POST["DIVISION_SELECTED"];
		
		// give everyone a high order in the selected division
		$competitor_divisions = DB_DataObject::factory('competitor_events');
		$competitor_divisions->query("SELECT * FROM {$competitor_divisions->__table} WHERE division_id = ".$from_division." AND event_id = ".$event_selected);
		$competitor_divisions->query("SET @pos = 1000");
		$competitor_divisions->query("UPDATE {$competitor_divisions->__table} SET draw_order = ( SELECT @pos := @pos + 1 ) WHERE division_id = ".$from_division." AND event_id = ".$event_selected." ORDER BY draw_order ASC");
		
		// order them as selected
		$order = 0;
		while ($temp_value = current($_POST['competitor_ids_clicked'])) {
			$competitor_divisions = DB_DataObject::factory('competitor_events');
			$competitor_divisions->query("SELECT * FROM {$competitor_divisions->__table} WHERE competitor_id = ".$temp_value." AND event_id = ".$event_selected);
			$competitor_divisions->query("UPDATE {$competitor_divisions->__table} SET draw_order = ".$order." WHERE competitor_id = ".$temp_value." AND event_id = ".$event_selected." AND division_id = ".$division_selected);
			$order++;
			next($_POST['competitor_ids_clicked']);	
		}
		
		// then reorder the whole division to include the ones that weren't selected
		$competitor_divisions = DB_DataObject::factory('competitor_events');
		$competitor_divisions->query("SELECT * FROM {$competitor_divisions->__table} WHERE division_id = ".$from_division." AND event_id = ".$event_selected);
		$competitor_divisions->query("SET @pos = -1");
		$competitor_divisions->query("UPDATE {$competitor_divisions->__table} SET draw_order = ( SELECT @pos := @pos + 1 ) WHERE division_id = ".$from_division." AND event_id = ".$event_selected." ORDER BY draw_order ASC");
	
		// the results are no longer going to be valid
		$results = DB_DataObject::factory('results');
		$results->division_id = $division_selected;
		$results->find();
		while ($results->fetch()) {
			$results->delete();
		}
	}
	
	// this means some division was selected to grab the selected competitors
	if (isset($_POST["DIVISION_SELECTED"])) {
		$division_selected = $_POST["DIVISION_SELECTED"];
		$temp_value;
	

		while ($temp_value = current($_POST['competitor_ids_clicked'])) {
	//		echo $temp_value." ".$_POST["DIVISION_SELECTED"]." ".$event_selected."<br>";
	//DB_DataObject::debugLevel(5);
			// unless they are going into unassigned need to find the current highest order number
			if ($_POST["DIVISION_SELECTED"] == 0) {
				$order = 0;
			} else {
				$competitor_divisions = DB_DataObject::factory('competitor_events');
				$competitor_divisions->event_id = $event_selected;
				$competitor_divisions->division_id = $_POST["DIVISION_SELECTED"];
				$competitor_divisions->orderBy("competitor_events.draw_order DESC");
				$competitor_divisions->find();
				if ($competitor_divisions->fetch()) {
					$order = $competitor_divisions->draw_order + 1;
				} else {
					$order = 0;	
				}
				
			}
	//		echo $order;
	//DB_DataObject::debugLevel(0);
			// fins the division the competitor was in
			$competitor_divisions = DB_DataObject::factory('competitor_events');
			$competitor_divisions->competitor_id = $temp_value;
			$competitor_divisions->event_id = $event_selected;
			$competitor_divisions->find();
			$competitor_divisions->fetch();	
			$from_division = $competitor_divisions->division_id;
					
			$competitor_divisions = DB_DataObject::factory('competitor_events');
			$competitor_divisions->query("SELECT * FROM {$competitor_divisions->__table} WHERE competitor_id = ".$temp_value." AND event_id = ".$event_selected);
	
			$competitor_divisions->query("UPDATE {$competitor_divisions->__table} SET division_id = ".$_POST["DIVISION_SELECTED"].", draw_order = ".$order." WHERE competitor_id = ".$temp_value." AND event_id = ".$event_selected);
	
			if ($from_division != 0) { 
				// reorder the division that the competitor was in
				Sort_Division($from_division);
			}
			
			next($_POST['competitor_ids_clicked']);	
		}	
	
		if ($_POST["DIVISION_SELECTED"] != 0) 
			Clear_Results_And_Init_Division($_POST["DIVISION_SELECTED"]); 
		
		if ($from_division !=0 ) {
			Clear_Results_And_Init_Division($from_division); 		
		}
	}

	$tournament_total_competitors = 0;
	$tournament_total_unassigned = 0;
	$tournament_total_signed_in = 0;

	// for getting get all the events for the active tournament.
 	$tournament_events_list = DB_DataObject::factory('tournament_events');
 	$tournament_events_list->tournament_id = $active_tournament->tournament_id;
	$events = DB_DataObject::factory('events');
	$tournament_events_list->selectAs();
	$tournament_events_list->joinAdd($events, "INNER", 'events', 'event_id');
	$tournament_events_list->selectAs($events, 'events_%s'); 	
  	$tournament_events_list->find();	 		   		  
  	 		  
 	while ($tournament_events_list->fetch()) {
		  
	   	// for getting all the divisions in each active event
	  	$tournament_divisions = DB_DataObject::factory('divisions');	  
	   	$tournament_divisions->tournament_id = $active_tournament->tournament_id;
		$tournament_divisions->event_id = $tournament_events_list->event_id;
		$tournament_divisions->orderBy("sequence ASC");
		$tournament_divisions->find();

		$total_competitor_count = 0;
		$total_signed_in_count = 0;

		while ($tournament_divisions->fetch()) {
			
			if ($event_selected == $tournament_events_list->event_id) {
				$smarty->append('competitor_division_starts', $total_competitor_count);
			}
		
			$competitor_count = 0;
			$signed_in_count = 0;	
//			echo $tournament_events_list->event_id."<br>";
			 // for getting all the competitors in each active division 		  
		   	$competitor_divisions = DB_DataObject::factory('competitor_events');	  
		  	$competitor_divisions->event_id = $tournament_events_list->event_id;
		  	$competitors = DB_DataObject::factory('competitors');
		  	$competitor_divisions->selectAs();	  
		 	$competitor_divisions->joinAdd($competitors, "INNER", 'competitors', 'competitor_id');
			$competitor_divisions->selectAs($competitors, 'competitors_%s'); 
			$competitor_divisions->whereAdd("competitors.tournament_id = '".$active_tournament->tournament_id."'"); 
			
			// if it is a team event only get the teams else only get individuals
			if ($tournament_events_list->events_max_competitors > 1) {
				$competitor_divisions->whereAdd("competitors.competitor_count != 0");
			} else {
				$competitor_divisions->whereAdd("competitors.competitor_count = 0");				
			}
			
			// need to ensure that competitors are always uniquely ordered
			// SELECT * FROM my_table ORDER BY ISNULL(field), field [ ASC | DESC ]
			$competitor_divisions->orderBy("competitor_events.draw_order ASC");

			$competitor_divisions->find();
	
			while ($competitor_divisions->fetch()) {
			
				if ($competitor_divisions->division_id == $tournament_divisions->division_id) {

					$competitor_count++;
					$enrolment = Convert_Enrolment_String_To_Char($competitor_divisions->competitors_enrolment, $signed_in_count);
					
					if ($event_selected == $tournament_events_list->event_id) {	
						$age = GetAgeAtTournament($competitor_divisions->competitors_DOB, $active_tournament->date_from);
						if ($competitor_divisions->competitors_comments) {
							$comments = "<a href='' title='".$competitor_divisions->competitors_comments."'>!</a>";
						} else {
							$comments = "";
						}

						$smarty->append('competitor_list', array(
						  'ID'				=> $competitor_divisions->competitor_id,
					      'FIRST_NAME'		=> stripslashes($competitor_divisions->competitors_first_name),
					      'MIDDLE_NAME'		=> stripslashes($competitor_divisions->competitors_middle_name),
					      'LAST_NAME' 		=> stripslashes($competitor_divisions->competitors_last_name),
					      'AGE'				=> $age,
					      'GENDER'			=> substr($competitor_divisions->competitors_gender, 0, 1),
					      'REPRESENTS'		=> $represents_display_lookup[$competitor_divisions->competitors_represents_id],
					      'RANK'			=> $rank_display_lookup[$competitor_divisions->competitors_rank_id],			      
					      'WEIGHT'			=> $competitor_divisions->competitors_weight,
					      'HEIGHT'			=> $competitor_divisions->competitors_height,
					      'COMMENTS'		=> stripslashes($comments),
					      'ENROLMENT'		=> $enrolment
						));
					}
				}
				
			}
			
			$total_competitor_count += $competitor_count;
			$total_signed_in_count += $signed_in_count;

			if ($event_selected == $tournament_events_list->event_id) {
				$smarty->append('division_list', array(
					'DIVISION_ID'			=> $tournament_divisions->division_id,
					'DIVISION_TYPE'		=> $tournament_divisions->type,
					'EVENT_ID'			=> $tournament_events_list->event_id,
					'EVENT'				=> $tournament_events_list->events_name,
					'DIVISION'			=> $tournament_divisions->name,
					'ENROLMENT_COUNT'  	=> $competitor_count - $signed_in_count,
					'COMPETITOR_COUNT'	=> $competitor_count,
					'SECTION_NAME'		=> Get_Section_Name($tournament_divisions->section_id)
				));
			}
		}
		
		// also need to do unassigned 
		// which is all competitors[active tournament id] and competitor_events[event_id] 
		// and no entry in competitor_divisions for the current event_id

		// first find all the competitors that need to be in a division in this event
		$competitors = DB_DataObject::factory('competitors');
		$competitors->tournament_id = $active_tournament->tournament_id;
		$competitors_events = DB_DataObject::factory('competitor_events');
		$competitors->joinAdd($competitors_events, "INNER", 'competitor_events', 'competitor_id');
		$competitors->selectAs($competitors_events, 'competitors_events_%s');
		$competitors->whereAdd("competitor_events.event_id = '".$tournament_events_list->event_id."'");	

		// if it is a team event only get the teams else only get individuals
		if ($tournament_events_list->events_max_competitors > 1) {
			$competitors->whereAdd("competitors.competitor_count != 0");
		} else {
			$competitors->whereAdd("competitors.competitor_count = 0");				
		}
		$unassigned_competitor_count = 0;	
		$unassigned_signed_in_count = 0;

		$competitors->find();

		while ($competitors->fetch()) {

			// next check this id isn't in the assigned array.
//			if (!isset($assigned_competitor_array[$competitors->competitor_id])) {
			if ($competitors->competitors_events_division_id == 0) {

				$unassigned_competitor_count++;
				$age = GetAgeAtTournament($competitors->DOB, $active_tournament->date_from);

				if ($event_selected == $tournament_events_list->event_id) {	
	//				echo "U".$competitors->competitor_id." ".$competitors->first_name."</br>";
					if ($competitors->comments) {
						$comments = "<a href='' title='".$competitors->comments."'>!</a>";
					} else {
						$comments = "";
					}
					

					
					$enrolment = Convert_Enrolment_String_To_Char($competitors->enrolment, $unassigned_signed_in_count);
								
					$smarty->append('competitor_list', array(
					  'ID'				=> $competitors->competitor_id,
				      'FIRST_NAME'		=> $competitors->first_name,
				      'MIDDLE_NAME'		=> $competitors->middle_name,
				      'LAST_NAME' 		=> $competitors->last_name,
				      'AGE'				=> $age,
				      'GENDER'			=> substr($competitors->gender, 0, 1),
					  'REPRESENTS'		=> $represents_display_lookup[$competitors->represents_id],				      
				      'RANK'			=> $rank_display_lookup[$competitors->rank_id], 
				      'WEIGHT'			=> $competitors->weight,
				      'HEIGHT'			=> $competitors->height,
				      'COMMENTS'		=> $comments,
				      'ENROLMENT'		=> $enrolment								
					));	
				}
			}	
		}
		
		$tournament_total_competitors += ($unassigned_competitor_count + $total_competitor_count);
		$tournament_total_unassigned += ($unassigned_competitor_count);
		$tournament_total_signed_in += ($total_signed_in_count + $unassigned_signed_in_count);

		$smarty->append('unassigned_list', array(
			'EVENT_ID'			=> $tournament_events_list->event_id,
			'EVENT'				=> $tournament_events_list->events_name,
			'DIVISION_ID'		=> 0,
			'DIVISION'			=> "Unassigned",
			'COMPETITOR_COUNT'	=> $unassigned_competitor_count,
			'ENROLMENT_COUNT'	=> $unassigned_competitor_count - $unassigned_signed_in_count,
			'EVENT_ENROLMENT_COUNT' => $total_competitor_count - $total_signed_in_count + $unassigned_competitor_count - $unassigned_signed_in_count,
			'TOTAL_COUNT'		=> $unassigned_competitor_count + $total_competitor_count
		));

		if ($event_selected == $tournament_events_list->event_id) {
			$smarty->append('competitor_division_starts', $total_competitor_count);
			$smarty->append('division_list', array(
				'EVENT_ID'			=> $tournament_events_list->event_id,
				'EVENT'				=> $tournament_events_list->events_name,
				'DIVISION_ID'		=> 0,
				'DIVISION'			=> "Unassigned",
				'COMPETITOR_COUNT'	=> $unassigned_competitor_count,
				'ENROLMENT_COUNT'	=> $unassigned_competitor_count - $unassigned_signed_in_count,
				'TOTAL_COUNT'		=> $unassigned_competitor_count + $total_competitor_count,
				'SECTION_NAME'		=> " "
			));
			$smarty->append('competitor_division_count', $unassigned_competitor_count);
		} 
	}
	
	$smarty->append('unassigned_list', array(
		'EVENT_ID'			=> 0,
		'EVENT'				=> "TOTAL",
		'DIVISION_ID'		=> 0,
		'DIVISION'			=> " ",
		'COMPETITOR_COUNT'	=> $tournament_total_unassigned,
		'ENROLMENT_COUNT'	=> $tournament_total_unassigned,
		'EVENT_ENROLMENT_COUNT' => $tournament_total_competitors - $tournament_total_signed_in,
		'TOTAL_COUNT'		=>  $tournament_total_competitors
	));
	
	$smarty->display('divisions.tpl');

/////////////////// STEWARDS	///////////////////
// they get a list of divisions for their ring
} else if ($user_access == "steward" && !isset($_GET["TYPE"])) {

	$divisions = DB_DataObject::factory('divisions');
	$divisions->tournament_id = $active_tournament->tournament_id;
	$events = DB_DataObject::factory('events');
	
	$divisions->selectAs();
	$divisions->joinAdd($events, "INNER", 'events', 'event_id');
	$divisions->selectAs($events, 'events_%s'); 
	
	$divisions->orderBy("sequence ASC");
	
	$divisions->find();
	
	while($divisions->fetch()) {
	
	      $smarty->append('divisions', array(
		  	  'ID'				=> $divisions->division_id,
		      'NAME'        	=> $divisions->name,
		      'EVENT_NAME'		=> $divisions->events_name,  
		      'SECTION_NAME'			=> Get_Section_Name($divisions->section_id)
	       )); 	
	}
	
	$smarty->display('divisions.tpl');
	
//////////// MANAGERS AND PUBLIC ////////////////
} else {
	
	$total_competitor_count = 0;
	$team_division = 0;
	
	// for getting get all the events for the active tournament.
 	$tournament_events_list = DB_DataObject::factory('tournament_events');
 	$tournament_events_list->tournament_id = $active_tournament->tournament_id;
	$events = DB_DataObject::factory('events');
	$tournament_events_list->selectAs();
	$tournament_events_list->joinAdd($events, "INNER", 'events', 'event_id');
	$tournament_events_list->selectAs($events, 'events_%s'); 	
  	$tournament_events_list->find();	 		   		  
  	 		  
 	while ($tournament_events_list->fetch()) {
		  
	   	// for getting all the divisions in each active event
	  	$tournament_divisions = DB_DataObject::factory('divisions');	  
	   	$tournament_divisions->tournament_id = $active_tournament->tournament_id;
	   	$tournament_divisions->event_id = $tournament_events_list->event_id;		
	   	if (isset($_GET["SECTION"]) && $_GET["SECTION"] != 0) {
	   		$tournament_divisions->section_id = $_GET["SECTION"];
	   	} 
		
		$tournament_divisions->orderBy("sequence ASC");
		$tournament_divisions->find();

		while ($tournament_divisions->fetch()) {
			
			$smarty->append('competitor_division_starts', $total_competitor_count);
			
			$competitor_count = 0;	
	  
		   	$competitor_divisions = DB_DataObject::factory('competitor_events');	  
		  	$competitor_divisions->event_id = $tournament_events_list->event_id;
		  	$competitors = DB_DataObject::factory('competitors');
		  	$competitor_divisions->selectAs();	  
		 	$competitor_divisions->joinAdd($competitors, "INNER", 'competitors', 'competitor_id');
			$competitor_divisions->selectAs($competitors, 'competitors_%s'); 
			$competitor_divisions->whereAdd("competitors.tournament_id = '".$active_tournament->tournament_id."'"); 

			$competitor_divisions->find();
		
			while ($competitor_divisions->fetch()) {
				
				if ($competitor_divisions->division_id == $tournament_divisions->division_id) {

					$competitor_count++;
					
					$age = GetAgeAtTournament($competitor_divisions->competitors_DOB, $active_tournament->date_from);
					
					$smarty->append('competitor_list', array(
				      'FIRST_NAME'		=> stripslashes($competitor_divisions->competitors_first_name),
				      'LAST_NAME' 		=> stripslashes($competitor_divisions->competitors_last_name),
				      'RANK'			=> $rank_display_lookup_name[$competitor_divisions->competitors_rank_id], 
				      'GENDER'			=> substr($competitor_divisions->competitors_gender, 0, 1),
				      'WEIGHT'			=> $competitor_divisions->competitors_weight,
				      'HEIGHT'			=> $competitor_divisions->competitors_height,
				      'AGE'				=> $age,
				      'REPRESENTS'		=> $represents_display_lookup[$competitor_divisions->competitors_represents_id],
				      'CAPTAIN_NAME' => stripslashes(Get_Competitor_Name($competitor_divisions->competitors_team_competitor_id1))
					));

					if ($competitor_divisions->competitors_competitor_count > 0) {
						$team_division = 1;	
					} else {
						$team_division = 0;
					}

				}
				
			}
			

			
			$smarty->append('competitor_division_count', $competitor_count);
			$total_competitor_count += $competitor_count;
			$smarty->append('division_list', array(
				'DIVISION_ID'			=> $tournament_divisions->division_id,
				'EVENT_ID'			=> $tournament_events_list->event_id,
				'EVENT'				=> $tournament_events_list->events_name,
				'DIVISION'			=> $tournament_divisions->name,
				'COMPETITOR_COUNT'	=> $competitor_count,
				'SECTION_NAME'		=> Get_Section_Name($tournament_divisions->section_id),
				'TEAM'						=> $team_division
			));

		}		
	}	
	$smarty->display('divisions.tpl');
}


 
?>
