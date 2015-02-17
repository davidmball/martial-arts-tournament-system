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
require_once('../simpletest/reporter.php');
require_once('../simpletest/web_tester.php');

class MATSTests extends WebTestCase{
  function userLogin($name1,$pass1){
    $this->setField('username',$name1);
    $this->setField('password',$pass1);
    $this->clickSubmit('Login');
  }

  function userLogout(){
    $this->clickSubmit('Logout');
  }

  function addTournament($tournName,$tournLoc,$tournFromYear,$tournFromMonth,$tournFromDay,
  $tournToYear,$tournToMonth,$tournToDay,$tournActive,$sparring,$patterns,$specialTech,$breaking,
  $teamSparring,$teamPatterns,$teamSpecialTech,$teamBreaking,$teamSpecialEvents){
        $this->click('new');
	$this->setField('Name',$tournName);
	$this->setField('Location',$tournLoc);
	$this->setField('From_Year',$tournFromYear);
	$this->setField('From_Month',$tournFromMonth);
	$this->setField('From_Day',$tournFromDay);
	$this->setField('To_Year',$tournToYear);
	$this->setField('To_Month',$tournToMonth);
	$this->setField('To_Day',$tournToDay);
	$this->setField('Active',$tournActive);
        $this->setField('Sparring_tf',$sparring);
        $this->setField('Patterns_tf',$patterns);
        $this->setField('SpecialTech_tf',$specialTech);
        $this->setField('Breaking_tf',$breaking);
        $this->setField('TeamSparring_tf',$teamSparring);
        $this->setField('TeamPatterns_tf',$teamPatterns);
        $this->setField('TeamSpecialTech_tf',$teamSpecialTech);
        $this->setField('TeamBreaking_tf',$teamBreaking);
        $this->setField('TeamSpecialEvents_tf',$teamSpecialEvents);
	$this->click('Submit');
  }

}

class ManagerLoginTests extends MATSTests {
  // test can log in and log out with manager details
  // check access to correct details

    function testManagerLogin() {
        $this->get('http://localhost/testphp/index.php');
        $this->assertField('username', '');
        $this->assertField('password', '');
        $this->userLogin('dball','dball');
        $this->assertText('Logged in as: dball');
        $this->assertNoText('Admin');
    }

    function testManagerLogout() {
        $this->get('http://localhost/testphp/index.php');
        $this->userLogin('dball','dball');
        $this->assertText('Logged in as');
        $this->userLogout();
        $this->assertField('username', '');
    }

    function testManagerAccess(){
      // could do this using assertLink($label) / assertNoLink($label)  ?
    }
}

class AdminLoginTests extends MATSTests {
  // test can log in and log out with admin details
  // check access to correct details

    function testAdminLogin() {
        $this->get('http://localhost/testphp/index.php');
        $this->userLogin('admin','admin');
        $this->assertText('Logged in as: admin');
    }

    function testAdminLogout() {
        $this->get('http://localhost/testphp/index.php');
        $this->userLogin('admin','admin');
        $this->assertText('Logged in as: admin');
        $this->userLogout();
        $this->assertField('username','');
    }

    function testAdminAccess(){
    }
}

class NoLoginTests extends MATSTests{
  // check access to correct details

  function testNoLoginAccess(){
  }
}

class ContactUsTests extends MATSTests{
  // check link works
  // incorrect email input: error message

  function testContactUs(){
        $this->get('http://localhost/testphp/index.php');
        $this->click('Contact Us or Sign Up');
        $this->assertText('Signing up is for team managers');
        $this->setField('Email','asdf');
        $this->clickSubmit('Submit');
        $this->assertText('Contacting or signing up did not work because:');
  }

}

class TournamentTests extends MATSTests {
  // add and delete tournament
  // adding details of tournament correctly
  // adding details of tournament incorrectly (which ones should call an error?)

	function testAddDeleteTournament(){
		$this->get('http://localhost/testphp/index.php');
		$this->userLogin('admin','admin');
		$this->assertText('Logged in as: admin');
		$this->addTournament('tournament1','St Pauls','2007','April','10',
                '2007','April','11',false,true,true,true,true,true,true,true,true,true);
		$tournamentId = $this->_browser->getField('ID');
		$this->assertText('has been added');
		$this->click('Main');
		$this->assertText('tournament1');
		$this->assertText('St Pauls');
		//$this->clickLinkById($tournamentId);  //???
		$array = array('http://localhost/testphp/edit_tournament.php?ID',$tournamentId);
		$editTournUrl = implode("=",$array);
		$this->get($editTournUrl);
		//$this->assertLinkById($tournamentId);
		//$this->clickLink('edit');
		$this->assertField('ID',$tournamentId);
		// need to delete tournament...
		$this->clickSubmit('Delete');
		$this->assertText('has been deleted');
		$this->userLogout();
	}
	// to check if something is available in one of the list boxes
	//$this->assertFalse($this->setField('type', 'Superuser'));
}

class CompetitorTests extends MATSTests {

	function testAddDeleteCompetitor(){
		$this->get('http://localhost/testphp/index.php');
		$this->userLogin('admin','admin');
		$this->assertText('Logged in as: admin');
		$this->addTournament('tournament1','St Pauls','2007','April','10',
                '2007','April','11',true,true,true,true,true,true,true,true,true,true);
		$tournamentId = $this->_browser->getField('ID');
		$this->click('Registration');
		$this->click('new');
		$this->setField('First Name','asdflkj');
		$this->setField('Middle Name','qwer');
		$this->setField('Last Name','poiu');
		$this->setField('DOB_Month','January');
		$this->setField('DOB_Day','04');
		$this->setField('DOB_Year','1980');
		$this->setField('Weight','80');
		$this->setField('Height','180');
		$this->setField('Rank','1st Dan');
		$this->setField('Represents','The Gap');
		$this->setField('Address','sadf');
		$this->setField('Phone','12345678');
		$this->setField('Gender','Male');
		$this->setField('RedCard','1234');
		$this->setField('Comments','adfqweroiu');
		$this->setField('Sparring_tf',true);
                $this->setField('Patterns_tf',true);
                $this->setField('SpecialTech_tf',true);
                $this->setField('Breaking_tf',true);
                $this->setField('TeamSparring_tf',true);
                $this->setField('TeamPatterns_tf',true);
                $this->setField('TeamSpecialTech_tf',true);
                $this->setField('TeamBreaking_tf',true);
                $this->setField('TeamSpecialEvents_tf',true);
		$this->click('Submit');
		$this->assertField('First Name', 'asdflkj');
		$this->assertField('Last Name', 'poiu');
	}
}

$test = &new ManagerLoginTests();
$test->run(new HtmlReporter());

$test = &new AdminLoginTests();
$test->run(new HtmlReporter());

$test = &new ContactUsTests();
$test->run(new HtmlReporter());

$test = &new TournamentTests();
$test ->run(new HtmlReporter());

$test = &new CompetitorTests();
$test -> run(new HtmlReporter());

?>