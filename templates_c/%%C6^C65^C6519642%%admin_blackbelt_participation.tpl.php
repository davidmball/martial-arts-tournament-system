<?php /* Smarty version 2.6.20, created on 2009-12-27 04:14:27
         compiled from admin_blackbelt_participation.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'admin_blackbelt_participation.tpl', 1, false),array('function', 'cycle', 'admin_blackbelt_participation.tpl', 36, false),array('modifier', 'date_format', 'admin_blackbelt_participation.tpl', 8, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => "test.conf",'section' => 'setup'), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="main_pane">
<h1>Black Belt Participation</h1>


<h2>Competitor List for: <?php echo $this->_tpl_vars['active_tournament']['NAME']; ?>
: <?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_FROM'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['date']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['date'])); ?>
<?php if ($this->_tpl_vars['active_tournament']['DATE_TO'] != $this->_tpl_vars['active_tournament']['DATE_FROM']): ?> - <?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_TO'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['date']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['date'])); ?>
<?php endif; ?></h2>


<p class="legend">
Legend: S = Sparring, P = Patterns, ST = Special Techniques, PB = Power Breaking, RRS = Round Robin Sparring</br>
Legend: TSp = Team Sparring, TP = Team Patterns, TST = Team Special Techniques, TPB = Team Power Breaking, TSE = Team Special Events
</p>

	  
  <table border="0" class="registration">
  <tr>

 		<th>ID</th>

 		<th>First Name</th>
 		<th>Last Name	</th>
 		<th>Represents</th> 		
 		<th>
  			Rank	
 		</th>	
 		<?php unset($this->_sections['event']);
$this->_sections['event']['name'] = 'event';
$this->_sections['event']['loop'] = is_array($_loop=$this->_tpl_vars['active_tournament_events_name_abbrev']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['event']['show'] = true;
$this->_sections['event']['max'] = $this->_sections['event']['loop'];
$this->_sections['event']['step'] = 1;
$this->_sections['event']['start'] = $this->_sections['event']['step'] > 0 ? 0 : $this->_sections['event']['loop']-1;
if ($this->_sections['event']['show']) {
    $this->_sections['event']['total'] = $this->_sections['event']['loop'];
    if ($this->_sections['event']['total'] == 0)
        $this->_sections['event']['show'] = false;
} else
    $this->_sections['event']['total'] = 0;
if ($this->_sections['event']['show']):

            for ($this->_sections['event']['index'] = $this->_sections['event']['start'], $this->_sections['event']['iteration'] = 1;
                 $this->_sections['event']['iteration'] <= $this->_sections['event']['total'];
                 $this->_sections['event']['index'] += $this->_sections['event']['step'], $this->_sections['event']['iteration']++):
$this->_sections['event']['rownum'] = $this->_sections['event']['iteration'];
$this->_sections['event']['index_prev'] = $this->_sections['event']['index'] - $this->_sections['event']['step'];
$this->_sections['event']['index_next'] = $this->_sections['event']['index'] + $this->_sections['event']['step'];
$this->_sections['event']['first']      = ($this->_sections['event']['iteration'] == 1);
$this->_sections['event']['last']       = ($this->_sections['event']['iteration'] == $this->_sections['event']['total']);
?>
 			<th>
 				<?php echo $this->_tpl_vars['active_tournament_events_name_abbrev'][$this->_sections['event']['index']]; ?>

 			</th>
 		<?php endfor; endif; ?>	 			
				
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
	<tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#eeeeee,#dddddd"), $this);?>
">
		<td style="padding: 0px 10px 0px 10px;">
		<?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['ID']; ?>

		</td>
		
 		<td style="padding: 0px 10px 0px 10px;">		
 			<?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['FIRST_NAME']; ?>
		
 		</td>
 		<td style="padding: 0px 10px 0px 10px;">
 			<?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['LAST_NAME']; ?>

 		</td>
  		<td style="padding: 0px 10px 0px 10px;">
 			<?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['REPRESENTS_NAME']; ?>

 		</td>
 		 <td style="padding: 0px 10px 0px 10px;">
 			<?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['RANK']; ?>

 		</td>
 		<?php unset($this->_sections['event']);
$this->_sections['event']['name'] = 'event';
$this->_sections['event']['loop'] = is_array($_loop=$this->_tpl_vars['competitors_events'][$this->_sections['competitor_list']['index']]) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['event']['show'] = true;
$this->_sections['event']['max'] = $this->_sections['event']['loop'];
$this->_sections['event']['step'] = 1;
$this->_sections['event']['start'] = $this->_sections['event']['step'] > 0 ? 0 : $this->_sections['event']['loop']-1;
if ($this->_sections['event']['show']) {
    $this->_sections['event']['total'] = $this->_sections['event']['loop'];
    if ($this->_sections['event']['total'] == 0)
        $this->_sections['event']['show'] = false;
} else
    $this->_sections['event']['total'] = 0;
if ($this->_sections['event']['show']):

            for ($this->_sections['event']['index'] = $this->_sections['event']['start'], $this->_sections['event']['iteration'] = 1;
                 $this->_sections['event']['iteration'] <= $this->_sections['event']['total'];
                 $this->_sections['event']['index'] += $this->_sections['event']['step'], $this->_sections['event']['iteration']++):
$this->_sections['event']['rownum'] = $this->_sections['event']['iteration'];
$this->_sections['event']['index_prev'] = $this->_sections['event']['index'] - $this->_sections['event']['step'];
$this->_sections['event']['index_next'] = $this->_sections['event']['index'] + $this->_sections['event']['step'];
$this->_sections['event']['first']      = ($this->_sections['event']['iteration'] == 1);
$this->_sections['event']['last']       = ($this->_sections['event']['iteration'] == $this->_sections['event']['total']);
?>
 			<td  style="padding: 0px 5px 0px 5px;" align="center">
 			 <?php echo $this->_tpl_vars['competitors_events'][$this->_sections['competitor_list']['index']][$this->_sections['event']['index']]; ?>

 			 </td>
 		<?php endfor; endif; ?>	 				

 	</tr>

 	 <?php endfor; endif; ?>
 	 <tr>
 	 <td></td>


 	 <td></td>
 	 <td></td>
 	 <td></td>
 		<?php unset($this->_sections['event']);
$this->_sections['event']['name'] = 'event';
$this->_sections['event']['loop'] = is_array($_loop=$this->_tpl_vars['active_tournament_events_name_abbrev']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['event']['show'] = true;
$this->_sections['event']['max'] = $this->_sections['event']['loop'];
$this->_sections['event']['step'] = 1;
$this->_sections['event']['start'] = $this->_sections['event']['step'] > 0 ? 0 : $this->_sections['event']['loop']-1;
if ($this->_sections['event']['show']) {
    $this->_sections['event']['total'] = $this->_sections['event']['loop'];
    if ($this->_sections['event']['total'] == 0)
        $this->_sections['event']['show'] = false;
} else
    $this->_sections['event']['total'] = 0;
if ($this->_sections['event']['show']):

            for ($this->_sections['event']['index'] = $this->_sections['event']['start'], $this->_sections['event']['iteration'] = 1;
                 $this->_sections['event']['iteration'] <= $this->_sections['event']['total'];
                 $this->_sections['event']['index'] += $this->_sections['event']['step'], $this->_sections['event']['iteration']++):
$this->_sections['event']['rownum'] = $this->_sections['event']['iteration'];
$this->_sections['event']['index_prev'] = $this->_sections['event']['index'] - $this->_sections['event']['step'];
$this->_sections['event']['index_next'] = $this->_sections['event']['index'] + $this->_sections['event']['step'];
$this->_sections['event']['first']      = ($this->_sections['event']['iteration'] == 1);
$this->_sections['event']['last']       = ($this->_sections['event']['iteration'] == $this->_sections['event']['total']);
?>
 			<th>
 				
 			</th>
 		<?php endfor; endif; ?>	 						  				 			 						
 
 
	 	 
 	 <td>

 	 </td>
 	 </tr>
 </table>



<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</div>