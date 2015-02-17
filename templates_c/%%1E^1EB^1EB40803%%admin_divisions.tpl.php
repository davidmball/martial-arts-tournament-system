<?php /* Smarty version 2.6.20, created on 2013-04-12 23:53:45
         compiled from admin_divisions.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'admin_divisions.tpl', 1, false),array('function', 'html_options', 'admin_divisions.tpl', 9, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => "test.conf",'section' => 'setup'), $this);?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="main_pane">
<h1>Division Management</h1>

<form action="<?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>
" method="post" enctype="multipart/form-data" onSubmit="return confirm('Are you sure you want to copy all the divisions from the selected tournament?');">
<?php echo smarty_function_html_options(array('name' => "Tournaments[]",'size' => 1,'options' => $this->_tpl_vars['tournaments_list']), $this);?>

<input type="submit" value="Copy divisions from selected tournament" name="Copy_Divisions">
</form>

 <table border="0">
  	<tr>
 		<th>		
 			ID		
 		</th>
		<th>
		Sequence
		</th>
 		<th>
 			Division
 		</th>
 		<th>
 			Event Name
 		</th> 		
 		<th>		
 			Section Name	
 		</th>			
 		 <th>		
 			Division Type	
 		</th>			
 	</tr>
 	<?php unset($this->_sections['division_list']);
$this->_sections['division_list']['name'] = 'division_list';
$this->_sections['division_list']['loop'] = is_array($_loop=$this->_tpl_vars['divisions']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['division_list']['show'] = true;
$this->_sections['division_list']['max'] = $this->_sections['division_list']['loop'];
$this->_sections['division_list']['step'] = 1;
$this->_sections['division_list']['start'] = $this->_sections['division_list']['step'] > 0 ? 0 : $this->_sections['division_list']['loop']-1;
if ($this->_sections['division_list']['show']) {
    $this->_sections['division_list']['total'] = $this->_sections['division_list']['loop'];
    if ($this->_sections['division_list']['total'] == 0)
        $this->_sections['division_list']['show'] = false;
} else
    $this->_sections['division_list']['total'] = 0;
if ($this->_sections['division_list']['show']):

            for ($this->_sections['division_list']['index'] = $this->_sections['division_list']['start'], $this->_sections['division_list']['iteration'] = 1;
                 $this->_sections['division_list']['iteration'] <= $this->_sections['division_list']['total'];
                 $this->_sections['division_list']['index'] += $this->_sections['division_list']['step'], $this->_sections['division_list']['iteration']++):
$this->_sections['division_list']['rownum'] = $this->_sections['division_list']['iteration'];
$this->_sections['division_list']['index_prev'] = $this->_sections['division_list']['index'] - $this->_sections['division_list']['step'];
$this->_sections['division_list']['index_next'] = $this->_sections['division_list']['index'] + $this->_sections['division_list']['step'];
$this->_sections['division_list']['first']      = ($this->_sections['division_list']['iteration'] == 1);
$this->_sections['division_list']['last']       = ($this->_sections['division_list']['iteration'] == $this->_sections['division_list']['total']);
?>
	<tr>
 		<td align="center">
 			<?php echo $this->_tpl_vars['divisions'][$this->_sections['division_list']['index']]['ID']; ?>
		
 		</td>
 		<td align="center">
 			<?php echo $this->_tpl_vars['divisions'][$this->_sections['division_list']['index']]['SEQUENCE']; ?>

 		</td>
 		<td>
 			<?php echo $this->_tpl_vars['divisions'][$this->_sections['division_list']['index']]['NAME']; ?>

 		</td>
 		<td  align="center">
 			<?php echo $this->_tpl_vars['divisions'][$this->_sections['division_list']['index']]['EVENT_NAME']; ?>

 		</td> 	
 		 <td align="center">
 			<?php echo $this->_tpl_vars['divisions'][$this->_sections['division_list']['index']]['SECTION_NAME']; ?>

 		</td> 			
 		 <td align="center">
 			<?php echo $this->_tpl_vars['divisions'][$this->_sections['division_list']['index']]['TYPE']; ?>

 		</td> 		 		 			
 		<td>
			<a href="edit_division.php?ID=<?php echo $this->_tpl_vars['divisions'][$this->_sections['division_list']['index']]['ID']; ?>
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
 	 <a href="edit_division.php?ID=new">new</a>
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