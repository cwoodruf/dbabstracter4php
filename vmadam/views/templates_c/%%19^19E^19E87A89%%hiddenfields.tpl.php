<?php /* Smarty version 2.6.26, created on 2011-02-02 01:09:20
         compiled from tools/hiddenfields.tpl */ ?>

<?php $_from = $this->_tpl_vars['this']->hidden; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field'] => $this->_tpl_vars['value']):
?>
<input type=hidden name="<?php echo $this->_tpl_vars['field']; ?>
" value="<?php echo $this->_tpl_vars['value']; ?>
">
<?php endforeach; endif; unset($_from); ?>
