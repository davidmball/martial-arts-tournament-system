<?php /* Smarty version 2.6.20, created on 2009-10-23 23:20:46
         compiled from divisions.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'divisions.tpl', 16, false),array('function', 'column', 'divisions.tpl', 167, false),array('block', 'datatable', 'divisions.tpl', 166, false),array('modifier', 'date_format', 'divisions.tpl', 238, false),)), $this); ?>
<?php echo '
<style type="text/css" media="print">
	#header_pane {
		display: none;
	}
	#main_pane {
 		top: 0px;
 	}
 	#login_pane {
 		display: none;
 	}
</style>
'; ?>



<?php echo smarty_function_config_load(array('file' => "test.conf"), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['user_access'] != 'admin' && ! $this->_tpl_vars['active_tournament']['DRAWS_PUBLIC']): ?>

<p>
The draws are not available at this time.
</p>

<?php elseif ($this->_tpl_vars['user_access'] == 'admin' && $this->_tpl_vars['display_type'] == 'interactive'): ?>

<form id="division_form" name="division_form" action="<?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>
" method="post" enctype="multipart/form-data">
<input type="hidden" name="EVENT_SELECTED" value="<?php echo $this->_tpl_vars['current_event_selected']; ?>
">
</form>

<?php echo '
<script type="text/javascript">
function event_clicked(id, event) {
	var x = document.getElementById("division_form");
	window.document.division_form.EVENT_SELECTED.value = event;
	x.submit();
}	

var competitor_selected_array = new Array();
var num_entries = 0;

function competitor_clicked(competitor_id) {
	
	// don\'t try and work on delselections here, just add them all to the list
	num_entries = competitor_selected_array.push(competitor_id);
	
	//window.document.division_form.competitor_ids_clicked = 2;
	//alert(competitor_id);
	
}

function grab_clicked(division_id )
{

	// decodes whether a competitor is selected or not
	// this needs to be done because as the user clicks the competitors_id are just added to a list
	// ie they are not removed as the user deselects them. There might be way of doing it properly as the
	// user clicks....
	var competitor_selected_confirmed = new Array();
	var i = 0;
	var already_confirmed;
	var selected;
	var num_confirmed;
	for (i = 0; i < num_entries; i++) {
		selected = 0;
		already_confirmed = 0;
		for (k = 0; k < num_confirmed; k++) {
			if (competitor_selected_confirmed[k] == competitor_selected_array[i])
				already_confirmed = 1;
		}		
		//selected = 1;
		if (already_confirmed == 0) {
			for (j = 0; j < num_entries; j++) {
				
				if (competitor_selected_array[i] == competitor_selected_array[j]) {
					if (selected) {
						selected = 0;
					} else {			
						selected = 1;
					}
				}
			}
		}
		if (selected)
			num_confirmed = competitor_selected_confirmed.push(competitor_selected_array[i]);
	}
	var x = document.getElementById("division_form");
	
	
	document.write(\'<form id="competitor_selected_form" name="competitor_selected_form" action="divisions.php" method="post" enctype="multipart/form-data">\');
	document.write(\'<input type="hidden" name="EVENT_SELECTED" value="'; ?>
<?php echo $this->_tpl_vars['current_event_selected']; ?>
<?php echo '"/>\');
	document.write(\'<input type="hidden" name="DIVISION_SELECTED" value="\'+division_id+\'"/>\');
	document.write(\'<select id="blah" name="competitor_ids_clicked[]" multiple style="display:none">\');
	for (i = 0; i < num_confirmed; i++) {
		document.write(\'<option label="fred" value="\'+competitor_selected_confirmed[i]+\'" selected="selected"></option>\');
	}
	document.write(\'</select>\');
	document.write(\'</form>\');

 	var x = document.getElementById("competitor_selected_form");
	x.submit();
 
}

function sort_selected(division_id)
{
	// decodes whether a competitor is selected or not
	// note that this doesn\'t quite work where a competitor is clicked 3, 5, 7... times amongst other competitors
	// being clicked. This is because the competitor is checked int he order of the inital clicks.
	// not that deselecting will still work though.
	var competitor_selected_confirmed = new Array();
	var i = 0;
	var already_confirmed;
	var selected;
	var num_confirmed;
	for (i = 0; i < num_entries; i++) {
		selected = 0;
		already_confirmed = 0;
		for (k = 0; k < num_confirmed; k++) {
			if (competitor_selected_confirmed[k] == competitor_selected_array[i])
				already_confirmed = 1;
		}		
		//selected = 1;
		if (already_confirmed == 0) {
			for (j = 0; j < num_entries; j++) {
				
				if (competitor_selected_array[i] == competitor_selected_array[j]) {
					if (selected) {
						selected = 0;
					} else {			
						selected = 1;
					}
				}
			}
		}
		if (selected)
			num_confirmed = competitor_selected_confirmed.push(competitor_selected_array[i]);
	}
	
	document.write(\'<form id="competitor_sort_form" name="competitor_sort_form" action="divisions.php" method="post" enctype="multipart/form-data">\');
	document.write(\'<input type="hidden" name="EVENT_SELECTED" value="'; ?>
<?php echo $this->_tpl_vars['current_event_selected']; ?>
<?php echo '"/>\');
	document.write(\'<input type="hidden" name="SORT_SELECTED" value="1"/>\');
	document.write(\'<input type="hidden" name="DIVISION_SELECTED" value="\'+division_id+\'"/>\');
	document.write(\'<select id="blah" name="competitor_ids_clicked[]" multiple style="display:none">\');
	for (i = 0; i < num_confirmed; i++) {
		document.write(\'<option label="fred" value="\'+competitor_selected_confirmed[i]+\'" selected="selected"></option>\');
	}
	document.write(\'</select>\');
	document.write(\'</form>\');

 	var x = document.getElementById("competitor_sort_form");
	x.submit();

}
</script>
'; ?>




<div id="main_pane">
<table cols="2" width="100%">
<tr valign="top">
<td width="50%">

<div class="unassigned_div">
 <?php $this->_tag_stack[] = array('datatable', array('data' => $this->_tpl_vars['unassigned_list'],'cycle' => 1,'mouseover' => 1,'width' => "100%",'id' => 'unassigned_class','class' => 'unassigned_class','row_onClick' => "event_clicked( \$__rowidx, \$EVENT_ID)")); $_block_repeat=true;smarty_block_datatable($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <?php echo smarty_function_column(array('id' => 'EVENT','name' => 'Event','align' => 'centre'), $this);?>

  <?php echo smarty_function_column(array('id' => 'EVENT_ENROLMENT_COUNT','name' => "Still to Sign-In",'align' => 'center','sorttype' => 'Numerical'), $this);?>

  <?php echo smarty_function_column(array('id' => 'COMPETITOR_COUNT','name' => 'Unassigned','align' => 'center','sorttype' => 'Numerical'), $this);?>

  <?php echo smarty_function_column(array('id' => 'TOTAL_COUNT','name' => 'Total','align' => 'center','sorttype' => 'Numerical'), $this);?>

 <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_datatable($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>

<div class="divisions_only">
 <?php $this->_tag_stack[] = array('datatable', array('data' => $this->_tpl_vars['division_list'],'sortable' => 1,'cycle' => 1,'mouseover' => 1,'width' => "100%",'id' => 'divisions_only_class','class' => 'divisions_only_class')); $_block_repeat=true;smarty_block_datatable($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
  <?php echo smarty_function_column(array('id' => 'EVENT','name' => 'Event'), $this);?>

  <?php echo smarty_function_column(array('id' => 'DIVISION','name' => 'Division'), $this);?>

  <?php echo smarty_function_column(array('id' => 'SECTION_NAME','name' => 'Section'), $this);?>

  <?php echo smarty_function_column(array('id' => 'ENROLMENT_COUNT','name' => "Still to Sign-In",'align' => 'center','sorttype' => 'Numerical'), $this);?>
 
  <?php echo smarty_function_column(array('id' => 'COMPETITOR_COUNT','name' => 'Total Count','align' => 'center','sorttype' => 'Numerical'), $this);?>

 <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_datatable($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</div>

<div class="divisions_left">
	
<?php unset($this->_sections['division']);
$this->_sections['division']['name'] = 'division';
$this->_sections['division']['loop'] = is_array($_loop=$this->_tpl_vars['division_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['division']['show'] = true;
$this->_sections['division']['max'] = $this->_sections['division']['loop'];
$this->_sections['division']['step'] = 1;
$this->_sections['division']['start'] = $this->_sections['division']['step'] > 0 ? 0 : $this->_sections['division']['loop']-1;
if ($this->_sections['division']['show']) {
    $this->_sections['division']['total'] = $this->_sections['division']['loop'];
    if ($this->_sections['division']['total'] == 0)
        $this->_sections['division']['show'] = false;
} else
    $this->_sections['division']['total'] = 0;
if ($this->_sections['division']['show']):

            for ($this->_sections['division']['index'] = $this->_sections['division']['start'], $this->_sections['division']['iteration'] = 1;
                 $this->_sections['division']['iteration'] <= $this->_sections['division']['total'];
                 $this->_sections['division']['index'] += $this->_sections['division']['step'], $this->_sections['division']['iteration']++):
$this->_sections['division']['rownum'] = $this->_sections['division']['iteration'];
$this->_sections['division']['index_prev'] = $this->_sections['division']['index'] - $this->_sections['division']['step'];
$this->_sections['division']['index_next'] = $this->_sections['division']['index'] + $this->_sections['division']['step'];
$this->_sections['division']['first']      = ($this->_sections['division']['iteration'] == 1);
$this->_sections['division']['last']       = ($this->_sections['division']['iteration'] == $this->_sections['division']['total']);
?>
<!--	<?php echo $this->_tpl_vars['competitor_division_starts'][$this->_sections['division']['index']]; ?>
 <?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['COMPETITOR_COUNT']; ?>
 -->
	 <?php $this->assign('table_name', $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION_ID']); ?>
	<button type="button" name="show" value=<?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION_ID']; ?>
 onClick="grab_clicked(this.value)">Grab Selected</button> <button type="button" name="show" value=<?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION_ID']; ?>
 onClick="sort_selected(this.value)">Sort</button> <?php if ($this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION_ID'] != 0): ?><a href="division_draw.php?DIVISION_ID=<?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION_ID']; ?>
"><?php endif; ?><?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION']; ?>
</a> (<?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['COMPETITOR_COUNT']; ?>
) "<?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION_TYPE']; ?>
"
	 <?php $this->_tag_stack[] = array('datatable', array('data' => $this->_tpl_vars['competitor_list'],'start' => $this->_tpl_vars['competitor_division_starts'][$this->_sections['division']['index']],'loops' => $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['COMPETITOR_COUNT'],'sortable' => 1,'cycle' => 1,'mouseover' => 1,'selectable' => 2,'width' => "100%",'id' => $this->_tpl_vars['table_name'],'class' => $this->_tpl_vars['table_name'],'row_onClick' => "competitor_clicked(\$ID)")); $_block_repeat=true;smarty_block_datatable($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>	  
	  <?php echo smarty_function_column(array('id' => 'ENROLMENT','name' => 'E'), $this);?>

	  <?php echo smarty_function_column(array('id' => 'FIRST_NAME','name' => 'First Name'), $this);?>

	  <?php echo smarty_function_column(array('id' => 'LAST_NAME','name' => 'Last Name'), $this);?>

	  <?php echo smarty_function_column(array('id' => 'GENDER','name' => "M/F",'align' => 'center'), $this);?>

	  <?php echo smarty_function_column(array('id' => 'AGE','name' => 'Age','align' => 'center','sorttype' => 'Numerical'), $this);?>

	  <?php echo smarty_function_column(array('id' => 'RANK','name' => 'Rank','align' => 'center','sorttype' => 'Numerical'), $this);?>

	  <?php echo smarty_function_column(array('id' => 'WEIGHT','name' => 'Weight','align' => 'center','sorttype' => 'Numerical'), $this);?>

	  <?php echo smarty_function_column(array('id' => 'HEIGHT','name' => 'Height','align' => 'center','sorttype' => 'Numerical'), $this);?>
 
  	  <?php echo smarty_function_column(array('id' => 'REPRESENTS','name' => 'Represents'), $this);?>
  
  	  <?php echo smarty_function_column(array('id' => 'COMMENTS','name' => "!"), $this);?>
    
	 <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_datatable($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<?php endfor; endif; ?>
</div>

</td>
<td width="50%">

<div class="divisions_right">
		
<?php unset($this->_sections['division']);
$this->_sections['division']['name'] = 'division';
$this->_sections['division']['loop'] = is_array($_loop=$this->_tpl_vars['division_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['division']['show'] = true;
$this->_sections['division']['max'] = $this->_sections['division']['loop'];
$this->_sections['division']['step'] = 1;
$this->_sections['division']['start'] = $this->_sections['division']['step'] > 0 ? 0 : $this->_sections['division']['loop']-1;
if ($this->_sections['division']['show']) {
    $this->_sections['division']['total'] = $this->_sections['division']['loop'];
    if ($this->_sections['division']['total'] == 0)
        $this->_sections['division']['show'] = false;
} else
    $this->_sections['division']['total'] = 0;
if ($this->_sections['division']['show']):

            for ($this->_sections['division']['index'] = $this->_sections['division']['start'], $this->_sections['division']['iteration'] = 1;
                 $this->_sections['division']['iteration'] <= $this->_sections['division']['total'];
                 $this->_sections['division']['index'] += $this->_sections['division']['step'], $this->_sections['division']['iteration']++):
$this->_sections['division']['rownum'] = $this->_sections['division']['iteration'];
$this->_sections['division']['index_prev'] = $this->_sections['division']['index'] - $this->_sections['division']['step'];
$this->_sections['division']['index_next'] = $this->_sections['division']['index'] + $this->_sections['division']['step'];
$this->_sections['division']['first']      = ($this->_sections['division']['iteration'] == 1);
$this->_sections['division']['last']       = ($this->_sections['division']['iteration'] == $this->_sections['division']['total']);
?>
	
	 <?php $this->assign('table_name', $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION_ID']+10000); ?>
	<!-- <button type="button" name="show" value=<?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION_ID']; ?>
 onClick="grab_clicked(this.value)">Grab All</button> --> <?php if ($this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION_ID'] != 0): ?><a href="division_draw.php?DIVISION_ID=<?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION_ID']; ?>
"><?php endif; ?><?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION']; ?>
</a> (<?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['COMPETITOR_COUNT']; ?>
) "<?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION_TYPE']; ?>
"
	 <?php $this->_tag_stack[] = array('datatable', array('data' => $this->_tpl_vars['competitor_list'],'start' => $this->_tpl_vars['competitor_division_starts'][$this->_sections['division']['index']],'loops' => $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['COMPETITOR_COUNT'],'sortable' => 1,'cycle' => 1,'mouseover' => 1,'selectable' => 2,'width' => "100%",'id' => $this->_tpl_vars['table_name'],'class' => $this->_tpl_vars['table_name'],'row_onClick' => "competitor_clicked(\$ID)")); $_block_repeat=true;smarty_block_datatable($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	  <?php echo smarty_function_column(array('id' => 'ENROLMENT','name' => 'E'), $this);?>

	  <?php echo smarty_function_column(array('id' => 'FIRST_NAME','name' => 'First Name'), $this);?>

	  <?php echo smarty_function_column(array('id' => 'LAST_NAME','name' => 'Last Name'), $this);?>

	  <?php echo smarty_function_column(array('id' => 'GENDER','name' => "M/F",'align' => 'center'), $this);?>

	  <?php echo smarty_function_column(array('id' => 'AGE','name' => 'Age','align' => 'center','sorttype' => 'Numerical'), $this);?>

	  <?php echo smarty_function_column(array('id' => 'RANK','name' => 'Rank','align' => 'center','sorttype' => 'Numerical'), $this);?>

	  <?php echo smarty_function_column(array('id' => 'WEIGHT','name' => 'Weight','align' => 'center','sorttype' => 'Numerical'), $this);?>

	  <?php echo smarty_function_column(array('id' => 'HEIGHT','name' => 'Height','align' => 'center','sorttype' => 'Numerical'), $this);?>

	  <?php echo smarty_function_column(array('id' => 'REPRESENTS','name' => 'Represents'), $this);?>

	  <?php echo smarty_function_column(array('id' => 'COMMENTS','name' => "!"), $this);?>
        
	 <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_datatable($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<?php endfor; endif; ?>
</div>

</td>

</tr>
</table>

<!-- for the stewards -->
<?php elseif ($this->_tpl_vars['user_access'] == 'steward'): ?>

<div id="main_pane">
<h1>Division List for: <?php echo $this->_tpl_vars['active_tournament']['NAME']; ?>
: <?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_FROM'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['date']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['date'])); ?>
<?php if ($this->_tpl_vars['active_tournament']['DATE_TO'] != $this->_tpl_vars['active_tournament']['DATE_FROM']): ?> - <?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_TO'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['date']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['date'])); ?>
<?php endif; ?></h1>
<h2>For Ring 2</h2>

 <table border="0">
  	<tr>
 		<th>		
 			ID		
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
 		<td>
 			<?php echo $this->_tpl_vars['divisions'][$this->_sections['division_list']['index']]['NAME']; ?>

 		</td>
 		<td  align="center">
 			<?php echo $this->_tpl_vars['divisions'][$this->_sections['division_list']['index']]['EVENT_NAME']; ?>

 		</td> 	
 		 <td align="center">
 			<?php echo $this->_tpl_vars['divisions'][$this->_sections['division_list']['index']]['SECTION_NAME']; ?>

 		</td> 			 			
 		<td>
			<a href="division_draw.php?DIVISION_ID=<?php echo $this->_tpl_vars['divisions'][$this->_sections['division_list']['index']]['ID']; ?>
">edit</a>
 		</td> 	
 	</tr>

 	 <?php endfor; endif; ?>
 </table>
</div>

<!-- for the public and managers -->
<?php else: ?>

<div id="main_pane">
<h1>Division List for: <?php echo $this->_tpl_vars['active_tournament']['NAME']; ?>
: <?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_FROM'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['date']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['date'])); ?>
<?php if ($this->_tpl_vars['active_tournament']['DATE_TO'] != $this->_tpl_vars['active_tournament']['DATE_FROM']): ?> - <?php echo ((is_array($_tmp=$this->_tpl_vars['active_tournament']['DATE_TO'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['date']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['date'])); ?>
<?php endif; ?></h1>

<?php if ($this->_tpl_vars['user_access'] != 'admin'): ?> 
<p>
Note that this division list is subject to change at any time!
</p>
<?php endif; ?>

<?php unset($this->_sections['division']);
$this->_sections['division']['name'] = 'division';
$this->_sections['division']['loop'] = is_array($_loop=$this->_tpl_vars['division_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['division']['show'] = true;
$this->_sections['division']['max'] = $this->_sections['division']['loop'];
$this->_sections['division']['step'] = 1;
$this->_sections['division']['start'] = $this->_sections['division']['step'] > 0 ? 0 : $this->_sections['division']['loop']-1;
if ($this->_sections['division']['show']) {
    $this->_sections['division']['total'] = $this->_sections['division']['loop'];
    if ($this->_sections['division']['total'] == 0)
        $this->_sections['division']['show'] = false;
} else
    $this->_sections['division']['total'] = 0;
if ($this->_sections['division']['show']):

            for ($this->_sections['division']['index'] = $this->_sections['division']['start'], $this->_sections['division']['iteration'] = 1;
                 $this->_sections['division']['iteration'] <= $this->_sections['division']['total'];
                 $this->_sections['division']['index'] += $this->_sections['division']['step'], $this->_sections['division']['iteration']++):
$this->_sections['division']['rownum'] = $this->_sections['division']['iteration'];
$this->_sections['division']['index_prev'] = $this->_sections['division']['index'] - $this->_sections['division']['step'];
$this->_sections['division']['index_next'] = $this->_sections['division']['index'] + $this->_sections['division']['step'];
$this->_sections['division']['first']      = ($this->_sections['division']['iteration'] == 1);
$this->_sections['division']['last']       = ($this->_sections['division']['iteration'] == $this->_sections['division']['total']);
?>

<br>
<strong><?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['SECTION_NAME']; ?>
 - <?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['EVENT']; ?>
 - <?php if ($this->_tpl_vars['division_list'][$this->_sections['division']['index']]['COMPETITOR_COUNT'] != 0): ?><a href="division_draw.php?DIVISION_ID=<?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION_ID']; ?>
"><?php endif; ?><?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['DIVISION']; ?>
</a> (<?php echo $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['COMPETITOR_COUNT']; ?>
)</strong>
 <table border="0" class="public_division" width="700px">
 <tr>
  <?php if (( $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['TEAM'] )): ?>
 		<th>
 			Team Name
 		</th>
 		<th>
 			Captain Name
 		</th>	
 		<th>
 			Represents
 		</th>	 			  
  <?php else: ?>

 		<th>
 			First Name
 		</th>
 		<th>
 			Last Name
 		</th>
 		<th>
 			Gender
 		</th>
 		<th>
 			Rank
 		</th>  		
 		<th>
 			Represents
 		</th> 
 		<?php if ($this->_tpl_vars['user_access'] == 'admin' && $this->_tpl_vars['type'] != 'BRIEF'): ?> 
 		<th>
 			Age
 		</th>
 		<th>
 			Height
 		</th>
 		<th>
 			Weight
 		</th> 		 		 		
 		<?php endif; ?>		
 
  <?php endif; ?>
   </tr>
   
 	<?php unset($this->_sections['competitor']);
$this->_sections['competitor']['name'] = 'competitor';
$this->_sections['competitor']['loop'] = is_array($_loop=$this->_tpl_vars['competitor_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['competitor']['start'] = (int)$this->_tpl_vars['competitor_division_starts'][$this->_sections['division']['index']];
$this->_sections['competitor']['max'] = (int)$this->_tpl_vars['competitor_division_count'][$this->_sections['division']['index']];
$this->_sections['competitor']['show'] = true;
if ($this->_sections['competitor']['max'] < 0)
    $this->_sections['competitor']['max'] = $this->_sections['competitor']['loop'];
$this->_sections['competitor']['step'] = 1;
if ($this->_sections['competitor']['start'] < 0)
    $this->_sections['competitor']['start'] = max($this->_sections['competitor']['step'] > 0 ? 0 : -1, $this->_sections['competitor']['loop'] + $this->_sections['competitor']['start']);
else
    $this->_sections['competitor']['start'] = min($this->_sections['competitor']['start'], $this->_sections['competitor']['step'] > 0 ? $this->_sections['competitor']['loop'] : $this->_sections['competitor']['loop']-1);
if ($this->_sections['competitor']['show']) {
    $this->_sections['competitor']['total'] = min(ceil(($this->_sections['competitor']['step'] > 0 ? $this->_sections['competitor']['loop'] - $this->_sections['competitor']['start'] : $this->_sections['competitor']['start']+1)/abs($this->_sections['competitor']['step'])), $this->_sections['competitor']['max']);
    if ($this->_sections['competitor']['total'] == 0)
        $this->_sections['competitor']['show'] = false;
} else
    $this->_sections['competitor']['total'] = 0;
if ($this->_sections['competitor']['show']):

            for ($this->_sections['competitor']['index'] = $this->_sections['competitor']['start'], $this->_sections['competitor']['iteration'] = 1;
                 $this->_sections['competitor']['iteration'] <= $this->_sections['competitor']['total'];
                 $this->_sections['competitor']['index'] += $this->_sections['competitor']['step'], $this->_sections['competitor']['iteration']++):
$this->_sections['competitor']['rownum'] = $this->_sections['competitor']['iteration'];
$this->_sections['competitor']['index_prev'] = $this->_sections['competitor']['index'] - $this->_sections['competitor']['step'];
$this->_sections['competitor']['index_next'] = $this->_sections['competitor']['index'] + $this->_sections['competitor']['step'];
$this->_sections['competitor']['first']      = ($this->_sections['competitor']['iteration'] == 1);
$this->_sections['competitor']['last']       = ($this->_sections['competitor']['iteration'] == $this->_sections['competitor']['total']);
?>
	<tr>
	  <?php if (( $this->_tpl_vars['division_list'][$this->_sections['division']['index']]['TEAM'] )): ?>

 		<td>		
 			<?php echo $this->_tpl_vars['competitor_list'][$this->_sections['competitor']['index']]['FIRST_NAME']; ?>
		
 		</td>
  		<td>		
 			<?php echo $this->_tpl_vars['competitor_list'][$this->_sections['competitor']['index']]['CAPTAIN_NAME']; ?>
		
 		</td>
   		<td>		
 			<?php echo $this->_tpl_vars['competitor_list'][$this->_sections['competitor']['index']]['REPRESENTS']; ?>
		
 		</td>				
	  <?php else: ?>
 		
 		<td>		
 			<?php echo $this->_tpl_vars['competitor_list'][$this->_sections['competitor']['index']]['FIRST_NAME']; ?>
		
 		</td>
 		<td>
 			<?php echo $this->_tpl_vars['competitor_list'][$this->_sections['competitor']['index']]['LAST_NAME']; ?>

 		</td>
  		<td>
 			<?php echo $this->_tpl_vars['competitor_list'][$this->_sections['competitor']['index']]['GENDER']; ?>

 		</td> 
 		 <td>
 			<?php echo $this->_tpl_vars['competitor_list'][$this->_sections['competitor']['index']]['RANK']; ?>

 		</td>		
  		<td>
 			<?php echo $this->_tpl_vars['competitor_list'][$this->_sections['competitor']['index']]['REPRESENTS']; ?>

 		</td>
 		<?php if ($this->_tpl_vars['user_access'] == 'admin' && $this->_tpl_vars['type'] != 'BRIEF'): ?> 
  		<td align="center">
 			<?php echo $this->_tpl_vars['competitor_list'][$this->_sections['competitor']['index']]['AGE']; ?>

 		</td>
 		<td align="center">
 			<?php echo $this->_tpl_vars['competitor_list'][$this->_sections['competitor']['index']]['HEIGHT']; ?>

 		</td>
 		 <td align="center">
 			<?php echo $this->_tpl_vars['competitor_list'][$this->_sections['competitor']['index']]['WEIGHT']; ?>

 		</td>
 		 		
 		<?php endif; ?> 	
 		
 	 	<?php endif; ?>			
 	  <?php endfor; endif; ?>	 	
 	
		
 	</tr>
 </table>
<?php endfor; endif; ?>

</div>

<?php endif; ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</div>