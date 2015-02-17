{config_load file=test.conf section="setup"}
{include file="header.tpl"}

<div id="main_pane">


<div id="command">
<p>
{$command}
</p>
</div>

<div id="error_string">
<p>
{section name=error_list loop=$error_string}
{$error_string[error_list]}</br>
{/section}
</p>
</div>

<div id="primary_{$level}">
<p>
{$primary}
</p>
</div>



{if $delete_success}

{else}
<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
	
	
	<table border="0">
		<tr>
	        <td>ID</td>
	        <td>{$user.ID}<input type="hidden" name="ID" value="{$user.ID}"></td>
	    </tr>
		<tr>
	        <td>Username</td>
	        <td><input type="text" name="USERNAME" value="{$user.USERNAME}"></td>
	    </tr>
	   <tr>
	        <td>Title</td>
	        <td><input type="text" name="Title" value="{$user.TITLE}" size="10"></td>
	    </tr>	    
	   <tr>
	        <td>First Name</td>
	        <td><input type="text" name="First_Name" value="{$user.FIRST_NAME}" size="40"></td>
	    </tr>
	    <tr>
	        <td>Last Name</td>
	        <td><input type="text" name="Last_Name" value="{$user.LAST_NAME}" size="40"></td>
	    </tr>
	    <tr>
	        <td>Access</td>
	        <td><select name="Access"><option value="admin" {if $user.ACCESS == "admin"} selected="selected"{/if}>admin</option>
	        			<option value="manager" {if $user.ACCESS == "manager"} selected="selected"{/if}>manager</option>
	        			<option value="steward" {if $user.ACCESS == "steward"} selected="selected"{/if}>steward</option>
	        			</select>
	    </tr>
	    <tr>
	        <td>Represents</td>
	        <td>{html_options name=Represents[] size=10 multiple=true options=$represents_list selected=$represents_selection}</td>
    
	    </tr>	    
	    <tr>
	        <td>Email</td>
	        <td><input type="text" name="Email" value="{$user.EMAIL}" size="40"></td>
	    </tr>
	    <tr>
	        <td>Active</td>
	        <td><input type="checkbox" name="Active" value="Active" {if $user.ACTIVE} checked {/if}></td>
	    </tr>
	    	    
	    <tr>
	        <td>Last Updated</td>
	        <td>{$user.LAST_UPDATED}</td>
	    </tr>	    	    	    
	    <tr>
	        <td colspan="2" align="center"><input type="submit" value="Submit" name="Submit">&nbsp;&nbsp;<input type="submit" value="Delete" name="Delete"></td>
	    </tr>

</form>
{/if}

{include file="footer.tpl"}

</body>

