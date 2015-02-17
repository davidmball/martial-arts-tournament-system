<?php /* Smarty version 2.6.20, created on 2012-03-16 22:03:52
         compiled from trophy.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'trophy.tpl', 15, false),array('modifier', 'date_format', 'trophy.tpl', 52, false),)), $this); ?>
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
<h1>Trophy List</h1>




 <table border="3" width="1100px" >
  <tr>
  		<th>
  			Count
  		</th>
 		<th>
 			Tournament Name
 		</th>
 		<th>
 			Tournament Date
 		</th> 		
 		<th>
 			Division
 		</th> 		
		<th>
			Notes
		</th>
  </tr>
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
	<tr>
		<td align="center" class="trophy_list">
		  <?php echo $this->_sections['division']['index']+1; ?>

		</td>
		<td align="center" class="trophy_list"> 
			<?php echo $this->_tpl_vars['active_tournament']['NAME']; ?>

		</td>
		<td align="center" class="trophy_list">
			<?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_FROM'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['date']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['date'])); ?>
<?php if ($this->_tpl_vars['active_tournament']['DATE_TO'] != $this->_tpl_vars['active_tournament']['DATE_FROM']): ?> - <?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_TO'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['date']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['date'])); ?>
<?php endif; ?>			
		</td>
		<td align="center" class="trophy_list">
			<?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['EVENT']; ?>
, <?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION']; ?>

		</td>
		<td align="center" class="trophy_list">
		 	<?php if ($this->_tpl_vars['division_list'][$this->_sections['division']['index']]['MAX_COMPETITORS'] == 1): ?>
				<?php if ($this->_tpl_vars['division_list'][$this->_sections['division']['index']]['MINOR_FINAL'] == '3rd4th'): ?>
					1st, 2nd, 3rd	
				<?php elseif ($this->_tpl_vars['division_list'][$this->_sections['division']['index']]['MINOR_FINAL'] == '3rd3rd'): ?>
					1st, 2nd, 3rd, 3rd		
				<?php elseif ($this->_tpl_vars['division_list'][$this->_sections['division']['index']]['MINOR_FINAL'] == '1stonly'): ?>
					1st
				<?php else: ?>
					1st, 2nd
				<?php endif; ?>
			<?php else: ?>
				<?php if ($this->_tpl_vars['division_list'][$this->_sections['division']['index']]['MINOR_FINAL'] == '3rd4th'): ?>
					(1st, 2nd, 3rd) x 5
				<?php elseif ($this->_tpl_vars['division_list'][$this->_sections['division']['index']]['MINOR_FINAL'] == '3rd3rd'): ?>
					(1st, 2nd, 3rd, 3rd) x 5
				<?php elseif ($this->_tpl_vars['division_list'][$this->_sections['division']['index']]['MINOR_FINAL'] == '1stonly'): ?>
					(1st) x 5
				<?php else: ?>
					(1st, 2nd) x 5
				<?php endif; ?>
		 	<?php endif; ?>
		</td>
 	</tr>
 	<?php endfor; endif; ?>
 </table>


</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</body>