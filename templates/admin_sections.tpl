{config_load file=test.conf section="setup"}
{include file="header.tpl"}

<div id="main_pane">
<h1>Section Management</h1>

<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data" onSubmit="return confirm('Are you sure you want to copy all the sections from the selected tournament?');">
{html_options name=Tournaments[] size=1 options=$tournaments_list}
<input type="submit" value="Copy sections from selected tournament" name="Copy_Sections">
</form>

 <table border="0">
  	<tr>
 		<th>		
 			ID		
 		</th>
 		<th>		
 			Name		
 		</th>
 		<th>
 			Date
 		</th>
 		<th>
 			Part
 		</th> 		
 	</tr>
 	{section name=section_list loop=$sections}
	<tr>
 		<td align="center">
 			{$sections[section_list].ID}		
 		</td>
 		<td>
 			{$sections[section_list].NAME}
 		</td>
 		<td  align="center">
 			{$sections[section_list].DATE|date_format:"%d %b, %Y"}
 		</td> 		
 		<td align="center">
 			{$sections[section_list].PART}
 		</td>	 			
 		<td>
			<a href="edit_sections.php?ID={$sections[section_list].ID}">edit</a>
 		</td> 	
 	</tr>

 	 {/section}
 	 <tr>
 	 <td></td>
 	 <td></td>
 	 <td></td>
 	 <td></td> 	 
 	 <td>	 
 	 <a href="edit_sections.php?ID=new">new</a>
 	 </td>
 	 </tr>
 </table>


{include file="footer.tpl"}
</body>
</div>

