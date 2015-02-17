<?php /* Smarty version 2.6.20, created on 2012-03-16 21:34:12
         compiled from my_account.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'my_account.tpl', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => "test.conf",'section' => 'setup'), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="main_pane">


<?php if ($this->_tpl_vars['user_access'] == 'admin' || $this->_tpl_vars['user_access'] == 'manager' || $this->_tpl_vars['user_access'] == 'steward'): ?>

<h1>Change Details</h1>

<div id="primary_<?php echo $this->_tpl_vars['level']; ?>
">
<p>
<?php echo $this->_tpl_vars['primary']; ?>

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

<div id="command">
<p>
<?php echo $this->_tpl_vars['command']; ?>

</p>
</div>

<form action="<?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>
" method="post" enctype="multipart/form-data">
	
	<p>
	Enter new details here.</br>
	If you do NOT want a new password leave the new password fields blank.</br>
	</p>
	<table border="1">
		<tr>
	        <td>ID</td>
	        <td><?php echo $this->_tpl_vars['user']['ID']; ?>
<input type="hidden" name="ID" value="<?php echo $this->_tpl_vars['user']['ID']; ?>
"></td>
	    </tr>
		<tr>
	        <td>Username</td>
	        <td><?php echo $this->_tpl_vars['user']['USERNAME']; ?>
<input type="hidden" name="USERNAME" value="<?php echo $this->_tpl_vars['user']['USERNAME']; ?>
"></td>
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
<!--	    <tr>
	        <td>Represents</td>
	        <td><input type="text" name="Represents" value="<?php echo $this->_tpl_vars['user']['REPRESENTS']; ?>
" size="40"></td>
	    </tr>	    -->
	    <tr>
	        <td>Email</td>
	        <td><input type="text" name="Email" value="<?php echo $this->_tpl_vars['user']['EMAIL']; ?>
" size="40"></td>
	    </tr>    	    	    
    
	    <tr>
	    	<td>New Password</td> 
	    	<td><input type="password" name="New_Password" value="" size="40"></td>
	    </tr>
	    
	    <tr>
	    	<td>New Password (Repeat)</td> 
	    	<td><input type="password" name="New_Password_Repeat" value="" size="40"></td>
	    </tr>
<!--	    <tr>
	    	<td>Current Password</td> 
	    	<td><input type"password" name="Current_Password" value="" size="40"></td>
	    </tr>
	    -->
	    
	   <tr>
	        <td colspan="2" align="center"><input type="submit" value="Submit" name="Submit_Update"></td>
	    </tr>


	 
</form>


<?php else: ?> <!-- for the public -->

<h1>Reset Password</h1>

<div id="primary_<?php echo $this->_tpl_vars['level']; ?>
">
<p>
<?php echo $this->_tpl_vars['primary']; ?>

</p>
</div>
<div id="command">
<p>
<?php echo $this->_tpl_vars['command']; ?>

</p>
</div>

<form action="<?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>
" method="post" enctype="multipart/form-data">
	
	<p>
	Enter your username and email address to reset your password.</br>
	A new password will be then be emailed to you.</br>
	If you don't receive the reset password email soon please check your SPAM folder.</br>
	The email will come from tournament@bairui.com, which you may wish to add to your contacts list.</br>
	</p>
	<table border="0">

		<tr>
	        <td>Username</td>
	        <td><input type="text" name="USERNAME" value=""></td>
	    </tr>    
	    <tr>
	        <td>Email</td>
	        <td><input type="text" name="Email" value="" size="40"></td>
	    </tr>    	    	    
 
	   <tr>
	        <td colspan="2" align="center"><input type="submit" value="Submit" name="Submit_Reset"></td>
	    </tr>

</form>

<!--
<h1>Sign Up</h1>

<form action="<?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>
" method="post" enctype="multipart/form-data">
	
	<p>
	Signing up is for team managers/instructors only.</br>
	The account must be verified by an admin before it will be activated.</br>
	</p>
	<table border="0">

		<tr>
	        <td>Username</td>
	        <td><input type="text" name="USERNAME" value=""></td>
	    </tr>    
	    <tr>
	        <td>Email</td>
	        <td><input type="text" name="Email" value="" size="40"></td>
	    </tr>    	    	    
 
	   <tr>
	        <td colspan="2" align="center"><input type="submit" value="Submit" name="Submit_New"></td>
	    </tr>


	 
</form>

-->
<?php endif; ?>


</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>