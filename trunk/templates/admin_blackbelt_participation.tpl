{config_load file=test.conf section="setup"}
{include file="header.tpl"}

<div id="main_pane">
<h1>Black Belt Participation</h1>


<h2>Competitor List for: {$active_tournament.NAME}: {$active_tournament.DATE_FROM|date_format:$date}{if $active_tournament.DATE_TO != $active_tournament.DATE_FROM} - {$active_tournament.DATE_TO|date_format:$date}{/if}</h2>


<p class="legend">
Legend: S = Sparring, P = Patterns, ST = Special Techniques, PB = Power Breaking, RRS = Round Robin Sparring</br>
Legend: TSp = Team Sparring, TP = Team Patterns, TST = Team Special Techniques, TPB = Team Power Breaking, TSE = Team Special Events
</p>

	  
  <table border="0" class="registration">
  <tr>

 		<th>ID</th>

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
				
  </tr>
 	{section name=competitor_list loop=$competitors}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
		<td style="padding: 0px 10px 0px 10px;">
		{$competitors[competitor_list].ID}
		</td>
		
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

 	</tr>

 	 {/section}
 	 <tr>
 	 <td></td>


 	 <td></td>
 	 <td></td>
 	 <td></td>
 		{section name=event loop=$active_tournament_events_name_abbrev}
 			<th>
 				
 			</th>
 		{/section}	 						  				 			 						
 
 
	 	 
 	 <td>

 	 </td>
 	 </tr>
 </table>



{include file="footer.tpl"}
</body>
</div>