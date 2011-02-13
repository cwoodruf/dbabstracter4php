<?php /* Smarty version 2.6.26, created on 2011-02-02 23:53:53
         compiled from profile.tpl */ ?>
<?php if ($this->_tpl_vars['this']->input('id') != null): ?>
<a href="?action=profile/show&clientid=<?php echo $this->_tpl_vars['this']->input('id'); ?>
">View Profile</a>
<br>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "tools/formgen.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>