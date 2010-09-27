<?php /* Smarty version 2.6.26, created on 2010-09-26 23:13:49
         compiled from top.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "xmljunk.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<head>
<title><?php echo $this->_tpl_vars['this']->name; ?>
</title>
<?php echo $this->_tpl_vars['this']->css(); ?>

<?php echo $this->_tpl_vars['this']->js(); ?>

</head>
<body>

<div class="toplevel">
<h3>Example site</h3>

<?php if ($this->_tpl_vars['errors']): ?>
errors:
<h3 class="errors"><?php echo $this->_tpl_vars['errors']; ?>
</h3>
<?php endif; ?>

<?php if ($this->_tpl_vars['topmsg']): ?>
<h3 class="topmsg"><?php echo $this->_tpl_vars['topmsg']; ?>
</h3>
<?php endif; ?>
