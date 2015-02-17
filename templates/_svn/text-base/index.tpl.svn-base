{config_load file=test.conf}
{include file="header.tpl"}

<div id="main_pane">

{if $user_access == "admin"}
<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
  <table border="0">
    <tr>
     	<th>
 			Active
 		</th>
       	<th>		
 			Name
 		</th>
       	<th>		
 			Location
 		</th>
       	<th>		
 			Date From
 		</th>
        <th>
 			Date To
 		</th>
        <th>		
 			Competitors
 		</th> 				 		    
    </tr>
 	{section name=tournament_list loop=$tournaments}
	<tr>
	 	<td>
 			<input type="radio" name="Active" value="{$tournaments[tournament_list].ID}" {if $tournaments[tournament_list].ACTIVE}checked{/if}>
 		</td>
 		<td>
 		 	{if $tournaments[tournament_list].ACTIVE}<div id="active_tourn">{/if}		
 			{$tournaments[tournament_list].NAME}
 			{if $tournaments[tournament_list].ACTIVE}</div>{/if}			
 		</td>
 		<td>
 			{$tournaments[tournament_list].LOCATION}
 		</td>
 		<td>
 			{$tournaments[tournament_list].DATE_FROM|date_format:"%d %b, %Y"}
 		</td>
  		<td>
 			{$tournaments[tournament_list].DATE_TO|date_format:"%d %b, %Y"}
 		</td>
 		<td align="center">
 			{$tournaments[tournament_list].COMPETITOR_COUNT}
 		</td>			
 		{if $user_access == "admin"}
 		<td>
			<a href="edit_tournament.php?ID={$tournaments[tournament_list].ID}">edit</a>
 		</td> 	
 		{/if}
 	</tr>

 	 {/section}
 	 <tr>
 	 <td><input type="submit" value="Submit" name="Submit"></td>
 	 <td></td>
 	 <td></td>
 	 <td></td>
 	 <td></td>
 	 <td></td>
 	 <td>
  	 {if $user_access == "admin"}	 
 	 <a href="edit_tournament.php?ID=new">new</a>
 	 {/if}
 	 </td>
 	 </tr>
 </table>
</form>
{else}

<div id="active_tourn">

<img src="images/{$active_tournament.LOGO_NAME}" alt="Tournament Logo" width="150" height="150">

<p class="breakhere">

{$active_tournament.NAME}</br>
@ {$active_tournament.LOCATION}<br/>
{$active_tournament.DATE_FROM|date_format}{if $active_tournament.DATE_TO != $active_tournament.DATE_FROM} - {$active_tournament.DATE_TO|date_format}{/if}</br><br>
Currently:<br>
{$competitor_count} competitors<br>
{$team_competitor_count} teams
</p>
<br>
<p>
<a href="docs/{$active_tournament.TOURNAMENT_FORM_PDF}">Click here to download the Tournament Form.</a>
</p>
<br>
<p>
<h2>Schedule</h2>
{if $active_tournament.SCHEDULE_HTML}
	{$active_tournament.SCHEDULE_HTML}
{else}
	Schedule coming soon!
{/if}
</p>
</div>

{/if}

{include file="footer.tpl"}
</body>
</div>
