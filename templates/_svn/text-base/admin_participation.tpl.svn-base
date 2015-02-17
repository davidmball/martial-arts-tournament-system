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

 	{section name=competitor_list loop=$competitors}



<ul class="page_break"  style="padding: 200px 0px 0px 0px;  text-align: center;">

<div style="font-size: 2.0em;">Certificate of Participation</div><br>
<img src="images/{$active_tournament.LOGO_NAME}" alt="Tournament Logo" width="170" height="170">
<br>
<br>
<br>
Congratulations to<br>
<br>
 <b style="font-size: 1.2em;">{$competitors[competitor_list].FIRST_NAME} {$competitors[competitor_list].LAST_NAME}</b>
 <br>
 <br>
on your participation in the {$active_tournament.NAME} tournament<br>
held at {$active_tournament.LOCATION}, Australia <br>
held on {$active_tournament.DATE_FROM|date_format}{if $active_tournament.DATE_TO != $active_tournament.DATE_FROM} - {$active_tournament.DATE_TO|date_format}{/if}
<br>
<br>
<br>
<br>
<br>
<br>
___________________________<br>
{$active_tournament.PARTICIPATION_SIGNATURE_HTML}
</ul>
 	 {/section}



</div>

{include file="footer.tpl"}

</body>