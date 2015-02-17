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
$smarty->assign('current_menu', "Results");
//echo "<br><br><br><br>";

function Get_Round_Results($division_id, $round_id, $result_a, $result_b, &$competitor_count, $represents_id, $competitor_id) {
	
	global $represents_display_lookup;
	global $smarty;
	
	$results = DB_DataObject::factory('results');
	$results->division_id = $division_id;
	$results->round_id = $round_id;
	if ($results->find()) {
		$results->fetch();
		
		if ($results->colour_win == "R") {

			$competitor = DB_DataObject::factory('competitors');
			$competitor->competitor_id = $results->competitor_red_id;
			$competitor->find();
			$competitor->fetch();
			if (($represents_id == 0 || $represents_id == $competitor->represents_id)
				&& ($competitor_id == 0 || $competitor_id == $competitor->competitor_id)
				&& ($competitor->competitor_id != 0) ) {
				$smarty->append('competitor_list', array(
				  'RESULT'			=> $result_a,
				  'NAME' 			=> Get_Competitor_Name($results->competitor_red_id),
			      'REPRESENTS'		=> $represents_display_lookup[$competitor->represents_id],
				));	
				$competitor_count++;
			}
			$competitor = DB_DataObject::factory('competitors');
			$competitor->competitor_id = $results->competitor_blue_id;
			$competitor->find();
			$competitor->fetch();
			if (($represents_id == 0 || $represents_id == $competitor->represents_id)
				&& ($competitor_id == 0 || $competitor_id == $competitor->competitor_id)
				&& ($competitor->competitor_id != 0) ) {
				$smarty->append('competitor_list', array(
				  'RESULT'			=> $result_b,
				  'NAME' 			=> Get_Competitor_Name($results->competitor_blue_id),
			      'REPRESENTS'		=> $represents_display_lookup[$competitor->represents_id],
				));	
				$competitor_count++;
			}
		} else if ($results->colour_win == "B") {
			$competitor = DB_DataObject::factory('competitors');
			$competitor->competitor_id = $results->competitor_blue_id;
			$competitor->find();
			$competitor->fetch();
			if (($represents_id == 0 || $represents_id == $competitor->represents_id)
				&& ($competitor_id == 0 || $competitor_id == $competitor->competitor_id) ) {
				$smarty->append('competitor_list', array(
				  'RESULT'			=> $result_a,
			      'NAME' 			=> Get_Competitor_Name($results->competitor_blue_id),			  
			      'REPRESENTS'		=> $represents_display_lookup[$competitor->represents_id],
				));
				$competitor_count++;
			}	
//			$competitor_count++;
			$competitor = DB_DataObject::factory('competitors');
			$competitor->competitor_id = $results->competitor_red_id;
			$competitor->find();
			$competitor->fetch();
			if (($represents_id == 0 || $represents_id == $competitor->represents_id)
				&& ($competitor_id == 0 || $competitor_id == $competitor->competitor_id) ) {		
				$smarty->append('competitor_list', array(
				  'RESULT'			=> $result_b,
				  'NAME' 			=> Get_Competitor_Name($results->competitor_red_id),
			      'REPRESENTS'		=> $represents_display_lookup[$competitor->represents_id],
				));	
				$competitor_count++;
			}				
		} else if ($results->colour_win == "Y") {
			$competitor = DB_DataObject::factory('competitors');
			$competitor->competitor_id = $results->competitor_red_id;
			$competitor->find();
			$competitor->fetch();
			if (($represents_id == 0 || $represents_id == $competitor->represents_id)
				&& ($competitor_id == 0 || $competitor_id == $competitor->competitor_id) ) {		
				$smarty->append('competitor_list', array(
				  'RESULT'			=> $result_a,
				  'NAME' 			=> Get_Competitor_Name($results->competitor_red_id),
			      'REPRESENTS'		=> $represents_display_lookup[$competitor->represents_id],
				));
				$competitor_count++;
			}				
		} else if ($results->colour_win == "N") {
			$competitor = DB_DataObject::factory('competitors');
			$competitor->competitor_id = $results->competitor_blue_id;
			$competitor->find();
			if ($competitor->fetch()) {
				if (($represents_id == 0 || $represents_id == $competitor->represents_id)
					&& ($competitor_id == 0 || $competitor_id == $competitor->competitor_id) ) {
					$smarty->append('competitor_list', array(
					  'RESULT'			=> $result_a,
				      'NAME' 			=> Get_Competitor_Name($results->competitor_blue_id),			  
				      'REPRESENTS'		=> $represents_display_lookup[$competitor->represents_id],
					));
					$competitor_count++;
				}	
			}
			$competitor = DB_DataObject::factory('competitors');
			$competitor->competitor_id = $results->competitor_red_id;
			$competitor->find();
			if ($competitor->fetch()) {
				if (($represents_id == 0 || $represents_id == $competitor->represents_id)
					&& ($competitor_id == 0 || $competitor_id == $competitor->competitor_id) ) {		
					$smarty->append('competitor_list', array(
					  'RESULT'			=> $result_b,
					  'NAME' 			=> Get_Competitor_Name($results->competitor_red_id),
				      'REPRESENTS'		=> $represents_display_lookup[$competitor->represents_id],
					));
					
					$competitor_count++;
				}
			}				
		}
	}

}

function Convert_Place_To_Result($place) {
	
	if ($place == 1)
		return "1st";
	else if ($place == 2)
		return "2nd";
	else if ($place == 3)
		return "3rd";
	else if ($place == 4)
		return "4th";
	else
		return " ";
		
}

function Get_Form_Results($division_id, &$competitor_count, $represents_id, $competitor_id) {
	
		global $represents_display_lookup;
		global $smarty;
		
		$results = DB_DataObject::factory('results');
		$results->division_id = $division_id;		
		$results->whereAdd("results.place != 0");
		$results->orderBy("place ASC");
		$results->find();				
		while ($results->fetch()) {
			$competitor = DB_DataObject::factory('competitors');
			$competitor->competitor_id = $results->competitor_red_id;
			$competitor->find();
			$competitor->fetch();
			if (($represents_id == 0 || $represents_id == $competitor->represents_id)
				&& ($competitor_id == 0 || $competitor_id == $competitor->competitor_id) ) {
				$smarty->append("competitor_list", array(
					'NAME' 					=> Get_Competitor_Name($results->competitor_red_id), 
					'REPRESENTS' 			=> $represents_display_lookup[$competitor->represents_id],
					'RESULT'				=> Convert_Place_To_Result($results->place)				
				));
				$competitor_count++;
			}
		}
}

function Get_Round_Robin_Results($division_id, &$competitor_count, $represents_id, $competitor_id) {
	
		global $represents_display_lookup;
		global $smarty;
		
		$results = DB_DataObject::factory('results');
		$results->division_id = $division_id;		
		$results->whereAdd("results.place != 0");
		$results->orderBy("place ASC");
		$results->find();				
		while ($results->fetch()) {
			$competitor = DB_DataObject::factory('competitors');
			$competitor->competitor_id = $results->competitor_blue_id;
			$competitor->find();
			$competitor->fetch();
			if (($represents_id == 0 || $represents_id == $competitor->represents_id)
				&& ($competitor_id == 0 || $competitor_id == $competitor->competitor_id) ) {
				$smarty->append("competitor_list", array(
					'NAME' 					=> Get_Competitor_Name($results->competitor_blue_id), 
					'REPRESENTS' 			=> $represents_display_lookup[$competitor->represents_id],
					'RESULT'				=> Convert_Place_To_Result($results->place)				
				));
				$competitor_count++;
			}
		}
}


$at_least_one_champs = 0;
// only individual
function Get_Overall_Champions($tournament_id) {
	
	global $represents_display_lookup;
	global $smarty;
	global $at_least_one_champs;

	$competitor = DB_DataObject::factory('competitors');
	$competitor->tournament_id = $tournament_id;
	$competitor->whereAdd("competitor_count = 0");
	$competitor->whereAdd("overall_place != 0");
	$competitor->orderBy("overall_place ASC");
	$competitor->find();
	$champ_count = 0;
	$champs = array();
	while ($competitor->fetch()) {
			$at_least_one_champs = 1;
			
			$smarty->append("champs_list", array(
				'NAME' => Get_Competitor_Name($competitor->competitor_id),
				'PLACE' => Convert_Place_To_Result($competitor->overall_place),
				'DESCRIPTION' => $competitor->overall_description,
				'REPRESENTS' => $represents_display_lookup[$competitor->represents_id]
			));
	}		
}

function Get_Champion_Results($champion_id) {
	
	global $represents_display_lookup;
	global $smarty;
	global $at_least_one_champs;

	$competitor = DB_DataObject::factory('competitors');
	$competitor->competitor_id = $champion_id;
	$competitor->whereAdd("competitor_count = 0");
	$competitor->whereAdd("overall_place != 0");
	$competitor->orderBy("overall_place ASC");
	$competitor->find();
	$champ_count = 0;
	$champs = array();
	while ($competitor->fetch()) {
			$at_least_one_champs = 1;

			$smarty->append("champs_list", array(
				'NAME' => Get_Competitor_Name($competitor->competitor_id),
				'PLACE' => Convert_Place_To_Result($competitor->overall_place),
				'DESCRIPTION' => $competitor->overall_description,
				'REPRESENTS' => $represents_display_lookup[$competitor->represents_id]
			));
	}		
}


// Get results for a tournament
// 
if (isset($_POST["Get_Tournament_Results"]) || isset($_POST["Get_Section_Results"])) {
	
	$total_competitor_count = 0;
	
	if (isset($_POST["Get_Section_Results"])) {
		$section = DB_DataObject::factory('sections');
		$section->section_id = $_POST["Section"];
		$section->find();	
		$section->fetch();		
		$selected_tournament = $section->tournament_id;
		$smarty->assign("section_name", $section->name);

	} else {
		$selected_tournament = $_POST["Tournament"];
	}

	Get_Overall_Champions($selected_tournament);

	// for getting get all the events for the active tournament.
 	$tournament_events_list = DB_DataObject::factory('tournament_events');
 	$tournament_events_list->tournament_id = $selected_tournament;
	$events = DB_DataObject::factory('events');
	$tournament_events_list->selectAs();
	$tournament_events_list->joinAdd($events, "INNER", 'events', 'event_id');
	$tournament_events_list->selectAs($events, 'events_%s'); 	
  	
  	
  	if ($tournament_events_list->find()) {

  		$smarty->assign("results_mode", "Tournament");	
  		$results_mode = "Tournament";
	 	
		$tournament = DB_DataObject::factory('tournaments');
		$tournament->get($selected_tournament);
		
		$smarty->assign('tournament', array(
	      'ID'        		=> $tournament->tournament_id,
	      'NAME' 			=> $tournament->name,     
	      'LOCATION'  		=> $tournament->location,     
	      'DATE_FROM'     	=> $tournament->date_from,
	      'DATE_TO' 		=> $tournament->date_to
	       ));
	 	
	 	while ($tournament_events_list->fetch()) {
			  
		   	// for getting all the divisions in each active event
		  	$tournament_divisions = DB_DataObject::factory('divisions');	  
		   	$tournament_divisions->tournament_id = $selected_tournament;
		   	$tournament_divisions->event_id = $tournament_events_list->event_id;

		   	if (isset($_POST["Get_Section_Results"]) && $_POST["Section"] != 0) {
		   		$tournament_divisions->section_id = $_POST["Section"];
		   	}	
			$tournament_divisions->orderBy("sequence ASC");
			$tournament_divisions->find();
	
			while ($tournament_divisions->fetch()) {
				
				$smarty->append('competitor_division_starts', $total_competitor_count);
				
				$competitor_count = 0;	
		  
			   	$competitor_divisions = DB_DataObject::factory('competitor_events');	  
			  	$competitor_divisions->division_id = $tournament_divisions->division_id;
			  	
				if ($tournament_divisions->type == "Round_Robin") {
					Get_Round_Robin_Results($tournament_divisions->division_id, $competitor_count, 0, 0);	
				} else if ($tournament_divisions->type == "Form_Individual" || $tournament_divisions->type == "Form_Team") {
					Get_Form_Results($tournament_divisions->division_id, $competitor_count, 0, 0);
				} else if ($tournament_divisions->type == "Elimination" || $tournament_divisions->type == "Repercharge") {		
					Get_Round_Results($tournament_divisions->division_id, 1, "1st", "2nd", $competitor_count, 0, 0);
										
					if ($tournament_divisions->minor_final == "3rd4th") {
						Get_Round_Results($tournament_divisions->division_id, 2, "3rd", "4th", $competitor_count, 0, 0);
					} else if ($tournament_divisions->minor_final == "3rd3rd") {
						Get_Round_Results($tournament_divisions->division_id, 2, "3rd", "3rd", $competitor_count, 0, 0);			
					}
				}
			
				$smarty->append('competitor_division_count', $competitor_count);
				$total_competitor_count += $competitor_count;
				$smarty->append('division_list', array(
					'DIVISION_ID'		=> $tournament_divisions->division_id,
					'EVENT_ID'			=> $tournament_events_list->event_id,
					'EVENT'				=> $tournament_events_list->events_name,
					'DIVISION'			=> $tournament_divisions->name,
					'COMPETITOR_COUNT'	=> $competitor_count,
					'SECTION_NAME'		=> Get_Section_Name($tournament_divisions->section_id)
				));
	
			}	
				
		}
  	} else {
 	 	$smarty->assign("results_mode", "Get");
 	 	$results_mode = "Get"; 		
  	}	
	
} else if (isset($_POST["Get_Represents_Results"])) {
	
	$total_competitor_count = 0;
	
	$selected_represents = $_POST["Represents"];

	 $smarty->assign("results_mode", "Represents");	
	 $results_mode = "Represents";
	 $smarty->assign("represents_name", $represents_display_lookup[$selected_represents]);

	$tournament = DB_DataObject::factory('tournaments');
	$tournament->find();
	while ($tournament->fetch()) {
	
		$smarty->append('tournament_list', array(
		  'ID'        		=> $tournament->tournament_id,
		  'NAME' 			=> $tournament->name,     
		  'LOCATION'  		=> $tournament->location,     
		  'DATE_FROM'     	=> $tournament->date_from,
		  'DATE_TO' 		=> $tournament->date_to
		   ));
		
		$selected_tournament = $tournament->tournament_id;
	
		// for getting get all the events for the active tournament.
	 	$tournament_events_list = DB_DataObject::factory('tournament_events');
	 	$tournament_events_list->tournament_id = $selected_tournament;
		$events = DB_DataObject::factory('events');
		$tournament_events_list->selectAs();
		$tournament_events_list->joinAdd($events, "INNER", 'events', 'event_id');
		$tournament_events_list->selectAs($events, 'events_%s'); 	
	  	
	  	
	  	if ($tournament_events_list->find()) {

		 		
		 	while ($tournament_events_list->fetch()) {
				  
			   	// for getting all the divisions in each active event
			  	$tournament_divisions = DB_DataObject::factory('divisions');	  
			   	$tournament_divisions->tournament_id = $selected_tournament;
			   	$tournament_divisions->event_id = $tournament_events_list->event_id;	
				
				$tournament_divisions->orderBy("sequence ASC");
				
				$tournament_divisions->find();
		
				while ($tournament_divisions->fetch()) {
					
					$smarty->append('competitor_division_starts', $total_competitor_count);
			
					$competitor_count = 0;	
			  
				   	$competitor_divisions = DB_DataObject::factory('competitor_events');	  
				  	$competitor_divisions->division_id = $tournament_divisions->division_id;
				  	
					if ($tournament_divisions->type == "Round_Robin") {
						Get_Round_Robin_Results($tournament_divisions->division_id, $competitor_count, $selected_represents, 0);		
					} else if ($tournament_divisions->type == "Form_Individual" || $tournament_divisions->type == "Form_Team") {
						Get_Form_Results($tournament_divisions->division_id, $competitor_count, $selected_represents, 0);
					} else if ($tournament_divisions->type == "Elimination" || $tournament_divisions->type == "Repercharge") {		

						Get_Round_Results($tournament_divisions->division_id, 1, "1st", "2nd", $competitor_count, $selected_represents, 0);
						
						if ($tournament_divisions->minor_final == "3rd4th") {
							Get_Round_Results($tournament_divisions->division_id, 2, "3rd", "4th", $competitor_count, $selected_represents, 0);
						} else if ($tournament_divisions->minor_final == "3rd3rd") {
							Get_Round_Results($tournament_divisions->division_id, 2, "3rd", "3rd", $competitor_count, $selected_represents, 0);			
						}
					}

					$smarty->append('competitor_division_count', $competitor_count);
		
					$total_competitor_count += $competitor_count;
					$smarty->append('division_list', array(
						'TOURNAMENT_ID'		=> $selected_tournament,
						'DIVISION_ID'		=> $tournament_divisions->division_id,
						'EVENT_ID'			=> $tournament_events_list->event_id,
						'EVENT'				=> $tournament_events_list->events_name,
						'DIVISION'			=> $tournament_divisions->name,
						'COMPETITOR_COUNT'	=> $competitor_count,
						'SECTION_NAME'		=> Get_Section_Name($tournament_divisions->section_id)
					));
		
				}	
					
			}
	  	}
	}
	
	// now do overall champs list
	$competitor = DB_DataObject::factory('competitors');
	$competitor->represents_id = $selected_represents;
	$competitor->whereAdd("competitor_count = 0");
	$competitor->whereAdd("overall_place != 0");
	$competitor->orderBy("overall_place ASC");
	$competitor->find();
	$champ_count = 0;
	$champs = array();
	
	$tournament = DB_DataObject::factory('tournaments');
	$tournament->tournament_id = $competitor->tournament_id;
	$tournament->find();
	$tournament->fetch();
	
	while ($competitor->fetch()) {
			$smarty->append("champs_list", array(
				'NAME' => Get_Competitor_Name($competitor->competitor_id),
				'PLACE' => Convert_Place_To_Result($competitor->overall_place),
				'DESCRIPTION' => $competitor->overall_description,
				'REPRESENTS' => $represents_display_lookup[$competitor->represents_id],
				'TOURNAMENT' => $tournament->name
			));
	}		
	
	
} else if (isset($_POST["Get_Competitor_Results"])) {



	$total_competitor_count = 0;

	 $smarty->assign("results_mode", "Competitor");	
	 $results_mode = "Competitor";

	$competitor = DB_DataObject::factory('competitors');
	$competitor->first_name = strip_tags($_POST["First_Name"]);
	$competitor->last_name = strip_tags($_POST["Last_Name"]);
	$competitor->DOB = $_POST["DOB_Year"]."-".$_POST["DOB_Month"]."-".$_POST["DOB_Day"];
	$competitor->find();
	while ($competitor->fetch()) {
		
		$smarty->assign("competitor_name", Get_Competitor_Name($competitor->competitor_id));
		
		
		
		$selected_competitor = $competitor->competitor_id;
		
		$tournament = DB_DataObject::factory('tournaments');
		$tournament->tournament_id = $competitor->tournament_id;
		$tournament->find();
		if ($tournament->fetch()) {
		
			$smarty->append('tournament_list', array(
			  'ID'        		=> $tournament->tournament_id,
			  'NAME' 			=> $tournament->name,     
			  'LOCATION'  		=> $tournament->location,     
			  'DATE_FROM'     	=> $tournament->date_from,
			  'DATE_TO' 		=> $tournament->date_to
			   ));
			
			$selected_tournament = $tournament->tournament_id;
		
			$smarty->append("champs_list", array(
				'NAME' => Get_Competitor_Name($competitor->competitor_id),
				'PLACE' => Convert_Place_To_Result($competitor->overall_place),
				'DESCRIPTION' => $competitor->overall_description,
				'REPRESENTS' => $represents_display_lookup[$competitor->represents_id],
				'TOURNAMENT' => $tournament->name
				));
		
		
			// for getting get all the events for the active tournament.
		 	$tournament_events_list = DB_DataObject::factory('tournament_events');
		 	$tournament_events_list->tournament_id = $selected_tournament;
			$events = DB_DataObject::factory('events');
			$tournament_events_list->selectAs();
			$tournament_events_list->joinAdd($events, "INNER", 'events', 'event_id');
			$tournament_events_list->selectAs($events, 'events_%s'); 	
		  	
		  	
		  	
		  	if ($tournament_events_list->find()) {
	
			 		
			 	while ($tournament_events_list->fetch()) {
					  
				   	// for getting all the divisions in each active event
				  	$tournament_divisions = DB_DataObject::factory('divisions');	  
				   	$tournament_divisions->tournament_id = $selected_tournament;
				   	$tournament_divisions->event_id = $tournament_events_list->event_id;	
					$tournament_divisions->orderBy("sequence ASC");
					
					$tournament_divisions->find();
			
					while ($tournament_divisions->fetch()) {
						
						$smarty->append('competitor_division_starts', $total_competitor_count);
						
						$competitor_count = 0;	
				  
					   	$competitor_divisions = DB_DataObject::factory('competitor_events');	  
					  	$competitor_divisions->division_id = $tournament_divisions->division_id;
			
						
						if ($tournament_divisions->type == "Round_Robin") {
							$return = Get_Round_Robin_Results($tournament_divisions->division_id, $competitor_count, 0, $selected_competitor);			
						} else if ($tournament_divisions->type == "Form_Individual" || $tournament_divisions->type == "Form_Team") {
							$return = Get_Form_Results($tournament_divisions->division_id, $competitor_count, 0, $selected_competitor);
						} else if ($tournament_divisions->type == "Elimination" || $tournament_divisions->type == "Repercharge") {		
							Get_Round_Results($tournament_divisions->division_id, 1, "1st", "2nd", $competitor_count, 0, $selected_competitor);
							
							if ($tournament_divisions->minor_final == "3rd4th") {
								Get_Round_Results($tournament_divisions->division_id, 2, "3rd", "4th", $competitor_count, 0, $selected_competitor);
							} else if ($tournament_divisions->minor_final == "3rd3rd") {
								Get_Round_Results($tournament_divisions->division_id, 2, "3rd", "3rd", $competitor_count, 0, $selected_competitor);			
							}
						}
						$smarty->append('competitor_division_count', $competitor_count);
						$total_competitor_count += $competitor_count;
						$smarty->append('division_list', array(
							'TOURNAMENT_ID'		=> $selected_tournament,
							'DIVISION_ID'		=> $tournament_divisions->division_id,
							'EVENT_ID'			=> $tournament_events_list->event_id,
							'EVENT'				=> $tournament_events_list->events_name,
							'DIVISION'			=> $tournament_divisions->name,
							'COMPETITOR_COUNT'	=> $competitor_count,
							'SECTION_NAME'		=> Get_Section_Name($tournament_divisions->section_id)
						));
			
					}	
						
				}
		  	}
		}
		
	}	
	
	Get_Champion_Results($selected_competitor);
	
// if no particular mode has been selected.
} else {
 	$smarty->assign("results_mode", "Get");
  	$results_mode = "Get"; 			
}

if ($results_mode == "Get") {
 		
	// get a list of possible tournaments
	$tournament = DB_DataObject::factory('tournaments');
	$tournament->find();	
	$temp1_list_array = array();
	while ($tournament->fetch())  { 	
		$temp1_list_array[$tournament->tournament_id] = $tournament->date_from." ".$tournament->name." @ ".$tournament->location;
	}
	$smarty->assign('tournament_select_list', $temp1_list_array); 

	// get a list of possible sections	
	$section = DB_DataObject::factory('sections');
	$section->find();	
	$temp2_list_array = array();
	while ($section->fetch())  { 
		$tournament = DB_DataObject::factory('tournaments');
		$tournament->tournament_id = $section->tournament_id;
		$tournament->find();
		$tournament->fetch();			
		$temp2_list_array[$section->section_id] = $section->name." - ".$tournament->name." (".$tournament->date_from.")";
	}
	$smarty->assign('section_select_list', $temp2_list_array); 

	// get a list of possible represents
	$represents = DB_DataObject::factory('represents');
	$represents->find();	
	$temp3_list_array = array();
	while ($represents->fetch())  { 	
		$temp3_list_array[$represents->represents_id] = stripslashes($represents->name);
	}
	$smarty->assign('represents_select_list', $temp3_list_array); 
		
}

	$smarty->assign('AT_LEAST_ONE_CHAMPS', $at_least_one_champs);
	
	$smarty->display('results.tpl');
	
?>
