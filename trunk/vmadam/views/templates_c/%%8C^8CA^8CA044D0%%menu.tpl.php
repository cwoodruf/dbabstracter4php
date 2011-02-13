<?php /* Smarty version 2.6.26, created on 2011-02-03 00:21:37
         compiled from menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'findwhat', 'menu.tpl', 26, false),)), $this); ?>
<div class="menu">

<div class="menuitem">
<a href="?">Home</a>
</div>

<div class="menuitem">
<a href="?action=phone">Phones</a>
</div>

<div class="menuitem">
<a href="?action=profile/create">Create Profile</a>
</div>

<div class="menuitem">
<a href="?action=profile">Dump Profiles</a>
</div>

<div class="menuitem">
<form action="index.php" method=get>
<input type="hidden" name="action[]" value="search">
<input name="terms" value="<?php echo $this->_tpl_vars['terms']; ?>
" size=30>
<input type="submit" name="button" value="Search">
<div class="instr">
Search for 
<input type="radio" name="findwhat" value="phones" <?php echo smarty_function_findwhat(array('isa' => 'Phones'), $this);?>
>
phones,  
<input type="radio" name="findwhat" value="profiles" <?php echo smarty_function_findwhat(array('isa' => 'Profiles'), $this);?>
>
profiles or 
<input type="radio" name="findwhat" value="messages" <?php echo smarty_function_findwhat(array('isa' => 'Messages'), $this);?>
>
messages
</div>
</form>

</div>
<div style="clear: both;"></div>
</div>
