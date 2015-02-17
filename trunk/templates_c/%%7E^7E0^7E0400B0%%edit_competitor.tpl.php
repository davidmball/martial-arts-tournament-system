<?php /* Smarty version 2.6.20, created on 2010-04-11 17:38:06
         compiled from edit_competitor.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'edit_competitor.tpl', 1, false),array('function', 'html_select_date', 'edit_competitor.tpl', 76, false),array('function', 'html_options', 'edit_competitor.tpl', 88, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => "test.conf",'section' => 'setup'), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="main_pane">

<h1>Edit Competitor</h1>

<?php if ($this->_tpl_vars['access_denied']): ?>
	Access Denied: <?php echo $this->_tpl_vars['access_denied']; ?>

<?php else: ?>

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
	
	
	
	<?php if ($this->_tpl_vars['delete_success']): ?>
	
	<?php else: ?>
	<form action="<?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>
" method="post" enctype="multipart/form-data">
		
		<table border="1">
			<tr>
		        <td>ID</td>
		        <td><?php echo $this->_tpl_vars['competitor']['ID']; ?>
<input type="hidden" name="ID" value="<?php echo $this->_tpl_vars['competitor']['ID']; ?>
"></td>
		    </tr>
		    <tr>
		        <?php if ($this->_tpl_vars['user_access'] == 'admin'): ?>
		        <td>Enrolment State</td>
		        <td><select name="Enrolment">
		        	<option value="Registered" <?php if ($this->_tpl_vars['competitor']['ENROLMENT'] == 'Registered'): ?> selected="selected"<?php endif; ?>>Registered</option>
		        	<option value="Signed_In" <?php if ($this->_tpl_vars['competitor']['ENROLMENT'] == 'Signed_In'): ?> selected="selected"<?php endif; ?>>Signed In</option>
		        	<option value="Scratched" <?php if ($this->_tpl_vars['competitor']['ENROLMENT'] == 'Scratched'): ?> selected="selected"<?php endif; ?>>Scratched</option>	        	
		        	<option value="Diqualified" <?php if ($this->_tpl_vars['competitor']['ENROLMENT'] == 'Disqualified'): ?> selected="selected"<?php endif; ?>>Disqualified</option>	        	
		        	</select>
		        <?php else: ?>
		        <td>Enrolment State</td>
		        <td><input type="hidden" name="Enrolment" value="<?php echo $this->_tpl_vars['competitor']['ENROLMENT']; ?>
"><?php echo $this->_tpl_vars['competitor']['ENROLMENT']; ?>
</td>
		        <?php endif; ?>
		    </tr>		    
		   <tr>
		        <td>Title</td>
		        <td><input type="text" name="Title" value="<?php echo $this->_tpl_vars['competitor']['TITLE']; ?>
" size="10"></td>
		    </tr>	    
		   <tr>
		        <td>First Name</td>
		        <td><input type="text" name="First Name" value="<?php echo $this->_tpl_vars['competitor']['FIRST_NAME']; ?>
" size="40"></td>
		    </tr>
		    <tr>
		        <td>Middle Name</td>
		        <td><input type="text" name="Middle Name" value="<?php echo $this->_tpl_vars['competitor']['MIDDLE_NAME']; ?>
" size="40"></td>
		    </tr>
		    <tr>
		        <td>Last Name</td>
		        <td><input type="text" name="Last Name" value="<?php echo $this->_tpl_vars['competitor']['LAST_NAME']; ?>
" size="40"></td>
		    </tr>
		    <tr>
		        <td>Date of Birth</td>
		        <td><?php echo smarty_function_html_select_date(array('prefix' => 'DOB_','time' => $this->_tpl_vars['competitor']['DOB'],'start_year' => $this->_tpl_vars['DOB_start'],'end_year' => $this->_tpl_vars['DOB_end'],'field_order' => 'DMY'), $this);?>
</td>
		    </tr>
		    <tr>
		        <td>Weight (kg)</td>
		        <td><input type="text" name="Weight" value="<?php echo $this->_tpl_vars['competitor']['WEIGHT']; ?>
" size="40"></td>
		    </tr>    
		    <tr>
		        <td>Height (cm)</td>
		        <td><input type="text" name="Height" value="<?php echo $this->_tpl_vars['competitor']['HEIGHT']; ?>
" size="40"></td>
		    </tr>	    
		    <tr>
		        <td>Rank</td>
		        <td><?php echo smarty_function_html_options(array('name' => 'Rank','size' => 1,'options' => $this->_tpl_vars['rank_list'],'selected' => $this->_tpl_vars['rank_selection']), $this);?>
</td>
	  	    </tr>
		    <tr>
		        <td>Represents</td>
		        <td><?php echo smarty_function_html_options(array('name' => 'Represents','size' => 1,'options' => $this->_tpl_vars['represents_list'],'selected' => $this->_tpl_vars['represents_selection']), $this);?>
</td>
	  	    </tr>  	        	 
		    <tr>
		        <td>Phone</td>
		        <td><input type="text" name="Phone" value="<?php echo $this->_tpl_vars['competitor']['PHONE']; ?>
" size="40"></td>
		    </tr>
		    <tr>
		        <td>Gender</td>
		        <td><select name="Gender"><option value="Male" <?php if ($this->_tpl_vars['competitor']['GENDER'] == 'Male'): ?> selected="selected"<?php endif; ?>>Male</option>
		        			<option value="Female" <?php if ($this->_tpl_vars['competitor']['GENDER'] == 'Female'): ?> selected="selected"<?php endif; ?>>Female</option></select>
		        </td>
		    </tr>
		    <tr>
		        <td>Red Card (Bai Rui Only)</td>
		        <td><input type="text" name="RedCard" value="<?php echo $this->_tpl_vars['competitor']['RED_CARD']; ?>
" size="40"></td>
		    </tr>	    
		    <tr>
		        <td>Comments</td>
		        <td><textarea cols="50" rows="4" name="Comments"><?php echo $this->_tpl_vars['competitor']['COMMENTS']; ?>
</textarea></td>
		    </tr>
		    <tr>
		        <td>Events</br>(Hold down CTRL to </br>select multiple events.)</td>
		        <td><?php echo smarty_function_html_options(array('name' => "Events[]",'size' => 6,'multiple' => true,'options' => $this->_tpl_vars['events_list'],'selected' => $this->_tpl_vars['events_selection']), $this);?>
</td>
		    </tr>
		    <tr>
		        <td>Team Events</br>(These are set by </br>adding the competitor to a team.)</td>
		        <td><?php echo smarty_function_html_options(array('name' => "Team_Events[]",'size' => 6,'multiple' => true,'options' => $this->_tpl_vars['team_events_list'],'selected' => $this->_tpl_vars['events_selection'],'disabled' => true), $this);?>
</td>
		    </tr>	    	
		    <tr>
		        <td>Amount Owed ($) (incl GST)</td>
		        <td><?php echo $this->_tpl_vars['competitor']['OWED_AMOUNT']; ?>
</td>
		    </tr>
		    <tr>
		        <td>Amount Paid ($) (incl GST)</td>
		        <td><?php if ($this->_tpl_vars['user_access'] == 'admin'): ?> <input type="text" name="Paid_Amount" value="<?php echo $this->_tpl_vars['competitor']['PAID_AMOUNT']; ?>
" size="10"><?php else: ?> <?php echo $this->_tpl_vars['competitor']['PAID_AMOUNT']; ?>
<input type="hidden" name="Paid_Amount" value="<?php echo $this->_tpl_vars['competitor']['PAID_AMOUNT']; ?>
"> <?php endif; ?></td>
		    </tr>	    
		    <tr>
		        <td>Last Updated</td>
		        <td><?php echo $this->_tpl_vars['competitor']['LAST_UPDATED']; ?>
</td>
		    </tr>	    	    	    
		    <tr>
		        <td colspan="2" align="center"><input type="submit" value="Submit" name="Submit">&nbsp;&nbsp;<input type="submit" value="Delete" name="Delete">&nbsp;&nbsp;or <a href="edit_competitor.php?ID=new">Add New Competitor</a></td>
		    </tr>
	
	</form>
	<?php endif; ?>

<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</body>
