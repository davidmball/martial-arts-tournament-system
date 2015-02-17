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


$competitors = DB_DataObject::factory('competitors');
$competitors->whereAdd("tournament_id = ".$competitors->escape($active_tournament->tournament_id));

$competitors->orderBy("last_name ASC");

$competitors->find();
 while ($competitors->fetch()) {

	// remove teams
	
	// under 13 years old only
	  
	  if ($competitors->competitor_count == 0 && (GetAgeAtTournament($competitors->DOB, $active_tournament->date_from) < 13)) { 
 		
	      $smarty->append('competitors', array(
		      'ID'        		=> $competitors->competitor_id,
		      'TITLE'			=> $competitors->title,
		      'FIRST_NAME'		=> stripslashes($competitors->first_name),
		      'MIDDLE_NAME'		=> stripslashes($competitors->middle_name),
		      'LAST_NAME' 		=> stripslashes($competitors->last_name),
		      'DOB'				=> $competitors->DOB,
		       ));
	  }
}
    
$smarty->display('admin_participation.tpl');


	
?>