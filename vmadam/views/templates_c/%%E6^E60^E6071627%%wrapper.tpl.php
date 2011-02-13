<?php /* Smarty version 2.6.26, created on 2011-02-05 11:20:12
         compiled from wrapper.tpl */ ?>
<html>
<head>
<title>In Touch Demo</title>
<?php echo $this->_tpl_vars['this']->css(); ?>

<?php echo $this->_tpl_vars['this']->js(); ?>

</head>
<body>
<h2>In Touch Demo</h2>
<div class="phonesubtitle">Test call in #: 778 374 0308 (Security code 7478)</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="error"><?php echo $this->_tpl_vars['error']; ?>
</div>
<div class="results"><?php echo $this->_tpl_vars['results']; ?>
</div>
<?php echo $this->_tpl_vars['content']; ?>

</body>
</html>