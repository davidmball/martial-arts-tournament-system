<?php /* Smarty version 2.6.20, created on 2012-03-11 11:45:28
         compiled from edit_tournament.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'edit_tournament.tpl', 1, false),array('function', 'html_select_date', 'edit_tournament.tpl', 39, false),array('function', 'html_options', 'edit_tournament.tpl', 63, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => "test.conf",'section' => 'setup'), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="main_pane">



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

<?php if ($this->_tpl_vars['delete_success']): ?>

<?php else: ?>
<form action="<?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>
" method="post" enctype="multipart/form-data" onSubmit="<?php echo 'if (document.pressed == \'Delete\') { return confirm(\'Are you sure you want to delete the tournament including all competitors, divisions, events, sections and results?\');}'; ?>
">
	
	<table border="1">
		<tr>
	        <td>ID</td>
	        <td><?php echo $this->_tpl_vars['tournament']['ID']; ?>
<input type="hidden" name="ID" value="<?php echo $this->_tpl_vars['tournament']['ID']; ?>
"></td>
	    </tr>
	   <tr>
	        <td>Name</td>
	        <td><input type="text" name="Name" value="<?php echo $this->_tpl_vars['tournament']['NAME']; ?>
" size="40"></td>
	    </tr>
	    <tr>
	        <td>Location</td>
	        <td><input type="text" name="Location" value="<?php echo $this->_tpl_vars['tournament']['LOCATION']; ?>
" size="40"></td>
	    </tr>
	    <tr>
	        <td>Date From</td>
	        <td><?php echo smarty_function_html_select_date(array('prefix' => 'From_','time' => $this->_tpl_vars['tournament']['DATE_FROM'],'end_year' => '+1','field_order' => 'DMY'), $this);?>
</td>
	    </tr>	    
	    <tr>
	        <td>Date To</td>
	        <td><?php echo smarty_function_html_select_date(array('prefix' => 'To_','time' => $this->_tpl_vars['tournament']['DATE_TO'],'end_year' => '+1','field_order' => 'DMY'), $this);?>
 </td>
	    </tr>
	    <tr>
	        <td>Due Date</td>
	        <td><?php echo smarty_function_html_select_date(array('prefix' => 'DueDate_','time' => $this->_tpl_vars['tournament']['DUE_DATE'],'end_year' => '+1','field_order' => 'DMY'), $this);?>
</td>
	    </tr>	    
	    <tr>
	        <td>Allow Managers To Edit</td>
	        <td><input type="checkbox" name="Allow_Managers_To_Edit" <?php if ($this->_tpl_vars['tournament']['ALLOW_MANAGERS_TO_EDIT']): ?> checked <?php endif; ?>></td>
	    </tr>	  
	    <tr>
	        <td>Make the Draws Public?</td>
	        <td><input type="checkbox" name="Draws_Public" <?php if ($this->_tpl_vars['tournament']['DRAWS_PUBLIC']): ?> checked <?php endif; ?>></td>
	    </tr>		      
	    <tr>
	        <td>Active</td>
	        <td><?php echo $this->_tpl_vars['tournament']['ACTIVE']; ?>
</td>
	    </tr>	    
	    <tr>
	        <td>Events</td>
	        <td><?php echo smarty_function_html_options(array('name' => "Events[]",'size' => 10,'multiple' => true,'options' => $this->_tpl_vars['events_list'],'selected' => $this->_tpl_vars['events_selection']), $this);?>
</td>
	    </tr>
	    <tr>
	        <td>Payment</td>
	        <td><?php echo smarty_function_html_options(array('name' => 'Payment','size' => 1,'options' => $this->_tpl_vars['payment_list'],'selected' => $this->_tpl_vars['payment_selection']), $this);?>
</td>
  	    </tr>
 	    <tr>
	        <td>Schedule (html)</td>
	        <td><textarea cols="60" rows="10" name="Schedule_HTML"><?php echo $this->_tpl_vars['tournament']['SCHEDULE_HTML']; ?>
</textarea></td>
	    </tr> 	
 	    <tr>
	        <td>Participation Signature (html)</td>
	        <td><textarea cols="60" rows="10" name="Participation_Signature_HTML"><?php echo $this->_tpl_vars['tournament']['PARTICIPATION_SIGNATURE_HTML']; ?>
</textarea></td>
	    </tr> 		    
 	    <tr>
	        <td>Tournament Form (pdf)</td>
	        <td><input type="text" name="Tournament_Form_PDF" value="<?php echo $this->_tpl_vars['tournament']['TOURNAMENT_FORM_PDF']; ?>
" size="70"></td>
	    </tr> 	      
 	    <tr>
	        <td>Logo Image Name</td>
	        <td><input type="text" name="Logo_Name" value="<?php echo $this->_tpl_vars['tournament']['LOGO_NAME']; ?>
" size="40"></td>
	    </tr> 	 	      	    	    
	    <tr>
	        <td>Last Updated</td>
	        <td><?php echo $this->_tpl_vars['tournament']['LAST_UPDATED']; ?>
</td>
	    </tr>	    	    	    
	    <tr>
	        <td colspan="2" align="center"><input type="submit" value="Submit" name="Submit" onClick="document.pressed=this.value">&nbsp;&nbsp;<input type="submit" value="Delete" name="Delete" onClick="document.pressed=this.value"></td>
	    </tr>

</form>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</body>
