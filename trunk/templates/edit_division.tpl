{config_load file=test.conf section="setup"}
{include file="header.tpl"}

<div id="main_pane">


<div id="command">
<p>
{$command}
</p>
</div>

<div id="primary_{$level}">
<p>
{$primary}
</p>
</div>

<div id="error_string">
<p>
{section name=error_list loop=$error_string}
{$error_string[error_list]}</br>
{/section}
</p>
</div>

{if $delete_success}

{else}
<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
	
	<table border="1">
		<tr>
	        <td>ID</td>
	        <td>{$division.ID}<input type="hidden" name="ID" value="{$division.ID}"></td>
	    </tr>
	    <tr>
	        <td>Sequence</td>
	        <td><input type="text" name="Sequence" value="{$division.SEQUENCE}" size="5"></td>
	    </tr>
	    <tr>
	        <td>Name</td>
	        <td><input type="text" name="Name" value="{$division.NAME}" size="40"></td>
	    </tr>
   		<tr>
	        <td>Event Type</td>
	        <td>{html_options name=Event_ID[] size=10 options=$events_list selected=$division.EVENT_ID}</td>
	    </tr>
	     <tr>
	        <td>Draw Type</td>
	        <td><select name="Type"><option value="Repercharge" {if $division.TYPE == "Repercharge"} selected="selected"{/if}>Repercharge</option>
	        <option value="Elimination" {if $division.TYPE == "Elimination"} selected="selected"{/if}>Elimination</option>
	        <option value="Form_Individual" {if $division.TYPE == "Form_Individual"} selected="selected"{/if}>Form (Individual)</option>
	        <option value="Form_Team" {if $division.TYPE == "Form_Team"} selected="selected"{/if}>Form (Team)</option>
	        <option value="Round_Robin" {if $division.TYPE == "Round_Robin"} selected="selected"{/if}>Round Robin</option>	        
	        <option value="Generic" {if $division.TYPE == "Generic"} selected="selected"{/if}>Generic</option>
	        </select></td>
	    </tr>
   		<tr>
	        <td>Section</td>
	        <td>{html_options name=Section_ID[] size=10 options=$sections_list selected=$division.SECTION_ID}</td>
	    </tr>
	    <tr>
	        <td>Sparring</td>
	        <td></td>
	    </tr> 		    
	    <tr>
	        <td>Rounds</td>
	        <td><input type="text" name="Rounds" value="{$division.ROUNDS}" size="5"></td>
	    </tr> 	    
	    <tr>
	        <td>Round (mins)</td>
	        <td><input type="text" name="Round_Min" value="{$division.ROUND_MIN}" size="5"></td>
	    </tr>	  
	    <tr>
	        <td>Break (mins)</td>
	        <td><input type="text" name="Break_Min" value="{$division.BREAK_MIN}" size="5"></td>
	    </tr>
	     <tr>
	        <td>Minor Final</td>
	        <td><select name="Minor_Final">
	        <option value="3rd4th" {if $division.MINOR_FINAL == "3rd4th"} selected="selected"{/if}>3rd4th</option>
	        <option value="3rd3rd" {if $division.MINOR_FINAL == "3rd3rd"} selected="selected"{/if}>3rd3rd</option>
			<option value="1stonly" {if $division.MINOR_FINAL == "1stonly"} selected="selected"{/if}>1st only</option>
	        <option value="None" {if $division.MINOR_FINAL == "None"} selected="selected"{/if}>None</option></select></td>
	    </tr>		    	
	    <tr>
	        <td>Forms</td>
	        <td></td>
	    </tr>   
	    <tr>
	        <td>Technique 1</td>
	        <td><input type="text" name="Technique1" value="{$division.TECHNIQUE1}" size="40"></td>
	    </tr>
	    <tr>
	        <td>Technique 2</td>
	        <td><input type="text" name="Technique2" value="{$division.TECHNIQUE2}" size="40"></td>
	    </tr>
	    <tr>
	        <td>Technique 3</td>
	        <td><input type="text" name="Technique3" value="{$division.TECHNIQUE3}" size="40"></td>
	    </tr>
	    <tr>
	        <td>Technique 4</td>
	        <td><input type="text" name="Technique4" value="{$division.TECHNIQUE4}" size="40"></td>
	    </tr>
	    <tr>
	        <td>Technique 5</td>
	        <td><input type="text" name="Technique5" value="{$division.TECHNIQUE5}" size="40"></td>
	    </tr>	    	    	    	    	        	      
	    <tr>
	        <td colspan="2" align="center"><input type="submit" value="Submit" name="Submit">&nbsp;&nbsp;<input type="submit" value="Delete" name="Delete"></td>
	    </tr>

</form>
{/if}

{include file="footer.tpl"}

</body>

