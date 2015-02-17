<?php /* Smarty version 2.6.20, created on 2009-10-24 14:08:00
         compiled from admin_sections.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'admin_sections.tpl', 1, false),array('function', 'html_options', 'admin_sections.tpl', 8, false),array('modifier', 'date_format', 'admin_sections.tpl', 36, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => "test.conf",'section' => 'setup'), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="main_pane">
<h1>Section Management</h1>

<form action="<?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>
" method="post" enctype="multipart/form-data" onSubmit="return confirm('Are you sure you want to copy all the sections from the selected tournament?');">
<?php echo smarty_function_html_options(array('name' => "Tournaments[]",'size' => 1,'options' => $this->_tpl_vars['tournaments_list']), $this);?>

<input type="submit" value="Copy sections from selected tournament" name="Copy_Sections">
</form>

 <table border="0">
  	<tr>
 		<th>		
 			ID		
 		</th>
 		<th>		
 			Name		
 		</th>
 		<th>
 			Date
 		</th>
 		<th>
 			Part
 		</th> 		
 	</tr>
 	<?php unset($this->_sections['section_list']);
$this->_sections['section_list']['name'] = 'section_list';
$this->_sections['section_list']['loop'] = is_array($_loop=$this->_tpl_vars['sections']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['section_list']['show'] = true;
$this->_sections['section_list']['max'] = $this->_sections['section_list']['loop'];
$this->_sections['section_list']['step'] = 1;
$this->_sections['section_list']['start'] = $this->_sections['section_list']['step'] > 0 ? 0 : $this->_sections['section_list']['loop']-1;
if ($this->_sections['section_list']['show']) {
    $this->_sections['section_list']['total'] = $this->_sections['section_list']['loop'];
    if ($this->_sections['section_list']['total'] == 0)
        $this->_sections['section_list']['show'] = false;
} else
    $this->_sections['section_list']['total'] = 0;
if ($this->_sections['section_list']['show']):

            for ($this->_sections['section_list']['index'] = $this->_sections['section_list']['start'], $this->_sections['section_list']['iteration'] = 1;
                 $this->_sections['section_list']['iteration'] <= $this->_sections['section_list']['total'];
                 $this->_sections['section_list']['index'] += $this->_sections['section_list']['step'], $this->_sections['section_list']['iteration']++):
$this->_sections['section_list']['rownum'] = $this->_sections['section_list']['iteration'];
$this->_sections['section_list']['index_prev'] = $this->_sections['section_list']['index'] - $this->_sections['section_list']['step'];
$this->_sections['section_list']['index_next'] = $this->_sections['section_list']['index'] + $this->_sections['section_list']['step'];
$this->_sections['section_list']['first']      = ($this->_sections['section_list']['iteration'] == 1);
$this->_sections['section_list']['last']       = ($this->_sections['section_list']['iteration'] == $this->_sections['section_list']['total']);
?>
	<tr>
 		<td align="center">
 			<?php echo $this->_tpl_vars['sections'][$this->_sections['section_list']['index']]['ID']; ?>
		
 		</td>
 		<td>
 			<?php echo $this->_tpl_vars['sections'][$this->_sections['section_list']['index']]['NAME']; ?>

 		</td>
 		<td  align="center">
 			<?php echo ((is_array($_tmp=$this->_tpl_vars['sections'][$this->_sections['section_list']['index']]['DATE'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d %b, %Y") : smarty_modifier_date_format($_tmp, "%d %b, %Y")); ?>

 		</td> 		
 		<td align="center">
 			<?php echo $this->_tpl_vars['sections'][$this->_sections['section_list']['index']]['PART']; ?>

 		</td>	 			
 		<td>
			<a href="edit_sections.php?ID=<?php echo $this->_tpl_vars['sections'][$this->_sections['section_list']['index']]['ID']; ?>
">edit</a>
 		</td> 	
 	</tr>

 	 <?php endfor; endif; ?>
 	 <tr>
 	 <td></td>
 	 <td></td>
 	 <td></td>
 	 <td></td> 	 
 	 <td>	 
 	 <a href="edit_sections.php?ID=new">new</a>
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
