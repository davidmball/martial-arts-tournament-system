<?php /* Smarty version 2.6.20, created on 2012-06-07 21:57:23
         compiled from results.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'results.tpl', 15, false),array('function', 'html_options', 'results.tpl', 26, false),array('function', 'html_select_date', 'results.tpl', 43, false),array('modifier', 'date_format', 'results.tpl', 49, false),)), $this); ?>
<?php echo '
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
'; ?>


<?php echo smarty_function_config_load(array('file' => "test.conf"), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<div id="main_pane">

<?php if ($this->_tpl_vars['results_mode'] == 'Get'): ?>
 <form action="<?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>
" method="post" enctype="multipart/form-data">
 
	 <h1>Tournament Results</h1>
	 Select the desired tournament and click Get Tournament Results.<br><br>
	 <?php echo smarty_function_html_options(array('name' => 'Tournament','size' => 1,'options' => $this->_tpl_vars['tournament_select_list'],'selected' => $this->_tpl_vars['active_tournament']['ID']), $this);?>

	 <input type="submit" value="Get Tournament Results" name="Get_Tournament_Results">

	 <h1>Section Results</h1>
	 Select the desired section and click Get Section Results.<br><br>
	 <?php echo smarty_function_html_options(array('name' => 'Section','size' => 1,'options' => $this->_tpl_vars['section_select_list']), $this);?>

	 <input type="submit" value="Get Section Results" name="Get_Section_Results">
	 
	 <h1>Represents Results</h1>
	 Select the desired club/school/country and click Get Represents Results<br><br>
	 <?php echo smarty_function_html_options(array('name' => 'Represents','size' => 1,'options' => $this->_tpl_vars['represents_select_list']), $this);?>

	 <input type="submit" value="Get Represents Results" name="Get_Represents_Results">
	 	 
	 <h1>Competitor Results</h1>
	 Enter their first name, last name and date of birth and click Get Competitor Results.<br><br>
	 First Name <input type="text" name="First Name" value="" size="30"><br><br>
	 Last Name <input type="text" name="Last Name" value="" size="30"><br><br>
	 Date of Birth<?php echo smarty_function_html_select_date(array('prefix' => 'DOB_','start_year' => $this->_tpl_vars['DOB_start'],'end_year' => $this->_tpl_vars['DOB_end'],'field_order' => 'DMY'), $this);?>
<br><br>
	 <input type="submit" value="Get Competitor Results" name="Get_Competitor_Results">
	 
 </form>
<?php elseif ($this->_tpl_vars['results_mode'] == 'Tournament'): ?>

	<h1>Results for: <?php echo $this->_tpl_vars['tournament']['NAME']; ?>
: <?php echo ((is_array($_tmp=$this->_tpl_vars['tournament']['DATE_FROM'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['date']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['date'])); ?>
<?php if ($this->_tpl_vars['tournament']['DATE_TO'] != $this->_tpl_vars['tournament']['DATE_FROM']): ?> - <?php echo ((is_array($_tmp=$this->_tpl_vars['tournament']['DATE_TO'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['date']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['date'])); ?>
<?php endif; ?></h1>
<?php if ($this->_tpl_vars['section_name']): ?>
<h2><?php echo $this->_tpl_vars['section_name']; ?>
</h2>
<?php endif; ?>
	<p>
	
	</p>
	<strong>Overall Champions</strong><br>
	<?php unset($this->_sections['champ']);
$this->_sections['champ']['name'] = 'champ';
$this->_sections['champ']['loop'] = is_array($_loop=$this->_tpl_vars['champs_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['champ']['show'] = true;
$this->_sections['champ']['max'] = $this->_sections['champ']['loop'];
$this->_sections['champ']['step'] = 1;
$this->_sections['champ']['start'] = $this->_sections['champ']['step'] > 0 ? 0 : $this->_sections['champ']['loop']-1;
if ($this->_sections['champ']['show']) {
    $this->_sections['champ']['total'] = $this->_sections['champ']['loop'];
    if ($this->_sections['champ']['total'] == 0)
        $this->_sections['champ']['show'] = false;
} else
    $this->_sections['champ']['total'] = 0;
if ($this->_sections['champ']['show']):

            for ($this->_sections['champ']['index'] = $this->_sections['champ']['start'], $this->_sections['champ']['iteration'] = 1;
                 $this->_sections['champ']['iteration'] <= $this->_sections['champ']['total'];
                 $this->_sections['champ']['index'] += $this->_sections['champ']['step'], $this->_sections['champ']['iteration']++):
$this->_sections['champ']['rownum'] = $this->_sections['champ']['iteration'];
$this->_sections['champ']['index_prev'] = $this->_sections['champ']['index'] - $this->_sections['champ']['step'];
$this->_sections['champ']['index_next'] = $this->_sections['champ']['index'] + $this->_sections['champ']['step'];
$this->_sections['champ']['first']      = ($this->_sections['champ']['iteration'] == 1);
$this->_sections['champ']['last']       = ($this->_sections['champ']['iteration'] == $this->_sections['champ']['total']);
?>
		<?php echo $this->_tpl_vars['champs_list'][$this->_sections['champ']['index']]['PLACE']; ?>
 - <?php echo $this->_tpl_vars['champs_list'][$this->_sections['champ']['index']]['DESCRIPTION']; ?>
 : <?php echo $this->_tpl_vars['champs_list'][$this->_sections['champ']['index']]['NAME']; ?>
 (<?php echo $this->_tpl_vars['champs_list'][$this->_sections['champ']['index']]['REPRESENTS']; ?>
)<br>
	<?php endfor; endif; ?>
	
	<?php unset($this->_sections['division']);
$this->_sections['division']['name'] = 'division';
$this->_sections['division']['loop'] = is_array($_loop=$this->_tpl_vars['division_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['division']['show'] = true;
$this->_sections['division']['max'] = $this->_sections['division']['loop'];
$this->_sections['division']['step'] = 1;
$this->_sections['division']['start'] = $this->_sections['division']['step'] > 0 ? 0 : $this->_sections['division']['loop']-1;
if ($this->_sections['division']['show']) {
    $this->_sections['division']['total'] = $this->_sections['division']['loop'];
    if ($this->_sections['division']['total'] == 0)
        $this->_sections['division']['show'] = false;
} else
    $this->_sections['division']['total'] = 0;
if ($this->_sections['division']['show']):

            for ($this->_sections['division']['index'] = $this->_sections['division']['start'], $this->_sections['division']['iteration'] = 1;
                 $this->_sections['division']['iteration'] <= $this->_sections['division']['total'];
                 $this->_sections['division']['index'] += $this->_sections['division']['step'], $this->_sections['division']['iteration']++):
$this->_sections['division']['rownum'] = $this->_sections['division']['iteration'];
$this->_sections['division']['index_prev'] = $this->_sections['division']['index'] - $this->_sections['division']['step'];
$this->_sections['division']['index_next'] = $this->_sections['division']['index'] + $this->_sections['division']['step'];
$this->_sections['division']['first']      = ($this->_sections['division']['iteration'] == 1);
$this->_sections['division']['last']       = ($this->_sections['division']['iteration'] == $this->_sections['division']['total']);
?>
	<br>
	<strong><?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['SECTION_NAME']; ?>
 - <?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['EVENT']; ?>
 - <a href="division_draw.php?DIVISION_ID=<?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION_ID']; ?>
"><?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION']; ?>
</a> </strong>
	 <?php if ($this->_tpl_vars['competitor_division_count'][$this->_sections['division']['index']] == 0): ?>
	 	</br>No results yet.<br>
	 <?php else: ?>
	 <table border="1" class="public_division">
	  <tr>
	  		<th>
	  			Result
	  		</th>
	 		<th>
	 			Name
	 		</th>		
	 		<th>
	 			Represents
	 		</th> 		
			
	  </tr>
	 	<?php unset($this->_sections['competitor']);
$this->_sections['competitor']['name'] = 'competitor';
$this->_sections['competitor']['loop'] = is_array($_loop=$this->_tpl_vars['competitor_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['competitor']['start'] = (int)$this->_tpl_vars['competitor_division_starts'][$this->_sections['division']['index']];
$this->_sections['competitor']['max'] = (int)$this->_tpl_vars['competitor_division_count'][$this->_sections['division']['index']];
$this->_sections['competitor']['show'] = true;
if ($this->_sections['competitor']['max'] < 0)
    $this->_sections['competitor']['max'] = $this->_sections['competitor']['loop'];
$this->_sections['competitor']['step'] = 1;
if ($this->_sections['competitor']['start'] < 0)
    $this->_sections['competitor']['start'] = max($this->_sections['competitor']['step'] > 0 ? 0 : -1, $this->_sections['competitor']['loop'] + $this->_sections['competitor']['start']);
else
    $this->_sections['competitor']['start'] = min($this->_sections['competitor']['start'], $this->_sections['competitor']['step'] > 0 ? $this->_sections['competitor']['loop'] : $this->_sections['competitor']['loop']-1);
if ($this->_sections['competitor']['show']) {
    $this->_sections['competitor']['total'] = min(ceil(($this->_sections['competitor']['step'] > 0 ? $this->_sections['competitor']['loop'] - $this->_sections['competitor']['start'] : $this->_sections['competitor']['start']+1)/abs($this->_sections['competitor']['step'])), $this->_sections['competitor']['max']);
    if ($this->_sections['competitor']['total'] == 0)
        $this->_sections['competitor']['show'] = false;
} else
    $this->_sections['competitor']['total'] = 0;
if ($this->_sections['competitor']['show']):

            for ($this->_sections['competitor']['index'] = $this->_sections['competitor']['start'], $this->_sections['competitor']['iteration'] = 1;
                 $this->_sections['competitor']['iteration'] <= $this->_sections['competitor']['total'];
                 $this->_sections['competitor']['index'] += $this->_sections['competitor']['step'], $this->_sections['competitor']['iteration']++):
$this->_sections['competitor']['rownum'] = $this->_sections['competitor']['iteration'];
$this->_sections['competitor']['index_prev'] = $this->_sections['competitor']['index'] - $this->_sections['competitor']['step'];
$this->_sections['competitor']['index_next'] = $this->_sections['competitor']['index'] + $this->_sections['competitor']['step'];
$this->_sections['competitor']['first']      = ($this->_sections['competitor']['iteration'] == 1);
$this->_sections['competitor']['last']       = ($this->_sections['competitor']['iteration'] == $this->_sections['competitor']['total']);
?>
		<tr>
			<td>
				<?php echo $this->_tpl_vars['competitor_list'][$this->_sections['competitor']['index']]['RESULT']; ?>

			</td>
	 		<td>		
	 			<?php echo $this->_tpl_vars['competitor_list'][$this->_sections['competitor']['index']]['NAME']; ?>
		
	 		</td>	
	  		<td>
	 			<?php echo $this->_tpl_vars['competitor_list'][$this->_sections['competitor']['index']]['REPRESENTS']; ?>

	 		</td>
	 	<?php endfor; endif; ?>	 				
	 	</tr>
	 </table>
	 <?php endif; ?>
	<?php endfor; endif; ?>
	
<?php elseif ($this->_tpl_vars['results_mode'] == 'Represents' || $this->_tpl_vars['results_mode'] == 'Competitor'): ?>
	
	<?php if ($this->_tpl_vars['results_mode'] == 'Represents'): ?>
	<h1>Represents results for: <?php echo $this->_tpl_vars['represents_name']; ?>
</h1>
	<?php else: ?>
	<h1>Competitor results for: <?php echo $this->_tpl_vars['competitor_name']; ?>
</h1>	
	<?php endif; ?>
	<p>
	
	</p>
	
	<p>
	<?php if ($this->_tpl_vars['AT_LEAST_ONE_CHAMPS'] == 1): ?>
	<strong>Overall Champion Results</strong><br>
	<?php unset($this->_sections['champ']);
$this->_sections['champ']['name'] = 'champ';
$this->_sections['champ']['loop'] = is_array($_loop=$this->_tpl_vars['champs_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['champ']['show'] = true;
$this->_sections['champ']['max'] = $this->_sections['champ']['loop'];
$this->_sections['champ']['step'] = 1;
$this->_sections['champ']['start'] = $this->_sections['champ']['step'] > 0 ? 0 : $this->_sections['champ']['loop']-1;
if ($this->_sections['champ']['show']) {
    $this->_sections['champ']['total'] = $this->_sections['champ']['loop'];
    if ($this->_sections['champ']['total'] == 0)
        $this->_sections['champ']['show'] = false;
} else
    $this->_sections['champ']['total'] = 0;
if ($this->_sections['champ']['show']):

            for ($this->_sections['champ']['index'] = $this->_sections['champ']['start'], $this->_sections['champ']['iteration'] = 1;
                 $this->_sections['champ']['iteration'] <= $this->_sections['champ']['total'];
                 $this->_sections['champ']['index'] += $this->_sections['champ']['step'], $this->_sections['champ']['iteration']++):
$this->_sections['champ']['rownum'] = $this->_sections['champ']['iteration'];
$this->_sections['champ']['index_prev'] = $this->_sections['champ']['index'] - $this->_sections['champ']['step'];
$this->_sections['champ']['index_next'] = $this->_sections['champ']['index'] + $this->_sections['champ']['step'];
$this->_sections['champ']['first']      = ($this->_sections['champ']['iteration'] == 1);
$this->_sections['champ']['last']       = ($this->_sections['champ']['iteration'] == $this->_sections['champ']['total']);
?>
		<?php if ($this->_tpl_vars['champs_list'][$this->_sections['champ']['index']]['TOURNAMENT'] != "" && $this->_tpl_vars['champs_list'][$this->_sections['champ']['index']]['DESCRIPTION'] != ""): ?>
			<?php echo $this->_tpl_vars['champs_list'][$this->_sections['champ']['index']]['PLACE']; ?>
 - <?php echo $this->_tpl_vars['champs_list'][$this->_sections['champ']['index']]['DESCRIPTION']; ?>
 : <?php echo $this->_tpl_vars['champs_list'][$this->_sections['champ']['index']]['TOURNAMENT']; ?>
 (<?php if ($this->_tpl_vars['results_mode'] == 'Represents'): ?><?php echo $this->_tpl_vars['champs_list'][$this->_sections['champ']['index']]['NAME']; ?>
<?php else: ?><?php echo $this->_tpl_vars['champs_list'][$this->_sections['champ']['index']]['REPRESENTS']; ?>
<?php endif; ?>)<br>
		<?php endif; ?>
	<?php endfor; endif; ?>	
	</p>
	<?php endif; ?>
	<strong>Results</strong><br>
	
	<table border="1">
	  <tr>
	    <th>Tournament</th>
	    <th>Division</th>
	    <?php if ($this->_tpl_vars['results_mode'] == 'Represents'): ?>
	    <th>Name</th>
	    <?php else: ?>
 		<th>Represents</th>
	  	<?php endif; ?>
	  	<th>Result</th>		
	  </tr> 		 
	<?php unset($this->_sections['tournament']);
$this->_sections['tournament']['name'] = 'tournament';
$this->_sections['tournament']['loop'] = is_array($_loop=$this->_tpl_vars['tournament_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['tournament']['show'] = true;
$this->_sections['tournament']['max'] = $this->_sections['tournament']['loop'];
$this->_sections['tournament']['step'] = 1;
$this->_sections['tournament']['start'] = $this->_sections['tournament']['step'] > 0 ? 0 : $this->_sections['tournament']['loop']-1;
if ($this->_sections['tournament']['show']) {
    $this->_sections['tournament']['total'] = $this->_sections['tournament']['loop'];
    if ($this->_sections['tournament']['total'] == 0)
        $this->_sections['tournament']['show'] = false;
} else
    $this->_sections['tournament']['total'] = 0;
if ($this->_sections['tournament']['show']):

            for ($this->_sections['tournament']['index'] = $this->_sections['tournament']['start'], $this->_sections['tournament']['iteration'] = 1;
                 $this->_sections['tournament']['iteration'] <= $this->_sections['tournament']['total'];
                 $this->_sections['tournament']['index'] += $this->_sections['tournament']['step'], $this->_sections['tournament']['iteration']++):
$this->_sections['tournament']['rownum'] = $this->_sections['tournament']['iteration'];
$this->_sections['tournament']['index_prev'] = $this->_sections['tournament']['index'] - $this->_sections['tournament']['step'];
$this->_sections['tournament']['index_next'] = $this->_sections['tournament']['index'] + $this->_sections['tournament']['step'];
$this->_sections['tournament']['first']      = ($this->_sections['tournament']['iteration'] == 1);
$this->_sections['tournament']['last']       = ($this->_sections['tournament']['iteration'] == $this->_sections['tournament']['total']);
?>
		<?php unset($this->_sections['division']);
$this->_sections['division']['name'] = 'division';
$this->_sections['division']['loop'] = is_array($_loop=$this->_tpl_vars['division_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['division']['show'] = true;
$this->_sections['division']['max'] = $this->_sections['division']['loop'];
$this->_sections['division']['step'] = 1;
$this->_sections['division']['start'] = $this->_sections['division']['step'] > 0 ? 0 : $this->_sections['division']['loop']-1;
if ($this->_sections['division']['show']) {
    $this->_sections['division']['total'] = $this->_sections['division']['loop'];
    if ($this->_sections['division']['total'] == 0)
        $this->_sections['division']['show'] = false;
} else
    $this->_sections['division']['total'] = 0;
if ($this->_sections['division']['show']):

            for ($this->_sections['division']['index'] = $this->_sections['division']['start'], $this->_sections['division']['iteration'] = 1;
                 $this->_sections['division']['iteration'] <= $this->_sections['division']['total'];
                 $this->_sections['division']['index'] += $this->_sections['division']['step'], $this->_sections['division']['iteration']++):
$this->_sections['division']['rownum'] = $this->_sections['division']['iteration'];
$this->_sections['division']['index_prev'] = $this->_sections['division']['index'] - $this->_sections['division']['step'];
$this->_sections['division']['index_next'] = $this->_sections['division']['index'] + $this->_sections['division']['step'];
$this->_sections['division']['first']      = ($this->_sections['division']['iteration'] == 1);
$this->_sections['division']['last']       = ($this->_sections['division']['iteration'] == $this->_sections['division']['total']);
?>
			<?php if ($this->_tpl_vars['division_list'][$this->_sections['division']['index']]['TOURNAMENT_ID'] == $this->_tpl_vars['tournament_list'][$this->_sections['tournament']['index']]['ID']): ?>
			 	<?php if ($this->_tpl_vars['competitor_division_count'][$this->_sections['division']['index']] != 0): ?>	
				 	<?php unset($this->_sections['competitor']);
$this->_sections['competitor']['name'] = 'competitor';
$this->_sections['competitor']['loop'] = is_array($_loop=$this->_tpl_vars['competitor_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['competitor']['start'] = (int)$this->_tpl_vars['competitor_division_starts'][$this->_sections['division']['index']];
$this->_sections['competitor']['max'] = (int)$this->_tpl_vars['competitor_division_count'][$this->_sections['division']['index']];
$this->_sections['competitor']['show'] = true;
if ($this->_sections['competitor']['max'] < 0)
    $this->_sections['competitor']['max'] = $this->_sections['competitor']['loop'];
$this->_sections['competitor']['step'] = 1;
if ($this->_sections['competitor']['start'] < 0)
    $this->_sections['competitor']['start'] = max($this->_sections['competitor']['step'] > 0 ? 0 : -1, $this->_sections['competitor']['loop'] + $this->_sections['competitor']['start']);
else
    $this->_sections['competitor']['start'] = min($this->_sections['competitor']['start'], $this->_sections['competitor']['step'] > 0 ? $this->_sections['competitor']['loop'] : $this->_sections['competitor']['loop']-1);
if ($this->_sections['competitor']['show']) {
    $this->_sections['competitor']['total'] = min(ceil(($this->_sections['competitor']['step'] > 0 ? $this->_sections['competitor']['loop'] - $this->_sections['competitor']['start'] : $this->_sections['competitor']['start']+1)/abs($this->_sections['competitor']['step'])), $this->_sections['competitor']['max']);
    if ($this->_sections['competitor']['total'] == 0)
        $this->_sections['competitor']['show'] = false;
} else
    $this->_sections['competitor']['total'] = 0;
if ($this->_sections['competitor']['show']):

            for ($this->_sections['competitor']['index'] = $this->_sections['competitor']['start'], $this->_sections['competitor']['iteration'] = 1;
                 $this->_sections['competitor']['iteration'] <= $this->_sections['competitor']['total'];
                 $this->_sections['competitor']['index'] += $this->_sections['competitor']['step'], $this->_sections['competitor']['iteration']++):
$this->_sections['competitor']['rownum'] = $this->_sections['competitor']['iteration'];
$this->_sections['competitor']['index_prev'] = $this->_sections['competitor']['index'] - $this->_sections['competitor']['step'];
$this->_sections['competitor']['index_next'] = $this->_sections['competitor']['index'] + $this->_sections['competitor']['step'];
$this->_sections['competitor']['first']      = ($this->_sections['competitor']['iteration'] == 1);
$this->_sections['competitor']['last']       = ($this->_sections['competitor']['iteration'] == $this->_sections['competitor']['total']);
?>
					<tr>
						<td>
							<?php echo $this->_tpl_vars['tournament_list'][$this->_sections['tournament']['index']]['NAME']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['tournament_list'][$this->_sections['tournament']['index']]['DATE_FROM'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['date']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['date'])); ?>
)
						</td>
						<td>
							<?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['EVENT']; ?>
 - <a href="division_draw.php?DIVISION_ID=<?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION_ID']; ?>
"><?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION']; ?>
</a>
						</td>
				 		<td>		
				 			<?php if ($this->_tpl_vars['results_mode'] == 'Represents'): ?>
	 						<?php echo $this->_tpl_vars['competitor_list'][$this->_sections['competitor']['index']]['NAME']; ?>
	
	 						<?php else: ?>	
				 			<?php echo $this->_tpl_vars['competitor_list'][$this->_sections['competitor']['index']]['REPRESENTS']; ?>

				 			<?php endif; ?>		
				 		</td>
						<td align="center">
							<?php echo $this->_tpl_vars['competitor_list'][$this->_sections['competitor']['index']]['RESULT']; ?>

						</td>			 			
				 	<tr>
				 	<?php endfor; endif; ?>			 	
			 	
			 	<?php endif; ?>
		 	<?php endif; ?>
		 <?php endfor; endif; ?>
	<?php endfor; endif; ?>		
	</table>

<?php endif; ?>

</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</body>