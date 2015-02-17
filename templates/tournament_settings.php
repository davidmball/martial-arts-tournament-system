<?php

  // important settings for the tournament system.
  // note this is kept below the domain names so it is never ever served by apache

  $db_username = "bairui_tourn";
 $db_password = "tkd4eva";
  $db_name     = "bairui_tourn";
  $site_root   = "http://www.bairui.com/tournament/";
  set_include_path('/web/sites/bairui/bairui.com/pear/PEAR/' . PATH_SEPARATOR . get_include_path());

 /*
  $db_username = "root";
  $db_password = "maxpower";
 $db_name     = "bairui_tourn";
  $site_root   = "http://localhost/testphp/";
  */
  ?>
