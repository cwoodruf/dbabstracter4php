<?php /* Smarty version 2.6.26, created on 2011-02-02 01:06:37
         compiled from tools/dump.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlentities', 'tools/dump.tpl', 7, false),)), $this); ?>
<table cellpadding="5" cellspacing="0" border="0" class="dump <?php echo $this->_tpl_vars['class']; ?>
">

<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field'] => $this->_tpl_vars['value']):
?>

<tr valign="top">
<td>
<b><?php echo htmlentities($this->_tpl_vars['field']); ?>
</b>
</td>
<td>
<?php echo htmlentities($this->_tpl_vars['value']); ?>

</td>
</tr>

<?php endforeach; endif; unset($_from); ?>

</table>

<?php if ($this->_tpl_vars['form']): ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['form'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php endif; ?>