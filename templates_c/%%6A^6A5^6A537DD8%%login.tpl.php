<?php /* Smarty version 2.6.20, created on 2009-04-30 23:10:06
         compiled from login.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "html_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="login_pane">
<form method="post" action="index.php">
Username: <input type="text" class="textfield" name="username" size="10">
Password: <input type="password" class="textfield" name="password" size="10">
<input type="submit" class="submit" value="Login"></br>
<a href="my_account.php">Forgot password?</a>
</form>
</div>