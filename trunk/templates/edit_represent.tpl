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
	        <td>{$represent.ID}<input type="hidden" name="ID" value="{$represent.ID}"></td>
	    </tr>
	    <tr>
	        <td>Represents</td>
	        <td><input type="text" name="Represents" value="{$represent.REPRESENTS}" size="40"></td>
	    </tr>	    
	    <tr>
	        <td>Active (unused)</td>
	        <td><input type="checkbox" name="Active" value="Active" {if $represent.ACTIVE} checked {/if}></td>
	    </tr>  	    
	    <tr>
	        <td>Last Updated</td>
	        <td>{$represent.LAST_UPDATED}</td>
	    </tr>	    	    	    
	    <tr>
	        <td colspan="2" align="center"><input type="submit" value="Submit" name="Submit">&nbsp;&nbsp;<input type="submit" value="Delete" name="Delete"></td>
	    </tr>

</form>
{/if}

{include file="footer.tpl"}

</body>

