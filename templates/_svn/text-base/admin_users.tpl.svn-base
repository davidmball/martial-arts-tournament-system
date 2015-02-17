{config_load file=test.conf section="setup"}
{include file="header.tpl"}

<div id="main_pane">
<h1>User Management</h1>

<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data" onSubmit="return confirm('Are you sure you want to copy all the represents from the selected tournament?');">
{html_options name=Tournaments[] size=1 options=$tournaments_list}
<input type="submit" value="Copy represents from selected tournament" name="Copy_Represents">
</form>

<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data" onSubmit="return confirm('Are you sure you want to send a check divisions email to all active users?');">
<input type="submit" value="Send a check divisions email to all active users" name="Check_Divisions">
</form>


  <table border="0">
  	<tr>
 		<th>		
 			Username		
 		</th>
 		<th>
 			First Name
 		</th>
 		<th>
 			Last Name
 		</th>
 		<th>
 			Represents
 		</th> 		
 		<th>
 			Access
 		</th>
 		<th>
 			Email
 		</th>
 		<th>
 			Active
 		</th> 
 	</tr>
 	{section name=user_list loop=$users}
	<tr>
 		<td>
 			{$users[user_list].USERNAME}		
 		</td>
 		<td>
 			{$users[user_list].FIRST_NAME|default:'&nbsp;'}
 		</td>
 		<td>
 			{$users[user_list].LAST_NAME}
 		</td>
 		<td>
 			{$users[user_list].REPRESENTS}
 		</td> 		
 		<td>
 			{$users[user_list].ACCESS}
 		</td>
  		<td>
 			{$users[user_list].EMAIL}
 		</td>		
 		<td>
 			{$users[user_list].ACTIVE}
 		</td> 		
			
 		{if $user_access == "admin"}
 		<td>
			<a href="edit_user.php?ID={$users[user_list].ID}">edit</a>
 		</td> 	
 		{/if}
 	</tr>

 	 {/section}
 	 <tr>
 	 <td></td>
 	 <td></td>
 	 <td></td>
 	 <td></td>
 	 <td></td>
 	 <td></td> 	 
  	 <td></td> 	 
 	 <td>
  	 {if $user_access == "admin"}	 
 	 <a href="edit_user.php?ID=new">new</a>
 	 {/if}
 	 </td>
 	 </tr>
 </table>


{include file="footer.tpl"}
</body>
</div>