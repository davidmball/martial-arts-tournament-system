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
$smarty->assign('current_menu', "Admin");


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
			
			$smarty->append('division_list', array(
				'DIVISION_ID'			=> $tournament_divisions->division_id,
				'EVENT_ID'			=> $tournament_events_list->event_id,
				'EVENT'				=> $tournament_events_list->events_name,
				'DIVISION'			=> $tournament_divisions->name,
				'MINOR_FINAL'		=> $tournament_divisions->minor_final,
				'MAX_COMPETITORS' 	=> Get_Event_Max_Competitors($tournament_events_list->event_id),
			));

		}		
	}	
	
	$smarty->display('trophy.tpl');

?>
