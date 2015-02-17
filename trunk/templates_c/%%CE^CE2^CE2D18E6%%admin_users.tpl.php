<?php /* Smarty version 2.6.20, created on 2012-03-16 21:27:30
         compiled from admin_users.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'admin_users.tpl', 1, false),array('function', 'html_options', 'admin_users.tpl', 8, false),array('modifier', 'default', 'admin_users.tpl', 47, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => "test.conf",'section' => 'setup'), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="main_pane">
<h1>User Management</h1>

<form action="<?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>
" method="post" enctype="multipart/form-data" onSubmit="return confirm('Are you sure you want to copy all the represents from the selected tournament?');">
<?php echo smarty_function_html_options(array('name' => "Tournaments[]",'size' => 1,'options' => $this->_tpl_vars['tournaments_list']), $this);?>

<input type="submit" value="Copy represents from selected tournament" name="Copy_Represents">
</form>

<form action="<?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>
" method="post" enctype="multipart/form-data" onSubmit="return confirm('Are you sure you want to send a check divisions email to all active users?');">
<input type="submit" value="Send a check divisions email to all active users" name="Check_Divisions">
</form>


  <table border="0">
  	<tr>
 		<th>		
 			Username		
 		</th>
 		<th>
 			First Name
 		</th>
 		<th>
 			Last Name
 		</th>
 		<th>
 			Represents
 		</th> 		
 		<th>
 			Access
 		</th>
 		<th>
 			Email
 		</th>
 		<th>
 			Active
 		</th> 
 	</tr>
 	<?php unset($this->_sections['user_list']);
$this->_sections['user_list']['name'] = 'user_list';
$this->_sections['user_list']['loop'] = is_array($_loop=$this->_tpl_vars['users']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['user_list']['show'] = true;
$this->_sections['user_list']['max'] = $this->_sections['user_list']['loop'];
$this->_sections['user_list']['step'] = 1;
$this->_sections['user_list']['start'] = $this->_sections['user_list']['step'] > 0 ? 0 : $this->_sections['user_list']['loop']-1;
if ($this->_sections['user_list']['show']) {
    $this->_sections['user_list']['total'] = $this->_sections['user_list']['loop'];
    if ($this->_sections['user_list']['total'] == 0)
        $this->_sections['user_list']['show'] = false;
} else
    $this->_sections['user_list']['total'] = 0;
if ($this->_sections['user_list']['show']):

            for ($this->_sections['user_list']['index'] = $this->_sections['user_list']['start'], $this->_sections['user_list']['iteration'] = 1;
                 $this->_sections['user_list']['iteration'] <= $this->_sections['user_list']['total'];
                 $this->_sections['user_list']['index'] += $this->_sections['user_list']['step'], $this->_sections['user_list']['iteration']++):
$this->_sections['user_list']['rownum'] = $this->_sections['user_list']['iteration'];
$this->_sections['user_list']['index_prev'] = $this->_sections['user_list']['index'] - $this->_sections['user_list']['step'];
$this->_sections['user_list']['index_next'] = $this->_sections['user_list']['index'] + $this->_sections['user_list']['step'];
$this->_sections['user_list']['first']      = ($this->_sections['user_list']['iteration'] == 1);
$this->_sections['user_list']['last']       = ($this->_sections['user_list']['iteration'] == $this->_sections['user_list']['total']);
?>
	<tr>
 		<td>
 			<?php echo $this->_tpl_vars['users'][$this->_sections['user_list']['index']]['USERNAME']; ?>
		
 		</td>
 		<td>
 			<?php echo ((is_array($_tmp=@$this->_tpl_vars['users'][$this->_sections['user_list']['index']]['FIRST_NAME'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>

 		</td>
 		<td>
 			<?php echo $this->_tpl_vars['users'][$this->_sections['user_list']['index']]['LAST_NAME']; ?>

 		</td>
 		<td>
 			<?php echo $this->_tpl_vars['users'][$this->_sections['user_list']['index']]['REPRESENTS']; ?>

 		</td> 		
 		<td>
 			<?php echo $this->_tpl_vars['users'][$this->_sections['user_list']['index']]['ACCESS']; ?>

 		</td>
  		<td>
 			<?php echo $this->_tpl_vars['users'][$this->_sections['user_list']['index']]['EMAIL']; ?>

 		</td>		
 		<td>
 			<?php echo $this->_tpl_vars['users'][$this->_sections['user_list']['index']]['ACTIVE']; ?>

 		</td> 		
			
 		<?php if ($this->_tpl_vars['user_access'] == 'admin'): ?>
 		<td>
			<a href="edit_user.php?ID=<?php echo $this->_tpl_vars['users'][$this->_sections['user_list']['index']]['ID']; ?>
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
 	 <td></td> 	 
  	 <td></td> 	 
 	 <td>
  	 <?php if ($this->_tpl_vars['user_access'] == 'admin'): ?>	 
 	 <a href="edit_user.php?ID=new">new</a>
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