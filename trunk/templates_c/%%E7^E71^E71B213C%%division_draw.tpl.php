<?php /* Smarty version 2.6.20, created on 2014-03-29 10:10:52
         compiled from division_draw.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'division_draw.tpl', 1, false),array('modifier', 'date_format', 'division_draw.tpl', 15, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => "test.conf"), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>




<?php if ($this->_tpl_vars['division']['TYPE'] == 'Form_Individual' || $this->_tpl_vars['division']['TYPE'] == 'Form_Team'): ?>
<div id="form_main_pane">

<!-- Do the Title Block -->
<div class="form_title_block">
<!-- Consider Tournament Name (although might be better in title box) -->
<img src="images/<?php echo $this->_tpl_vars['active_tournament']['LOGO_NAME']; ?>
" alt="Tournament Logo" width="90" height="90" align="left">
<?php echo $this->_tpl_vars['active_tournament']['NAME']; ?>
</br>
<?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_FROM'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<?php if ($this->_tpl_vars['active_tournament']['DATE_TO'] != $this->_tpl_vars['active_tournament']['DATE_FROM']): ?> - <?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_TO'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<?php endif; ?></br>
<?php echo $this->_tpl_vars['division']['NAME']; ?>
 (<?php echo $this->_tpl_vars['division']['NUM_COMPETITORS']; ?>
) <br>
Type: <?php echo $this->_tpl_vars['division']['TYPE']; ?>
<br>
</div>

<?php if ($this->_tpl_vars['user_access'] == 'admin' || $this->_tpl_vars['user_access'] == 'steward'): ?> 
<form action="<?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>
?DIVISION_ID=<?php echo $this->_tpl_vars['division']['ID']; ?>
" method="post" enctype="multipart/form-data">
<div ="draw_title_buttons"><input type="submit" value="Submit" name="Submit"></div>

<?php endif; ?>

	<table border="1" class="form">
	<tr>
	   <?php if ($this->_tpl_vars['division']['TYPE'] == 'Form_Individual'): ?>
 		<th>Name</th>	
 		<th>ID</th>
 	   <?php endif; ?>
 		<th>Represents</th>
 		<?php if ($this->_tpl_vars['num_techs'] >= 1): ?><th><?php echo $this->_tpl_vars['division']['TECHNIQUE1']; ?>
</th><?php endif; ?>
 		<?php if ($this->_tpl_vars['num_techs'] >= 2): ?><th><?php echo $this->_tpl_vars['division']['TECHNIQUE2']; ?>
</th><?php endif; ?>
  		<?php if ($this->_tpl_vars['num_techs'] >= 3): ?><th><?php echo $this->_tpl_vars['division']['TECHNIQUE3']; ?>
</th><?php endif; ?>
 		<?php if ($this->_tpl_vars['num_techs'] >= 4): ?><th><?php echo $this->_tpl_vars['division']['TECHNIQUE4']; ?>
</th><?php endif; ?>
 		<?php if ($this->_tpl_vars['num_techs'] >= 5): ?><th><?php echo $this->_tpl_vars['division']['TECHNIQUE5']; ?>
</th><?php endif; ?>
 		<th>Total Points</th>
 		<th>Extra Test (1)</th>
 		<th>Extra Test (2)</th>
 		<th>Final Points</th>
 		<th>Place</th>
	</tr>
	
	<?php unset($this->_sections['competitor_list']);
$this->_sections['competitor_list']['name'] = 'competitor_list';
$this->_sections['competitor_list']['loop'] = is_array($_loop=$this->_tpl_vars['competitors']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['competitor_list']['show'] = true;
$this->_sections['competitor_list']['max'] = $this->_sections['competitor_list']['loop'];
$this->_sections['competitor_list']['step'] = 1;
$this->_sections['competitor_list']['start'] = $this->_sections['competitor_list']['step'] > 0 ? 0 : $this->_sections['competitor_list']['loop']-1;
if ($this->_sections['competitor_list']['show']) {
    $this->_sections['competitor_list']['total'] = $this->_sections['competitor_list']['loop'];
    if ($this->_sections['competitor_list']['total'] == 0)
        $this->_sections['competitor_list']['show'] = false;
} else
    $this->_sections['competitor_list']['total'] = 0;
if ($this->_sections['competitor_list']['show']):

            for ($this->_sections['competitor_list']['index'] = $this->_sections['competitor_list']['start'], $this->_sections['competitor_list']['iteration'] = 1;
                 $this->_sections['competitor_list']['iteration'] <= $this->_sections['competitor_list']['total'];
                 $this->_sections['competitor_list']['index'] += $this->_sections['competitor_list']['step'], $this->_sections['competitor_list']['iteration']++):
$this->_sections['competitor_list']['rownum'] = $this->_sections['competitor_list']['iteration'];
$this->_sections['competitor_list']['index_prev'] = $this->_sections['competitor_list']['index'] - $this->_sections['competitor_list']['step'];
$this->_sections['competitor_list']['index_next'] = $this->_sections['competitor_list']['index'] + $this->_sections['competitor_list']['step'];
$this->_sections['competitor_list']['first']      = ($this->_sections['competitor_list']['iteration'] == 1);
$this->_sections['competitor_list']['last']       = ($this->_sections['competitor_list']['iteration'] == $this->_sections['competitor_list']['total']);
?>
	<tr>
   	   <?php if ($this->_tpl_vars['division']['TYPE'] == 'Form_Individual'): ?>
 		<td><?php if ($this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['ENROLMENT'] == 'Disqualified'): ?><strike><?php endif; ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['NAME']; ?>
<?php if ($this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['ENROLMENT'] == 'Disqualified'): ?></strike><?php endif; ?></td>
		<td><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['ID']; ?>
</td>
	   <?php endif; ?>
		<td><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['REPRESENTS']; ?>
</td>
	   <?php if ($this->_tpl_vars['user_access'] == 'admin' || $this->_tpl_vars['user_access'] == 'steward'): ?> 
 		<?php if ($this->_tpl_vars['num_techs'] >= 1): ?><td align="center"><input type="text" name="round<?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['ROUND_NUMBER']; ?>
Technique1" value="<?php if (( $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE1'] == 0 )): ?>&nbsp;<?php else: ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE1']; ?>
<?php endif; ?>" size=1></td><?php endif; ?>
 		<?php if ($this->_tpl_vars['num_techs'] >= 2): ?><td align="center"><input type="text" name="round<?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['ROUND_NUMBER']; ?>
Technique2" value="<?php if (( $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE2'] == 0 )): ?>&nbsp;<?php else: ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE2']; ?>
<?php endif; ?>" size=1></td><?php endif; ?>
 		<?php if ($this->_tpl_vars['num_techs'] >= 3): ?><td align="center"><input type="text" name="round<?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['ROUND_NUMBER']; ?>
Technique3" value="<?php if (( $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE3'] == 0 )): ?>&nbsp;<?php else: ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE3']; ?>
<?php endif; ?>" size=1></td><?php endif; ?>
 		<?php if ($this->_tpl_vars['num_techs'] >= 4): ?><td align="center"><input type="text" name="round<?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['ROUND_NUMBER']; ?>
Technique4" value="<?php if (( $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE4'] == 0 )): ?>&nbsp;<?php else: ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE4']; ?>
<?php endif; ?>" size=1></td><?php endif; ?>
 		<?php if ($this->_tpl_vars['num_techs'] >= 5): ?><td align="center"><input type="text" name="round<?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['ROUND_NUMBER']; ?>
Technique5" value="<?php if (( $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE5'] == 0 )): ?>&nbsp;<?php else: ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE5']; ?>
<?php endif; ?>" size=1></td><?php endif; ?>	   
	   <?php else: ?>
 		<?php if ($this->_tpl_vars['num_techs'] >= 1): ?><td align="center"><?php if (( $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE1'] == 0 )): ?>&nbsp;<?php else: ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE1']; ?>
<?php endif; ?></td><?php endif; ?>
 		<?php if ($this->_tpl_vars['num_techs'] >= 2): ?><td align="center"><?php if (( $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE2'] == 0 )): ?>&nbsp;<?php else: ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE2']; ?>
<?php endif; ?></td><?php endif; ?>
 		<?php if ($this->_tpl_vars['num_techs'] >= 3): ?><td align="center"><?php if (( $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE3'] == 0 )): ?>&nbsp;<?php else: ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE3']; ?>
<?php endif; ?></td><?php endif; ?>
 		<?php if ($this->_tpl_vars['num_techs'] >= 4): ?><td align="center"><?php if (( $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE4'] == 0 )): ?>&nbsp;<?php else: ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE4']; ?>
<?php endif; ?></td><?php endif; ?>
 		<?php if ($this->_tpl_vars['num_techs'] >= 5): ?><td align="center"><?php if (( $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE5'] == 0 )): ?>&nbsp;<?php else: ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TECHNIQUE5']; ?>
<?php endif; ?></td><?php endif; ?>
 	   <?php endif; ?> 		 		 			
		<td align="center"><?php if (( $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TOTAL_POINTS'] == 0 )): ?>&nbsp;<?php else: ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TOTAL_POINTS']; ?>
<?php endif; ?></td>
	   <?php if ($this->_tpl_vars['user_access'] == 'admin' || $this->_tpl_vars['user_access'] == 'steward'): ?> 		
		<td align="center"><input type="text" name="round<?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['ROUND_NUMBER']; ?>
Extra1" value="<?php if (( $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['EXTRA_TEST1_POINTS'] == 0 )): ?>&nbsp;<?php else: ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['EXTRA_TEST1_POINTS']; ?>
<?php endif; ?>" size=1></td>			
		<td align="center"><input type="text" name="round<?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['ROUND_NUMBER']; ?>
Extra2" value="<?php if (( $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['EXTRA_TEST2_POINTS'] == 0 )): ?>&nbsp;<?php else: ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['EXTRA_TEST2_POINTS']; ?>
<?php endif; ?>" size=1></td>
	   <?php else: ?>		
		<td align="center"><?php if (( $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['EXTRA_TEST1_POINTS'] == 0 )): ?>&nbsp;<?php else: ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['EXTRA_TEST1_POINTS']; ?>
<?php endif; ?></td>	
		<td align="center"><?php if (( $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['EXTRA_TEST2_POINTS'] == 0 )): ?>&nbsp;<?php else: ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['EXTRA_TEST2_POINTS']; ?>
<?php endif; ?></td>
 	   <?php endif; ?> 								
		<td align="center"><?php if (( $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['FINAL_POINTS'] == 0 )): ?>&nbsp;<?php else: ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['FINAL_POINTS']; ?>
<?php endif; ?></td>
	   <?php if ($this->_tpl_vars['user_access'] == 'admin' || $this->_tpl_vars['user_access'] == 'steward'): ?> 		
		<td align="center"><input type="text" name="round<?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['ROUND_NUMBER']; ?>
Place" value="<?php if (( $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['PLACE'] == 0 )): ?>&nbsp;<?php else: ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['PLACE']; ?>
<?php endif; ?>" size=1></td>
	   <?php else: ?>		
		<td align="center"><?php if (( $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['PLACE'] == 0 )): ?>&nbsp;<?php else: ?><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['PLACE']; ?>
<?php endif; ?></td>
 	   <?php endif; ?> 				
	</tr>
	<?php endfor; endif; ?>
	</table>

<?php if ($this->_tpl_vars['user_access'] == 'admin' || $this->_tpl_vars['user_access'] == 'steward'): ?> 
</br>
<div ="draw_title_buttons"><input type="submit" value="Submit" name="Submit"></div>
</form>	
<?php endif; ?>
		
</div> <!-- /form_main_pane -->

<?php elseif ($this->_tpl_vars['division']['TYPE'] == 'Round_Robin'): ?>



<div id="main_pane">

<?php if ($this->_tpl_vars['unable_to_draw']): ?>
	ERROR: Unable to draw this division as it is either too big or too small.
<?php elseif ($this->_tpl_vars['bad_division_id']): ?>
	ERROR: Bad division id on URI.
<?php else: ?>

<!-- Do the Title Block -->

<!-- Consider Tournament Name (although might be better in title box) -->
<img src="images/<?php echo $this->_tpl_vars['active_tournament']['LOGO_NAME']; ?>
" alt="Tournament Logo" width="90" height="90" align="left">
<?php echo $this->_tpl_vars['active_tournament']['NAME']; ?>
<br>
<?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_FROM'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<?php if ($this->_tpl_vars['active_tournament']['DATE_TO'] != $this->_tpl_vars['active_tournament']['DATE_FROM']): ?> - <?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_TO'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<?php endif; ?></br>
<?php echo $this->_tpl_vars['division']['NAME']; ?>
 (<?php echo $this->_tpl_vars['division']['NUM_COMPETITORS']; ?>
) <br>
Type: <?php echo $this->_tpl_vars['division']['TYPE']; ?>
<br>
Ring: <br><br>


<?php if ($this->_tpl_vars['user_access'] == 'admin' || $this->_tpl_vars['user_access'] == 'steward'): ?> 
<form action="<?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>
?DIVISION_ID=<?php echo $this->_tpl_vars['division']['ID']; ?>
" method="post" enctype="multipart/form-data">
<div ="draw_title_buttons"><input type="submit" value="Submit" name="Submit"></div>
<?php endif; ?>

<p></p>

<style type="text/css" media="screen">
	<?php echo $this->_tpl_vars['css_draw_styles']; ?>

</style>
<style type="text/css" media="print">
	<?php echo $this->_tpl_vars['css_draw_styles']; ?>

</style>
		
	<table border="1" class="form">
	<tr>
 		<th>Name</th>	
 		<th>ID</th>
 		<th>Place</th>
 		<th>Wins</th>
 		<th>Draws</th>
 		<th>Loses</th>
 		<th>Points</th>
 		<th>Score Diff</th>
	</tr>
		<?php unset($this->_sections['competitor_list']);
$this->_sections['competitor_list']['name'] = 'competitor_list';
$this->_sections['competitor_list']['loop'] = is_array($_loop=$this->_tpl_vars['competitors']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['competitor_list']['show'] = true;
$this->_sections['competitor_list']['max'] = $this->_sections['competitor_list']['loop'];
$this->_sections['competitor_list']['step'] = 1;
$this->_sections['competitor_list']['start'] = $this->_sections['competitor_list']['step'] > 0 ? 0 : $this->_sections['competitor_list']['loop']-1;
if ($this->_sections['competitor_list']['show']) {
    $this->_sections['competitor_list']['total'] = $this->_sections['competitor_list']['loop'];
    if ($this->_sections['competitor_list']['total'] == 0)
        $this->_sections['competitor_list']['show'] = false;
} else
    $this->_sections['competitor_list']['total'] = 0;
if ($this->_sections['competitor_list']['show']):

            for ($this->_sections['competitor_list']['index'] = $this->_sections['competitor_list']['start'], $this->_sections['competitor_list']['iteration'] = 1;
                 $this->_sections['competitor_list']['iteration'] <= $this->_sections['competitor_list']['total'];
                 $this->_sections['competitor_list']['index'] += $this->_sections['competitor_list']['step'], $this->_sections['competitor_list']['iteration']++):
$this->_sections['competitor_list']['rownum'] = $this->_sections['competitor_list']['iteration'];
$this->_sections['competitor_list']['index_prev'] = $this->_sections['competitor_list']['index'] - $this->_sections['competitor_list']['step'];
$this->_sections['competitor_list']['index_next'] = $this->_sections['competitor_list']['index'] + $this->_sections['competitor_list']['step'];
$this->_sections['competitor_list']['first']      = ($this->_sections['competitor_list']['iteration'] == 1);
$this->_sections['competitor_list']['last']       = ($this->_sections['competitor_list']['iteration'] == $this->_sections['competitor_list']['total']);
?>
		<tr>
		<td><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['NAME']; ?>
</td>
		<td><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['ID']; ?>
</td>
	   <?php if ($this->_tpl_vars['user_access'] == 'admin' || $this->_tpl_vars['user_access'] == 'steward'): ?> 		
		 <td align="center"><input type="text" name="competitor_<?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['ROUND']; ?>
Place" value="<?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['PLACE']; ?>
" size=1></td>
	   <?php else: ?>		
		 <td align="center"><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['PLACE']; ?>
</td>
	  <?php endif; ?> 		
		<td><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['WINS']; ?>
</td>
		<td><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['DRAWS']; ?>
</td>
		<td><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['LOSES']; ?>
</td>
		<td><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['POINTS']; ?>
</td>
		<td><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['DIFF']; ?>
</td>		
		</tr>
		<?php endfor; endif; ?>
	</table>
	<p></p>
	<p>Note that first and second in points fight each other in a final which determines placings.</p>
	<p></p>
	<table border="1" class="form">

		<?php unset($this->_sections['round_list']);
$this->_sections['round_list']['name'] = 'round_list';
$this->_sections['round_list']['loop'] = is_array($_loop=$this->_tpl_vars['rounds']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['round_list']['show'] = true;
$this->_sections['round_list']['max'] = $this->_sections['round_list']['loop'];
$this->_sections['round_list']['step'] = 1;
$this->_sections['round_list']['start'] = $this->_sections['round_list']['step'] > 0 ? 0 : $this->_sections['round_list']['loop']-1;
if ($this->_sections['round_list']['show']) {
    $this->_sections['round_list']['total'] = $this->_sections['round_list']['loop'];
    if ($this->_sections['round_list']['total'] == 0)
        $this->_sections['round_list']['show'] = false;
} else
    $this->_sections['round_list']['total'] = 0;
if ($this->_sections['round_list']['show']):

            for ($this->_sections['round_list']['index'] = $this->_sections['round_list']['start'], $this->_sections['round_list']['iteration'] = 1;
                 $this->_sections['round_list']['iteration'] <= $this->_sections['round_list']['total'];
                 $this->_sections['round_list']['index'] += $this->_sections['round_list']['step'], $this->_sections['round_list']['iteration']++):
$this->_sections['round_list']['rownum'] = $this->_sections['round_list']['iteration'];
$this->_sections['round_list']['index_prev'] = $this->_sections['round_list']['index'] - $this->_sections['round_list']['step'];
$this->_sections['round_list']['index_next'] = $this->_sections['round_list']['index'] + $this->_sections['round_list']['step'];
$this->_sections['round_list']['first']      = ($this->_sections['round_list']['iteration'] == 1);
$this->_sections['round_list']['last']       = ($this->_sections['round_list']['iteration'] == $this->_sections['round_list']['total']);
?>
		

		
	    	<tr>
				<td><?php echo $this->_tpl_vars['rounds'][$this->_sections['round_list']['index']]['ROUND_NUMBER']; ?>
</td>
				<td><?php echo $this->_tpl_vars['rounds'][$this->_sections['round_list']['index']]['NAME_LEFT']; ?>
</td>
				   <?php if ($this->_tpl_vars['user_access'] == 'admin' || $this->_tpl_vars['user_access'] == 'steward'): ?> 		
					 <td align="center"><input type="text" name="round_<?php echo $this->_tpl_vars['rounds'][$this->_sections['round_list']['index']]['ROUND_NUMBER']; ?>
_Score_Left" value="<?php echo $this->_tpl_vars['rounds'][$this->_sections['round_list']['index']]['SCORE_LEFT']; ?>
" size=1></td>
				   <?php else: ?>		
					 <td align="center"><?php echo $this->_tpl_vars['rounds'][$this->_sections['round_list']['index']]['SCORE_LEFT']; ?>
</td>
				  <?php endif; ?> 					
				<td><?php echo $this->_tpl_vars['rounds'][$this->_sections['round_list']['index']]['NAME_RIGHT']; ?>
</td>
				   <?php if ($this->_tpl_vars['user_access'] == 'admin' || $this->_tpl_vars['user_access'] == 'steward'): ?> 		
					 <td align="center"><input type="text" name="round_<?php echo $this->_tpl_vars['rounds'][$this->_sections['round_list']['index']]['ROUND_NUMBER']; ?>
_Score_Right" value="<?php echo $this->_tpl_vars['rounds'][$this->_sections['round_list']['index']]['SCORE_RIGHT']; ?>
" size=1></td>
				   <?php else: ?>		
					 <td align="center"><?php echo $this->_tpl_vars['rounds'][$this->_sections['round_list']['index']]['SCORE_RIGHT']; ?>
</td>
				  <?php endif; ?> 					
			</tr>
			

			
		<?php endfor; endif; ?>		

	</table>			

<?php if ($this->_tpl_vars['user_access'] == 'admin' || $this->_tpl_vars['user_access'] == 'steward'): ?> 
</br>
<div ="draw_title_buttons"><input type="submit" value="Submit" name="Submit"></div>
</form>	
<?php endif; ?>
		
</div>

<?php endif; ?>


		
<?php else: ?>

<div id="division_main_pane">

<?php if ($this->_tpl_vars['unable_to_draw']): ?>
	<?php echo $this->_tpl_vars['division']['NAME']; ?>
 (<?php echo $this->_tpl_vars['division']['NUM_COMPETITORS']; ?>
)<br>
	ERROR: Unable to draw this division as it is either too big or too small.
<?php elseif ($this->_tpl_vars['bad_division_id']): ?>
	ERROR: Bad division id on URI.
<?php else: ?>

<style type="text/css" media="screen">
	<?php echo $this->_tpl_vars['css_draw_styles']; ?>

</style>
<style type="text/css" media="print">
	<?php echo $this->_tpl_vars['css_draw_styles']; ?>

</style>

<form action="<?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>
?DIVISION_ID=<?php echo $this->_tpl_vars['division']['ID']; ?>
" method="post" enctype="multipart/form-data" >

<!-- Do the Title Block -->
<div class="draw_title_block">
<!-- Consider Tournament Name (although might be better in title box) -->
<img src="images/<?php echo $this->_tpl_vars['active_tournament']['LOGO_NAME']; ?>
" alt="Tournament Logo" width="110" height="110" align="left" style="padding-bottom:100px;">
<?php echo $this->_tpl_vars['active_tournament']['NAME']; ?>
 - <?php echo $this->_tpl_vars['division']['SECTION_NAME']; ?>
</br>
<?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_FROM'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<?php if ($this->_tpl_vars['active_tournament']['DATE_TO'] != $this->_tpl_vars['active_tournament']['DATE_FROM']): ?> - <?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_TO'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<?php endif; ?></br>
<?php echo $this->_tpl_vars['division']['NAME']; ?>
 (<?php echo $this->_tpl_vars['division']['NUM_COMPETITORS']; ?>
) <br>
Event: <?php echo $this->_tpl_vars['division']['EVENT_NAME']; ?>
 - <?php echo $this->_tpl_vars['division']['TYPE']; ?>
<br>
<?php if ($this->_tpl_vars['division']['EVENT_NAME'] == 'Sparring' || $this->_tpl_vars['division']['EVENT_NAME'] == 'Team Sparring'): ?>
	Format: <?php echo $this->_tpl_vars['division']['ROUNDS']; ?>
 x <?php echo $this->_tpl_vars['division']['ROUND_MIN']; ?>
 min <?php if ($this->_tpl_vars['division']['BREAK_MIN'] != 0): ?>+ <?php echo $this->_tpl_vars['division']['BREAK_MIN']; ?>
 min break<?php endif; ?><br>
<?php endif; ?>
Ring: <br>
<?php if ($this->_tpl_vars['user_access'] == 'admin' || $this->_tpl_vars['user_access'] == 'steward'): ?>
<div class="draw_title_buttons"><input type="submit" value="Submit" name="Submit">&nbsp;&nbsp;<input type="submit" value="Clear" name="Clear"></div>
<a href="edit_division.php?ID=<?php echo $this->_tpl_vars['division']['ID']; ?>
">Edit</a>
<?php endif; ?>
</div>



<?php unset($this->_sections['round']);
$this->_sections['round']['name'] = 'round';
$this->_sections['round']['loop'] = is_array($_loop=$this->_tpl_vars['round_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['round']['start'] = (int)-1;
$this->_sections['round']['step'] = ((int)-1) == 0 ? 1 : (int)-1;
$this->_sections['round']['show'] = true;
$this->_sections['round']['max'] = $this->_sections['round']['loop'];
if ($this->_sections['round']['start'] < 0)
    $this->_sections['round']['start'] = max($this->_sections['round']['step'] > 0 ? 0 : -1, $this->_sections['round']['loop'] + $this->_sections['round']['start']);
else
    $this->_sections['round']['start'] = min($this->_sections['round']['start'], $this->_sections['round']['step'] > 0 ? $this->_sections['round']['loop'] : $this->_sections['round']['loop']-1);
if ($this->_sections['round']['show']) {
    $this->_sections['round']['total'] = min(ceil(($this->_sections['round']['step'] > 0 ? $this->_sections['round']['loop'] - $this->_sections['round']['start'] : $this->_sections['round']['start']+1)/abs($this->_sections['round']['step'])), $this->_sections['round']['max']);
    if ($this->_sections['round']['total'] == 0)
        $this->_sections['round']['show'] = false;
} else
    $this->_sections['round']['total'] = 0;
if ($this->_sections['round']['show']):

            for ($this->_sections['round']['index'] = $this->_sections['round']['start'], $this->_sections['round']['iteration'] = 1;
                 $this->_sections['round']['iteration'] <= $this->_sections['round']['total'];
                 $this->_sections['round']['index'] += $this->_sections['round']['step'], $this->_sections['round']['iteration']++):
$this->_sections['round']['rownum'] = $this->_sections['round']['iteration'];
$this->_sections['round']['index_prev'] = $this->_sections['round']['index'] - $this->_sections['round']['step'];
$this->_sections['round']['index_next'] = $this->_sections['round']['index'] + $this->_sections['round']['step'];
$this->_sections['round']['first']      = ($this->_sections['round']['iteration'] == 1);
$this->_sections['round']['last']       = ($this->_sections['round']['iteration'] == $this->_sections['round']['total']);
?>
<div class="<?php echo $this->_tpl_vars['round_list'][$this->_sections['round']['index']]['STYLE_NAME']; ?>
">
<?php if ($this->_tpl_vars['round_list'][$this->_sections['round']['index']]['COLOUR_WIN'] == 'Y'): ?> 
<table class="round">

<TR><td class="division_bye_round_number"><?php echo $this->_tpl_vars['round_list'][$this->_sections['round']['index']]['ROUND_NUMBER']; ?>
</td>
<TD style="text-align: center; border-width: 0px;  padding-top: 4px; background-color:#f30">
R</TD><TD style=" border-width: 0px; padding-top: 4px;">  
<input  <?php if ($this->_tpl_vars['round_list'][$this->_sections['round']['index']]['RED_ID'] < 0): ?> style="color:#aaa; text-align:right;"<?php endif; ?> type="text" readonly value="<?php echo $this->_tpl_vars['round_list'][$this->_sections['round']['index']]['RED_NAME']; ?>
" size="18"><?php if ($this->_tpl_vars['user_access'] == 'admin' || $this->_tpl_vars['user_access'] == 'steward'): ?><input type="radio" NAME="<?php echo $this->_tpl_vars['round_list'][$this->_sections['round']['index']]['ROUND_NUMBER']; ?>
" VALUE="Y" checked><?php else: ?>*<?php endif; ?>

</TD></TR>
</table>
<?php else: ?>


<table <?php if ($this->_tpl_vars['round_list'][$this->_sections['round']['index']]['ROUND_NUMBER'] == 2 && $this->_tpl_vars['division']['MINOR_FINAL'] == '3rd3rd'): ?> class="round_3rd3rd" <?php else: ?> class="round"<?php endif; ?>>
	<TR><td rowspan="3" style="text-align: left; border-width: 0px; width: 20px"><?php echo $this->_tpl_vars['round_list'][$this->_sections['round']['index']]['ROUND_NUMBER']; ?>
</td>
	<TD style="text-align: center; border-width: 0px; vertical-align: top; padding-top: 4px; background-color:#f30">R</TD>
	<TD style=" border-width: 0px; vertical-align: top; padding-top: 4px;">  
	<input  <?php if ($this->_tpl_vars['round_list'][$this->_sections['round']['index']]['RED_ID'] < 0): ?> style="color:#aaa; text-align:right;"<?php endif; ?> type="text" readonly value="<?php echo $this->_tpl_vars['round_list'][$this->_sections['round']['index']]['RED_NAME']; ?>
" size="18"><?php if ($this->_tpl_vars['user_access'] == 'admin' || $this->_tpl_vars['user_access'] == 'steward'): ?><input type="radio" NAME="<?php echo $this->_tpl_vars['round_list'][$this->_sections['round']['index']]['ROUND_NUMBER']; ?>
" VALUE="R" <?php if ($this->_tpl_vars['round_list'][$this->_sections['round']['index']]['COLOUR_WIN'] == 'R'): ?> checked<?php endif; ?>><?php elseif ($this->_tpl_vars['round_list'][$this->_sections['round']['index']]['COLOUR_WIN'] == 'R'): ?>*<?php endif; ?>
	</TD></TR><TR><td></td><td></td><td><!-- hr size=4 width=15 color=black style="float: left; position: absolute; left: 200px;" --></td></TR><TR>
	<TD style="text-align: center; border-width: 0px; vertical-align: bottom; padding-bottom: 4px; background-color:#0bf">B</td>
	<td style="border-width: 0px; vertical-align: bottom; padding-bottom: 4px;">
	<input  <?php if ($this->_tpl_vars['round_list'][$this->_sections['round']['index']]['BLUE_ID'] < 0): ?> style="color:#aaa; text-align:right;"<?php endif; ?> type="text" readonly value="<?php echo $this->_tpl_vars['round_list'][$this->_sections['round']['index']]['BLUE_NAME']; ?>
" size="18"><?php if ($this->_tpl_vars['user_access'] == 'admin' || $this->_tpl_vars['user_access'] == 'steward'): ?><input type="radio" NAME="<?php echo $this->_tpl_vars['round_list'][$this->_sections['round']['index']]['ROUND_NUMBER']; ?>
" VALUE="B" <?php if ($this->_tpl_vars['round_list'][$this->_sections['round']['index']]['COLOUR_WIN'] == 'B'): ?> checked<?php endif; ?>><?php elseif ($this->_tpl_vars['round_list'][$this->_sections['round']['index']]['COLOUR_WIN'] == 'B'): ?>*<?php endif; ?>
	</TD></TR>
</table>

<?php endif; ?>
</div>
<?php endfor; endif; ?>


<!-- Do the Results Part -->
<div class="draw_results">

<table style="background-color: #ccc; width: 100%; border-collapse: collapse; height: 100%; border-width: 0px;">
<tr><td>1st</td><td><input type="text" readonly value="<?php echo $this->_tpl_vars['FIRST']; ?>
" size="20"></td></tr>
<tr><td>2nd</td><td><input type="text" readonly value="<?php echo $this->_tpl_vars['SECOND']; ?>
" size="20"></td></tr>
<?php if ($this->_tpl_vars['competitors_in_draw'] != 2): ?>
	<?php if ($this->_tpl_vars['division']['MINOR_FINAL'] == '3rd4th'): ?>
	<tr><td>3rd</td><td><input type="text" readonly value="<?php echo $this->_tpl_vars['THIRD']; ?>
" size="20"></td></tr>
	<tr><td>4th</td><td><input type="text" readonly value="<?php echo $this->_tpl_vars['FOURTH']; ?>
" size="20"></td></tr>
	<?php elseif ($this->_tpl_vars['division']['MINOR_FINAL'] == '3rd3rd'): ?>
		<?php if ($this->_tpl_vars['division']['TYPE'] == 'Elimination'): ?>
			<tr><td>3rd</td><td><input <?php if ($this->_tpl_vars['THIRD'] == '4'): ?> style="color:#aaa; text-align:right;"<?php endif; ?> type="text" readonly value="<?php if ($this->_tpl_vars['THIRD'] == '4'): ?>Loser from <?php endif; ?><?php echo $this->_tpl_vars['THIRD']; ?>
" size="20"></td></tr>
			<tr><td>3rd</td><td><input <?php if ($this->_tpl_vars['FOURTH'] == '3'): ?> style="color:#aaa; text-align:right;"<?php endif; ?> type="text" readonly value="<?php if ($this->_tpl_vars['FOURTH'] == '3'): ?>Loser from <?php endif; ?><?php echo $this->_tpl_vars['FOURTH']; ?>
" size="20"></td></tr>
		<?php else: ?>
			<tr><td>3rd</td><td><input <?php if ($this->_tpl_vars['THIRD'] == '4'): ?> style="color:#aaa; text-align:right;"<?php endif; ?> type="text" readonly value="<?php if ($this->_tpl_vars['THIRD'] == '4'): ?>Loser from L2<?php else: ?><?php echo $this->_tpl_vars['THIRD']; ?>
<?php endif; ?>" size="20"></td></tr>
			<tr><td>3rd</td><td><input <?php if ($this->_tpl_vars['FOURTH'] == '3'): ?> style="color:#aaa; text-align:right;"<?php endif; ?> type="text" readonly value="<?php if ($this->_tpl_vars['FOURTH'] == '3'): ?>Loser from L1<?php else: ?><?php echo $this->_tpl_vars['FOURTH']; ?>
<?php endif; ?>" size="20"></td></tr>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
</table>
<tr><td></td><td></td></tr>
<tr><td></td><td></td></tr>
</div>


<?php unset($this->_sections['round']);
$this->_sections['round']['name'] = 'round';
$this->_sections['round']['loop'] = is_array($_loop=$this->_tpl_vars['loser_round_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['round']['start'] = (int)-1;
$this->_sections['round']['step'] = ((int)-1) == 0 ? 1 : (int)-1;
$this->_sections['round']['show'] = true;
$this->_sections['round']['max'] = $this->_sections['round']['loop'];
if ($this->_sections['round']['start'] < 0)
    $this->_sections['round']['start'] = max($this->_sections['round']['step'] > 0 ? 0 : -1, $this->_sections['round']['loop'] + $this->_sections['round']['start']);
else
    $this->_sections['round']['start'] = min($this->_sections['round']['start'], $this->_sections['round']['step'] > 0 ? $this->_sections['round']['loop'] : $this->_sections['round']['loop']-1);
if ($this->_sections['round']['show']) {
    $this->_sections['round']['total'] = min(ceil(($this->_sections['round']['step'] > 0 ? $this->_sections['round']['loop'] - $this->_sections['round']['start'] : $this->_sections['round']['start']+1)/abs($this->_sections['round']['step'])), $this->_sections['round']['max']);
    if ($this->_sections['round']['total'] == 0)
        $this->_sections['round']['show'] = false;
} else
    $this->_sections['round']['total'] = 0;
if ($this->_sections['round']['show']):

            for ($this->_sections['round']['index'] = $this->_sections['round']['start'], $this->_sections['round']['iteration'] = 1;
                 $this->_sections['round']['iteration'] <= $this->_sections['round']['total'];
                 $this->_sections['round']['index'] += $this->_sections['round']['step'], $this->_sections['round']['iteration']++):
$this->_sections['round']['rownum'] = $this->_sections['round']['iteration'];
$this->_sections['round']['index_prev'] = $this->_sections['round']['index'] - $this->_sections['round']['step'];
$this->_sections['round']['index_next'] = $this->_sections['round']['index'] + $this->_sections['round']['step'];
$this->_sections['round']['first']      = ($this->_sections['round']['iteration'] == 1);
$this->_sections['round']['last']       = ($this->_sections['round']['iteration'] == $this->_sections['round']['total']);
?>
<div class="<?php echo $this->_tpl_vars['loser_round_list'][$this->_sections['round']['index']]['STYLE_NAME']; ?>
">
<?php if ($this->_tpl_vars['loser_round_list'][$this->_sections['round']['index']]['COLOUR_WIN'] == 'Y'): ?> 
<table class="round">

<TR><td class="division_bye_round_number"><?php echo $this->_tpl_vars['loser_round_list'][$this->_sections['round']['index']]['ROUND_NUMBER_DISPLAY']; ?>
</td>
<TD style="text-align: center; border-width: 0px;  padding-top: 4px; background-color:#f30">
R</TD><TD style=" border-width: 0px; padding-top: 4px;">  
<input <?php if ($this->_tpl_vars['loser_round_list'][$this->_sections['round']['index']]['RED_ID'] < 0): ?> style="color:#aaa; text-align:right;"<?php endif; ?> type="text" readonly value="<?php echo $this->_tpl_vars['loser_round_list'][$this->_sections['round']['index']]['RED_NAME']; ?>
" size="18"><?php if ($this->_tpl_vars['user_access'] == 'admin' || $this->_tpl_vars['user_access'] == 'steward'): ?><input type="radio" NAME="<?php echo $this->_tpl_vars['loser_round_list'][$this->_sections['round']['index']]['ROUND_NUMBER']; ?>
" VALUE="Y" checked><?php else: ?>*<?php endif; ?>

</TD></TR>
</table>
<?php else: ?>
<table class="round">

<TR><td rowspan="3" style="text-align: left; border-width: 0px; width: 20px;"><?php echo $this->_tpl_vars['loser_round_list'][$this->_sections['round']['index']]['ROUND_NUMBER_DISPLAY']; ?>
</td>
<TD style="text-align: center; border-width: 0px; vertical-align: top; padding-top: 4px; background-color:#f30">
R</TD><TD style=" border-width: 0px; vertical-align: top; padding-top: 4px;">  
<input <?php if ($this->_tpl_vars['loser_round_list'][$this->_sections['round']['index']]['RED_ID'] < 0): ?> style="color:#aaa; text-align:right;"<?php endif; ?> type="text" readonly value="<?php echo $this->_tpl_vars['loser_round_list'][$this->_sections['round']['index']]['RED_NAME']; ?>
" size="18"><?php if ($this->_tpl_vars['user_access'] == 'admin' || $this->_tpl_vars['user_access'] == 'steward'): ?><input type="radio" NAME="<?php echo $this->_tpl_vars['loser_round_list'][$this->_sections['round']['index']]['ROUND_NUMBER']; ?>
" VALUE="R" <?php if ($this->_tpl_vars['loser_round_list'][$this->_sections['round']['index']]['COLOUR_WIN'] == 'R'): ?> checked<?php endif; ?>><?php elseif ($this->_tpl_vars['loser_round_list'][$this->_sections['round']['index']]['COLOUR_WIN'] == 'R'): ?>*<?php endif; ?>

</TD></TR>
<TR><td></td><td></td></TR>

<TR><TD style="text-align: center; border-width: 0px; vertical-align: bottom; padding-bottom: 4px; background-color:#0bf">
B</td><td style="border-width: 0px; vertical-align: bottom; padding-bottom: 4px;">
<input <?php if ($this->_tpl_vars['loser_round_list'][$this->_sections['round']['index']]['BLUE_ID'] < 0): ?> class="draw_instruction"<?php endif; ?> type="text" readonly value="<?php echo $this->_tpl_vars['loser_round_list'][$this->_sections['round']['index']]['BLUE_NAME']; ?>
" size="18"><?php if ($this->_tpl_vars['user_access'] == 'admin' || $this->_tpl_vars['user_access'] == 'steward'): ?><input type="radio" NAME="<?php echo $this->_tpl_vars['loser_round_list'][$this->_sections['round']['index']]['ROUND_NUMBER']; ?>
" VALUE="B" <?php if ($this->_tpl_vars['loser_round_list'][$this->_sections['round']['index']]['COLOUR_WIN'] == 'B'): ?> checked<?php endif; ?>><?php elseif ($this->_tpl_vars['loser_round_list'][$this->_sections['round']['index']]['COLOUR_WIN'] == 'B'): ?>*<?php endif; ?>

</TD></TR>
</table>
<?php endif; ?>
</div>
<?php endfor; endif; ?>




</form>


</div> <!-- /division_main_pane -->
<?php endif; ?>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</div>

