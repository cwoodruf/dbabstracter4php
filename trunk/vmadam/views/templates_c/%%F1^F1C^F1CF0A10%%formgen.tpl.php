<?php /* Smarty version 2.6.26, created on 2011-02-02 01:10:32
         compiled from tools/formgen.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'schema', 'tools/formgen.tpl', 12, false),array('modifier', 'htmlentities', 'tools/formgen.tpl', 51, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['schema'] ) && isset ( $this->_tpl_vars['this']->schema )): ?>
	<?php $this->assign('schema', $this->_tpl_vars['this']->schema); ?>
<?php endif; ?>
<?php if (! isset ( $this->_tpl_vars['input'] ) && isset ( $this->_tpl_vars['this']->input )): ?>
	<?php $this->assign('input', $this->_tpl_vars['this']->input); ?>
<?php endif; ?>
<?php echo smarty_function_schema(array('schema' => $this->_tpl_vars['schema']), $this);?>

<form id="formgen" action="<?php echo $_SERVER['PHP_SELF']; ?>
" method="post">
<table cellspacing="0" cellpadding="5" border="0" class="formgen">
<tr class="formgen formbuttons">
<td class="formgen formbuttons">
<input type="reset" value="reset" />
</td>
<td class="formgen formbuttons" align="right">

<input type="hidden" name="action[]" value="<?php echo $this->_tpl_vars['this']->controller; ?>
" />

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "tools/hiddenfields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<input type="submit" name="action[]" value="save" />

</td>
</tr>

<?php $_from = $this->_tpl_vars['schema']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field'] => $this->_tpl_vars['fdata']):
?>

<?php if ($this->_tpl_vars['fdata']['hide']): ?><?php continue; ?><?php endif; ?>

<tr class="formgen" valign="top">
<td class="formgen"><b><?php echo $this->_tpl_vars['field']; ?>
</b></td>
<td class="formgen">
<?php $this->assign('value', $this->_tpl_vars['input'][$this->_tpl_vars['field']]); ?>

<?php if ($this->_tpl_vars['fdata']['auto']): ?>
 <?php if (isset ( $this->_tpl_vars['value'] )): ?>
  <?php echo $this->_tpl_vars['value']; ?>

  <input type="hidden" name="<?php echo $this->_tpl_vars['field']; ?>
" value="<?php echo $this->_tpl_vars['value']; ?>
">
 <?php else: ?>
  <i><?php echo $this->_tpl_vars['fdata']['alt']; ?>
</i>
 <?php endif; ?>
&nbsp;
<?php continue; ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['fdata']['static']): ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['value'])) ? $this->_run_mod_handler('htmlentities', true, $_tmp) : htmlentities($_tmp)); ?>

<?php continue; ?>
<?php endif; ?>


<?php if ($this->_tpl_vars['fdata']['plugin']): ?>
<?php echo $this->_tpl_vars['fdata']['plugin']; ?>


<?php elseif ($this->_tpl_vars['fdata']['template']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['fdata']['template'], 'smarty_include_vars' => array('field' => $this->_tpl_vars['field'],'data' => $this->_tpl_vars['fdata'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php elseif ($this->_tpl_vars['fdata']['type'] == 'text'): ?>
<textarea name="<?php echo $this->_tpl_vars['field']; ?>
" rows="<?php echo $this->_tpl_vars['fdata']['rows']; ?>
" cols="<?php echo $this->_tpl_vars['fdata']['cols']; ?>
"><?php echo $this->_tpl_vars['value']; ?>
</textarea>

<?php elseif ($this->_tpl_vars['fdata']['type'] == 'varchar'): ?>
<input name="<?php echo $this->_tpl_vars['field']; ?>
" size="<?php echo $this->_tpl_vars['fdata']['size']; ?>
" value="<?php echo $this->_tpl_vars['value']; ?>
" /> 

<?php elseif ($this->_tpl_vars['fdata']['type'] == 'enum' && is_array ( $this->_tpl_vars['fdata']['opts'] )): ?>
<select name="<?php echo $this->_tpl_vars['field']; ?>
"><option></option>
<?php $_from = $this->_tpl_vars['fdata']['opts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['option']):
?>
	<?php if ($this->_tpl_vars['option'] == $this->_tpl_vars['value']): ?><?php $this->assign('selected', 'selected'); ?><?php else: ?><?php $this->assign('selected', ''); ?><?php endif; ?>
<option value="<?php echo $this->_tpl_vars['option']; ?>
" <?php echo $this->_tpl_vars['selected']; ?>
><?php echo $this->_tpl_vars['option']; ?>
</option>
<?php endforeach; endif; unset($_from); ?>
</select>

<?php elseif ($this->_tpl_vars['fdata']['type'] == 'select' && $this->_tpl_vars['fdata']['options']): ?>
<select name="<?php echo $this->_tpl_vars['field']; ?>
"><option></option>
<?php echo $this->_tpl_vars['fdata']['options']; ?>

</select>

<?php elseif ($this->_tpl_vars['fdata']['type'] == 'password'): ?>
<input type="password" name="<?php echo $this->_tpl_vars['field']; ?>
" size="<?php echo $this->_tpl_vars['fdata']['size']; ?>
" value="<?php echo $this->_tpl_vars['value']; ?>
" /> 

<?php elseif ($this->_tpl_vars['fdata']['type'] == 'hidden'): ?>
<input type="hidden" name="<?php echo $this->_tpl_vars['field']; ?>
" value="<?php echo $this->_tpl_vars['value']; ?>
" />

<?php else: ?>
<input name="<?php echo $this->_tpl_vars['field']; ?>
" value="<?php echo $this->_tpl_vars['value']; ?>
" /> 
	
<?php endif; ?>

</td>
</tr>

<?php endforeach; endif; unset($_from); ?>

</table>
</form>