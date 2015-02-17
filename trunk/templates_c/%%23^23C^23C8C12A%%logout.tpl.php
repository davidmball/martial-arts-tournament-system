<?php /* Smarty version 2.6.20, created on 2009-10-23 23:13:32
         compiled from logout.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "html_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="login_pane">

<?php if (! $this->_tpl_vars['print_version']): ?>

<form action="<?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>
" method="post" enctype="multipart/form-data">
Logged in as: <b><?php echo $this->_tpl_vars['username']; ?>
</b> &nbsp;&nbsp;<input type="submit" value="Logout" name="logout" class="submit"></br>
<a href="my_account.php">Manage My Account</a>
</form>

<?php endif; ?>

</div>