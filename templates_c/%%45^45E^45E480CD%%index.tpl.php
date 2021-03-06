<?php /* Smarty version 2.6.20, created on 2009-04-30 23:12:30
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'index.tpl', 1, false),array('modifier', 'date_format', 'index.tpl', 43, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => "test.conf"), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="main_pane">

<?php if ($this->_tpl_vars['user_access'] == 'admin'): ?>
<form action="<?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>
" method="post" enctype="multipart/form-data">
  <table border="0">
    <tr>
     	<th>
 			Active
 		</th>
       	<th>		
 			Name
 		</th>
       	<th>		
 			Location
 		</th>
       	<th>		
 			Date From
 		</th>
        <th>
 			Date To
 		</th>
        <th>		
 			Competitors
 		</th> 				 		    
    </tr>
 	<?php unset($this->_sections['tournament_list']);
$this->_sections['tournament_list']['name'] = 'tournament_list';
$this->_sections['tournament_list']['loop'] = is_array($_loop=$this->_tpl_vars['tournaments']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['tournament_list']['show'] = true;
$this->_sections['tournament_list']['max'] = $this->_sections['tournament_list']['loop'];
$this->_sections['tournament_list']['step'] = 1;
$this->_sections['tournament_list']['start'] = $this->_sections['tournament_list']['step'] > 0 ? 0 : $this->_sections['tournament_list']['loop']-1;
if ($this->_sections['tournament_list']['show']) {
    $this->_sections['tournament_list']['total'] = $this->_sections['tournament_list']['loop'];
    if ($this->_sections['tournament_list']['total'] == 0)
        $this->_sections['tournament_list']['show'] = false;
} else
    $this->_sections['tournament_list']['total'] = 0;
if ($this->_sections['tournament_list']['show']):

            for ($this->_sections['tournament_list']['index'] = $this->_sections['tournament_list']['start'], $this->_sections['tournament_list']['iteration'] = 1;
                 $this->_sections['tournament_list']['iteration'] <= $this->_sections['tournament_list']['total'];
                 $this->_sections['tournament_list']['index'] += $this->_sections['tournament_list']['step'], $this->_sections['tournament_list']['iteration']++):
$this->_sections['tournament_list']['rownum'] = $this->_sections['tournament_list']['iteration'];
$this->_sections['tournament_list']['index_prev'] = $this->_sections['tournament_list']['index'] - $this->_sections['tournament_list']['step'];
$this->_sections['tournament_list']['index_next'] = $this->_sections['tournament_list']['index'] + $this->_sections['tournament_list']['step'];
$this->_sections['tournament_list']['first']      = ($this->_sections['tournament_list']['iteration'] == 1);
$this->_sections['tournament_list']['last']       = ($this->_sections['tournament_list']['iteration'] == $this->_sections['tournament_list']['total']);
?>
	<tr>
	 	<td>
 			<input type="radio" name="Active" value="<?php echo $this->_tpl_vars['tournaments'][$this->_sections['tournament_list']['index']]['ID']; ?>
" <?php if ($this->_tpl_vars['tournaments'][$this->_sections['tournament_list']['index']]['ACTIVE']): ?>checked<?php endif; ?>>
 		</td>
 		<td>
 		 	<?php if ($this->_tpl_vars['tournaments'][$this->_sections['tournament_list']['index']]['ACTIVE']): ?><div id="active_tourn"><?php endif; ?>		
 			<?php echo $this->_tpl_vars['tournaments'][$this->_sections['tournament_list']['index']]['NAME']; ?>

 			<?php if ($this->_tpl_vars['tournaments'][$this->_sections['tournament_list']['index']]['ACTIVE']): ?></div><?php endif; ?>			
 		</td>
 		<td>
 			<?php echo $this->_tpl_vars['tournaments'][$this->_sections['tournament_list']['index']]['LOCATION']; ?>

 		</td>
 		<td>
 			<?php echo ((is_array($_tmp=$this->_tpl_vars['tournaments'][$this->_sections['tournament_list']['index']]['DATE_FROM'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d %b, %Y") : smarty_modifier_date_format($_tmp, "%d %b, %Y")); ?>

 		</td>
  		<td>
 			<?php echo ((is_array($_tmp=$this->_tpl_vars['tournaments'][$this->_sections['tournament_list']['index']]['DATE_TO'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d %b, %Y") : smarty_modifier_date_format($_tmp, "%d %b, %Y")); ?>

 		</td>
 		<td align="center">
 			<?php echo $this->_tpl_vars['tournaments'][$this->_sections['tournament_list']['index']]['COMPETITOR_COUNT']; ?>

 		</td>			
 		<?php if ($this->_tpl_vars['user_access'] == 'admin'): ?>
 		<td>
			<a href="edit_tournament.php?ID=<?php echo $this->_tpl_vars['tournaments'][$this->_sections['tournament_list']['index']]['ID']; ?>
">edit</a>
 		</td> 	
 		<?php endif; ?>
 	</tr>

 	 <?php endfor; endif; ?>
 	 <tr>
 	 <td><input type="submit" value="Submit" name="Submit"></td>
 	 <td></td>
 	 <td></td>
 	 <td></td>
 	 <td></td>
 	 <td></td>
 	 <td>
  	 <?php if ($this->_tpl_vars['user_access'] == 'admin'): ?>	 
 	 <a href="edit_tournament.php?ID=new">new</a>
 	 <?php endif; ?>
 	 </td>
 	 </tr>
 </table>
</form>
<?php else: ?>

<div id="active_tourn">

<img src="images/<?php echo $this->_tpl_vars['active_tournament']['LOGO_NAME']; ?>
" alt="Tournament Logo" width="150" height="150">

<p class="breakhere">

<?php echo $this->_tpl_vars['active_tournament']['NAME']; ?>
</br>
@ <?php echo $this->_tpl_vars['active_tournament']['LOCATION']; ?>
<br/>
<?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_FROM'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<?php if ($this->_tpl_vars['active_tournament']['DATE_TO'] != $this->_tpl_vars['active_tournament']['DATE_FROM']): ?> - <?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_TO'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<?php endif; ?></br><br>
Currently:<br>
<?php echo $this->_tpl_vars['competitor_count']; ?>
 competitors<br>
<?php echo $this->_tpl_vars['team_competitor_count']; ?>
 teams
</p>
<br>
<p>
<a href="docs/<?php echo $this->_tpl_vars['active_tournament']['TOURNAMENT_FORM_PDF']; ?>
">Click here to download the Tournament Form.</a>
</p>
<br>
<p>
<h2>Schedule</h2>
<?php if ($this->_tpl_vars['active_tournament']['SCHEDULE_HTML']): ?>
	<?php echo $this->_tpl_vars['active_tournament']['SCHEDULE_HTML']; ?>

<?php else: ?>
	Schedule coming soon!
<?php endif; ?>
</p>
</div>

<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</div>