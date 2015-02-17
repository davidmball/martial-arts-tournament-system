{config_load file=test.conf section="setup"}
{include file="header.tpl"}

<div id="main_pane">

<h1>Edit Team</h1>
{if $access_denied}
	Access Denied: {$access_denied}
{else}
	
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
	
	<div id="command">
	<p>
	{$command}
	</p>
	</div>
	
	
	
	{if $delete_success}
	
	{else}
	<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
		
		<table border="1">
			<tr>
		        <td>ID</td>
		        <td>{$team.ID}<input type="hidden" name="ID" value="{$team.ID}"></td>
		    </tr>	    
		   <tr>
		        <td>Team Name</td>
		        <td><input type="text" name="Team_Name" value="{$team.TEAM_NAME}" size="40"></td>
		    </tr>
		    <tr>
		        <td>Represents</td>
		        <td>{html_options name=Represents size=1 options=$represents_list selected=$represents_selection}</td>
	  	    </tr>  	    	    
		    <tr>
		        <td>Comments</td>
		        <td><textarea cols="50" rows="4" name="Comments">{$team.COMMENTS}</textarea></td>
		    </tr>
		    <tr>
		        <td>Team Member 1 (Captain)</td>
		        <td>{html_options name=Team_Competitor_id1 size=1 options=$competitors_select_list selected=$team.TEAM_COMPETITOR_ID1}</td>	    
		    </tr>
		    <tr>
		        <td>Team Member 2</td>
		        <td>{html_options name=Team_Competitor_id2 size=1 options=$competitors_select_list selected=$team.TEAM_COMPETITOR_ID2}</td>	    
		    </tr>
		    <tr>
		        <td>Team Member 3</td>
		        <td>{html_options name=Team_Competitor_id3 size=1 options=$competitors_select_list selected=$team.TEAM_COMPETITOR_ID3}</td>	    
		    </tr>
		    <tr>
		        <td>Team Member 4</td>
		        <td>{html_options name=Team_Competitor_id4 size=1 options=$competitors_select_list selected=$team.TEAM_COMPETITOR_ID4}</td>	    
		    </tr>
		    <tr>
		        <td>Team Member 5</td>
		        <td>{html_options name=Team_Competitor_id5 size=1 options=$competitors_select_list selected=$team.TEAM_COMPETITOR_ID5}</td>	    
		    </tr>
		    <tr>
		        <td>Team Member 6</td>
		        <td>{html_options name=Team_Competitor_id6 size=1 options=$competitors_select_list selected=$team.TEAM_COMPETITOR_ID6}</td>	    
		    </tr>	    	    	    	    	    
		    <tr>
		        <td>Events</br>(Hold down CTRL to </br>select multiple events.)</td>
		        <td>{html_options name=Events[] size=6 multiple=true options=$events_list selected=$events_selection}</td>
		    </tr>		    
		    <tr>
		        <td>Last Updated</td>
		        <td>{$team.LAST_UPDATED}</td>
		    </tr>	    	    	    
		    <tr>
		        <td colspan="2" align="center"><input type="submit" value="Submit" name="Submit">&nbsp;&nbsp;<input type="submit" value="Delete" name="Delete">&nbsp;&nbsp;or <a href="edit_team.php?ID=new">Add New Team</a></td>
		    </tr>
	
	</form>
	{/if}

{/if}

{include file="footer.tpl"}

</body>

