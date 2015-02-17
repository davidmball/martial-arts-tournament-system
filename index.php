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

require_once('DB/DataObject.php');
require 'configDB.php';
require 'utility.php';

$smarty->assign('current_menu', "Main");


if(isset($_POST["Submit"])) {
	// make them all inactive first
	$tournament = DB_DataObject::factory('tournaments');
	$tournament->find();
	while ($tournament->fetch()) {
		$tournament->active = 0;
		$tournament->update();				
	}

	//activate the selected one
	
	$tournament = DB_DataObject::factory('tournaments');
	$tournament->tournament_id = $_POST["Active"];
	$tournament->find();
	$tournament->fetch();
	$tournament->active = true;	
	$tournament->update();

	$smarty->clear_cache('registration.tpl');
}

if ($user_access == "admin") {
	$tournament = DB_DataObject::factory('tournaments');
	
	$tournament->find();
	 while ($tournament->fetch()) {

		$competitor = DB_DataObject::factory('competitors');
		$competitor->tournament_id = $tournament->tournament_id;
		$competitor->competitor_count = 0;
		$competitor_count = $competitor->find();
	
	      $smarty->append('tournaments', array(
	      'ID'        									=> $tournament->tournament_id,
	      'NAME' 									=> $tournament->name,     
	      'LOCATION'  							=> $tournament->location,     
	      'DATE_FROM'     					=> $tournament->date_from,
	      'DATE_TO' 								=> $tournament->date_to,
	      'ACTIVE'  								=> $tournament->active,
	      'SCHEDULE_HTML' 				=> stripslashes($tournament->schedule_html),
	      'COMPETITOR_COUNT'		=> $competitor_count,
	      'TOURNAMENT_FORM_PDF' => $tournament->tournament_form_pdf,
	      'LOGO_NAME'						=> $tournament->logo_name  
	   ));
	}
} else {

	$competitor = DB_DataObject::factory('competitors');
	$competitor->tournament_id = $active_tournament->tournament_id;
	$competitor->competitor_count = 0;	
	$competitor_count = $competitor->find();
	$smarty->assign('competitor_count', $competitor_count);
	
	$competitor = DB_DataObject::factory('competitors');
	$competitor->tournament_id = $active_tournament->tournament_id;
	$competitor->whereAdd("competitors.competitor_count > 0");	
	$competitor_count = $competitor->find();
	$smarty->assign('team_competitor_count', $competitor_count);	
}

$smarty->display('index.tpl');

?>