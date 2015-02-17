<?php /* Smarty version 2.6.20, created on 2010-04-11 20:34:04
         compiled from admin_report.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'admin_report.tpl', 15, false),array('modifier', 'date_format', 'admin_report.tpl', 20, false),array('modifier', 'upper', 'admin_report.tpl', 26, false),)), $this); ?>
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


<?php echo smarty_function_config_load(array('file' => "test.conf",'section' => 'setup'), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="main_pane">

<h1><?php echo $this->_tpl_vars['REPORT']; ?>
: <?php echo $this->_tpl_vars['active_tournament']['NAME']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_FROM'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<?php if ($this->_tpl_vars['active_tournament']['DATE_TO'] != $this->_tpl_vars['active_tournament']['DATE_FROM']): ?> - <?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_TO'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<?php endif; ?> - <?php echo $this->_tpl_vars['SECTION']; ?>
</h1>
  <table>
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
	<td><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['TITLE']; ?>
</td>
	<td><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['FIRST_NAME']; ?>
</td>
	<td><?php echo ((is_array($_tmp=$this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['LAST_NAME'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
</td>
	<td><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['REPRESENTS']; ?>
</td>
	<td><?php unset($this->_sections['event']);
$this->_sections['event']['name'] = 'event';
$this->_sections['event']['loop'] = is_array($_loop=9) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['event']['start'] = (int)0;
$this->_sections['event']['show'] = true;
$this->_sections['event']['max'] = $this->_sections['event']['loop'];
$this->_sections['event']['step'] = 1;
if ($this->_sections['event']['start'] < 0)
    $this->_sections['event']['start'] = max($this->_sections['event']['step'] > 0 ? 0 : -1, $this->_sections['event']['loop'] + $this->_sections['event']['start']);
else
    $this->_sections['event']['start'] = min($this->_sections['event']['start'], $this->_sections['event']['step'] > 0 ? $this->_sections['event']['loop'] : $this->_sections['event']['loop']-1);
if ($this->_sections['event']['show']) {
    $this->_sections['event']['total'] = min(ceil(($this->_sections['event']['step'] > 0 ? $this->_sections['event']['loop'] - $this->_sections['event']['start'] : $this->_sections['event']['start']+1)/abs($this->_sections['event']['step'])), $this->_sections['event']['max']);
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
 			<?php if ($this->_tpl_vars['competitors_events'][$this->_sections['competitor_list']['index']][$this->_sections['event']['index']]): ?>
		 		<?php echo $this->_tpl_vars['active_tournament_events_name'][$this->_sections['event']['index']]; ?>
&nbsp;&nbsp;
	 		<?php endif; ?>	
		<?php endfor; endif; ?>	</td>
</tr>
 	 <?php endfor; endif; ?>
	 </table>
<br>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</body>