{config_load file=test.conf section="setup"}
{include file="header.tpl"}

<div id="main_pane">

<h1>Competitor List for: {$active_tournament.NAME}: {$active_tournament.DATE_FROM|date_format:$date}{if $active_tournament.DATE_TO != $active_tournament.DATE_FROM} - {$active_tournament.DATE_TO|date_format:$date}{/if}</h1>
   	 {if $user_access == "admin" || ($user_access == "manager" && $active_tournament.ALLOW_MANAGERS_TO_EDIT)}
   	 Click to enter new 
 	 <a href="edit_competitor.php?ID=new">competitor</a>
 	 or 
 	 <a href="edit_team.php?ID=new">team</a>
 	 {/if}

<h2>Competitors</h2>
<p class="legend">
Legend: S = Sparring, P = Patterns, ST = Special Techniques, PB = Power Breaking, RRS = Round Robin Sparring</br>
Legend: TSp = Team Sparring, TP = Team Patterns, TST = Team Special Techniques, TPB = Team Power Breaking, TSE = Team Special Events
</p>
{if $user_access == "admin"}
<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
<input type="submit" value="Submit" name="Submit">
{/if}
	  
  <table border="0" class="registration">
  <tr>

 		<th>ID</th>
 		{if $user_access == "admin" || ($user_access == "manager" && $active_tournament.ALLOW_MANAGERS_TO_EDIT)}
 		<th>Enrolment	</th>
 		{/if}
 		<th>First Name</th>
 		<th>Last Name	</th>
 		<th>Represents</th> 		
 		<th>
  			Rank	
 		</th>	
 		{section name=event loop=$active_tournament_events_name_abbrev}
 			<th>
 				{$active_tournament_events_name_abbrev[event]}
 			</th>
 		{/section}	 		
 		 {if $user_access == "admin" or $user_access == "manager" }		
 		<th>$Paid/$Cost (incl GST)</th>  				
		{/if} 	
				
  </tr>
 	{section name=competitor_list loop=$competitors}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td style="padding: 0px 10px 0px 10px;">
		{$competitors[competitor_list].ID}
		</td>
		
		{if $user_access == "admin" || ($user_access == "manager" && $active_tournament.ALLOW_MANAGERS_TO_EDIT)}
		<td style="padding: 0px 10px 0px 10px;">
		{if $user_access == "admin"}
				<select name="enrolment{$competitors[competitor_list].ID}">
	        	<option value="Registered" {if $competitors[competitor_list].ENROLMENT == "Registered"} selected="selected"{/if}>Registered</option>
	        	<option value="Signed_In" {if $competitors[competitor_list].ENROLMENT == "Signed_In"} selected="selected"{/if}>Signed In</option>
	        	<option value="Scratched" {if $competitors[competitor_list].ENROLMENT == "Scratched"} selected="selected"{/if}>Scratched</option>	        	
	        	<option value="Disqualified" {if $competitors[competitor_list].ENROLMENT == "Disqualified"} selected="selected"{/if}>Disqualified</option>	        	
	        	</select>
	     {else if ($user_access == "manager" and $competitors[competitor_list].EDIT)}
	     		{$competitors[competitor_list].ENROLMENT}
		{/if}
		</td>
		{/if}
		
 		<td style="padding: 0px 10px 0px 10px;">		
 			{$competitors[competitor_list].FIRST_NAME}		
 		</td>
 		<td style="padding: 0px 10px 0px 10px;">
 			{$competitors[competitor_list].LAST_NAME}
 		</td>
  		<td style="padding: 0px 10px 0px 10px;">
 			{$competitors[competitor_list].REPRESENTS_NAME}
 		</td>
 		 <td style="padding: 0px 10px 0px 10px;">
 			{$competitors[competitor_list].RANK}
 		</td>
 		{section name=event loop=$competitors_events[competitor_list]}
 			<td  style="padding: 0px 5px 0px 5px;" align="center">
 			 {$competitors_events[competitor_list][event]}
 			 </td>
 		{/section}	 				
 		{if $user_access == "admin" or ($user_access == "manager" and $competitors[competitor_list].EDIT) }		
   		<td style="padding: 0px 10px 0px 10px;">
 			${$competitors[competitor_list].PAID_AMOUNT|string_format:"%.2f"} / ${$competitors[competitor_list].OWED_AMOUNT|string_format:"%.2f"}
 		</td> 				  				 			 						
 
 		<td>{if $user_access == "admin" || ($user_access == "manager" && $active_tournament.ALLOW_MANAGERS_TO_EDIT)}
			<a href="edit_competitor.php?ID={$competitors[competitor_list].ID}">edit</a>
 			{/if}
 		</td> 	
 		{/if}
 	</tr>

 	 {/section}
 	 <tr>
 	 <td></td>
 	 {if $user_access == "admin" || ($user_access == "manager" && $active_tournament.ALLOW_MANAGERS_TO_EDIT)}
 	 <td></td>
 	 {/if}
 	 
		{if $user_access == "admin" || ($user_access == "manager" && $active_tournament.ALLOW_MANAGERS_TO_EDIT)}
 		<td></td>
		{/if}
 	 <td></td>
 	 <td></td>
 	 <td></td>
 		{section name=event loop=$active_tournament_events_name_abbrev}
 			<th>
 				
 			</th>
 		{/section}	 						  				 			 						
 
 
	{if $user_access == "admin" or ($user_access == "manager") }		
 	 <td></td> 	
 	{/if}   	 	 
 	 <td>
  	 {if $user_access == "admin" || ($user_access == "manager" && $active_tournament.ALLOW_MANAGERS_TO_EDIT)}	 
 	 <a href="edit_competitor.php?ID=new">new</a>
 	 {/if}
 	 </td>
 	 </tr>
 </table>
{if $user_access == "admin"}
<input type="submit" value="Submit" name="Submit">
</form>
{/if}

<h2>Teams</h2>
<p class="legend">
Legend: TSp = Team Sparring, TP = Team Patterns, TST = Team Special Techniques, TPB = Team Power Breaking, TSE = Team Special Events
</p>

  <table border="0" class="registration">
  <tr>
 		<th>ID</th>
 		<th>Team Name</th>
   		<th>Captain Name</th>		
 		<th>Represents</th> 		
 		{section name=event loop=$active_tournament_events_name_abbrev}
 		   {if $active_tournament_teams_event[event] == 1}
 			<th>
 				{$active_tournament_events_name_abbrev[event]}
 			</th>
 		   {/if}
 		{/section} 					
  </tr>
 	{section name=team_list loop=$teams}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td style="padding: 0px 10px 0px 10px;">
			{$teams[team_list].ID}
		</td>
		<td style="padding: 0px 10px 0px 10px;">		
 			{$teams[team_list].TEAM_NAME}		
 		</td>
 		<td style="padding: 0px 10px 0px 10px;">
 			{$teams[team_list].CAPTAIN_NAME}
 		</td>
  		<td style="padding: 0px 10px 0px 10px;">
 			{$teams[team_list].REPRESENTS_NAME}
 		</td>
 		{section name=event loop=$teams_events[team_list]}
			{if $active_tournament_teams_event[event] == 1}
 			<td  style="padding: 0px 5px 0px 5px;" align="center">
				{$teams_events[team_list][event]}
 			</td>
 			{/if}
 		{/section}
 		<td>
 		{if $user_access == "admin" || ($user_access == "manager" && $active_tournament.ALLOW_MANAGERS_TO_EDIT && $teams[team_list].EDIT)}
		<a href="edit_team.php?ID={$teams[team_list].ID}">edit</a>
 		{/if}
 		</td> 	
 	</tr>
 	 {/section}
 	 
 	 <tr>
 	 <td></td>
 	 <td></td>
 	 <td></td>
 	 <td></td>

 		{section name=event loop=$active_tournament_events_name_abbrev}
    	   {if $active_tournament_teams_event[event] == 1}
 			<td>
 			</td>
 		   {/if}
 		{/section}  	 
 	  	    	 	 
 	 <td>
  	 {if $user_access == "admin" || ($user_access == "manager" && $active_tournament.ALLOW_MANAGERS_TO_EDIT)}	 
 	 <a href="edit_team.php?ID=new">new</a>
 	 {/if}
 	 </td>
 	 </tr>
 </table>



{include file="footer.tpl"}
</body>
</div>
