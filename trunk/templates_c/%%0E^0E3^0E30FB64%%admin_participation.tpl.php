<?php /* Smarty version 2.6.20, created on 2009-10-24 11:33:22
         compiled from admin_participation.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'admin_participation.tpl', 15, false),array('modifier', 'date_format', 'admin_participation.tpl', 38, false),)), $this); ?>
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



<ul class="page_break"  style="padding: 200px 0px 0px 0px;  text-align: center;">

<div style="font-size: 2.0em;">Certificate of Participation</div><br>
<img src="images/<?php echo $this->_tpl_vars['active_tournament']['LOGO_NAME']; ?>
" alt="Tournament Logo" width="170" height="170">
<br>
<br>
<br>
Congratulations to<br>
<br>
 <b style="font-size: 1.2em;"><?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['FIRST_NAME']; ?>
 <?php echo $this->_tpl_vars['competitors'][$this->_sections['competitor_list']['index']]['LAST_NAME']; ?>
</b>
 <br>
 <br>
on your participation in the <?php echo $this->_tpl_vars['active_tournament']['NAME']; ?>
 tournament<br>
held at <?php echo $this->_tpl_vars['active_tournament']['LOCATION']; ?>
, Australia <br>
held on <?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_FROM'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<?php if ($this->_tpl_vars['active_tournament']['DATE_TO'] != $this->_tpl_vars['active_tournament']['DATE_FROM']): ?> - <?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_TO'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<?php endif; ?>
<br>
<br>
<br>
<br>
<br>
<br>
___________________________<br>
<?php echo $this->_tpl_vars['active_tournament']['PARTICIPATION_SIGNATURE_HTML']; ?>

</ul>
 	 <?php endfor; endif; ?>



</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</body>