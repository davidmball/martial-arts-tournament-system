A complete system for running martial arts tournaments. Includes the ability for coaches to enter their own students, perform divisioning, enter results, and print results. Includes support for sparring, patterns, round robin, special techniques, power breaking, and a wide variety of team events.

Uses PHP, the Smarty template engine (http://www.smarty.net/) v 2.6.2, MySQL, PEAR (notably Auth and DB), HTML and some javascript.

This system has been used to run over 15 tournaments including one international event.

Development on this project is now inactive. Anyone who would like to submit documentation, in particular, a setup guide would be appreciated.

Note that the pear.ini and tournament\_settings.php files need to be moved two levels below (in the directory structure) the index.php file. The database file is in the root directory and should be imported eg using phpmyadmin.

I recommend XAMPP for getting this to easily work under windows.