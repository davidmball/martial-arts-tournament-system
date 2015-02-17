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


if (isset($_POST["Check_Divisions"])) {
	
	$user = DB_DataObject::factory('auth');		
	$user->active = 1;
	$user->find();
	while ($user->fetch()) {
		EmailCheckDivisionsToUser($user);
	}
}

if(isset($_POST["Copy_Represents"])) {
	$auth_represents_connections = DB_DataObject::factory('auth_represents_connection');
	$auth_represents_connections->whereAdd("tournament_id = ".current($_POST["Tournaments"]));	// zzz	
	$auth_represents_connections->find();
	while 	($auth_represents_connections->fetch()) {
		$auth_represents_connection = DB_DataObject::factory('auth_represents_connection');
		$auth_represents_connection = $auth_represents_connections;
		$auth_represents_connection->tournament_id = $active_tournament->tournament_id;
		$auth_represents_connection->insert();	
	}

}


//DB_DataObject::debugLevel(0);

$user = DB_DataObject::factory('auth');

$auth_represents_connection = DB_DataObject::factory('auth_represents_connection');
$auth_represents_connection->whereAdd("tournament_id = ".$active_tournament->tournament_id);	// zzz
$represents = DB_DataObject::factory('represents');
$auth_represents_connection->selectAs();
$auth_represents_connection->joinAdd($represents, "INNER", 'represents', 'represents_id');
$auth_represents_connection->selectAs($represents, 'represents_%s');

$represents->find(); 


$user->find();
 while ($user->fetch()) {
 	
	$auth_represents_connection_c = clone $auth_represents_connection;
	$represents_string = "| ";
	$auth_represents_connection_c->whereAdd("user_id = '".addslashes($user->user_id)."'");
	$auth_represents_connection_c->find();
	while ($auth_represents_connection_c->fetch()) {
		$represents_string .= $auth_represents_connection_c->represents_name." | ";	
	}
 	
      $smarty->append('users', array(
      	  'ID'				=> $user->user_id,
          'USERNAME'        => $user->username,
          'ACCESS' 			=> $user->access,     
          'EMAIL'  			=> $user->email,     
          'REPRESENTS'     	=> $represents_string,
          'FIRST_NAME' 		=> $user->first_name,
          'LAST_NAME'  		=> $user->last_name,
          'ACTIVE' 			=> $user->active  
       ));
         
    }

$smarty->assign('tournaments_list', Get_Tournament_List());  
  

$smarty->display('admin_users.tpl');
?>