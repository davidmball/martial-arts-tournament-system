{config_load file=test.conf section="setup"}
{include file="header.tpl"}

<div id="main_pane">

<h1>Generate Enrolment</h1>

 	{section name=section_list loop=$sections}
 		<a href="enrolment.php?SECTION={$sections[section_list].ID}">{$sections[section_list].NAME}</a>&nbsp;|&nbsp;
 	{/section}

<h1>Generate Trophy List</h1>

 	{section name=section_list loop=$sections}
 		<a href="trophy.php?SECTION={$sections[section_list].ID}">{$sections[section_list].NAME}</a>&nbsp;|&nbsp;
 	{/section}
 	
<h1>Generate Results List</h1>

 	{section name=section_list loop=$sections}
 		<a href="results.php?SECTION={$sections[section_list].ID}">{$sections[section_list].NAME}</a>&nbsp;|&nbsp;
 	{/section} 	

<h1>Generate Division List</h1>

	BRIEF ::
 	{section name=section_list loop=$sections}
 		<a href="divisions.php?SECTION={$sections[section_list].ID}&TYPE=BRIEF">{$sections[section_list].NAME}</a>&nbsp;|&nbsp;
 	{/section}
 	
 	<br>
 	
 	DETAILED ::
 	 {section name=section_list loop=$sections}
 		<a href="divisions.php?SECTION={$sections[section_list].ID}&TYPE=DETAILED">{$sections[section_list].NAME}</a>&nbsp;|&nbsp;
 	{/section}
 	
<h1>Management</h1>
<a href="admin_divisions.php">Division Management</a> <br>
<a href="admin_represents.php">Represents Management</a>  <br>
<a href="admin_users.php">User Management</a>  <br>
<a href="admin_sections.php">Sections Management</a>  <br>
<a href="admin_champion.php?GENDER=All">Overall Champion Management - All</a><br> 
<a href="admin_champion.php?GENDER=Male">Overall Champion Management - Male</a><br> 
<a href="admin_champion.php?GENDER=Female">Overall Champion Management - Female</a> 

<h1>Participation Certificates</h1>
    <a href="admin_participation.php">Generate HTML participation certificates</a><br>

<h1>Reports</h1>
<a href="admin_blackbelt_participation.php">Generate Black Belt participation</a><br>
 	Form: 
	{section name=section_list loop=$sections}
 		<a href="admin_report.php?SECTION={$sections[section_list].ID}&REPORT=FORM">{$sections[section_list].NAME}</a>&nbsp;|&nbsp;
 	{/section}
	<br>
 	Payment: 
	{section name=section_list loop=$sections}
 		<a href="admin_report.php?SECTION={$sections[section_list].ID}&REPORT=PAYMENT">{$sections[section_list].NAME}</a>&nbsp;|&nbsp;
 	{/section}
	<br>
 	Not Enrolled: 
	{section name=section_list loop=$sections}
 		<a href="admin_report.php?SECTION={$sections[section_list].ID}&REPORT=NOTENROLLED">{$sections[section_list].NAME}</a>&nbsp;|&nbsp;
 	{/section}
    <br>
    Exceptions:
    {section name=section_list loop=$sections}
        <a href="admin_report.php?SECTION={$sections[section_list].ID}&REPORT=EXCEPTIONS">{$sections[section_list].NAME}</a>&nbsp;|&nbsp;
    {/section}




{include file="footer.tpl"}
</body>
</div>