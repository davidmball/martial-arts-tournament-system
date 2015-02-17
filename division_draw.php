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


$POINTS_WIN = 3;
$POINTS_DRAW = 1;
$POINTS_LOSE = 0;

// TODO: Check that a division has been included in the url and that it is valid.
// and don't use the get[division_id] ... make sure this is formatted coreectly at the start
if (!isset($_GET["DIVISION_ID"])) {
	header('Location: '.$site_root.'index.php' ) ;	
}

//$uri_division = filter_var($_GET["DIVISION_ID"], FILTER_VALIDATE_INT); cyberwurx php version too low
$uri_division = $_GET["DIVISION_ID"];

if ($uri_division == 0 || $uri_division == FALSE) {
	$smarty->assign('bad_divsion_id', true);
	$smarty->display('division_draw.tpl');	
}

$competitor_list_id = Get_Competitor_IDs_Division($_GET["DIVISION_ID"]);
$competitors_in_draw = count($competitor_list_id);
$smarty->assign("competitors_in_draw", $competitors_in_draw);

$division = DB_DataObject::factory('divisions');
$division->division_id = $_GET["DIVISION_ID"];
$division->find();
$division->fetch();
$smarty->assign("division", array(
	'NAME' 				=> $division->name,
	'ID' 				=> $division->division_id,
	'ROUND_MIN' 		=> $division->round_min,
	'ROUNDS' 			=> $division->rounds,
	'BREAK_MIN' 		=> $division->break_min,
	'NUM_COMPETITORS' 	=> $competitors_in_draw,
	'MINOR_FINAL' 		=> $division->minor_final,
	'TYPE'				=> $division->type,
	'EVENT_NAME'		=> Get_Event_Name($division->event_id),
	'SECTION_NAME'		=> Get_Section_Name($division->section_id),
	'TECHNIQUE1'		=> $division->technique1,
	'TECHNIQUE2'		=> $division->technique2,
	'TECHNIQUE3'		=> $division->technique3,
	'TECHNIQUE4'		=> $division->technique4,
	'TECHNIQUE5'		=> $division->technique5,						
));

// determine how many techniques there are
$num_techs = 0;
if ($division->technique1 != "") $num_techs++;
if ($division->technique2 != "") $num_techs++;
if ($division->technique3 != "") $num_techs++;
if ($division->technique4 != "") $num_techs++;
if ($division->technique5 != "") $num_techs++;

$smarty->assign("num_techs", $num_techs);

/*
 * Form Types
 */
if ($division->type == "Form_Individual" || $division->type == "Form_Team") {

									
	if (isset($_POST["Submit"])) {

		
		$technique1 = array();
		$technique2 = array();
		$technique3 = array();
		$technique4 = array();
		$technique5 = array();
		$extra1 = array();
		$extra2 = array();
		$place = array();
		$round = 1;
		while ($round < $competitors_in_draw + 1) {
			if (isset($_POST["round".(string) $round."Technique1"])) $technique1[$round] = $_POST["round".(string) $round."Technique1"]; else $technique1[$round] = 0;
			if (isset($_POST["round".(string) $round."Technique2"])) $technique2[$round] = $_POST["round".(string) $round."Technique2"]; else $technique2[$round] = 0;
			if (isset($_POST["round".(string) $round."Technique3"])) $technique3[$round] = $_POST["round".(string) $round."Technique3"]; else $technique3[$round] = 0;
			if (isset($_POST["round".(string) $round."Technique4"])) $technique4[$round] = $_POST["round".(string) $round."Technique4"]; else $technique4[$round] = 0;
			if (isset($_POST["round".(string) $round."Technique5"])) $technique5[$round] = $_POST["round".(string) $round."Technique5"]; else $technique5[$round] = 0;
			if (isset($_POST["round".(string) $round."Extra1"])) $extra1[$round] = $_POST["round".(string) $round."Extra1"]; else $extra1[$round] = 0;
			if (isset($_POST["round".(string) $round."Extra2"])) $extra2[$round] = $_POST["round".(string) $round."Extra2"]; else $extra2[$round] = 0;
			if (isset($_POST["round".(string) $round."Place"])) $place[$round] = $_POST["round".(string) $round."Place"]; else $place[$round] = 0;									
		
			$round++;
		}
		
		Update_Results_From_Forms($_GET["DIVISION_ID"], $division->type, $competitors_in_draw, $technique1, $technique2, $technique3, $technique4, $technique5, $extra1, $extra2, $place);
	}


	$round = 1;
	
	while ($round < $competitors_in_draw + 1) {

		$results = DB_DataObject::factory('results');
		$results->division_id = $_GET["DIVISION_ID"];		
		$results->round_id = $round;
		$results->find();				
		$results->fetch();
		
		$competitor = DB_DataObject::factory('competitors');
		$competitor->competitor_id = $results->competitor_red_id;
		$competitor->find();
		$competitor->fetch();

		$total_points = $results->technique1 + $results->technique2 + $results->technique3 + $results->technique4 + $results->technique5;
		$final_points = $total_points + $results->extra1 + $results->extra2;
		
		$smarty->append("competitors", array(
			'ROUND_NUMBER'			=> $round,
			'NAME' 					=> Get_Competitor_Name($results->competitor_red_id), 
			'ID'					=> $results->competitor_red_id,
			'REPRESENTS' 			=> $represents_display_lookup[$competitor->represents_id],
			'ENROLMENT'				=> $competitor->enrolment,
			'TECHNIQUE1'			=> $results->technique1,
			'TECHNIQUE2'			=> $results->technique2,
			'TECHNIQUE3'			=> $results->technique3,
			'TECHNIQUE4'			=> $results->technique4,
			'TECHNIQUE5'			=> $results->technique5,
			'TOTAL_POINTS'			=> $total_points,
			'EXTRA_TEST1_POINTS' 	=> $results->extra1,
			'EXTRA_TEST2_POINTS'	=> $results->extra2,
			'FINAL_POINTS'			=> $final_points,
			'PLACE'					=> $results->place					
		));

		$round++;			
	}

	$smarty->display('division_draw.tpl');

/*
 * Round Robin
 */
} else if ($division->type == "Round_Robin") {
	
	
	if (isset($_POST["Submit"])) {
		
		$stored_result = array();
		
		if ($competitors_in_draw % 2 == 0)
			$extra_rounds = floor($competitors_in_draw/2);
		else
			$extra_rounds = 0;
			
		for ($i = 1; $i < $competitors_in_draw * ($competitors_in_draw - 1)/2 + 1 + $extra_rounds; $i++) {
			$stored_result[$i] = DB_DataObject::factory('results');
			$stored_result[$i]->division_id = $_GET["DIVISION_ID"];	
			$stored_result[$i]->round_id = $i;
			$stored_result[$i]->find();
			$stored_result[$i]->fetch();
			if (1 == $i % floor($competitors_in_draw/2))
		    	if (isset($_POST["competitor_".(string) $i."Place"])) $stored_result[$i]->place = $_POST["competitor_".(string) $i."Place"]; else $stored_result[$i]->place = 0;
		    
			if (isset($_POST["round_".(string) $i."_Score_Left"])) $stored_result[$i]->extra1 = $_POST["round_".(string) $i."_Score_Left"]; else $stored_result[$i]->extra1 = 0;		    
			 if (isset($_POST["round_".(string) $i."_Score_Right"])) $stored_result[$i]->extra2 = $_POST["round_".(string) $i."_Score_Right"]; else $stored_result[$i]->extra2 = 0;
		}

	   Clear_Division($_GET["DIVISION_ID"]);
			
		for ($round = 1; $round < $competitors_in_draw * ($competitors_in_draw - 1)/2 + 1 + $extra_rounds; $round++) {
  
			$results = DB_DataObject::factory('results');
			$results->division_id = $_GET["DIVISION_ID"];		
			$results->round_id = $round;
			
			$results->competitor_red_id = $stored_result[$round]->competitor_red_id;
			$results->competitor_blue_id = $stored_result[$round]->competitor_blue_id;
			$results->colour_win = 'N';	
			
			$results->technique1 = 0;		
			$results->technique2 = 0;
			$results->technique3 = 0;
			$results->technique4 = 0;
			$results->technique5 = 0;
			$results->extra1 = $stored_result[$round]->extra1;
			$results->extra2 = $stored_result[$round]->extra2;
			$results->place = $stored_result[$round]->place;
			$results->user_id = $user_id;
			$results->last_updated = date("Y-m-d H:i:s");			
			$results->insert();
		}
	}

	if ($competitors_in_draw < 3 || $competitors_in_draw > 12) {
		$smarty->assign('unable_to_draw', true);
		$smarty->display('division_draw.tpl');
	} else {
	
		$competitor_wins = array();
		$competitor_loses = array();
		$competitor_draws = array();
		$competitor_points = array();
		$competitor_score_diff = array();
	
		for ($competitor_id = 0; $competitor_id < $competitors_in_draw; $competitor_id++ ) {

			$competitor_wins[$competitor_list_id[$competitor_id]] = 0;
			$competitor_loses[$competitor_list_id[$competitor_id]] = 0;
			$competitor_draws[$competitor_list_id[$competitor_id]] = 0;
			$competitor_points[$competitor_list_id[$competitor_id]] = 0;
			$competitor_score_diff[$competitor_list_id[$competitor_id]] = 0;
		}	
	
	 $round = 1;
		
		while ($round < $competitors_in_draw * ($competitors_in_draw - 1)/2 + 1) {
	
			$results = DB_DataObject::factory('results');
			$results->division_id = $_GET["DIVISION_ID"];		
			$results->round_id = $round;
			$results->find();				
			$results->fetch();
		
			$smarty->append("rounds", array(
				'ROUND_NUMBER'			=> $round,
				'NAME_LEFT' 					=> Get_Competitor_Name($results->competitor_red_id),
				'NAME_RIGHT' 					=> Get_Competitor_Name($results->competitor_blue_id),				 
				'ID_LEFT'					=> $results->competitor_red_id,
				'ID_RIGHT'					=> $results->competitor_blue_id,
				'SCORE_LEFT'			=> $results->extra1,
				'SCORE_RIGHT'		=> $results->extra2			
			));
			
			$competitor_score_diff[$results->competitor_red_id] +=  $results->extra1;	
			$competitor_score_diff[$results->competitor_red_id] -=  $results->extra2;			
			$competitor_score_diff[$results->competitor_blue_id] -=  $results->extra1;			
			$competitor_score_diff[$results->competitor_blue_id] +=  $results->extra2;
									
			if ($results->extra1 > $results->extra2) {
				$competitor_wins[$results->competitor_red_id]++;
				$competitor_points[$results->competitor_red_id] += $POINTS_WIN;
				$competitor_loses[$results->competitor_blue_id]++;
				$competitor_points[$results->competitor_blue_id] += $POINTS_LOSE;
			} else if ($results->extra2 > $results->extra1) {
				$competitor_wins[$results->competitor_blue_id]++;
				$competitor_points[$results->competitor_blue_id] += $POINTS_WIN;				
				$competitor_loses[$results->competitor_red_id]++;					
				$competitor_points[$results->competitor_red_id] += $POINTS_LOSE;				
			} else {
				$competitor_draws[$results->competitor_blue_id]++;
				$competitor_points[$results->competitor_blue_id] += $POINTS_DRAW;					
				$competitor_draws[$results->competitor_red_id]++;						
				$competitor_points[$results->competitor_red_id] += $POINTS_DRAW;					
			}
			$round++;			
		}		
		
		
		for ($round = 1, $competitor = 0; $competitor < $competitors_in_draw; $competitor++, $round = $round + floor($competitors_in_draw/2)) {
			$results = DB_DataObject::factory('results');
			$results->division_id = $_GET["DIVISION_ID"];		
			$results->round_id = $round;
			$results->find();				
			$results->fetch();
		
			$smarty->append("competitors", array(
				'NAME' 							=> Get_Real_Competitor_Name($results->competitor_blue_id),		 
				'ID'									=> $results->competitor_blue_id,	
				'ROUND'						=> $round,
				'PLACE'							=> $results->place,
				'WINS'							=> $competitor_wins[$results->competitor_blue_id],
				'DRAWS'						=> $competitor_draws[$results->competitor_blue_id],
				'LOSES'							=> $competitor_loses[$results->competitor_blue_id],
				'POINTS'						=> $competitor_points[$results->competitor_blue_id],
				'DIFF'								=> $competitor_score_diff[$results->competitor_blue_id] 
			));	
		}

		$smarty->display('division_draw.tpl');		
	}
	
/*
 * Draw Types
 */
} else if ($division->type == "Elimination" || $division->type == "Repercharge") {
	
if ($competitors_in_draw < 2 || $competitors_in_draw > 32 || ($division->type == "Repercharge" && $competitors_in_draw > 16)|| ($division->type == "Repercharge" && $competitors_in_draw < 5)) {
	$smarty->assign('unable_to_draw', true);
	$smarty->display('division_draw.tpl');
} else {


if (isset($_POST["Clear"])) {
	Clear_Results_And_Init_Division($_GET["DIVISION_ID"]); 
}

$competitor_list = 0;

for ($i = $round_count_lookup[$competitors_in_draw]; $i > 0; $i--) {
	$round_red[$i] = 0;
	$round_blue[$i] = 0;
	$round_win[$i] = "N";	
	
	if ($i > $round_count_lookup[$competitors_in_draw]/2) {
		if ($i > ($competitors_in_draw)) {
			$round_red[$i] = $competitor_list_id[$competitor_list++];
			$round_win[$i] = "Y"; // bye			
		} else {
			$round_red[$i] = $competitor_list_id[$competitor_list++];
			$round_blue[$i] = $competitor_list_id[$competitor_list++];
		}
	}
	
	// get when the division was last updated, by who, and what the result was
	$results = DB_DataObject::factory('results');
	$results->division_id = $_GET["DIVISION_ID"];		
	$results->round_id = $i;
	$results->find();				
	$results->fetch();
	$stored_round_colour_win[$i] = $results->colour_win;
	$stored_round_last_updated[$i] = $results->last_updated;
	$stored_round_user_id[$i] = $results->user_id;
}

if ($division->type == "Repercharge") {
	for ($i = $loser_round_count_lookup[$competitors_in_draw] + 100; $i > 100; $i--) {
		
		$round_red[$i] = 0;
		$round_blue[$i] = 0;
		$round_win[$i] = "N";	

		if (isset($repercharge_bye_lookup[$competitors_in_draw][$i])) {
			$round_win[$i] = "Y";
		}
		
		// get when the division was last updated, by who, and what the result was
		$results = DB_DataObject::factory('results');
		$results->division_id = $_GET["DIVISION_ID"];		
		$results->round_id = $i;
		$results->find();				
		$results->fetch();
		$stored_round_colour_win[$i] = $results->colour_win;
		$stored_round_last_updated[$i] = $results->last_updated;
		$stored_round_user_id[$i] = $results->user_id;
	}
}

// a hack for 3 competitors because there will be no 3rd/4th playoff
if ($competitors_in_draw == 3) {
	$round_win[2] = "Y";
	if (isset($_POST["3"])) {
		
		if ($_POST["3"] == "B") {
			$round_red[2] = $round_red[3];			
		} else {
			$round_red[2] = $round_blue[3];				
		}
	}
}

if (isset($_POST["Submit"])) {

	// ineffecient but simple	 
	Clear_Division($_GET["DIVISION_ID"]); 

	for ($i = $round_count_lookup[$competitors_in_draw]; $i > 0; $i--) {
		
		if (isset($_POST[(string) $i])) {

			$round_win[$i] = $_POST[(string) $i];			

			
			if (isset($win_results_lookup_colour[$i])) {
						
				
				if ($win_results_lookup_colour[$i] == "R") {
					if ($_POST[(string) $i] == "Y") {
						$round_red[$win_results_lookup_round[$i]] = $round_red[$i];
					} else if ($_POST[(string) $i] == "R") {
						$round_red[$win_results_lookup_round[$i]] = $round_red[$i];
					} else {
						$round_red[$win_results_lookup_round[$i]] = $round_blue[$i];
					}
				} else {
					if ($_POST[(string) $i] == "Y") {
						$round_blue[$win_results_lookup_round[$i]] = $round_red[$i];					
					} else if ($_POST[(string) $i] == "R") {
						$round_blue[$win_results_lookup_round[$i]] = $round_red[$i];
					} else {
						$round_blue[$win_results_lookup_round[$i]] = $round_blue[$i];
					}					
				}
			}


			if ($division->type == "Repercharge") {	
				
				if (isset($repercharge_lose_results_lookup_colour[$competitors_in_draw][$i]) && $competitors_in_draw != 3) {
	
					// complicated awful bit of logic to handle to ensure every competitor gets at least 2 fights when they
					// have a by first. This really results in IF clauses in the draw because it depends on whether they
					// win their first non bye fight. in this case only the competitor had the bye should get another fight
					// -1000 is a hacked number for bye used in the name lookup function
					if ($repercharge_lose_results_lookup_colour[$competitors_in_draw][$i] == "R") {
						if ($_POST[(string) $i] == "B") {
							$round_red[abs($repercharge_lose_results_lookup_round[$competitors_in_draw][$i])] = $round_red[$i];
						} else {
							if ($repercharge_lose_results_lookup_round[$competitors_in_draw][$i] < 0)
								$round_red[-1 * $repercharge_lose_results_lookup_round[$competitors_in_draw][$i]] = -1000;
							else
								$round_red[$repercharge_lose_results_lookup_round[$competitors_in_draw][$i]] = $round_blue[$i];
						}
					} else {
						if ($_POST[(string) $i] == "B") {
							$round_blue[$repercharge_lose_results_lookup_round[$competitors_in_draw][$i]] = $round_red[$i];
						} else {
							$round_blue[$repercharge_lose_results_lookup_round[$competitors_in_draw][$i]] = $round_blue[$i];
						}					
					}
				}
				
			} else {
				
				if (isset($lose_results_lookup_colour[$i]) && $competitors_in_draw != 3) {
	
					if ($lose_results_lookup_colour[$i] == "R") {
						if ($_POST[(string) $i] == "B") {
							$round_red[$lose_results_lookup_round[$i]] = $round_red[$i];
						} else {
							$round_red[$lose_results_lookup_round[$i]] = $round_blue[$i];
						}
					} else {
						if ($_POST[(string) $i] == "B") {
							$round_blue[$lose_results_lookup_round[$i]] = $round_red[$i];
						} else {
							$round_blue[$lose_results_lookup_round[$i]] = $round_blue[$i];
						}					
					}
				}
							
			}
			

		} else if ($division->type == "Repercharge" && isset($repercharge_lose_results_lookup_colour[$competitors_in_draw][$i])) {
			if ($repercharge_lose_results_lookup_colour[$competitors_in_draw][$i] == "R") {
				// if the loser part has already been entered don't overwrite it (allows for 'clever' array).
				if ($repercharge_lose_results_lookup_round[$competitors_in_draw][$i] < 0)
					$round_red[-1 * $repercharge_lose_results_lookup_round[$competitors_in_draw][$i]] = -1 * ($i + 100);				
				else
					$round_red[$repercharge_lose_results_lookup_round[$competitors_in_draw][$i]] = -1 * $i;
			} else {
			//	if ($repercharge_lose_results_lookup_round[$competitors_in_draw][$i] > 0)
					$round_blue[$repercharge_lose_results_lookup_round[$competitors_in_draw][$i]] = -1 * $i;
			}
			
		} else if (isset($lose_results_lookup_colour[$i]) && $competitors_in_draw != 3) {
			
			if ($lose_results_lookup_colour[$i] == "R") {
				$round_red[$lose_results_lookup_round[$i]] = -1 * $i;
			} else {
				$round_blue[$lose_results_lookup_round[$i]] = -1 * $i;
			}
		}
	} 
	
	if ($division->type == "Repercharge") {
	
	// 101 is the first loser round. I assume we will never have more than 100 rounds in the elimination part of the draw.
		
		for ($i = $loser_round_count_lookup[$competitors_in_draw] + 100; $i > 100; $i--) {		
			
			if (isset($_POST[(string) $i])) {
				$round_win[$i] = $_POST[(string) $i];
					
				if (isset($repercharge_win_results_lookup_colour[$i])) {
				
					if ($repercharge_win_results_lookup_colour[$i] == "R") {
						if ($_POST[(string) $i] == "Y") {
							$round_red[$repercharge_win_results_lookup_round[$i]] = $round_red[$i];
						} else if ($_POST[(string) $i] == "R") {
							$round_red[$repercharge_win_results_lookup_round[$i]] = $round_red[$i];
						} else {
							$round_red[$repercharge_win_results_lookup_round[$i]] = $round_blue[$i];
						}
					} else {
						if ($_POST[(string) $i] == "Y") {
							$round_blue[$repercharge_win_results_lookup_round[$i]] = $round_red[$i];					
						} else if ($_POST[(string) $i] == "R") {
							$round_blue[$repercharge_win_results_lookup_round[$i]] = $round_red[$i];
						} else {
							$round_blue[$repercharge_win_results_lookup_round[$i]] = $round_blue[$i];
						}					
					}
				}
			
			}

		}
	}


	
	Update_Results_From_Rounds($_GET["DIVISION_ID"], $division->type, $competitors_in_draw, $round_red, $round_blue, $round_win, $stored_round_colour_win, $stored_round_user_id, $stored_round_last_updated);

	
}
		/*
		 * Get the results from the database for the elimination part of the draw.
		 */
		$round = 1;
		while ($round < $round_count_lookup[$competitors_in_draw] + 1 ) {

			$results = DB_DataObject::factory('results');
			$results->division_id = $_GET["DIVISION_ID"];		
			$results->round_id = $round;
			$results->find();				
			$results->fetch();
			
			if ($results->round_id == $round) {
		
				if ($round == 1) {
					if ($results->colour_win == "R") {
						$smarty->assign("FIRST", Get_Competitor_Name($results->competitor_red_id));
						$smarty->assign("SECOND", Get_Competitor_Name($results->competitor_blue_id));
					} else if ($results->colour_win == "B") {
						$smarty->assign("FIRST", Get_Competitor_Name($results->competitor_blue_id));
						$smarty->assign("SECOND", Get_Competitor_Name($results->competitor_red_id));					
					}		
				} else if ($round == 2) {
					if ($results->colour_win == "R") {
						$smarty->assign("THIRD", Get_Competitor_Name($results->competitor_red_id));
						$smarty->assign("FOURTH", Get_Competitor_Name($results->competitor_blue_id));
					} else if ($results->colour_win == "B") {
						$smarty->assign("THIRD", Get_Competitor_Name($results->competitor_blue_id));
						$smarty->assign("FOURTH", Get_Competitor_Name($results->competitor_red_id));					
					} else if ($results->colour_win == "Y") {
						$smarty->assign("THIRD", Get_Competitor_Name($results->competitor_red_id));
					} else if ($division->minor_final == "3rd3rd" && $results->colour_win == "N") {
						$smarty->assign("THIRD", Get_Competitor_Name($results->competitor_blue_id));
						$smarty->assign("FOURTH", Get_Competitor_Name($results->competitor_red_id));							
					} else if ($division->minor_final == "3rd3rd") {
						$smarty->assign("THIRD", "4");
						$smarty->assign("FOURTH", "3");						
					}
				}
				
				$colour_win = $results->colour_win;
			
			} else {
				$colour_win = "N";
			}
			
			
			$smarty->append("round_list", array(
				'ROUND_NUMBER'		=> $round,
				'STYLE_NAME' 	=> "round".$round,
				'RED_NAME' 		=> Get_Competitor_Name($results->competitor_red_id), 
				'RED_ID'		=> $results->competitor_red_id,
				'BLUE_NAME'		=> Get_Competitor_Name($results->competitor_blue_id),
				'BLUE_ID'		=> $results->competitor_blue_id,
				'COLOUR_WIN' 	=> $colour_win
			));

			$round++;
		}

		// get the loser rounds out
		if ($division->type == "Repercharge") {
			
			// 101 is the first loser round. I assume we will never have more than 100 rounds in the elimination part of the draw.
			$round = 101;
			while ($round < $loser_round_count_lookup[$competitors_in_draw] + 101 ) {
			
				$results = DB_DataObject::factory('results');
				$results->division_id = $_GET["DIVISION_ID"];		
				$results->round_id = $round;
				$results->find();				
				$results->fetch();
			
				if ($results->round_id == $round) {
					$colour_win = $results->colour_win;
				} else {
					$colour_win = "N";
				}

				$smarty->append("loser_round_list", array(
					'ROUND_NUMBER_DISPLAY' => "L".($round - 100),
					'ROUND_NUMBER'		=> $round,
					'STYLE_NAME' 	=> "loser_round".$round,
					'RED_NAME' 		=> Get_Competitor_Name($results->competitor_red_id), 
					'RED_ID'		=> $results->competitor_red_id,
					'BLUE_NAME'		=> Get_Competitor_Name($results->competitor_blue_id),
					'BLUE_ID'		=> $results->competitor_blue_id,
					'COLOUR_WIN' 	=> $colour_win
				));
					
				$round++;
			}		
		}
		


// this is just awful ... this handles all the layout of the divisions and all the fringe cases
$css_draw_styles = " ";
if ($competitors_in_draw == 2) {
	$css_draw_styles = ".round1 {padding: 0px; height: 55px; }\n"; 
	$css_draw_styles .= ".draw_results { left: 210px; height:90px; top:-50px; }\n";
} else {
						
	for ($round = $round_count_lookup[$competitors_in_draw], $round_set = 1;
		 $round != 1; 
		 $round = $round/2, $round_set++) {
		
		if ($round == $round_count_lookup[$competitors_in_draw]) {
			$css_draw_styles .= $css_rounds[$round]." { ".$css_round_set[$round_set]." }\n";
		} else if ($round == 2) { 
			$css_draw_styles .= $css_rounds[$round]." { ".$css_round_set[$round_set]." }\n";
			if ($division->type == "Repercharge") {
				if ($round_count_lookup[$competitors_in_draw] == 16) {
					$css_draw_styles .= ".round2 {height: 165px; top: -1010px; }\n";
					$css_draw_styles .= ".round1 {height: 280px; top: -1840px; padding-bottom: 0px;}\n";
					$css_draw_styles .= ".draw_results { left: 840px; top: -2000px; height:180px }\n";	
				} else if ($round_count_lookup[$competitors_in_draw] == 8) {
					$css_draw_styles .= ".round2 {height: 165px; top: -200px; }\n";
					$css_draw_styles .= ".round1 {height: 165px; top: -740px; }\n";
					$css_draw_styles .= ".draw_results { left: 630px; top: -940px; height:180px }\n";					
				}
		
			} else {
				$css_draw_styles .= ".round2 {height: 90px; ".$css_round_set_top[$round_count_lookup[$competitors_in_draw]][$round_set]." }\n";
				$css_draw_styles .= ".round1 {padding: 0px; ".$css_round_set_top_one[$round_count_lookup[$competitors_in_draw]]." }\n"; 
				$css_draw_styles .= ".draw_results { ".$css_round_set[$round_set+1]." ".$css_round_set_top[$round_count_lookup[$competitors_in_draw]][$round_set+1]." height:180px }\n";
			}
			
		} else {
			$css_draw_styles .= $css_rounds[$round]." { ".$css_round_set[$round_set]." ".$css_round_set_top[$round_count_lookup[$competitors_in_draw]][$round_set]." }\n";
		}
	}

	
}

if ($division->type == "Repercharge") {
	for ($round = $loser_round_count_lookup[$competitors_in_draw], $round_set = 1;
	 $round != 1; 
	 $round = $round/2, $round_set++) {
	 	
	 	$css_draw_styles .= $repercharge_css_style[$loser_round_count_lookup[$competitors_in_draw]];
	 	
	 }
}


$smarty->assign("css_draw_styles", $css_draw_styles);		

$smarty->display('division_draw.tpl');

}
}
?>