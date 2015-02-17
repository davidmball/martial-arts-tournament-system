<div id="content">

	<div id="header_pane">
		<table border="0" class="head" cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<td>
					<h1>Martial Arts Tournament System</h1>
					<div id="copyright">&#169; 2007-2015 David Ball and Ruth Schulz. Available from <a href=http://code.google.com/p/martial-arts-tournament-system/>google code</a> under the GNU GPL license. Page Generated: {$smarty.now|date_format:$date_time}</div>
				</td>
		
				<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
		
				<div id="menu_pane">
		
				<td class="head_menu">	
				
						 <a {if $current_menu == "Main"} style="background-color: #fff;" {/if} href="index.php">&nbsp;Main&nbsp;</a>
						|<a {if $current_menu == "Registration"} style="background-color: #fff;" {/if} href="registration.php">&nbsp;Registration&nbsp;</a>
						|<a {if $current_menu == "Divisions"} style="background-color: #fff;" {/if} href="divisions.php">&nbsp;Divisions&nbsp;</a>
						|<a {if $current_menu == "Results"} style="background-color: #fff;" {/if} href="results.php">&nbsp;Results&nbsp;</a>
						|<a {if $current_menu == "Contact"} style="background-color: #fff;" {/if} href="contact.php">&nbsp;Contact&nbsp;</a>
						|<a {if $current_menu == "Help"} style="background-color: #fff;" {/if} href="help.php">&nbsp;Help&nbsp;</a>
						{if $user_access == "admin"}
						 |<a {if $current_menu == "Admin"} style="background-color: #fff;" {/if} href="admin.php">&nbsp;Admin&nbsp;</a>
						{/if}

					</form>
				</td>
				</div>		
			</tr>
		</table>	

</div>
