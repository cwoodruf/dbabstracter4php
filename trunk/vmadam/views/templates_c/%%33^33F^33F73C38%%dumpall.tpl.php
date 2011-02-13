<?php /* Smarty version 2.6.26, created on 2011-02-02 03:58:44
         compiled from tools/dumpall.tpl */ ?>
<?php if (! isset ( $this->_tpl_vars['dumptpl'] )): ?>
	<?php $this->assign('dumptpl', "tools/dump.tpl"); ?>
<?php endif; ?>

<table cellpadding="5" cellspacing="0" border="0" class="<?php echo $this->_tpl_vars['class']; ?>
">

<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['num'] => $this->_tpl_vars['data']):
?>
<tr><td>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['dumptpl'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</td></tr>
<?php endforeach; else: ?>
<tr><td>No records</td></tr>

<?php endif; unset($_from); ?>

</table>
