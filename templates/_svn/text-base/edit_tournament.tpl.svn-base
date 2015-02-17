{config_load file=test.conf section="setup"}
{include file="header.tpl"}

<div id="main_pane">



<div id="primary_{$level}">
<p>
{$primary}
</p>
</div>
<div id="command">
<p>
{$command}
</p>
</div>

{if $delete_success}

{else}
<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data" onSubmit="{literal}if (document.pressed == 'Delete') { return confirm('Are you sure you want to delete the tournament including all competitors, divisions, events, sections and results?');}{/literal}">
	
	<table border="1">
		<tr>
	        <td>ID</td>
	        <td>{$tournament.ID}<input type="hidden" name="ID" value="{$tournament.ID}"></td>
	    </tr>
	   <tr>
	        <td>Name</td>
	        <td><input type="text" name="Name" value="{$tournament.NAME}" size="40"></td>
	    </tr>
	    <tr>
	        <td>Location</td>
	        <td><input type="text" name="Location" value="{$tournament.LOCATION}" size="40"></td>
	    </tr>
	    <tr>
	        <td>Date From</td>
	        <td>{html_select_date prefix='From_' time=$tournament.DATE_FROM end_year='+1' field_order='DMY'}</td>
	    </tr>	    
	    <tr>
	        <td>Date To</td>
	        <td>{html_select_date prefix='To_' time=$tournament.DATE_TO end_year='+1' field_order='DMY'} </td>
	    </tr>
	    <tr>
	        <td>Due Date</td>
	        <td>{html_select_date prefix='DueDate_' time=$tournament.DUE_DATE end_year='+1' field_order='DMY'}</td>
	    </tr>	    
	    <tr>
	        <td>Allow Managers To Edit</td>
	        <td><input type="checkbox" name="Allow_Managers_To_Edit" {if $tournament.ALLOW_MANAGERS_TO_EDIT} checked {/if}></td>
	    </tr>	  
	    <tr>
	        <td>Make the Draws Public?</td>
	        <td><input type="checkbox" name="Draws_Public" {if $tournament.DRAWS_PUBLIC} checked {/if}></td>
	    </tr>		      
	    <tr>
	        <td>Active</td>
	        <td>{$tournament.ACTIVE}</td>
	    </tr>	    
	    <tr>
	        <td>Events</td>
	        <td>{html_options name=Events[] size=10 multiple=true options=$events_list selected=$events_selection}</td>
	    </tr>
	    <tr>
	        <td>Payment</td>
	        <td>{html_options name=Payment size=1 options=$payment_list selected=$payment_selection}</td>
  	    </tr>
 	    <tr>
	        <td>Schedule (html)</td>
	        <td><textarea cols="60" rows="10" name="Schedule_HTML">{$tournament.SCHEDULE_HTML}</textarea></td>
	    </tr> 	
 	    <tr>
	        <td>Participation Signature (html)</td>
	        <td><textarea cols="60" rows="10" name="Participation_Signature_HTML">{$tournament.PARTICIPATION_SIGNATURE_HTML}</textarea></td>
	    </tr> 		    
 	    <tr>
	        <td>Tournament Form (pdf)</td>
	        <td><input type="text" name="Tournament_Form_PDF" value="{$tournament.TOURNAMENT_FORM_PDF}" size="70"></td>
	    </tr> 	      
 	    <tr>
	        <td>Logo Image Name</td>
	        <td><input type="text" name="Logo_Name" value="{$tournament.LOGO_NAME}" size="40"></td>
	    </tr> 	 	      	    	    
	    <tr>
	        <td>Last Updated</td>
	        <td>{$tournament.LAST_UPDATED}</td>
	    </tr>	    	    	    
	    <tr>
	        <td colspan="2" align="center"><input type="submit" value="Submit" name="Submit" onClick="document.pressed=this.value">&nbsp;&nbsp;<input type="submit" value="Delete" name="Delete" onClick="document.pressed=this.value"></td>
	    </tr>

</form>
{/if}

{include file="footer.tpl"}

</body>

