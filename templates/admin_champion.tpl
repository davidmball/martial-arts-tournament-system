{config_load file=test.conf section="setup"}
{include file="header.tpl"}

<div id="main_pane">

<h1>{$active_tournament.NAME}: {$active_tournament.DATE_FROM|date_format:$date}{if $active_tournament.DATE_TO != $active_tournament.DATE_FROM} - {$active_tournament.DATE_TO|date_format:$date}{/if} : Overall Champion - {$GENDER}</h1>


<form action="{$SCRIPT_NAME}?GENDER={$GENDER}" method="post" enctype="multipart/form-data">
<input type="submit" value="Submit" name="Submit">

<table border="1" class="champion">
  <tr>
     <th>Name</th>
      <th>Gender</th> 
      <th>Age</th>  
   		{section name=event loop=$event_names}
        	<th>{$event_names[event]}</th>
 		{/section}	 	    
     <th>Total Points</th>
     <th>Place</th>
     <th>Description</th>
	
	
  </tr>
		 
 	{section name=competitor loop=$champs_list}
      <tr>
 		<td>{$champs_list[competitor].NAME}</td>
 		<td>{$champs_list[competitor].GENDER}</td> 		
 		<td>{$champs_list[competitor].AGE}</td> 	 		
       {section name=event loop=$champs_list[competitor] max=$event_count}
		<td align="center">{$champs_list[competitor][event]}</td>
	   {/section}
 		<td align="center">{$champs_list[competitor].TOTAL}</td>
		<td align="center"><input type="text" name="Place{$champs_list[competitor].ID}" value="{$champs_list[competitor].PLACE}" size=1></td>
		<td align="center"><input type="text" name="Description{$champs_list[competitor].ID}" value="{$champs_list[competitor].DESCRIPTION}" size=20></td>
 	 </tr>

 	 {/section}
 </table>

<input type="submit" value="Submit" name="Submit">
</form>


{include file="footer.tpl"}
</body>
</div>
