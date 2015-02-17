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
require 'configDB.php';

//echo "<br><br><br><br><br><br><br><br>";

$from_address = "tournament@bairui.com";

// because ruth wanted it like this :)
$smarty->assign('date', "%d %b, %Y");
$smarty->assign('date_time', "%I:%M%p %d %b, %Y");

// gets the active tournament details ... most pages need some of this information
$active_tournament = DB_DataObject::factory('tournaments');
$active_tournament->whereAdd('active = 1');
$active_tournament->find();
$active_tournament->fetch();

// rank to rank display look up
$rank_display_lookup = Array();
$rank = DB_DataObject::factory('rank');
$rank->find();
while ($rank->fetch()) {
	$rank_display_lookup[$rank->rank_id] = $rank->html_display;
	$rank_display_lookup_name[$rank->rank_id] = $rank->name;	
}
	$rank_display_lookup[0] = " ";	
	$rank_display_lookup_name[0] = " ";	

$represents_display_lookup = Array();
$represents = DB_DataObject::factory('represents');
$represents->find();
while ($represents->fetch()) {
	$represents_display_lookup[$represents->represents_id] = $represents->name;	
}

	$smarty->assign('active_tournament', array(
	      'ID'        		=> $active_tournament->tournament_id,
	      'NAME' 			=> $active_tournament->name,     
	      'LOCATION'  		=> $active_tournament->location,     
	      'DATE_FROM'     	=> $active_tournament->date_from,
	      'DATE_TO' 		=> $active_tournament->date_to,
	      'ALLOW_MANAGERS_TO_EDIT' => $active_tournament->allow_managers_to_edit,
	      'ACTIVE'  		=> $active_tournament->active,		      
	      'LAST_UPDATED' 	=> $active_tournament->last_updated,  
	      'DRAWS_PUBLIC'		=> $active_tournament->draws_public,
	      'SCHEDULE_HTML'							=> $active_tournament->schedule_html,
	      'TOURNAMENT_FORM_PDF'  => $active_tournament->tournament_form_pdf,
	      'PARTICIPATION_SIGNATURE_HTML' => $active_tournament->participation_signature_html,
	      'DUE_DATE'		=> $active_tournament->due_date,
	      'LOGO_NAME'										=> $active_tournament->logo_name
	       ));


		$active_tournament_events = DB_DataObject::factory('tournament_events');
		$active_tournament_events->tournament_id = $active_tournament->tournament_id;
		$events_temp = DB_DataObject::factory('events');
		$active_tournament_events->selectAs();
		$active_tournament_events->joinAdd($events_temp, "INNER", 'events', 'event_id');
		$active_tournament_events->selectAs($events_temp, 'events_%s');


		if ($active_tournament_events->find()) {
			$temp_selection_array_id = array();		
			$temp_selection_array_name = array();
			$temp_selection_array_name_abbrev = array();
			$temp_selection_team_event = array();
			$i = 0;
			while ($active_tournament_events->fetch())  { 	
				$active_tournament_events_id[$i] = $active_tournament_events->event_id;
				$temp_selection_array_name[$i] = $active_tournament_events->events_name;
				if ($active_tournament_events->events_max_competitors > 1) 
					$temp_selection_team_event[$i] = 1;
				else
					$temp_selection_team_event[$i] = 0;
				$temp_selection_array_name_abbrev[$i++] = $active_tournament_events->events_name_abbrev;
				
			}
			$smarty->assign('active_tournament_events_id', $active_tournament_events_id);	
			$smarty->assign('active_tournament_events_name', $temp_selection_array_name);
			$smarty->assign('active_tournament_events_name_abbrev', $temp_selection_array_name_abbrev);
			$smarty->assign('active_tournament_teams_event', $temp_selection_team_event);

		}


function Convert_Enrolment_String_To_Char($enrolment_string, &$active_count) {
	
	
	if ($enrolment_string == "Registered") {
		$enrolment = " ";	
	} else if ($enrolment_string == "Signed_In") {
		$enrolment = "*";
		$active_count++;	
	} else if ($enrolment_string == "Disqualified") {
		$enrolment = "D";	
		$active_count++;
	} else if ($enrolment_string == "Scratched") {
		// this would be an error state as if they are scratched they are not meant to be in the event at all!
		$enrolment = "!";	
	} else {
		$enrolment = " ";	
	}
	
	return $enrolment;							
}

function eventidtostring($event_id)
{
	$events = DB_DataObject::factory('events');
	$events->event_id = $event_id;
	if ($events->find()) {	
		$events->fetch();
		return $events->name_abbrev;
	} else {
	 	return " ";	
	}
}

function userinputcheckEmail($email) {
	
	global $smarty;
	
    $regex = "^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,6}$";
    if(!eregi($regex, $email)){
		$smarty->append("error_string", "Invalid Email Address");
		return false;
    } else {
    	return true;	
    }	
}

function userinputcheckWeight($weight) {

	global $smarty;
	
     if(!is_numeric($weight) || $weight < 10 || $weight > 300){
		$smarty->append("error_string", "Invalid Weight");
		return false;
    } else {
    	return true;	
    }		
}

function userinputcheckHeight($height) {

	global $smarty;
	
     if(!is_numeric($height) || $height < 30 || $height > 300){
		$smarty->append("error_string", "Invalid Height");
		return false;
    } else {
    	return true;	
    }		
}

function userinputcheckFirstName($string) {

	global $smarty;

	if (strlen(utf8_decode($string)) < 2) { 
		$smarty->append("error_string", "Invalid First Name");
		return false;
	} else {
		return true;
	}
}

function userinputcheckLastName($string) {

	global $smarty;

	if (strlen(utf8_decode($string)) < 2) { 
		$smarty->append("error_string", "Invalid Last Name");
		return false;
	} else {
		return true;
	}
}

function userinputcheckPassword($string) {

	global $smarty;

	if (strlen(utf8_decode($string)) < 6) { 
		$smarty->append("error_string", "Password must be more than 6 characters.");
		return false;
	} else {
		return true;
	}
}

function EmailDetailsToUser($user, $new, $password) {

	$body_string = "Dear ".$user->title." ".$user->first_name." ".$user->last_name.",\n\n";
	if ($new)
		$body_string .= "An account has been created for you on MATS with the following details:\n\n";
	else
		$body_string .= "Your details have been updated on MATS to the following:\n\n";
		
	$body_string .= "username: ".$user->username."\n";
	$body_string .= "email: ".$user->email."\n";
//	$body_string .= "represents: ".$user->represents."\n"; // TODO: to a list of who they represent
	if ($password) {
		$body_string .= "password: ".$password."\n";
	}
	$body_string .= "\nIf these are not correct please login to fix them.\n";

	$body_string .= "\nMartial Arts Tournament System\n";
	$body_string .= "http://www.bairui.com/tournament/\n";
	
	$body_string .= "\nIf you are not this person then please reply to this email.\n";

	global $from_address;
	ini_set('sendmail_from', $from_address);
//	$header = "MIME-Version: 1.0\r\n";
//	$header .= "Content-type: text/plain; charset=iso-8859-2\r\nContent-Transfer-Encoding: 8bit\r\nX-Priority: 1\r\nX-MSMail-Priority: High\r\n";
	$header = "From: ".$from_address."\nReply-To: ".$from_address."\nX-Mailer: PHP/" . phpversion() . "\nX-originating-IP: www.bairui.com\nSender:".$from_address."\nMessage-Id: \n";


	mail($user->email, "MATS: Your account details", $body_string, $header,"-ftournament@bairui.com");
  	ini_restore('sendmail_from');	
} 

/* ran out of time to implement this
function EmailReminderToUser($user, $password) {
	
	global $active_tournament;
	$body_string = "Dear ".$user->title." ".$user->first_name." ".$user->last_name.",\n\n";
	
	// if due date
	$body_string .= "The ".$active_tournament->name." is in "."23"."days. \n";
	
	$body_string .= "The due date for you to enter your competitors is "."blah";
	
	$body_string .= "Note that all forms and money must be submitted prior to the tournament.";
	
	// else
	$body_string .= "The ".$active_tournament->name." was "."23"."days ago. \n";
	$body_string .= "Your account is as follows:\n";
	
	$body_string .= "Any money owing is now overdue.";


	// all
	$body_string .= "Note that it may take some time to process money submitted to HQ.\n";

	$body_string .= "\nMartial Arts Tournament System\n";
	$body_string .= "http://www.bairui.com/tournament/";
	
	$body_string .= "\nIf you are not the person indicated in this email then please tell us and delete this email.\n";
	
	global $from_address;
	ini_set('sendmail_from', $from_address);
	$header .= "From: ".$from_address."\nReply-To: ".$from_address."\nX-Mailer: PHP/" . phpversion() . "\nX-originating-IP: www.bairui.com\nSender:".$from_address."\nMessage-Id: \n";
	mail($user->email, "MATS: Divisions now online.", $body_string, $header,"-ftournament@bairui.com");
  	ini_restore('sendmail_from');	
}
*/

function EmailCheckDivisionsToUser($user) {
	
	global $active_tournament;
	
	$body_string = "Dear ".$user->title." ".$user->first_name." ".$user->last_name.",\n\n";

	$body_string .= "The divisions for the ".$active_tournament->name." are now online.\n";
	$body_string .= "It is important that you check that your competitors are:\n";
	$body_string .= "* in the requested events,\n";
	$body_string .= "* in appropriate divisions,\n";
	$body_string .= "* for multi-day tournaments that they know the correct day to turn up on.\n";
	$body_string .= "If you find a mistake, please reply to this email with the changes needed.\n";

	$body_string .= "\nMartial Arts Tournament System\n";
	$body_string .= "http://www.bairui.com/tournament/\n";
	
	global $from_address;
	ini_set('sendmail_from', $from_address);
	
	$header = "From: ".$from_address."\nReply-To: ".$from_address."\nX-Mailer: PHP/" . phpversion() . "\nX-originating-IP: www.bairui.com\nSender:".$from_address."\nMessage-Id: \n";
	mail($user->email, "MATS: Divisions now online", $body_string, $header,"-ftournament@bairui.com");
	
  	ini_restore('sendmail_from');	
	
}

function strrand($length,$chars='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
{
   // Required Variables
   $string = '';
   // Loop
   for($i = 0; $i <= $length-1; $i++)
      $string .= $chars[rand(0,strlen($chars)-1)];
   // Return our random string.
   return $string;
}
 

function GetAgeAtTournament($DOB, $tournament_date) {
        $birth = explode("-", $DOB);
        $date = explode("-", $tournament_date);
        
        $age = date("Y") - $birth[0];

        if(($birth[1] > $date[1]) || ($birth[1] ==$date[1] && $date[2] < $birth[2]))
        {
                $age -= 1;
        }
        return $age;
} 


// division stuff
// this all needs to go into a division draw include.

// for each results[round_id] ahve blue and red and colour that won
// when you get a result you set the next rounds blue or red id. and also set the colour_win to something like "N" 
// [5] -> [3]["R"]
// [6] -> [3]["B"]
// [3] -> [1]["R"]
// this is a bit backwards...really the result will come in round 5 and you will look up the round 3 and the colour to put it in.
// $results[3]->red_id = if $results[5]->colour_win == R then $results[5]->red_id else $results[5]->blue_id
// $results[1]->red_id = if $results[3]->colour_win == R then $results[3]->red_id else $results[3]->blue_id
//
// this should make it fast to read out the division. 
// this will also be fast to read the final results and look up the fights a player has had.

$css_round_set = array(	1 => "height: 55px; left: 0px; padding-bottom: 10px;", 
						2 => "height: 90px; left: 210px; padding-bottom: 40px;", 
						3 => "height: 165px; left: 420px; padding-bottom: 95px;",
						4 => "height: 280px; left: 630px; padding-bottom: 230px;",	
						5 => "height: 540px; left: 840px; padding-bottom: 300px;",
						6 => "height: 800px; left: 1050px; padding-bottom: 400px;");	
														
$css_round_set_top = array(	32 => array( 	1 => "top: -100px;", 
											2 => "top: -1025px;", 
											3 => "top: -2040px;",
											4 => "top: -3000px;",
											5 => "top: -3200px;",
											6 => "top: -4560px;"),
							16 => array( 	1 => "top: -100px;", 
											2 => "top: -505px;", 
											3 => "top: -1000px;",
											4 => "top: -1120px;",
											5 => "top: -1920px;"),
							8 => array( 	1 => "top: -100px;", 
											2 => "top: -245px;", 
											3 => "top: -280px;",
											4 => "top: -770px;"),											
							4 => array( 	1 => "top: -100px;", 
											2 => "top: -0px;", 
											3 => "top: -310px;")																						
											);
											
	$css_round_set_top_one = array(32 => "top: -4280px;",
									16 => "top: -1770px;",
									8 => "top: -660px;", 
									4 => "top: -245px;");																		  

$css_rounds = array(32 => ".round17, .round18, .round19, .round20, .round21, .round22, .round23, .round24, .round25, .round26, .round27, .round28, .round29, .round30, .round31, .round32",
					16 => ".round9, .round10, .round11, .round12, .round13, .round14, .round15, .round16",
					8 => ".round5, .round6, .round7, .round8",
					4 => ".round3, .round4",
					2 => ".round2, .round1");
$win_results_lookup_round = array(32 => 16, 31 => 16, 30 => 15, 29 => 15, 28 => 14, 27 => 14, 26 => 13, 25 => 13, 24 => 12, 23 => 12, 22 => 11, 21 => 11, 20 => 10, 19 => 10, 18 => 9, 17 => 9,
									16 => 8, 15 => 8, 14 => 7, 13 => 7, 12 => 6, 11 => 6, 10 => 5, 9 => 5, 8 => 4, 7 => 4, 6 => 3, 5 => 3, 4 => 1, 3 => 1);
$win_results_lookup_colour = array(32 => "R", 31 => "B", 30 => "R", 29 => "B", 28 => "R", 27 => "B", 26 => "R", 25 => "B", 24 => "R", 23 => "B", 22 => "R", 21 => "B", 20 => "R", 19 => "B", 18 => "R", 17 => "B",
									16 => "R", 15 => "B", 14 => "R", 13 => "B", 12 => "R", 11 => "B", 10 => "R", 9 => "B", 8 => "R", 7 => "B", 6 => "R", 5 => "B", 4 => "R", 3 => "B");

$lose_results_lookup_round = array(3 => 2, 4 => 2);
$lose_results_lookup_colour = array(4 => "R", 3 => "B" );

$round_count_lookup = array(
2 => 1, 
3 => 4, 4 => 4, 
5 => 8, 6 => 8, 7 => 8, 8 => 8,
9 => 16, 10 => 16, 11 => 16, 12 => 16, 13 => 16, 14 => 16, 15 => 16, 16 => 16,
17 => 32, 18 => 32, 19 => 32, 20 => 32, 21 => 32, 22 => 32, 23 => 32, 24 => 32,
 25 => 32, 26 => 32, 27 => 32, 28 => 32, 29 => 32, 30 => 32, 31 => 32, 32 => 32);

$loser_round_count_lookup = array(
	5 => 2, 6 => 2, 7 => 4, 8 => 4, 
	9 => 8, 10 => 8, 11 => 8, 12 => 8, 13 => 8, 14 => 8, 15 => 8, 16 => 8);

// because of the complicated nature of repercharge above 8 peopl I have listed these out manually! argh!
// based on the number of competitors as apposed to rounds
// negatives correspond to ifs
$repercharge_lose_results_lookup_round = array(
16 => array(16 => 108, 15 => 108, 14 => 107, 13 => 107, 12 => 106, 11 => 106, 10 => 105, 9 => 105, 4 => 101, 3 => 102),
15 => array(8 => -108, 15 => 108, 14 => 107, 13 => 107, 12 => 106, 11 => 106, 10 => 105, 9 => 105, 4 => 101, 3 => 102),
14 => array(8 => 108, 14 => 107, 13 => 107, 12 => 106, 11 => 106, 10 => 105, 9 => 105, 4 => 101, 3 => 102),
13 => array(8 => 108, 7 => -107, 13 => 107, 12 => 106, 11 => 106, 10 => 105, 9 => 105, 4 => 101, 3 => 102),
12 => array(8 => 108, 7 => 107, 12 => 106, 11 => 106, 10 => 105, 9 => 105, 4 => 101, 3 => 102),
11 => array(8 => 108, 7 => 107, 6 => -106, 11 => 106, 10 => 105, 9 => 105, 4 => 101, 3 => 102),
10 => array(8 => 108, 7 => 107, 6 => 106, 10 => 105, 9 => 105, 4 => 101, 3 => 102),
9 => array(8 => 108, 7 => 107, 6 => 106, 5 => -105, 9 => 105, 4 => 101, 3 => 102),
8 => array(8 => 104, 7 => 104, 6 => 103, 5 => 103, 4 => 101, 3 => 102),
7 => array(8 => 104, 7 => 104, 6 => 103, 5 => 103, 4 => 101, 3 => 102),
6 => array(6 => 102, 5 => 101, 4 => 101, 3 => 102),
5 => array(5 => 101, 4 => 101, 3 => 102));
$repercharge_lose_results_lookup_colour = array(
16 => array(16 => "R", 15 => "B", 14 => "B", 13 => "R", 12 => "R", 11 => "B", 10 => "R", 9 => "B", 4 => "R", 3 => "R"),
15 => array(8 => "R", 15 => "B", 14 => "B", 13 => "R", 12 => "R", 11 => "B", 10 => "R", 9 => "B", 4 => "R", 3 => "R"),
14 => array(8 => "R", 14 => "B", 13 => "R", 12 => "R", 11 => "B", 10 => "R", 9 => "B", 4 => "R", 3 => "R"),
13 => array(8 => "R", 7 => "R", 13 => "B", 12 => "R", 11 => "B", 10 => "R", 9 => "B", 4 => "R", 3 => "R"),
12 => array(8 => "R", 7 => "R", 12 => "R", 11 => "B", 10 => "R", 9 => "B", 4 => "R", 3 => "R"),
11 => array(8 => "R", 7 => "R", 6 => "R", 11 => "B", 10 => "R", 9 => "B", 4 => "R", 3 => "R"),
10 => array(8 => "R", 7 => "R", 6 => "R", 10 => "R", 9 => "B", 4 => "R", 3 => "R"),
9 => array(8 => "R", 7 => "R", 6 => "R", 5 => "R", 9 => "B", 4 => "R", 3 => "R"),
8 => array(8 => "B", 7 => "R", 6 => "B", 5 => "R", 4 => "R", 3 => "R"),
7 => array(7 => "R", 6 => "B", 5 => "R", 4 => "R", 3 => "R"),
6 => array(6 => "B", 5 => "B", 4 => "R", 3 => "R"),
5 => array(5 => "B", 4 => "R", 3 => "R"));
$repercharge_bye_lookup = array(
14 => array(108 => 1),
13 => array(108 => 1),
12 => array(108 => 1, 107 => 1),
11 => array(108 => 1, 107 => 1),
10 => array(108 => 1, 107 => 1, 106 => 1),
9 => array(108 => 1, 107 => 1, 106 => 1),
7 => array(104 => 1),
5 => array(102 => 1));

$repercharge_win_results_lookup_round = array(108 => 104, 107 => 104, 106 => 103, 105 => 103,
												104 => 102, 103 => 101, 102 => 2, 101 => 2);
$repercharge_win_results_lookup_colour = array(108 => "R", 107 => "B", 106 => "R", 105 => "B",
												104 => "B", 103 => "B", 102 => "R", 101 => "B");


$repercharge_css_style = array(
8 => 
".loser_round105, .loser_round106, .loser_round107, .loser_round108 {
 height: 55px;
 left: 0px;
 top: -1880px;
  padding-bottom: 10px;
}
.loser_round104, .loser_round103 {
 height: 90px;
 left: 210px;
 top: -2120px;
  padding-bottom: 40px;
}
.loser_round102, .loser_round101  {
 height: 90px;
 left: 420px;
 top: -2420px;
   padding-bottom: 40px;
}",

4 =>
".loser_round104, .loser_round103 {
 height: 55px;
 left: 0px;
 top: -870px;
  padding-bottom: 80px;
}
.loser_round102, .loser_round101  {
 height: 92px;
 left: 210px;
 top: -1190px;
   padding-bottom: 40px;
}",

2 =>"
.loser_round102, .loser_round101  {
 height: 92px;
 left: 210px;
 top: -930px;
  padding-bottom: 40px;
}
");


function Get_Competitor_IDs_Division($division_id) {
	global $active_tournament;
	$competitor_divisions = DB_DataObject::factory('competitor_events');	  
	$competitor_divisions->division_id = $division_id;		  	
	$competitors = DB_DataObject::factory('competitors');
	$competitor_divisions->selectAs();	  
	$competitor_divisions->joinAdd($competitors, "INNER", 'competitors', 'competitor_id');
	$competitor_divisions->selectAs($competitors, 'competitors_%s'); 
	$competitor_divisions->whereAdd("competitors.tournament_id = '".$active_tournament->tournament_id."'"); 			
	$competitor_divisions->orderBy("competitor_events.draw_order ASC");			
	$competitors_in_draw = $competitor_divisions->find();
	
	$competitor_list_id = array();
			
	$i = 0;
	while ($competitor_divisions->fetch()) {
		$competitor_list_id[$i] = $competitor_divisions->competitor_id;
		$i++;
	}
	return $competitor_list_id;
}

function Clear_Division($division_id) {
		
	$results = DB_DataObject::factory('results');
	$results->division_id = $division_id;
	$results->find();
	while ($results->fetch()) {
		$results->delete();
	}
}

function Sort_Division($division_id) {

	$competitor_divisions = DB_DataObject::factory('competitor_events');
	$competitor_divisions->query("SELECT * FROM {$competitor_divisions->__table} WHERE division_id = ".$division_id);//." AND event_id = ".$event_selected);
	$competitor_divisions->query("SET @pos = -1");
	$competitor_divisions->query("UPDATE {$competitor_divisions->__table} SET draw_order = ( SELECT @pos := @pos + 1 ) WHERE division_id = ".$division_id./*" AND event_id = ".$event_selected.*/" ORDER BY draw_order ASC");
		
}

function Unassign_Division($division_id, $event_id) {

	$competitor_divisions = DB_DataObject::factory('competitor_events');
	$competitor_divisions->query("SELECT * FROM {$competitor_divisions->__table} WHERE event_id = ".$event_id." AND division_id = ".$division_id);
	$competitor_divisions->query("UPDATE {$competitor_divisions->__table} SET draw_order = 0, division_id = 0 WHERE event_id = ".$event_id." AND division_id = ".$division_id);
	
}

function Get_Tournament_List() {
	
	$temp_array = array();
	$tournament = DB_DataObject::factory('tournaments');
	$tournament->find();
	 while ($tournament->fetch()) {
			$temp_array[$tournament->tournament_id] = $tournament->name.", ".$tournament->date_from;
	 }	
	 return $temp_array;	
}

// remove a competitor from an event
// when unenrolled this should be called for each event the competitor was in
// note that it need to sort the division the competitor was taken from by removing the gap.
function Remove_Competitor_And_Init_Division($competitor_id, $event_id) {
	
	// work out what division the competitor is in 
	$competitor_divisions = DB_DataObject::factory('competitor_events');
	$competitor_divisions->event_id = $event_id;
	$competitor_divisions->competitor_id = $competitor_id;
	if ($competitor_divisions->find()) {
		$competitor_divisions->fetch();
		$division_id = $competitor_divisions->division_id;	

//		DB_DataObject::debugLevel(5);
		$competitor_events = DB_DataObject::factory('competitor_events');
		$competitor_events->query("DELETE FROM {$competitor_events->__table} WHERE event_id = ".$event_id." AND competitor_id = ".$competitor_id);

	
		if ($division_id != 0) {

			// sort the division
			Sort_Division($division_id);
			
			// then 'clear' the division and reinit it
			Clear_Results_And_Init_Division($division_id);
		}
	}		

}


function Update_Results_From_Forms($division_id, $division_type, $competitors_in_draw, $technique1, $technique2, $technique3, $technique4, $technique5, $extra1, $extra2, $place) {

	global $user_id;
	
	$stored_result = array();
	
	for ($i = 1; $i < $competitors_in_draw + 1; $i++) {
		$stored_result[$i] = DB_DataObject::factory('results');
		$stored_result[$i]->division_id = $division_id;		
		$stored_result[$i]->round_id = $i;
		$stored_result[$i]->find();
		$stored_result[$i]->fetch();
	}
	
	Clear_Division($division_id);
//		DB_DataObject::debugLevel(5);	
	for ($i = 1; $i < $competitors_in_draw + 1; $i++) {	
		$result = DB_DataObject::factory('results');
		$result->division_id = $division_id;		
		$result->round_id = $i;
		$result->technique1 = $technique1[$i];		
		$result->technique2 = $technique2[$i];
		$result->technique3 = $technique3[$i];
		$result->technique4 = $technique4[$i];
		$result->technique5 = $technique5[$i];
		$result->extra1 = $extra1[$i];
		$result->extra2 = $extra2[$i];
		$result->place = $place[$i];
		$result->competitor_red_id = $stored_result[$i]->competitor_red_id;
		$result->competitor_blue_id = 0;
		$result->colour_win = "F";										
		if (   $stored_result[$i]->technique1 == $technique1[$i] 
			&& $stored_result[$i]->technique2 == $technique2[$i]
			&& $stored_result[$i]->technique3 == $technique3[$i]
			&& $stored_result[$i]->technique4 == $technique4[$i]
			&& $stored_result[$i]->technique5 == $technique5[$i]
			&& $stored_result[$i]->extra1 == $extra1[$i]
			&& $stored_result[$i]->extra2 == $extra2[$i]
			&& $stored_result[$i]->place == $place[$i]) {
			$result->user_id = $stored_result[$i]->user_id;
			$result->last_updated = $stored_result[$i]->last_updated;					
		} else {
			$result->user_id = $user_id;
			$result->last_updated = date("Y-m-d H:i:s");				
		}										
										
		$result->insert();
	}		
	//DB_DataObject::debugLevel(0);
} 


function Update_Results_From_Rounds($division_id, $division_type, $competitors_in_draw, $round_red, $round_blue, $round_win, $stored_round_colour_win, $stored_round_user_id, $stored_round_last_updated) {
	global $round_count_lookup;
	global $loser_round_count_lookup;
	global $user_id;


	for ($i = 1; $i < $round_count_lookup[$competitors_in_draw] + 1; $i++) {
		$results = DB_DataObject::factory('results');
		$results->division_id = $division_id;		
		$results->round_id = $i;
		$results->competitor_red_id = $round_red[$i];
		$results->competitor_blue_id = $round_blue[$i];
		$results->colour_win = $round_win[$i];	
		
		$results->technique1 = 0;		
		$results->technique2 = 0;
		$results->technique3 = 0;
		$results->technique4 = 0;
		$results->technique5 = 0;
		$results->extra1 = 0;
		$results->extra2 = 0;
		$results->place = 0;
		
		// if there was no change to the result then keep the old user_id and update time
		if ($stored_round_colour_win[$i] == $round_win[$i]) {
			$results->user_id = $stored_round_user_id[$i];
			$results->last_updated = $stored_round_last_updated[$i];					
		} else {
			$results->user_id = $user_id;
			$results->last_updated = date("Y-m-d H:i:s");				
		}

		$results->insert();
	}
	if ($division_type == "Repercharge") {
		
		for ($i = 101; $i < $loser_round_count_lookup[$competitors_in_draw] + 101; $i++) {
			$results = DB_DataObject::factory('results');
			$results->division_id = $division_id;		
			$results->round_id = $i;
			$results->competitor_red_id = $round_red[$i];
			$results->competitor_blue_id = $round_blue[$i];
			$results->colour_win = $round_win[$i];

			$results->technique1 = 0;		
			$results->technique2 = 0;
			$results->technique3 = 0;
			$results->technique4 = 0;
			$results->technique5 = 0;
			$results->extra1 = 0;
			$results->extra2 = 0;
			$results->place = 0;

			// if there was no change to the result then keep the old user_id and update time
			if ($stored_round_colour_win[$i] == $round_win[$i]) {
				$results->user_id = $stored_round_user_id[$i];
				$results->last_updated = $stored_round_last_updated[$i];					
			} else {
				$results->user_id = $user_id;
				$results->last_updated = date("Y-m-d H:i:s");				
			}		
			$results->insert();
		}
	}	
} 

function Clear_Results_And_Init_Division($division_id) {
	
	$division = DB_DataObject::factory('divisions');
	$division->division_id = $division_id;
	$division->find();
	$division->fetch();
	
	if ($division->type == "Round_Robin") {
		
		/*
		 The trick to generating round robin is to keep one competitor (or in the case of an odd number of competitors the bye) locked in place
		 and rotate the other competitors around.
		 
		 So for 6 competitors
		 5 0		5 4		5 3	 	5 2		5 1
		 4 1		3 0		2 4		1 3		0 2
		 3 2		2 1		1 0		0 4		4 3
		 
		 You can see 5 is locked and 0 - 4 is rotated clockwise
		 
		 Keep in mind there is also some work to try to give people breaks between their fights.
		 */
		
		global $user_id;
		 	
		Clear_Division($division_id);
		
		$competitor_list_id = Get_Competitor_IDs_Division($division_id);
		$competitors_in_draw = count($competitor_list_id);
		$round_id = 1;
	
		// for odd numbers of competitors make the algorithm think there is an even number but don't add the bye rounds
		if ($competitors_in_draw % 2 == 1)
		{
			$odd = 1;
			$competitors_in_draw = $competitors_in_draw + 1;
		} else {
			$odd = 0;
		}
		// note that a redundant set of rounds are added for storing the place of the non rotated competitor (for division draws with an even number of competitors)
/*
		echo "start";
		for ($i = 0; $i < $competitors_in_draw; $i++)
			echo $i." - ".$competitor_list_id[$i].", ";
*/			
		for ($i = 0; $i < $competitors_in_draw ; $i++) {
			for ($j = 0; $j < floor($competitors_in_draw/2); $j++) {
			// for odd numbers of competitors make the algorithm think there is an even number but don't add the bye rounds				
				if ($odd  == 1 && $j == 0)
					continue;
//				echo "<br>i".$i."j".$j;
				$results = DB_DataObject::factory('results');
				$results->division_id = $division_id;		
				$results->round_id = $round_id;
				if ($j == 0) {
					$results->competitor_red_id = $competitor_list_id[$competitors_in_draw - 1];
//					echo "r1 - ".$results->competitor_red_id;		
				} else {
					// * 2 so don't go negative for mod
					$results->competitor_red_id = $competitor_list_id[(2 * ($competitors_in_draw - 1) -$i - $j) % ($competitors_in_draw - 1)];
//				    echo "r* - ".$results->competitor_red_id;									
				}

				// this handles the special redundant case
				if ($i == $competitors_in_draw -1 && $j == 0) {
					$results->competitor_blue_id = $competitor_list_id[$competitors_in_draw - 1];
//					echo "b1 - ".$results->competitor_blue_id;		
				} else {
					$results->competitor_blue_id = $competitor_list_id[($competitors_in_draw - 1 -$i + $j) % ($competitors_in_draw - 1)];
//					echo "b* - ".$results->competitor_blue_id;	
				}
				$results->colour_win = "F";	
				$results->technique1 = 0;
				$results->technique2 = 0;			
				$results->technique3 = 0;
				$results->technique4 = 0;
				$results->technique5 = 0;
				$results->extra1 = 0;
				$results->extra2 = 0;			
				$results->place = 0;															
				$results->user_id = $user_id;
				$results->last_updated = date("Y-m-d H:i:s");				
	
				$results->insert();					
				
				$round_id++;
			}
			
			
		}

	} else if ($division->type == "Form_Individual" || $division->type == "Form_Team" || $division->type == "Generic") {

		global $user_id;
		 	
		Clear_Division($division_id);
		
		$competitor_list_id = Get_Competitor_IDs_Division($division_id);
		$competitors_in_draw = count($competitor_list_id);
			
//		echo $competitors_in_draw;	
		for ($i = 1; $i < $competitors_in_draw + 1; $i++) {
				
			$results = DB_DataObject::factory('results');
			$results->division_id = $division_id;		
			$results->round_id = $i;
			$results->competitor_red_id = $competitor_list_id[$i - 1];
			$results->competitor_blue_id = 0;
			$results->colour_win = "F";	
			$results->technique1 = 0;
			$results->technique2 = 0;			
			$results->technique3 = 0;
			$results->technique4 = 0;
			$results->technique5 = 0;
			$results->extra1 = 0;
			$results->extra2 = 0;			
			$results->place = 0;															
			$results->user_id = $user_id;
			$results->last_updated = date("Y-m-d H:i:s");				
		
			$results->insert();	
		}
	
	} else if ($division->type == "Repercharge" || $division->type == "Elimination") {	

	
		global $round_count_lookup;
		global $user_id;
		global $loser_round_count_lookup;
		global $repercharge_bye_lookup;
		global $repercharge_lose_results_lookup_round;
		global $repercharge_lose_results_lookup_colour;
		global $win_results_lookup_colour;
		global $win_results_lookup_round;
		
		$competitor_list_id = array();
		
	
		$competitor_list_id = Get_Competitor_IDs_Division($division_id);
		$competitors_in_draw = count($competitor_list_id);
		
		if ($competitors_in_draw < 2) {
			return;	
		}

		Clear_Division($division_id);
		

		/*
		 * use temp variables to stop having to worry up update/insert
		 */
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
			$results->division_id = $division_id;		
			$results->round_id = $i;
			$results->find();				
			$results->fetch();
			$stored_round_colour_win[$i] = $results->colour_win;
			$stored_round_last_updated[$i] = $results->last_updated;
			$stored_round_user_id[$i] = $results->user_id;
		}

		// a hack for 3 competitors because there will be no 3rd/4th playoff
		if ($competitors_in_draw == 3) {
			$round_win[2] = "Y";
			$round_red[2] = 0;			
			$round_blue[2] = 0;				
		} else if ($division->type == "Elimination") {
			$round_win[2] = "N";
			$round_red[2] = -4;
			$round_blue[2] = -3;
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
				$results->division_id = $division_id;		
				$results->round_id = $i;
				$results->find();				
				$results->fetch();
				$stored_round_colour_win[$i] = $results->colour_win;
				$stored_round_last_updated[$i] = $results->last_updated;
				$stored_round_user_id[$i] = $results->user_id;
			}
		}
		for ($i = $round_count_lookup[$competitors_in_draw]; $i > 0; $i--) {
			if (isset($win_results_lookup_colour[$i])) {
				if ($win_results_lookup_colour[$i] == "R") {
					if ($round_win[$i] == "Y") {
						$round_red[$win_results_lookup_round[$i]] = $round_red[$i];
					} 
				} else {
					if ($round_win[$i] == "Y") {
						$round_blue[$win_results_lookup_round[$i]] = $round_red[$i];					
					}				
				}
			}
			
			if ($division->type == "Repercharge" && isset($repercharge_lose_results_lookup_colour[$competitors_in_draw][$i])) {
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
			}
		}

		Update_Results_From_Rounds($division_id, $division->type, $competitors_in_draw, $round_red, $round_blue, $round_win, $stored_round_colour_win, $stored_round_user_id, $stored_round_last_updated);
	}
}

function Get_Competitor_Name($id) {
	
	if ($id == -1000) {
		return "Bye";
	} else if ($id < -100) {
		return (-1*$id-100).".R IF lost, ELSE bye";	
//		return "If ".(-1*$id-100).".R loses";
//		return "Loser of ".(-1*$id-100)." IF R loses";
	} else if ($id < 0) {
		return "Loser from ".-1*$id;		
	} else if ($id == 0) {
		return " ";
	}
	
	$competitors = DB_DataObject::factory('competitors');
	$competitors->competitor_id = $id;
	$competitors->find();
	$competitors->fetch();
	return stripslashes($competitors->first_name." ".$competitors->last_name);
}

function Get_Real_Competitor_Name($id) {
	
	$competitors = DB_DataObject::factory('competitors');
	$competitors->competitor_id = $id;
	$competitors->find();
	$competitors->fetch();
	return stripslashes($competitors->first_name." ".$competitors->last_name);
}

function Get_Payment_Amount($payment_id, $competitor_id, $competitor_DOB, $tournament_id, $tournament_date) {
	
	$competitor_age = GetAgeAtTournament($competitor_DOB, $tournament_date);
	// $33 for 12 and under, $44 for everyone else
	if ($payment_id == 1) {
		if ($competitor_age <= 12) {
			return $cost = 33;
		} else {
			return $cost = 44;	
		}
	} else if ($payment_id == 2) {
		if ($competitor_age <= 12) {
			return $cost = 44;
		} else {
			return $cost = 55;	
		}
	} else if ($payment_id == 3) {
		if ($competitor_age <= 12) {
			return $cost = 55;
		} else {
			return $cost = 66;	
		}
	} else {
		return $cost = 0;	
	}
}

function Get_Section_Name($id) {
	
	$sections = DB_DataObject::factory('sections');		
	$sections->section_id = $id;
	if ($sections->find()) {
		$sections->fetch();
		return $sections->name;	
	} else {
		return " ";	
	}

}

function Get_Event_Name($id) {
	
	$events = DB_DataObject::factory('events');		
	$events->event_id = $id;
	if ($events->find()) {
		$events->fetch();
		return $events->name;	
	} else {
		return " ";	
	}

}

?>

