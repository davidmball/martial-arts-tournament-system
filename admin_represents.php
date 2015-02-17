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


$represents = DB_DataObject::factory('represents');

$auth_represents_connection = DB_DataObject::factory('auth_represents_connection');
$users = DB_DataObject::factory('auth');
$auth_represents_connection->selectAs();
$auth_represents_connection->joinAdd($users, "INNER", 'auth', 'user_id');
$auth_represents_connection->selectAs($users, 'users_%s');

$competitors = DB_DataObject::factory('competitors');
$competitors->tournament_id = $active_tournament->tournament_id;
$competitors->whereAdd("tournament_id = ".$competitors->escape($active_tournament->tournament_id));

$represents->find();

 while ($represents->fetch()) {
	
	$auth_represents_connection_c = clone $auth_represents_connection;
	$user_string = "| ";
	$auth_represents_connection_c->whereAdd("auth_represents_connection.represents_id = '".$auth_represents_connection->escape($represents->represents_id)."'");
	$auth_represents_connection_c->find();
	while ($auth_represents_connection_c->fetch()) {
		if ($auth_represents_connection_c->tournament_id == $active_tournament->tournament_id)		// zzz
			$user_string .= $auth_represents_connection_c->users_username." | ";	
	}

	$competitors_c = clone $competitors;
	$competitors_c->whereAdd("competitors.represents_id = ".$represents->represents_id);
	$competitor_count = $competitors_c->find();

      $smarty->append('represents', array(
      	  'ID'				=> $represents->represents_id,
          'REPRESENTS'        => stripslashes($represents->name),
          'USERNAME' 			=> $user_string,     
          'ACTIVE' 			=> $represents->active, 
          'COMPETITOR_COUNT'	=> $competitor_count 
       ));   
}
$smarty->display('admin_represents.tpl');

?>