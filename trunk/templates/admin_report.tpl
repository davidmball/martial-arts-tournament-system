{literal}
<style type="text/css" media="print">
	#header_pane {
		display: none;
	}
	#main_pane {
 		top: 0px;
 	}
 	#login_pane {
 		display: none;
 	}
</style>
{/literal}

{config_load file=test.conf section="setup"}
{include file="header.tpl"}

<div id="main_pane">

<h1>{$REPORT}: {$active_tournament.NAME} {$active_tournament.DATE_FROM|date_format}{if $active_tournament.DATE_TO != $active_tournament.DATE_FROM} - {$active_tournament.DATE_TO|date_format}{/if} - {$SECTION}</h1>
  <table>
 	{section name=competitor_list loop=$competitors}
<tr>
	<td>{$competitors[competitor_list].TITLE}</td>
	<td>{$competitors[competitor_list].FIRST_NAME}</td>
	<td>{$competitors[competitor_list].LAST_NAME|upper}</td>
	<td>{$competitors[competitor_list].REPRESENTS}</td>
	<td>{section name=event loop=$active_tournament_events_name start=0 loop=9}
 			{if $competitors_events[competitor_list][event]}
		 		{$active_tournament_events_name[event]}&nbsp;&nbsp;
	 		{/if}	
		{/section}	</td>
</tr>
 	 {/section}
	 </table>
<br>
</div>

{include file="footer.tpl"}

</body>