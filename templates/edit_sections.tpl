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
	        <td>{$section.ID}<input type="hidden" name="ID" value="{$section.ID}"></td>
	    </tr>
	    <tr>
	        <td>Name</td>
	        <td><input type="text" name="Name" value="{$section.NAME}" size="40"></td>
	    </tr>	    	
	    <tr>
	        <td>Date</td>
	        <td>{html_select_date prefix='Date_' time=$section.DATE end_year='+1' field_order='DMY'}</td>
	    </tr>	
	    <tr>
	        <td>Part (Needs to be unique and ordered)</td>
	        <td><input type="text" name="Part" value="{$section.PART}" size="5"></td>
	    </tr> 	        	      
	    <tr>
	        <td colspan="2" align="center"><input type="submit" value="Submit" name="Submit">&nbsp;&nbsp;<input type="submit" value="Delete" name="Delete"></td>
	    </tr>

</form>
{/if}

{include file="footer.tpl"}

</body>

