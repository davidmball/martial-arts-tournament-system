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




if(isset($_POST["Copy_Divisions"])) {
	$divisions = DB_DataObject::factory('divisions');
	$divisions->tournament_id = current($_POST["Tournaments"]);
	$divisions->find();
	while ($divisions->fetch()) {
		$division = DB_DataObject::factory('divisions');
		$division = $divisions;
		$division->tournament_id = $active_tournament->tournament_id;
		$division->section_id = 0;	
		$new_division_id = $division->insert();	
		Clear_Results_And_Init_Division($new_division_id);	
	}

}

$smarty->assign('tournaments_list', Get_Tournament_List());  
   
   
   


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
      	  'SEQUENCE' => $divisions->sequence,
          'NAME'        	=> $divisions->name,
           'TYPE'			=> $divisions->type,
          'EVENT_NAME'		=> $divisions->events_name,  
          'SECTION_NAME'			=> Get_Section_Name($divisions->section_id)
       )); 	
}
echo "<br><br><br><br>";
$smarty->display('admin_divisions.tpl');
echo "<br><br><br><br>";
?>
