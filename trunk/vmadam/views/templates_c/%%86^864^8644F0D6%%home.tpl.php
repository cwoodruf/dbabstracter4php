<?php /* Smarty version 2.6.26, created on 2011-02-05 11:20:39
         compiled from home.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'phoneformat', 'home.tpl', 7, false),array('function', 'splitmsg', 'home.tpl', 26, false),)), $this); ?>
<div class="home notcalledlist">
<h1>Clients who have not called in <?php echo $this->_tpl_vars['this']->notcalledinterval; ?>
s</h1>

<?php $_from = $this->_tpl_vars['notcalled']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['profile']):
?>
<div class="home notcalled">
<b>Last call:</b> <?php echo $this->_tpl_vars['profile']['created']; ?>
 
<b>Phone:</b> <?php echo ((is_array($_tmp=$this->_tpl_vars['profile']['phone'])) ? $this->_run_mod_handler('phoneformat', true, $_tmp) : smarty_modifier_phoneformat($_tmp)); ?>

from <a href="?profile/show&clientid=<?php echo $this->_tpl_vars['profile']['id']; ?>
"><?php echo $this->_tpl_vars['profile']['name']; ?>
</a> - 
<?php if ($this->_tpl_vars['profile']['email']): ?>
<a href="mailto:<?php echo $this->_tpl_vars['profile']['email']; ?>
"><?php echo $this->_tpl_vars['profile']['email']; ?>
</a>
<?php else: ?>
no email
<?php endif; ?>
</div>

<?php endforeach; else: ?>
<h3>All clients have reported in recently.</h3>

<?php endif; unset($_from); ?>
</div>

<div class="home messages">
<h1>Recent Messages</h1>
<?php $_from = $this->_tpl_vars['messages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['message']):
?>

<?php echo smarty_function_splitmsg(array('msg' => $this->_tpl_vars['message']['filename']), $this);?>

<div class="home message">
<?php echo $this->_tpl_vars['splitmsg']['created']; ?>

<?php if ($this->_tpl_vars['message']['iscallback']): ?> (callback) <?php endif; ?>
<a href="<?php echo $this->_tpl_vars['splitmsg']['url']; ?>
">play</a> &nbsp;&nbsp; 
<b>caller id</b>
<?php echo ((is_array($_tmp=$this->_tpl_vars['splitmsg']['callerid'])) ? $this->_run_mod_handler('phoneformat', true, $_tmp) : smarty_modifier_phoneformat($_tmp)); ?>
 &nbsp;&nbsp;
<b>client</b>
(<a href="?action=messages/changeclient&filename=<?php echo $this->_tpl_vars['message']['filename']; ?>
">change</a>)
<a href="?action=profile/show&clientid=<?php echo $this->_tpl_vars['message']['id']; ?>
"><?php echo $this->_tpl_vars['message']['name']; ?>
</a> - 
<?php if ($this->_tpl_vars['message']['email']): ?>
<a href="mailto:<?php echo $this->_tpl_vars['message']['email']; ?>
"><?php echo $this->_tpl_vars['message']['email']; ?>
</a>
<?php else: ?>
no email
<?php endif; ?>
</div>

<?php endforeach; else: ?>
<h3>No messages found</h3>

<?php endif; unset($_from); ?>

