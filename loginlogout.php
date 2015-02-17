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

require_once('DB/DataObject.php');

require 'configDB.php';
require_once('Auth/Auth.php');

// the session is only used to determine caching
session_start();
session_register("cache_username");


function loginFunction($username = null, $status = null, &$auth = null)
{
	global $smarty;
	
	$smarty->display('login.tpl');
	
}
 
    
$auth_options = array(
  'dsn' => "mysql://".$db_username.":".$db_password."@localhost/".$db_name

  );
$a = new Auth("DB", $auth_options, "loginFunction");


if (isset($_REQUEST['logout']) && $_REQUEST['logout'] && $a->getAuth()) {
	$a->start();
	$a->logout();
	session_destroy();
	header('Location: '.$site_root.'index.php' ) ;
	
	$smarty->clear_cache('registration.tpl');
	$smarty->clear_cache('logout.tpl');		
	$HTTP_SESSION_VARS ["cache_username"] = "silly name to force cache to refresh";
}

$a->start();


$user_access = "public";
$user_represents = false;
$username = false;

if ($a->checkAuth()) {

   $smarty->assign('username', $a->getUsername());
   
   $user = DB_DataObject::factory('auth');

	$user->username = $a->getUsername();
	$user->find();
 	$user->fetch();
 	
 	if (!$user->active) {
 		$a->logout();
		session_destroy();
		header('Location: '.$site_root.'index.php' ) ;
 	} else {
	   $user_access = $user->access;
	   $user_represents = $user->represents_id;
	   $user_id = $user->user_id;
	   $username = $a->getUsername();
		
		// if the username has changed clear the cache
//		if (isset($HTTP_SESSION_VARS ["cache_username"]) && $HTTP_SESSION_VARS ["cache_username"] != $username) {
		if ($_SESSION ["cache_username"] != $username) {
			$smarty->clear_cache('registration.tpl');		
			$smarty->clear_cache('logout.tpl');			
		} 
	   //$_SESSION ["cache_username"] = $username;
		
 	}
  
   $smarty->display('logout.tpl');
}

$smarty->assign('user_access', $user_access);


?>
