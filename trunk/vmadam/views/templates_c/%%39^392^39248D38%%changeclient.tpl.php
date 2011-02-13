<?php /* Smarty version 2.6.26, created on 2011-02-05 19:10:21
         compiled from changeclient.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlentities', 'changeclient.tpl', 3, false),)), $this); ?>
<h1>Change client</h1>
<div class="messages changeclient">
<h3>Message: <?php echo htmlentities($_GET['filename']); ?>
</h3>
<form action="index.php" method=post>
<input type="hidden" name="filename" value="<?php echo htmlentities($_GET['filename']); ?>
">
<b>Clients:</b>
<select name="clientid">
<?php $_from = $this->_tpl_vars['clients']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['client']):
?>
<option value="<?php echo $this->_tpl_vars['client']['id']; ?>
">
(<?php echo $this->_tpl_vars['client']['id']; ?>
) 
<?php echo $this->_tpl_vars['client']['name']; ?>
 
<?php echo $this->_tpl_vars['client']['email']; ?>

</option>
<?php endforeach; else: ?>
<option value="0">No clients available!</option>
<?php endif; unset($_from); ?>
</select>
<input type="hidden" name="action[]" value="messages">
<input type="hidden" name="action[]" value="setclient">
<input type="submit" value="Change client">
</form>
</div>