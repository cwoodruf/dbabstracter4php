<?php /* Smarty version 2.6.26, created on 2011-02-03 00:24:51
         compiled from searchresults.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlentities', 'searchresults.tpl', 4, false),array('modifier', 'default', 'searchresults.tpl', 28, false),array('function', 'splitmsg', 'searchresults.tpl', 12, false),)), $this); ?>
<?php if ($this->_tpl_vars['terms']): ?>

<h1><?php echo $this->_tpl_vars['this']->searchtype; ?>
 search results for 
<a href="?action=search&terms=<?php echo $this->_tpl_vars['terms']; ?>
&findwhat=<?php echo htmlentities($_GET['findwhat']); ?>
">
<?php echo $this->_tpl_vars['terms']; ?>
</a></h1>

<?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['result']):
?>

<div class="searchresults">

<?php if ($this->_tpl_vars['result']['filename']): ?>
<?php echo smarty_function_splitmsg(array('msg' => $this->_tpl_vars['result']['filename']), $this);?>

<?php echo $this->_tpl_vars['result']['created']; ?>
: 
<a href="<?php echo $this->_tpl_vars['splitmsg']['url']; ?>
">play</a> from 

<?php elseif ($this->_tpl_vars['result']['phone']): ?>
<a href="?action=phone/show&phone=<?php echo $this->_tpl_vars['result']['phone']; ?>
"><?php echo $this->_tpl_vars['result']['phone']; ?>
</a>
taken: <?php echo $this->_tpl_vars['result']['taken']; ?>
, returned: <?php echo $this->_tpl_vars['result']['returned']; ?>
 by
<?php endif; ?>

<a href="?action=profile/show&clientid=<?php echo $this->_tpl_vars['result']['id']; ?>
"><?php echo $this->_tpl_vars['result']['name']; ?>
</a>, 
<?php if ($this->_tpl_vars['result']['email']): ?>
<a href="mailto:<?php echo $this->_tpl_vars['result']['email']; ?>
"><?php echo $this->_tpl_vars['result']['email']; ?>
</a>
<?php else: ?>
no email
<?php endif; ?>

(status <?php echo ((is_array($_tmp=@$this->_tpl_vars['result']['status'])) ? $this->_run_mod_handler('default', true, $_tmp, 'active') : smarty_modifier_default($_tmp, 'active')); ?>
)

</div>

<?php endforeach; else: ?>
<h3>Nothing found!</h3>
<?php endif; unset($_from); ?>

<?php else: ?>

<h1>Nothing to search for!</h1>

<?php endif; ?>