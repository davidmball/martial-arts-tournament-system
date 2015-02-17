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
$smarty->caching = 1;
$smarty->compile_check = true;
require 'loginlogout.php';
require 'configDB.php';
require 'utility.php';
$smarty->assign('current_menu', "Registration");


// handles changes to the enrolment state.
// processes all competitors for this tournament.
if(isset($_POST["Submit"])) {

	$competitors = DB_DataObject::factory('competitors');
	$competitors->whereAdd("tournament_id = ".$competitors->escape($active_tournament->tournament_id));
	$competitors->whereAdd("competitors.competitor_count = 0");		
	$competitors->find();	
	while($competitors->fetch()) {
		
		$competitor = DB_DataObject::factory('competitors');
		$competitor->get($competitors->competitor_id);
		$competitor->enrolment = $_POST["enrolment".(string) $competitors->competitor_id];
		$competitor->received_form = isset($_POST["paperwork".(string) $competitors->competitor_id]);
		$competitor->update();		
	}
	
	$smarty->clear_cache('registration.tpl');
}




$competitors = DB_DataObject::factory('competitors');
$competitors->whereAdd("tournament_id = ".$competitors->escape($active_tournament->tournament_id));


$represents = DB_DataObject::factory('represents');
$competitors->selectAs();
$competitors->joinAdd($represents, "INNER", 'represents', 'represents_id');
$competitors->selectAs($represents, 'represent_%s');

if ($user_access == "manager") {
	$auth_represents_connection = DB_DataObject::factory('auth_represents_connection');
 	$auth_represents_connection->whereAdd("tournament_id = ".$active_tournament->tournament_id); 	// zzz	
}


/*
if (!isset($_SESSION['sort_direction'])) {
	$_SESSION['sort_direction'] = "DESC";
}

if (isset($_GET["sort"])) {
	if ($_SESSION['sort_direction'] == "DESC") {
		$_SESSION['sort_direction'] = "ASC";
	} elseif ($_SESSION['sort_direction'] == "ASC") {
		$_SESSION['sort_direction'] = "DESC";
	} 
	
	if (!($_GET["sort"] == "paid_amount" && $user_access == "manager"))
		$competitors->orderBy($competitors->escape($_GET["sort"])." ".$_SESSION['sort_direction']);
		
	$smarty->clear_cache('registration.tpl');
}
*/

$competitors->orderBy("LAST_NAME ASC");

if (!$smarty->is_cached('registration.tpl') || $user_access == "manager" || $user_access == "admin") {

/*
 *  This is for optimisation and makes an array of [competitor_id][event_id] = [1,0]
 */
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
/*
				if (!isset($team_competitor_event[$team_competitor->team_competitor_id1][$active_tournament_events_id[$i]])) $team_competitor_event[$team_competitor->team_competitor_id1][$active_tournament_events_id[$i]] = 1;
				if (!isset($team_competitor_event[$team_competitor->team_competitor_id2][$active_tournament_events_id[$i]])) $team_competitor_event[$team_competitor->team_competitor_id2][$active_tournament_events_id[$i]] = 1;
				if (!isset($team_competitor_event[$team_competitor->team_competitor_id3][$active_tournament_events_id[$i]])) $team_competitor_event[$team_competitor->team_competitor_id3][$active_tournament_events_id[$i]] = 1;
				if (!isset($team_competitor_event[$team_competitor->team_competitor_id4][$active_tournament_events_id[$i]])) $team_competitor_event[$team_competitor->team_competitor_id4][$active_tournament_events_id[$i]] = 1;
				if (!isset($team_competitor_event[$team_competitor->team_competitor_id5][$active_tournament_events_id[$i]])) $team_competitor_event[$team_competitor->team_competitor_id5][$active_tournament_events_id[$i]] = 1;
				if (!isset($team_competitor_event[$team_competitor->team_competitor_id6][$active_tournament_events_id[$i]])) $team_competitor_event[$team_competitor->team_competitor_id6][$active_tournament_events_id[$i]] = 1;
*/
				if (!isset($team_competitor_event[$team_competitor->team_competitor_id1][$active_tournament_events_id[$i]])) $team_competitor_event[$team_competitor->team_competitor_id1][$active_tournament_events_id[$i]] = eventidtostring($active_tournament_events_id[$i]);
				if (!isset($team_competitor_event[$team_competitor->team_competitor_id2][$active_tournament_events_id[$i]])) $team_competitor_event[$team_competitor->team_competitor_id2][$active_tournament_events_id[$i]] = eventidtostring($active_tournament_events_id[$i]);
				if (!isset($team_competitor_event[$team_competitor->team_competitor_id3][$active_tournament_events_id[$i]])) $team_competitor_event[$team_competitor->team_competitor_id3][$active_tournament_events_id[$i]] = eventidtostring($active_tournament_events_id[$i]);
				if (!isset($team_competitor_event[$team_competitor->team_competitor_id4][$active_tournament_events_id[$i]])) $team_competitor_event[$team_competitor->team_competitor_id4][$active_tournament_events_id[$i]] = eventidtostring($active_tournament_events_id[$i]);
				if (!isset($team_competitor_event[$team_competitor->team_competitor_id5][$active_tournament_events_id[$i]])) $team_competitor_event[$team_competitor->team_competitor_id5][$active_tournament_events_id[$i]] = eventidtostring($active_tournament_events_id[$i]);
				if (!isset($team_competitor_event[$team_competitor->team_competitor_id6][$active_tournament_events_id[$i]])) $team_competitor_event[$team_competitor->team_competitor_id6][$active_tournament_events_id[$i]] = eventidtostring($active_tournament_events_id[$i]);
			}		

		}
	}
	$i++;
} 




$competitors->find();
//DB_DataObject::debugLevel(0);

while ($competitors->fetch()) {

	 // find out if the logged in manager can edit this competitor
	 if ($user_access == "manager") {	
	
	 	$auth_represents_connection_c = clone $auth_represents_connection;	
	 	$auth_represents_connection_c->whereAdd("represents_id = '".$competitors->represents_id."'");
	 	$auth_represents_connection_c->whereAdd("user_id = '".$user_id."'");
	
	 	if ($auth_represents_connection_c->find())
	 		$edit = true;
	 	else
	 		$edit = false;
	 } else {
	 	$edit = false;
	 }	
	 
	if ($competitors->competitor_count > 0) {
		
      $smarty->append('teams', array(
          'ID' 				=> $competitors->competitor_id,
          'TOURNAMENT_ID'   => $competitors->tournament_id,
          'REPRESENTS_NAME'	=> stripslashes($competitors->represent_name),
          'TEAM_NAME' 		=> stripslashes($competitors->first_name), 
          'CAPTAIN_NAME'	=> Get_Competitor_Name($competitors->team_competitor_id1),              
	      'EDIT'			=> $edit	
       ));

		$i = 0;
		$temp_selection_array = array();
		while (isset($active_tournament_events_id[$i])) {
		//	if ($temp_selection_team_event[$i]) {
				$competitor_events = DB_DataObject::factory('competitor_events');
				$competitor_events->competitor_id = $competitors->competitor_id;
				$competitor_events->event_id = $active_tournament_events_id[$i];
				if ($competitor_events->find()) {
					$temp_selection_array[$i] = eventidtostring($competitor_events->event_id);
				} else {
					$temp_selection_array[$i] = " ";
				}
		//	}
			$i++;
		}	
		$smarty->append('teams_events', $temp_selection_array);
	       	
	} else {

      $smarty->append('competitors', array(
          'ID' 				=> $competitors->competitor_id,
          'PAPERWORK_RECEIVED'		=> $competitors->received_form,
          'TOURNAMENT_ID'   => $competitors->tournament_id,
          'REPRESENTS_NAME'	=> stripslashes($competitors->represent_name),
          'FIRST_NAME' 		=> stripslashes($competitors->first_name),               
          'LAST_NAME'  		=> stripslashes($competitors->last_name),
	      'GENDER'			=> $competitors->gender, 
	      'RANK'			=> $rank_display_lookup_name[$competitors->rank_id],              	      	      
	      'PAID_AMOUNT'		=> $competitors->paid_amount,
	      'ENROLMENT'		=> $competitors->enrolment,
	      'OWED_AMOUNT'		=> Get_Payment_Amount($active_tournament->payment_id, $competitors->competitor_id, $competitors->DOB, $active_tournament->tournament_id, $active_tournament->date_from),
	      'EDIT'			=> $edit	
       ));


		
		$i = 0;
		$events_array = array();
		
		// get all the teams
		

		$competitor_events = DB_DataObject::factory('competitor_events');
		$team_competitors = DB_DataObject::factory('competitors');				
		while (isset($active_tournament_events_id[$i])) {
			if ($temp_selection_team_event[$i]) {
				
//				if ($competitors->competitor_id == 752)
//					echo "here ".$competitors->competitor_id." ".$active_tournament_events_id[$i]." ".isset($team_competitor_event[$competitors->competitor_id][$active_tournament_events_id[$i]]);
//				$events_array[$i] = isset($team_competitor_event[$competitors->competitor_id][$active_tournament_events_id[$i]]);
				if (isset($team_competitor_event[$competitors->competitor_id][$active_tournament_events_id[$i]]))
					$events_array[$i] = $team_competitor_event[$competitors->competitor_id][$active_tournament_events_id[$i]];
				else
					$events_array[$i] = " ";
				
/*
				// also need to check what team events they are in
				$events_array[$i] = 0;
				for ($id = 1; $id < 6 + 1; $id++) {
					$team_competitor = clone $team_competitors;
					$team_competitor->query("SELECT * FROM {$competitors->__table} WHERE team_competitor_id".(string)$id." = ".$competitors->competitor_id);		
					while ($team_competitor->fetch()) {	
						$competitor_event = clone $competitor_events;
						$competitor_event->competitor_id = $team_competitor->competitor_id;
						$competitor_event->event_id = $active_tournament_events_id[$i];
						$events_array[$i] = $competitor_event->find();
					}

				} 	
*/						
			} else {
				$competitor_event = clone $competitor_events;
				$competitor_event->competitor_id = $competitors->competitor_id;
				$competitor_event->event_id = $active_tournament_events_id[$i];
//				$events_array[$i] = $competitor_event->find();			
				if ($competitor_event->find())
					$events_array[$i] = eventidtostring($competitor_event->event_id);
				else
					$events_array[$i] = " ";
			}
			$i++;	
		}

					
		$smarty->append('competitors_events', $events_array);
	}
}	
       


$smarty->assign('user_represents', $user_represents);

}

// the admin / manager one is not cached
if ($user_access == "manager" || $user_access == "admin")
	$smarty->display('manager_registration.tpl');
else
	$smarty->display('registration.tpl');

	$smarty->clear_cache('manager_registration.tpl');
	
?>
