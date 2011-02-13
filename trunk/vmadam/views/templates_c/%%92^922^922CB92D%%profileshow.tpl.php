<?php /* Smarty version 2.6.26, created on 2011-02-05 11:34:34
         compiled from profileshow.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'phoneformat', 'profileshow.tpl', 24, false),array('modifier', 'regex_replace', 'profileshow.tpl', 25, false),array('modifier', 'default', 'profileshow.tpl', 28, false),array('function', 'splitmsg', 'profileshow.tpl', 46, false),)), $this); ?>
<div class="profile">
<h1>Profile for <?php echo $this->_tpl_vars['this']->input('name'); ?>
</h1>
<a href="?action=profile/edit&clientid=<?php echo $this->_tpl_vars['clientid']; ?>
">Edit Profile</a> &nbsp;&nbsp;
<a href="#phones">Phones</a> &nbsp;&nbsp;
<a href="#messages">Messages</a> &nbsp;&nbsp;
<br>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "tools/dump.tpl", 'smarty_include_vars' => array('data' => $this->_tpl_vars['this']->input)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>

<div class="profile phones">
<a name="phones"></a>
<h2>Phones</h2>
<form action="index.php#phones" method=post>
<input type="hidden" name="action[]" value="phone">
<input type="hidden" name="action[]" value="lend">
<input type="hidden" name="clientid" value="<?php echo $this->_tpl_vars['clientid']; ?>
">
Phone: 
<input size="32" maxlength="32" name="phone">
<input type="submit" value="lend phone">
</form>

<?php $_from = $this->_tpl_vars['phones']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['phone']):
?>
<div class="profile phone">
<?php echo ((is_array($_tmp=$this->_tpl_vars['phone']['phone'])) ? $this->_run_mod_handler('phoneformat', true, $_tmp) : smarty_modifier_phoneformat($_tmp)); ?>
 
<b>taken</b> <?php echo ((is_array($_tmp=$this->_tpl_vars['phone']['taken'])) ? $this->_run_mod_handler('regex_replace', true, $_tmp, "# .*#", "") : smarty_modifier_regex_replace($_tmp, "# .*#", "")); ?>
 
<b>returned</b> 
<?php if ($this->_tpl_vars['phone']['returned']): ?>
<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['phone']['returned'])) ? $this->_run_mod_handler('regex_replace', true, $_tmp, "# .*#", "") : smarty_modifier_regex_replace($_tmp, "# .*#", "")))) ? $this->_run_mod_handler('default', true, $_tmp, 'not returned') : smarty_modifier_default($_tmp, 'not returned')); ?>

<?php else: ?>
<a href="?action=phone/return&clientid=<?php echo $this->_tpl_vars['clientid']; ?>
&phone=<?php echo $this->_tpl_vars['phone']['phone']; ?>
">return phone</a>
<?php endif; ?>
</div>

<?php endforeach; else: ?>
<h3>No phones found</h3>

<?php endif; unset($_from); ?>

</div>

<div class="profile messages">
<a name="messages"></a>
<h2>Messages</h2>
<?php $_from = $this->_tpl_vars['messages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['message']):
?>

<?php echo smarty_function_splitmsg(array('msg' => $this->_tpl_vars['message']['filename']), $this);?>

<div class="profile message">
<?php echo $this->_tpl_vars['message']['created']; ?>
: 
<a href="<?php echo $this->_tpl_vars['splitmsg']['url']; ?>
">play</a> from <?php echo ((is_array($_tmp=$this->_tpl_vars['splitmsg']['callerid'])) ? $this->_run_mod_handler('phoneformat', true, $_tmp) : smarty_modifier_phoneformat($_tmp)); ?>

</div>

<?php endforeach; else: ?>
<h3>No messages found</h3>

<?php endif; unset($_from); ?>
</div>
