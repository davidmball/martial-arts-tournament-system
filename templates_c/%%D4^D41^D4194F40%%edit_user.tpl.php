<?php /* Smarty version 2.6.20, created on 2012-03-16 21:32:50
         compiled from edit_user.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'edit_user.tpl', 1, false),array('function', 'html_options', 'edit_user.tpl', 65, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => "test.conf",'section' => 'setup'), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="main_pane">


<div id="command">
<p>
<?php echo $this->_tpl_vars['command']; ?>

</p>
</div>

<div id="error_string">
<p>
<?php unset($this->_sections['error_list']);
$this->_sections['error_list']['name'] = 'error_list';
$this->_sections['error_list']['loop'] = is_array($_loop=$this->_tpl_vars['error_string']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['error_list']['show'] = true;
$this->_sections['error_list']['max'] = $this->_sections['error_list']['loop'];
$this->_sections['error_list']['step'] = 1;
$this->_sections['error_list']['start'] = $this->_sections['error_list']['step'] > 0 ? 0 : $this->_sections['error_list']['loop']-1;
if ($this->_sections['error_list']['show']) {
    $this->_sections['error_list']['total'] = $this->_sections['error_list']['loop'];
    if ($this->_sections['error_list']['total'] == 0)
        $this->_sections['error_list']['show'] = false;
} else
    $this->_sections['error_list']['total'] = 0;
if ($this->_sections['error_list']['show']):

            for ($this->_sections['error_list']['index'] = $this->_sections['error_list']['start'], $this->_sections['error_list']['iteration'] = 1;
                 $this->_sections['error_list']['iteration'] <= $this->_sections['error_list']['total'];
                 $this->_sections['error_list']['index'] += $this->_sections['error_list']['step'], $this->_sections['error_list']['iteration']++):
$this->_sections['error_list']['rownum'] = $this->_sections['error_list']['iteration'];
$this->_sections['error_list']['index_prev'] = $this->_sections['error_list']['index'] - $this->_sections['error_list']['step'];
$this->_sections['error_list']['index_next'] = $this->_sections['error_list']['index'] + $this->_sections['error_list']['step'];
$this->_sections['error_list']['first']      = ($this->_sections['error_list']['iteration'] == 1);
$this->_sections['error_list']['last']       = ($this->_sections['error_list']['iteration'] == $this->_sections['error_list']['total']);
?>
<?php echo $this->_tpl_vars['error_string'][$this->_sections['error_list']['index']]; ?>
</br>
<?php endfor; endif; ?>
</p>
</div>

<div id="primary_<?php echo $this->_tpl_vars['level']; ?>
">
<p>
<?php echo $this->_tpl_vars['primary']; ?>

</p>
</div>



<?php if ($this->_tpl_vars['delete_success']): ?>

<?php else: ?>
<form action="<?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>
" method="post" enctype="multipart/form-data">
	
	
	<table border="0">
		<tr>
	        <td>ID</td>
	        <td><?php echo $this->_tpl_vars['user']['ID']; ?>
<input type="hidden" name="ID" value="<?php echo $this->_tpl_vars['user']['ID']; ?>
"></td>
	    </tr>
		<tr>
	        <td>Username</td>
	        <td><input type="text" name="USERNAME" value="<?php echo $this->_tpl_vars['user']['USERNAME']; ?>
"></td>
	    </tr>
	   <tr>
	        <td>Title</td>
	        <td><input type="text" name="Title" value="<?php echo $this->_tpl_vars['user']['TITLE']; ?>
" size="10"></td>
	    </tr>	    
	   <tr>
	        <td>First Name</td>
	        <td><input type="text" name="First_Name" value="<?php echo $this->_tpl_vars['user']['FIRST_NAME']; ?>
" size="40"></td>
	    </tr>
	    <tr>
	        <td>Last Name</td>
	        <td><input type="text" name="Last_Name" value="<?php echo $this->_tpl_vars['user']['LAST_NAME']; ?>
" size="40"></td>
	    </tr>
	    <tr>
	        <td>Access</td>
	        <td><select name="Access"><option value="admin" <?php if ($this->_tpl_vars['user']['ACCESS'] == 'admin'): ?> selected="selected"<?php endif; ?>>admin</option>
	        			<option value="manager" <?php if ($this->_tpl_vars['user']['ACCESS'] == 'manager'): ?> selected="selected"<?php endif; ?>>manager</option>
	        			<option value="steward" <?php if ($this->_tpl_vars['user']['ACCESS'] == 'steward'): ?> selected="selected"<?php endif; ?>>steward</option>
	        			</select>
	    </tr>
	    <tr>
	        <td>Represents</td>
	        <td><?php echo smarty_function_html_options(array('name' => "Represents[]",'size' => 10,'multiple' => true,'options' => $this->_tpl_vars['represents_list'],'selected' => $this->_tpl_vars['represents_selection']), $this);?>
</td>
    
	    </tr>	    
	    <tr>
	        <td>Email</td>
	        <td><input type="text" name="Email" value="<?php echo $this->_tpl_vars['user']['EMAIL']; ?>
" size="40"></td>
	    </tr>
	    <tr>
	        <td>Active</td>
	        <td><input type="checkbox" name="Active" value="Active" <?php if ($this->_tpl_vars['user']['ACTIVE']): ?> checked <?php endif; ?>></td>
	    </tr>
	    	    
	    <tr>
	        <td>Last Updated</td>
	        <td><?php echo $this->_tpl_vars['user']['LAST_UPDATED']; ?>
</td>
	    </tr>	    	    	    
	    <tr>
	        <td colspan="2" align="center"><input type="submit" value="Submit" name="Submit">&nbsp;&nbsp;<input type="submit" value="Delete" name="Delete"></td>
	    </tr>

</form>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</body>
