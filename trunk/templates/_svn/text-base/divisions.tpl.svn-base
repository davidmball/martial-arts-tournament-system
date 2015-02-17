{literal}
<style type="text/css" media="print">
	#header_pane {
		display: none;
	}
	#main_pane {
 		top: 0px;
 	}
 	#login_pane {
 		display: none;
 	}
</style>
{/literal}


{config_load file=test.conf}
{include file="header.tpl"}

{if $user_access != "admin" && !$active_tournament.DRAWS_PUBLIC}

<p>
The draws are not available at this time.
</p>

{elseif $user_access == "admin" && $display_type == "interactive"}

<form id="division_form" name="division_form" action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
<input type="hidden" name="EVENT_SELECTED" value="{$current_event_selected}">
</form>

{literal}
<script type="text/javascript">
function event_clicked(id, event) {
	var x = document.getElementById("division_form");
	window.document.division_form.EVENT_SELECTED.value = event;
	x.submit();
}	

var competitor_selected_array = new Array();
var num_entries = 0;

function competitor_clicked(competitor_id) {
	
	// don't try and work on delselections here, just add them all to the list
	num_entries = competitor_selected_array.push(competitor_id);
	
	//window.document.division_form.competitor_ids_clicked = 2;
	//alert(competitor_id);
	
}

function grab_clicked(division_id )
{

	// decodes whether a competitor is selected or not
	// this needs to be done because as the user clicks the competitors_id are just added to a list
	// ie they are not removed as the user deselects them. There might be way of doing it properly as the
	// user clicks....
	var competitor_selected_confirmed = new Array();
	var i = 0;
	var already_confirmed;
	var selected;
	var num_confirmed;
	for (i = 0; i < num_entries; i++) {
		selected = 0;
		already_confirmed = 0;
		for (k = 0; k < num_confirmed; k++) {
			if (competitor_selected_confirmed[k] == competitor_selected_array[i])
				already_confirmed = 1;
		}		
		//selected = 1;
		if (already_confirmed == 0) {
			for (j = 0; j < num_entries; j++) {
				
				if (competitor_selected_array[i] == competitor_selected_array[j]) {
					if (selected) {
						selected = 0;
					} else {			
						selected = 1;
					}
				}
			}
		}
		if (selected)
			num_confirmed = competitor_selected_confirmed.push(competitor_selected_array[i]);
	}
	var x = document.getElementById("division_form");
	
	
	document.write('<form id="competitor_selected_form" name="competitor_selected_form" action="divisions.php" method="post" enctype="multipart/form-data">');
	document.write('<input type="hidden" name="EVENT_SELECTED" value="{/literal}{$current_event_selected}{literal}"/>');
	document.write('<input type="hidden" name="DIVISION_SELECTED" value="'+division_id+'"/>');
	document.write('<select id="blah" name="competitor_ids_clicked[]" multiple style="display:none">');
	for (i = 0; i < num_confirmed; i++) {
		document.write('<option label="fred" value="'+competitor_selected_confirmed[i]+'" selected="selected"></option>');
	}
	document.write('</select>');
	document.write('</form>');

 	var x = document.getElementById("competitor_selected_form");
	x.submit();
 
}

function sort_selected(division_id)
{
	// decodes whether a competitor is selected or not
	// note that this doesn't quite work where a competitor is clicked 3, 5, 7... times amongst other competitors
	// being clicked. This is because the competitor is checked int he order of the inital clicks.
	// not that deselecting will still work though.
	var competitor_selected_confirmed = new Array();
	var i = 0;
	var already_confirmed;
	var selected;
	var num_confirmed;
	for (i = 0; i < num_entries; i++) {
		selected = 0;
		already_confirmed = 0;
		for (k = 0; k < num_confirmed; k++) {
			if (competitor_selected_confirmed[k] == competitor_selected_array[i])
				already_confirmed = 1;
		}		
		//selected = 1;
		if (already_confirmed == 0) {
			for (j = 0; j < num_entries; j++) {
				
				if (competitor_selected_array[i] == competitor_selected_array[j]) {
					if (selected) {
						selected = 0;
					} else {			
						selected = 1;
					}
				}
			}
		}
		if (selected)
			num_confirmed = competitor_selected_confirmed.push(competitor_selected_array[i]);
	}
	
	document.write('<form id="competitor_sort_form" name="competitor_sort_form" action="divisions.php" method="post" enctype="multipart/form-data">');
	document.write('<input type="hidden" name="EVENT_SELECTED" value="{/literal}{$current_event_selected}{literal}"/>');
	document.write('<input type="hidden" name="SORT_SELECTED" value="1"/>');
	document.write('<input type="hidden" name="DIVISION_SELECTED" value="'+division_id+'"/>');
	document.write('<select id="blah" name="competitor_ids_clicked[]" multiple style="display:none">');
	for (i = 0; i < num_confirmed; i++) {
		document.write('<option label="fred" value="'+competitor_selected_confirmed[i]+'" selected="selected"></option>');
	}
	document.write('</select>');
	document.write('</form>');

 	var x = document.getElementById("competitor_sort_form");
	x.submit();

}
</script>
{/literal}



<div id="main_pane">
<table cols="2" width="100%">
<tr valign="top">
<td width="50%">

<div class="unassigned_div">
 {datatable data=$unassigned_list cycle=1 mouseover=1 width="100%" id="unassigned_class" class="unassigned_class" row_onClick="event_clicked( \$__rowidx, \$EVENT_ID)"}
  {column id="EVENT" name="Event" align="centre"}
  {column id="EVENT_ENROLMENT_COUNT" name="Still to Sign-In" align="center" sorttype="Numerical"}
  {column id="COMPETITOR_COUNT" name="Unassigned" align="center" sorttype="Numerical"}
  {column id="TOTAL_COUNT" name="Total" align="center" sorttype="Numerical"}
 {/datatable}
</div>

<div class="divisions_only">
 {datatable data=$division_list sortable=1 cycle=1 mouseover=1 width="100%" id="divisions_only_class" class="divisions_only_class"}
  {column id="EVENT" name="Event"}
  {column id="DIVISION" name="Division" }
  {column id="SECTION_NAME" name="Section" }
  {column id="ENROLMENT_COUNT" name="Still to Sign-In" align="center" sorttype="Numerical"} 
  {column id="COMPETITOR_COUNT" name="Total Count" align="center" sorttype="Numerical"}
 {/datatable}
</div>

<div class="divisions_left">
	
{section name=division loop=$division_list}
<!--	{$competitor_division_starts[division]} {$division_list[division].COMPETITOR_COUNT} -->
	 {assign var='table_name' value=$division_list[division].DIVISION_ID}
	<button type="button" name="show" value={$division_list[division].DIVISION_ID} onClick="grab_clicked(this.value)">Grab Selected</button> <button type="button" name="show" value={$division_list[division].DIVISION_ID} onClick="sort_selected(this.value)">Sort</button> {if $division_list[division].DIVISION_ID != 0}<a href="division_draw.php?DIVISION_ID={$division_list[division].DIVISION_ID}">{/if}{$division_list[division].DIVISION}</a> ({$division_list[division].COMPETITOR_COUNT}) "{$division_list[division].DIVISION_TYPE}"
	 {datatable data=$competitor_list start=$competitor_division_starts[division] loops=$division_list[division].COMPETITOR_COUNT sortable=1 cycle=1 mouseover=1 selectable=2 width="100%" id=$table_name class=$table_name row_onClick="competitor_clicked(\$ID)"}	  
	  {column id="ENROLMENT" name="E"}
	  {column id="FIRST_NAME" name="First Name" }
	  {column id="LAST_NAME" name="Last Name" }
	  {column id="GENDER" name="M/F" align="center"}
	  {column id="AGE" name="Age" align="center" sorttype="Numerical"}
	  {column id="RANK" name="Rank" align="center" sorttype="Numerical"}
	  {column id="WEIGHT" name="Weight" align="center" sorttype="Numerical"}
	  {column id="HEIGHT" name="Height" align="center" sorttype="Numerical"} 
  	  {column id="REPRESENTS" name="Represents"}  
  	  {column id="COMMENTS" name="!"}    
	 {/datatable}
{/section}
</div>

</td>
<td width="50%">

<div class="divisions_right">
		
{section name=division loop=$division_list}
	
	 {assign var='table_name' value=$division_list[division].DIVISION_ID+10000}
	<!-- <button type="button" name="show" value={$division_list[division].DIVISION_ID} onClick="grab_clicked(this.value)">Grab All</button> --> {if $division_list[division].DIVISION_ID != 0}<a href="division_draw.php?DIVISION_ID={$division_list[division].DIVISION_ID}">{/if}{$division_list[division].DIVISION}</a> ({$division_list[division].COMPETITOR_COUNT}) "{$division_list[division].DIVISION_TYPE}"
	 {datatable data=$competitor_list start=$competitor_division_starts[division] loops=$division_list[division].COMPETITOR_COUNT sortable=1 cycle=1 mouseover=1 selectable=2 width="100%" id=$table_name class=$table_name row_onClick="competitor_clicked(\$ID)"}
	  {column id="ENROLMENT" name="E"}
	  {column id="FIRST_NAME" name="First Name" }
	  {column id="LAST_NAME" name="Last Name" }
	  {column id="GENDER" name="M/F" align="center"}
	  {column id="AGE" name="Age" align="center" sorttype="Numerical"}
	  {column id="RANK" name="Rank" align="center" sorttype="Numerical"}
	  {column id="WEIGHT" name="Weight" align="center" sorttype="Numerical"}
	  {column id="HEIGHT" name="Height" align="center" sorttype="Numerical"}
	  {column id="REPRESENTS" name="Represents"}
	  {column id="COMMENTS" name="!"}        
	 {/datatable}
{/section}
</div>

</td>

</tr>
</table>

<!-- for the stewards -->
{elseif $user_access == "steward"}

<div id="main_pane">
<h1>Division List for: {$active_tournament.NAME}: {$active_tournament.DATE_FROM|date_format:$date}{if $active_tournament.DATE_TO != $active_tournament.DATE_FROM} - {$active_tournament.DATE_TO|date_format:$date}{/if}</h1>
<h2>For Ring 2</h2>

 <table border="0">
  	<tr>
 		<th>		
 			ID		
 		</th>
 		<th>
 			Division
 		</th>
 		<th>
 			Event Name
 		</th> 		
 		<th>		
 			Section Name	
 		</th>				
 	</tr>
 	{section name=division_list loop=$divisions}
	<tr>
 		<td align="center">
 			{$divisions[division_list].ID}		
 		</td>
 		<td>
 			{$divisions[division_list].NAME}
 		</td>
 		<td  align="center">
 			{$divisions[division_list].EVENT_NAME}
 		</td> 	
 		 <td align="center">
 			{$divisions[division_list].SECTION_NAME}
 		</td> 			 			
 		<td>
			<a href="division_draw.php?DIVISION_ID={$divisions[division_list].ID}">edit</a>
 		</td> 	
 	</tr>

 	 {/section}
 </table>
</div>

<!-- for the public and managers -->
{else}

<div id="main_pane">
<h1>Division List for: {$active_tournament.NAME}: {$active_tournament.DATE_FROM|date_format:$date}{if $active_tournament.DATE_TO != $active_tournament.DATE_FROM} - {$active_tournament.DATE_TO|date_format:$date}{/if}</h1>

{if $user_access != "admin"} 
<p>
Note that this division list is subject to change at any time!
</p>
{/if}

{section name=division loop=$division_list}

<br>
<strong>{$division_list[division].SECTION_NAME} - {$division_list[division].EVENT} - {if $division_list[division].COMPETITOR_COUNT != 0}<a href="division_draw.php?DIVISION_ID={$division_list[division].DIVISION_ID}">{/if}{$division_list[division].DIVISION}</a> ({$division_list[division].COMPETITOR_COUNT})</strong>
 <table border="0" class="public_division" width="700px">
 <tr>
  {if ($division_list[division].TEAM)}
 		<th>
 			Team Name
 		</th>
 		<th>
 			Captain Name
 		</th>	
 		<th>
 			Represents
 		</th>	 			  
  {else}

 		<th>
 			First Name
 		</th>
 		<th>
 			Last Name
 		</th>
 		<th>
 			Gender
 		</th>
 		<th>
 			Rank
 		</th>  		
 		<th>
 			Represents
 		</th> 
 		{if $user_access == "admin" && $type != "BRIEF"} 
 		<th>
 			Age
 		</th>
 		<th>
 			Height
 		</th>
 		<th>
 			Weight
 		</th> 		 		 		
 		{/if}		
 
  {/if}
   </tr>
   
 	{section name=competitor loop=$competitor_list start=$competitor_division_starts[division] max=$competitor_division_count[division]}
	<tr>
	  {if ($division_list[division].TEAM)}

 		<td>		
 			{$competitor_list[competitor].FIRST_NAME}		
 		</td>
  		<td>		
 			{$competitor_list[competitor].CAPTAIN_NAME}		
 		</td>
   		<td>		
 			{$competitor_list[competitor].REPRESENTS}		
 		</td>				
	  {else}
 		
 		<td>		
 			{$competitor_list[competitor].FIRST_NAME}		
 		</td>
 		<td>
 			{$competitor_list[competitor].LAST_NAME}
 		</td>
  		<td>
 			{$competitor_list[competitor].GENDER}
 		</td> 
 		 <td>
 			{$competitor_list[competitor].RANK}
 		</td>		
  		<td>
 			{$competitor_list[competitor].REPRESENTS}
 		</td>
 		{if $user_access == "admin" && $type != "BRIEF"} 
  		<td align="center">
 			{$competitor_list[competitor].AGE}
 		</td>
 		<td align="center">
 			{$competitor_list[competitor].HEIGHT}
 		</td>
 		 <td align="center">
 			{$competitor_list[competitor].WEIGHT}
 		</td>
 		 		
 		{/if} 	
 		
 	 	{/if}			
 	  {/section}	 	
 	
		
 	</tr>
 </table>
{/section}

</div>

{/if}


{include file="footer.tpl"}
</body>
</div>