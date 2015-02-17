{config_load file=test.conf section="setup"}
{include file="header.tpl"}

<div id="main_pane">

<h1>Contact Us or Sign Up</h1>

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



<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
	
	<p>

	</p>
	<table border="0">
 
	    <tr>
	        <td>Your Email Address</td>
	        <td><input type="text" name="Email" value="" size="40"></td>
	    </tr>
	    <tr>
	        <td>First Name</td>
	        <td><input type="text" name="First_Name" value="" size="20"></td>
	    </tr>
	    <tr>
	        <td>Last Name</td>
	        <td><input type="text" name="Last_Name" value="" size="20"></td>
	    </tr>
	    <tr>
	        <td>Club/School/Country/Organisation (s)</td>
	        <td><input type="text" name="Represents" value="" size="50"></td>
	    </tr>	       	        	    	    
	    <tr>
	        <td>Subject</td>
	        <td><select name="Subject"><option value="General_Enquiry">General Enquiry</option>
	        			<option value="Sign_Up">Sign Up</option></select>
	    </tr>
		<tr>
	        <td>Message</td>
	        <td><textarea cols="50" rows="10" name="Body"></textarea></td>
	    </tr>
	    <tr>
	        <td>(Spam Test) Two + 7 =</td>
	        <td><input type="text" name="Spam_Test" value="" size="2"></td>
	    </tr> 
	   <tr>
	        <td colspan="2" align="center"><input type="submit" value="Submit" name="Submit"></td>
	    </tr>


	 
</form>


</div>
{include file="footer.tpl"}
</body>