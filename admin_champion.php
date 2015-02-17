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
if ($user_access != "admin") {
	$smarty->display('denied.tpl');
	exit;
}
$smarty->assign('current_menu', "Admin");

require_once('DB/DataObject.php');
require 'configDB.php';
require 'utility.php';

echo "<br><br><br><br>";


if (isset($_POST["Submit"])) {
		
	$competitors = DB_DataObject::factory('competitors');
	$competitors->tournament_id = $active_tournament->tournament_id;
	$competitors->find();
	while ($competitors->fetch()) {
		if (isset($_POST["Place".(string) $competitors->competitor_id])) {
			$competitor = DB_DataObject::factory('competitors');
			$competitor->get($competitors->competitor_id);
			$competitor->overall_place = $_POST["Place".(string) $competitors->competitor_id];
			$competitor->overall_description = $_POST["Description".(string) $competitors->competitor_id];
			$competitor->update();
		}
	}
	
}


function Get_Form_Place($division_id, $competitor_id) {

//		echo "GFP id: ".Get_Competitor_Name($competitor_id)." ".$division_id."<br>";

		$results = DB_DataObject::factory('results');
		$results->division_id = $division_id;
		$results->competitor_red_id = $competitor_id;		
		if ($results->find()) {				
			$results->fetch();
			return $results->place;				
		} else {
			return 0;
		}
}


function Get_Round_Place($division_id, $competitor_id, $minor_final) {

		$results = DB_DataObject::factory('results');
		$results->division_id = $division_id;
		$results->competitor_red_id = $competitor_id;
		$results->round_id = 1;		
		if ($results->find()) {	
			$results->fetch();
			if ($results->colour_win == "R") {
				return 1;			
			} else { 			
				return 2;		
			}
		}
		$results = DB_DataObject::factory('results');
		$results->division_id = $division_id;
		$results->competitor_blue_id = $competitor_id;
		$results->round_id = 1;		
		if ($results->find()) {	
			$results->fetch();			
			if ($results->colour_win == "R") {
				return 2;			
			} else {
				return 1;
			}	
		}	
		
		if ($minor_final == "3rd4th" || $minor_final == "3rd3rd") {	
			$results = DB_DataObject::factory('results');
			$results->division_id = $division_id;
			$results->competitor_red_id = $competitor_id;
			$results->round_id = 2;
			$results->colour_win == "R";					
			if ($results->find()) {				
					return 3;				
			}		
			$results = DB_DataObject::factory('results');
			$results->division_id = $division_id;
			$results->competitor_blue_id = $competitor_id;
			$results->round_id = 2;		
			if ($results->find()) {		
				$results->fetch();				
				if ($minor_final == "3rd3rd") {		
					return 3;
				} else if ($minor_final == "3rd4th" && $results->colour_win == "R") {
					return 4;				
				}
			}
		}
		
		return 0;
}


$place_to_points_lookup = array(0 => 0, 1 => 5, 2 => 3, 3 => 2, 4 => 1);


$champs_list = array();
$champ_count = 0;
$event_names = array();


$competitor = DB_DataObject::factory('competitors');

$competitor->tournament_id = $active_tournament->tournament_id;
$competitor->whereAdd("competitor_count = 0");

if (isset($_GET["GENDER"])) {
	if ($_GET["GENDER"] == "Male") {
		$gender = "Male";
	    $competitor->gender = "Male";
	} else if ($_GET["GENDER"] == "Female") {
		$gender = "Female";
	    $competitor->gender = "Female";
	} else {
	   $gender = "All";
	}
	$smarty->assign("GENDER", $gender);
} else {
	$gender = "All";
	$smarty->assign("GENDER", $gender);	
}

$competitor->find();
while ($competitor->fetch()) {
	
	$champs_list[$champ_count] = array();
	$champs_list[$champ_count]["ID"] = $competitor->competitor_id;
	$champs_list[$champ_count]["NAME"] = Get_Competitor_Name($competitor->competitor_id);
	$champs_list[$champ_count]["TOTAL"] = 0;
	$champs_list[$champ_count]["PLACE"] = $competitor->overall_place;
	$champs_list[$champ_count]["DESCRIPTION"] = $competitor->overall_description;
	$champs_list[$champ_count]["GENDER"] = $competitor->gender;
	$champs_list[$champ_count]["AGE"] = GetAgeAtTournament($competitor->DOB, $active_tournament->date_from);

	// for getting get all the events for the active tournament.
 	$tournament_events_list = DB_DataObject::factory('tournament_events');
 	$tournament_events_list->tournament_id =$active_tournament->tournament_id;
	$events = DB_DataObject::factory('events');
	$tournament_events_list->selectAs();
	$tournament_events_list->joinAdd($events, "INNER", 'events', 'event_id');
	$tournament_events_list->selectAs($events, 'events_%s'); 	
	$tournament_events_list->find();		

		  
  	$event_count = 0;
	
	$tournament_events_list->find();	
  	while (	$tournament_events_list->fetch()	) {

		// don't want team events
		if ($tournament_events_list->events_max_competitors > 1)
		 continue;
		
  		if ($champ_count == 0) {
			$event_names[$event_count] = $tournament_events_list->events_name;	
  		}
			  
	   	// for getting all the divisions in each active event
	  	$tournament_divisions = DB_DataObject::factory('divisions');	  
	   	$tournament_divisions->tournament_id = $active_tournament->tournament_id;
	   	$tournament_divisions->event_id = $tournament_events_list->event_id;	
		$tournament_divisions->find();

		$found_competitor = 0;
		while ($tournament_divisions->fetch() && !$found_competitor) {

		   	$competitor_divisions = DB_DataObject::factory('competitor_events');	  
		  	$competitor_divisions->division_id = $tournament_divisions->division_id;
			$competitor_divisions->competitor_id = $competitor->competitor_id;
			if ($competitor_divisions->find()) {
								
				if ($tournament_divisions->type == "Form_Individual" || $tournament_divisions->type == "Form_Team") {
					$place = Get_Form_Place($tournament_divisions->division_id, $competitor->competitor_id);
					$champs_list[$champ_count]["TOTAL"] += $place_to_points_lookup[$place];
					$champs_list[$champ_count][(string) $event_count] = $place_to_points_lookup[$place];			
					$found_competitor = 1;						
				} else if ($tournament_divisions->type == "Elimination" || $tournament_divisions->type == "Repercharge") {							
					$place = Get_Round_Place($tournament_divisions->division_id, $competitor->competitor_id, $tournament_divisions->minor_final);
				   	$champs_list[$champ_count]["TOTAL"] += $place_to_points_lookup[$place];	
					$champs_list[$champ_count][(string) $event_count] = $place_to_points_lookup[$place];
					$found_competitor = 1;		
				} else {
					$champs_list[$champ_count][(string) $event_count] = 0;
					$found_competitor = 1;				
				}
			} else {
				$champs_list[$champ_count][(string) $event_count] = "&nbsp;";							
			}

		}

		$event_count++;					
	}	
  	if ($champ_count == 0) {
  		$smarty->assign("event_count", $event_count);	
  	}
//	echo "id:".$champs_list[$champ_count]["NAME"]." ".$champs_list[$champ_count]["TOTAL"]." ".$champs_list[$champ_count][0]." ".$champs_list[$champ_count][1]." ".$champs_list[$champ_count][2]." ".$champs_list[$champ_count][3]."<br>";
 	$champ_count++;		
}

function msort($array, $id="id", $sort="asc") {
        $temp_array = array();
        while(count($array)>0) {
            $lowest_id = 0;
            $index=0;
            foreach ($array as $item) {
                if (isset($item[$id]) ) {
                    if ($sort == "asc" && ($item[$id]<$array[$lowest_id][$id])) {
                        $lowest_id = $index;
                    } elseif ($sort == "desc" && ($item[$id]>$array[$lowest_id][$id])) {
                        $lowest_id = $index;                  	
                    }
                }
               $index++;
            }
            $temp_array[] = $array[$lowest_id];

            $array = array_merge(array_slice($array, 0,$lowest_id), array_slice($array, $lowest_id+1));

        }
        return $temp_array;
}

		$champs_list = msort($champs_list, "TOTAL", "desc");
	
		$smarty->assign("champs_list", $champs_list);	
		$smarty->assign("event_names", $event_names);
		
		$smarty->display('admin_champion.tpl');

?>
