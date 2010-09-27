<?php /* Smarty version 2.6.26, created on 2010-09-26 23:10:31
         compiled from menu.tpl */ ?>
<div class="menu">

<div class="menuitem">
<a href="index.php">Home</a>
</div>

<div class="menuitem">
<a href="index.php?action=boxes/search">List vm boxes</a>
</div>

<div class="menuitem">
<a href="index.php?action=workers/edit">Add new vm box</a>
</div>

<div class="menuitem">
<form name=search id=search action="index.php" method=get>
<input type=hidden name=action value="workers/search">
<input name=terms size=20 value="<?php echo $this->_tpl_vars['terms']; ?>
">
<input type=submit value="Search">
</form>
</div>

<div class="menuitem">

<?php if ($_SESSION['login']): ?>
<nobr>
Welcome 
<a href="index.php?action=logout">Log out</a>
</nobr>

<?php else: ?>
<a href="index.php?action=loginform">Log in</a>
<?php endif; ?>

</div>

</div>

<div style="clear: both;"></div>