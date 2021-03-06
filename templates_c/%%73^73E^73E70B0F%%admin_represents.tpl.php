<?php /* Smarty version 2.6.20, created on 2009-12-27 04:15:29
         compiled from admin_represents.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'admin_represents.tpl', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => "test.conf",'section' => 'setup'), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="main_pane">
<h1>Represents Management</h1>
	
 <table border="0">
  	<tr>
 		<th>		
 			ID		
 		</th>
 		<th>
 			Represents
 		</th>
 		<th>
 			Usernames
 		</th>
 		<th>
 			Active
 		</th> 
 		<th>
 			Competitor Count
 		</th>				
 	</tr>
 	<?php unset($this->_sections['represent_list']);
$this->_sections['represent_list']['name'] = 'represent_list';
$this->_sections['represent_list']['loop'] = is_array($_loop=$this->_tpl_vars['represents']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['represent_list']['show'] = true;
$this->_sections['represent_list']['max'] = $this->_sections['represent_list']['loop'];
$this->_sections['represent_list']['step'] = 1;
$this->_sections['represent_list']['start'] = $this->_sections['represent_list']['step'] > 0 ? 0 : $this->_sections['represent_list']['loop']-1;
if ($this->_sections['represent_list']['show']) {
    $this->_sections['represent_list']['total'] = $this->_sections['represent_list']['loop'];
    if ($this->_sections['represent_list']['total'] == 0)
        $this->_sections['represent_list']['show'] = false;
} else
    $this->_sections['represent_list']['total'] = 0;
if ($this->_sections['represent_list']['show']):

            for ($this->_sections['represent_list']['index'] = $this->_sections['represent_list']['start'], $this->_sections['represent_list']['iteration'] = 1;
                 $this->_sections['represent_list']['iteration'] <= $this->_sections['represent_list']['total'];
                 $this->_sections['represent_list']['index'] += $this->_sections['represent_list']['step'], $this->_sections['represent_list']['iteration']++):
$this->_sections['represent_list']['rownum'] = $this->_sections['represent_list']['iteration'];
$this->_sections['represent_list']['index_prev'] = $this->_sections['represent_list']['index'] - $this->_sections['represent_list']['step'];
$this->_sections['represent_list']['index_next'] = $this->_sections['represent_list']['index'] + $this->_sections['represent_list']['step'];
$this->_sections['represent_list']['first']      = ($this->_sections['represent_list']['iteration'] == 1);
$this->_sections['represent_list']['last']       = ($this->_sections['represent_list']['iteration'] == $this->_sections['represent_list']['total']);
?>
	<tr>
 		<td>
 			<?php echo $this->_tpl_vars['represents'][$this->_sections['represent_list']['index']]['ID']; ?>
		
 		</td>
 		<td>
 			<?php echo $this->_tpl_vars['represents'][$this->_sections['represent_list']['index']]['REPRESENTS']; ?>

 		</td>
 		<td>
 			<?php echo $this->_tpl_vars['represents'][$this->_sections['represent_list']['index']]['USERNAME']; ?>

 		</td>	
 		<td align="center">
 			<?php echo $this->_tpl_vars['represents'][$this->_sections['represent_list']['index']]['ACTIVE']; ?>

 		</td>
 		<td align="center">
 			<?php echo $this->_tpl_vars['represents'][$this->_sections['represent_list']['index']]['COMPETITOR_COUNT']; ?>

 		</td>	 			
 		<?php if ($this->_tpl_vars['user_access'] == 'admin'): ?>
 		<td>
			<a href="edit_represents.php?ID=<?php echo $this->_tpl_vars['represents'][$this->_sections['represent_list']['index']]['ID']; ?>
">edit</a>
 		</td> 	
 		<?php endif; ?>
 	</tr>

 	 <?php endfor; endif; ?>
 	 <tr>
 	 <td></td>
 	 <td></td>
 	 <td></td>
 	 <td></td> 
 	 <td></td>  	 
 	 <td>
  	 <?php if ($this->_tpl_vars['user_access'] == 'admin'): ?>	 
 	 <a href="edit_represents.php?ID=new">new</a>
 	 <?php endif; ?>
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