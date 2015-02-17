{config_load file=test.conf}
{include file="header.tpl"}




{if $division.TYPE == "Form_Individual" || $division.TYPE == "Form_Team"}
<div id="form_main_pane">

<!-- Do the Title Block -->
<div class="form_title_block">
<!-- Consider Tournament Name (although might be better in title box) -->
<img src="images/{$active_tournament.LOGO_NAME}" alt="Tournament Logo" width="90" height="90" align="left">
{$active_tournament.NAME}</br>
{$active_tournament.DATE_FROM|date_format}{if $active_tournament.DATE_TO != $active_tournament.DATE_FROM} - {$active_tournament.DATE_TO|date_format}{/if}</br>
{$division.NAME} ({$division.NUM_COMPETITORS}) <br>
Type: {$division.TYPE}<br>
</div>

{if $user_access == "admin" || $user_access == "steward"} 
<form action="{$SCRIPT_NAME}?DIVISION_ID={$division.ID}" method="post" enctype="multipart/form-data">
<div ="draw_title_buttons"><input type="submit" value="Submit" name="Submit"></div>

{/if}

	<table border="1" class="form">
	<tr>
	   {if $division.TYPE == "Form_Individual"}
 		<th>Name</th>	
 		<th>ID</th>
 	   {/if}
 		<th>Represents</th>
 		{if $num_techs >= 1}<th>{$division.TECHNIQUE1}</th>{/if}
 		{if $num_techs >= 2}<th>{$division.TECHNIQUE2}</th>{/if}
  		{if $num_techs >= 3}<th>{$division.TECHNIQUE3}</th>{/if}
 		{if $num_techs >= 4}<th>{$division.TECHNIQUE4}</th>{/if}
 		{if $num_techs >= 5}<th>{$division.TECHNIQUE5}</th>{/if}
 		<th>Total Points</th>
 		<th>Extra Test (1)</th>
 		<th>Extra Test (2)</th>
 		<th>Final Points</th>
 		<th>Place</th>
	</tr>
	
	{section name=competitor_list loop=$competitors}
	<tr>
   	   {if $division.TYPE == "Form_Individual"}
 		<td>{if $competitors[competitor_list].ENROLMENT == "Disqualified"}<strike>{/if}{$competitors[competitor_list].NAME}{if $competitors[competitor_list].ENROLMENT == "Disqualified"}</strike>{/if}</td>
		<td>{$competitors[competitor_list].ID}</td>
	   {/if}
		<td>{$competitors[competitor_list].REPRESENTS}</td>
	   {if $user_access == "admin" || $user_access == "steward"} 
 		{if $num_techs >= 1}<td align="center"><input type="text" name="round{$competitors[competitor_list].ROUND_NUMBER}Technique1" value="{if ($competitors[competitor_list].TECHNIQUE1 == 0)}&nbsp;{else}{$competitors[competitor_list].TECHNIQUE1}{/if}" size=1></td>{/if}
 		{if $num_techs >= 2}<td align="center"><input type="text" name="round{$competitors[competitor_list].ROUND_NUMBER}Technique2" value="{if ($competitors[competitor_list].TECHNIQUE2 == 0)}&nbsp;{else}{$competitors[competitor_list].TECHNIQUE2}{/if}" size=1></td>{/if}
 		{if $num_techs >= 3}<td align="center"><input type="text" name="round{$competitors[competitor_list].ROUND_NUMBER}Technique3" value="{if ($competitors[competitor_list].TECHNIQUE3 == 0)}&nbsp;{else}{$competitors[competitor_list].TECHNIQUE3}{/if}" size=1></td>{/if}
 		{if $num_techs >= 4}<td align="center"><input type="text" name="round{$competitors[competitor_list].ROUND_NUMBER}Technique4" value="{if ($competitors[competitor_list].TECHNIQUE4 == 0)}&nbsp;{else}{$competitors[competitor_list].TECHNIQUE4}{/if}" size=1></td>{/if}
 		{if $num_techs >= 5}<td align="center"><input type="text" name="round{$competitors[competitor_list].ROUND_NUMBER}Technique5" value="{if ($competitors[competitor_list].TECHNIQUE5 == 0)}&nbsp;{else}{$competitors[competitor_list].TECHNIQUE5}{/if}" size=1></td>{/if}	   
	   {else}
 		{if $num_techs >= 1}<td align="center">{if ($competitors[competitor_list].TECHNIQUE1 == 0)}&nbsp;{else}{$competitors[competitor_list].TECHNIQUE1}{/if}</td>{/if}
 		{if $num_techs >= 2}<td align="center">{if ($competitors[competitor_list].TECHNIQUE2 == 0)}&nbsp;{else}{$competitors[competitor_list].TECHNIQUE2}{/if}</td>{/if}
 		{if $num_techs >= 3}<td align="center">{if ($competitors[competitor_list].TECHNIQUE3 == 0)}&nbsp;{else}{$competitors[competitor_list].TECHNIQUE3}{/if}</td>{/if}
 		{if $num_techs >= 4}<td align="center">{if ($competitors[competitor_list].TECHNIQUE4 == 0)}&nbsp;{else}{$competitors[competitor_list].TECHNIQUE4}{/if}</td>{/if}
 		{if $num_techs >= 5}<td align="center">{if ($competitors[competitor_list].TECHNIQUE5 == 0)}&nbsp;{else}{$competitors[competitor_list].TECHNIQUE5}{/if}</td>{/if}
 	   {/if} 		 		 			
		<td align="center">{if ($competitors[competitor_list].TOTAL_POINTS == 0)}&nbsp;{else}{$competitors[competitor_list].TOTAL_POINTS}{/if}</td>
	   {if $user_access == "admin" || $user_access == "steward"} 		
		<td align="center"><input type="text" name="round{$competitors[competitor_list].ROUND_NUMBER}Extra1" value="{if ($competitors[competitor_list].EXTRA_TEST1_POINTS == 0)}&nbsp;{else}{$competitors[competitor_list].EXTRA_TEST1_POINTS}{/if}" size=1></td>			
		<td align="center"><input type="text" name="round{$competitors[competitor_list].ROUND_NUMBER}Extra2" value="{if ($competitors[competitor_list].EXTRA_TEST2_POINTS == 0)}&nbsp;{else}{$competitors[competitor_list].EXTRA_TEST2_POINTS}{/if}" size=1></td>
	   {else}		
		<td align="center">{if ($competitors[competitor_list].EXTRA_TEST1_POINTS == 0)}&nbsp;{else}{$competitors[competitor_list].EXTRA_TEST1_POINTS}{/if}</td>	
		<td align="center">{if ($competitors[competitor_list].EXTRA_TEST2_POINTS == 0)}&nbsp;{else}{$competitors[competitor_list].EXTRA_TEST2_POINTS}{/if}</td>
 	   {/if} 								
		<td align="center">{if ($competitors[competitor_list].FINAL_POINTS == 0)}&nbsp;{else}{$competitors[competitor_list].FINAL_POINTS}{/if}</td>
	   {if $user_access == "admin" || $user_access == "steward"} 		
		<td align="center"><input type="text" name="round{$competitors[competitor_list].ROUND_NUMBER}Place" value="{if ($competitors[competitor_list].PLACE == 0)}&nbsp;{else}{$competitors[competitor_list].PLACE}{/if}" size=1></td>
	   {else}		
		<td align="center">{if ($competitors[competitor_list].PLACE == 0)}&nbsp;{else}{$competitors[competitor_list].PLACE}{/if}</td>
 	   {/if} 				
	</tr>
	{/section}
	</table>

{if $user_access == "admin" || $user_access == "steward"} 
</br>
<div ="draw_title_buttons"><input type="submit" value="Submit" name="Submit"></div>
</form>	
{/if}
		
</div> <!-- /form_main_pane -->

{elseif $division.TYPE == "Round_Robin"}



<div id="main_pane">

{if $unable_to_draw}
	ERROR: Unable to draw this division as it is either too big or too small.
{elseif $bad_division_id}
	ERROR: Bad division id on URI.
{else}

<!-- Do the Title Block -->

<!-- Consider Tournament Name (although might be better in title box) -->
<img src="images/{$active_tournament.LOGO_NAME}" alt="Tournament Logo" width="90" height="90" align="left">
{$active_tournament.NAME}<br>
{$active_tournament.DATE_FROM|date_format}{if $active_tournament.DATE_TO != $active_tournament.DATE_FROM} - {$active_tournament.DATE_TO|date_format}{/if}</br>
{$division.NAME} ({$division.NUM_COMPETITORS}) <br>
Type: {$division.TYPE}<br>
Ring: <br><br>


{if $user_access == "admin" || $user_access == "steward"} 
<form action="{$SCRIPT_NAME}?DIVISION_ID={$division.ID}" method="post" enctype="multipart/form-data">
<div ="draw_title_buttons"><input type="submit" value="Submit" name="Submit"></div>
{/if}

<p></p>

<style type="text/css" media="screen">
	{$css_draw_styles}
</style>
<style type="text/css" media="print">
	{$css_draw_styles}
</style>
		
	<table border="1" class="form">
	<tr>
 		<th>Name</th>	
 		<th>ID</th>
 		<th>Place</th>
 		<th>Wins</th>
 		<th>Draws</th>
 		<th>Loses</th>
 		<th>Points</th>
 		<th>Score Diff</th>
	</tr>
		{section name=competitor_list loop=$competitors}
		<tr>
		<td>{$competitors[competitor_list].NAME}</td>
		<td>{$competitors[competitor_list].ID}</td>
	   {if $user_access == "admin" || $user_access == "steward"} 		
		 <td align="center"><input type="text" name="competitor_{$competitors[competitor_list].ROUND}Place" value="{$competitors[competitor_list].PLACE}" size=1></td>
	   {else}		
		 <td align="center">{$competitors[competitor_list].PLACE}</td>
	  {/if} 		
		<td>{$competitors[competitor_list].WINS}</td>
		<td>{$competitors[competitor_list].DRAWS}</td>
		<td>{$competitors[competitor_list].LOSES}</td>
		<td>{$competitors[competitor_list].POINTS}</td>
		<td>{$competitors[competitor_list].DIFF}</td>		
		</tr>
		{/section}
	</table>
	<p></p>
	<p>Note that first and second in points fight each other in a final which determines placings.</p>
	<p></p>
	<table border="1" class="form">

		{section name=round_list loop=$rounds}
		

		
	    	<tr>
				<td>{$rounds[round_list].ROUND_NUMBER}</td>
				<td>{$rounds[round_list].NAME_LEFT}</td>
				   {if $user_access == "admin" || $user_access == "steward"} 		
					 <td align="center"><input type="text" name="round_{$rounds[round_list].ROUND_NUMBER}_Score_Left" value="{$rounds[round_list].SCORE_LEFT}" size=1></td>
				   {else}		
					 <td align="center">{$rounds[round_list].SCORE_LEFT}</td>
				  {/if} 					
				<td>{$rounds[round_list].NAME_RIGHT}</td>
				   {if $user_access == "admin" || $user_access == "steward"} 		
					 <td align="center"><input type="text" name="round_{$rounds[round_list].ROUND_NUMBER}_Score_Right" value="{$rounds[round_list].SCORE_RIGHT}" size=1></td>
				   {else}		
					 <td align="center">{$rounds[round_list].SCORE_RIGHT}</td>
				  {/if} 					
			</tr>
			

			
		{/section}		

	</table>			

{if $user_access == "admin" || $user_access == "steward"} 
</br>
<div ="draw_title_buttons"><input type="submit" value="Submit" name="Submit"></div>
</form>	
{/if}
		
</div>

{/if}


		
{else}

<div id="division_main_pane">

{if $unable_to_draw}
	{$division.NAME} ({$division.NUM_COMPETITORS})<br>
	ERROR: Unable to draw this division as it is either too big or too small.
{elseif $bad_division_id}
	ERROR: Bad division id on URI.
{else}

<style type="text/css" media="screen">
	{$css_draw_styles}
</style>
<style type="text/css" media="print">
	{$css_draw_styles}
</style>

<form action="{$SCRIPT_NAME}?DIVISION_ID={$division.ID}" method="post" enctype="multipart/form-data" >

<!-- Do the Title Block -->
<div class="draw_title_block">
<!-- Consider Tournament Name (although might be better in title box) -->
<img src="images/{$active_tournament.LOGO_NAME}" alt="Tournament Logo" width="110" height="110" align="left" style="padding-bottom:100px;">
{$active_tournament.NAME} - {$division.SECTION_NAME}</br>
{$active_tournament.DATE_FROM|date_format}{if $active_tournament.DATE_TO != $active_tournament.DATE_FROM} - {$active_tournament.DATE_TO|date_format}{/if}</br>
{$division.NAME} ({$division.NUM_COMPETITORS}) <br>
Event: {$division.EVENT_NAME} - {$division.TYPE}<br>
{if $division.EVENT_NAME == "Sparring" || $division.EVENT_NAME == "Team Sparring"}
	Format: {$division.ROUNDS} x {$division.ROUND_MIN} min {if $division.BREAK_MIN != 0}+ {$division.BREAK_MIN} min break{/if}<br>
{/if}
Ring: <br>
{if $user_access == "admin" || $user_access == "steward"}
<div class="draw_title_buttons"><input type="submit" value="Submit" name="Submit">&nbsp;&nbsp;<input type="submit" value="Clear" name="Clear"></div>
<a href="edit_division.php?ID={$division.ID}">Edit</a>
{/if}
</div>



{section name=round loop=$round_list start=-1 step=-1}
<div class="{$round_list[round].STYLE_NAME}">
{if $round_list[round].COLOUR_WIN == "Y"} 
<table class="round">

<TR><td class="division_bye_round_number">{$round_list[round].ROUND_NUMBER}</td>
<TD style="text-align: center; border-width: 0px;  padding-top: 4px; background-color:#f30">
R</TD><TD style=" border-width: 0px; padding-top: 4px;">  
<input  {if $round_list[round].RED_ID < 0} style="color:#aaa; text-align:right;"{/if} type="text" readonly value="{$round_list[round].RED_NAME}" size="18">{if $user_access == "admin" || $user_access == "steward"}<input type="radio" NAME="{$round_list[round].ROUND_NUMBER}" VALUE="Y" checked>{else}*{/if}

</TD></TR>
</table>
{else}


<table {if $round_list[round].ROUND_NUMBER == 2 && $division.MINOR_FINAL == "3rd3rd"} class="round_3rd3rd" {else} class="round"{/if}>
	<TR><td rowspan="3" style="text-align: left; border-width: 0px; width: 20px">{$round_list[round].ROUND_NUMBER}</td>
	<TD style="text-align: center; border-width: 0px; vertical-align: top; padding-top: 4px; background-color:#f30">R</TD>
	<TD style=" border-width: 0px; vertical-align: top; padding-top: 4px;">  
	<input  {if $round_list[round].RED_ID < 0} style="color:#aaa; text-align:right;"{/if} type="text" readonly value="{$round_list[round].RED_NAME}" size="18">{if $user_access == "admin" || $user_access == "steward"}<input type="radio" NAME="{$round_list[round].ROUND_NUMBER}" VALUE="R" {if $round_list[round].COLOUR_WIN == "R"} checked{/if}>{elseif $round_list[round].COLOUR_WIN == "R"}*{/if}
	</TD></TR><TR><td></td><td></td><td><!-- hr size=4 width=15 color=black style="float: left; position: absolute; left: 200px;" --></td></TR><TR>
	<TD style="text-align: center; border-width: 0px; vertical-align: bottom; padding-bottom: 4px; background-color:#0bf">B</td>
	<td style="border-width: 0px; vertical-align: bottom; padding-bottom: 4px;">
	<input  {if $round_list[round].BLUE_ID < 0} style="color:#aaa; text-align:right;"{/if} type="text" readonly value="{$round_list[round].BLUE_NAME}" size="18">{if $user_access == "admin" || $user_access == "steward"}<input type="radio" NAME="{$round_list[round].ROUND_NUMBER}" VALUE="B" {if $round_list[round].COLOUR_WIN == "B"} checked{/if}>{elseif $round_list[round].COLOUR_WIN == "B"}*{/if}
	</TD></TR>
</table>

{/if}
</div>
{/section}


<!-- Do the Results Part -->
<div class="draw_results">

<table style="background-color: #ccc; width: 100%; border-collapse: collapse; height: 100%; border-width: 0px;">
<tr><td>1st</td><td><input type="text" readonly value="{$FIRST}" size="20"></td></tr>
<tr><td>2nd</td><td><input type="text" readonly value="{$SECOND}" size="20"></td></tr>
{if $competitors_in_draw != 2}
	{if $division.MINOR_FINAL == "3rd4th"}
	<tr><td>3rd</td><td><input type="text" readonly value="{$THIRD}" size="20"></td></tr>
	<tr><td>4th</td><td><input type="text" readonly value="{$FOURTH}" size="20"></td></tr>
	{elseif $division.MINOR_FINAL == "3rd3rd"}
		{if $division.TYPE == "Elimination"}
			<tr><td>3rd</td><td><input {if $THIRD == "4"} style="color:#aaa; text-align:right;"{/if} type="text" readonly value="{if $THIRD == "4"}Loser from {/if}{$THIRD}" size="20"></td></tr>
			<tr><td>3rd</td><td><input {if $FOURTH == "3"} style="color:#aaa; text-align:right;"{/if} type="text" readonly value="{if $FOURTH == "3"}Loser from {/if}{$FOURTH}" size="20"></td></tr>
		{else}
			<tr><td>3rd</td><td><input {if $THIRD == "4"} style="color:#aaa; text-align:right;"{/if} type="text" readonly value="{if $THIRD == "4"}Loser from L2{else}{$THIRD}{/if}" size="20"></td></tr>
			<tr><td>3rd</td><td><input {if $FOURTH == "3"} style="color:#aaa; text-align:right;"{/if} type="text" readonly value="{if $FOURTH == "3"}Loser from L1{else}{$FOURTH}{/if}" size="20"></td></tr>
		{/if}
	{/if}
{/if}
</table>
<tr><td></td><td></td></tr>
<tr><td></td><td></td></tr>
</div>


{section name=round loop=$loser_round_list start=-1 step=-1}
<div class="{$loser_round_list[round].STYLE_NAME}">
{if $loser_round_list[round].COLOUR_WIN == "Y"} 
<table class="round">

<TR><td class="division_bye_round_number">{$loser_round_list[round].ROUND_NUMBER_DISPLAY}</td>
<TD style="text-align: center; border-width: 0px;  padding-top: 4px; background-color:#f30">
R</TD><TD style=" border-width: 0px; padding-top: 4px;">  
<input {if $loser_round_list[round].RED_ID < 0} style="color:#aaa; text-align:right;"{/if} type="text" readonly value="{$loser_round_list[round].RED_NAME}" size="18">{if $user_access == "admin" || $user_access == "steward"}<input type="radio" NAME="{$loser_round_list[round].ROUND_NUMBER}" VALUE="Y" checked>{else}*{/if}

</TD></TR>
</table>
{else}
<table class="round">

<TR><td rowspan="3" style="text-align: left; border-width: 0px; width: 20px;">{$loser_round_list[round].ROUND_NUMBER_DISPLAY}</td>
<TD style="text-align: center; border-width: 0px; vertical-align: top; padding-top: 4px; background-color:#f30">
R</TD><TD style=" border-width: 0px; vertical-align: top; padding-top: 4px;">  
<input {if $loser_round_list[round].RED_ID < 0} style="color:#aaa; text-align:right;"{/if} type="text" readonly value="{$loser_round_list[round].RED_NAME}" size="18">{if $user_access == "admin" || $user_access == "steward"}<input type="radio" NAME="{$loser_round_list[round].ROUND_NUMBER}" VALUE="R" {if $loser_round_list[round].COLOUR_WIN == "R"} checked{/if}>{elseif $loser_round_list[round].COLOUR_WIN == "R"}*{/if}

</TD></TR>
<TR><td></td><td></td></TR>

<TR><TD style="text-align: center; border-width: 0px; vertical-align: bottom; padding-bottom: 4px; background-color:#0bf">
B</td><td style="border-width: 0px; vertical-align: bottom; padding-bottom: 4px;">
<input {if $loser_round_list[round].BLUE_ID < 0} class="draw_instruction"{/if} type="text" readonly value="{$loser_round_list[round].BLUE_NAME}" size="18">{if $user_access == "admin" || $user_access == "steward"}<input type="radio" NAME="{$loser_round_list[round].ROUND_NUMBER}" VALUE="B" {if $loser_round_list[round].COLOUR_WIN == "B"} checked{/if}>{elseif $loser_round_list[round].COLOUR_WIN == "B"}*{/if}

</TD></TR>
</table>
{/if}
</div>
{/section}




</form>


</div> <!-- /division_main_pane -->
{/if}
{/if}

{include file="footer.tpl"}
</body>
</div>


