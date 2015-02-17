{config_load file=test.conf section="setup"}
{include file="header.tpl"}

<div id="main_pane">
<h1>Represents Management</h1>
	
 <table border="0">
  	<tr>
 		<th>		
 			ID		
 		</th>
 		<th>
 			Represents
 		</th>
 		<th>
 			Usernames
 		</th>
 		<th>
 			Active
 		</th> 
 		<th>
 			Competitor Count
 		</th>				
 	</tr>
 	{section name=represent_list loop=$represents}
	<tr>
 		<td>
 			{$represents[represent_list].ID}		
 		</td>
 		<td>
 			{$represents[represent_list].REPRESENTS}
 		</td>
 		<td>
 			{$represents[represent_list].USERNAME}
 		</td>	
 		<td align="center">
 			{$represents[represent_list].ACTIVE}
 		</td>
 		<td align="center">
 			{$represents[represent_list].COMPETITOR_COUNT}
 		</td>	 			
 		{if $user_access == "admin"}
 		<td>
			<a href="edit_represents.php?ID={$represents[represent_list].ID}">edit</a>
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
 	 <td>
  	 {if $user_access == "admin"}	 
 	 <a href="edit_represents.php?ID=new">new</a>
 	 {/if}
 	 </td>
 	 </tr>
 </table>
	


{include file="footer.tpl"}
</body>
</div>