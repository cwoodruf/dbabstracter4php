<div class="menu">

<div class="menuitem">
<a href="index.php">Home</a>
</div>

<div class="menuitem">
<a href="index.php?action=workers/search">List workers</a>
</div>

<div class="menuitem">
<a href="index.php?action=workers/edit">Add new worker</a>
</div>

<div class="menuitem">
<form name=search id=search action="index.php" method=get>
<input type=hidden name=action value="workers/search">
<input name=terms size=20 value="{$terms}">
<input type=submit value="Search">
</form>
</div>

<div class="menuitem">
<a href="index.php?action=admin">Admin</a>
</div>

<div class="menuitem">
<a href="index.php?action=logout">Log out</a>
</div>

</div>

<div style="clear: both;"></div>