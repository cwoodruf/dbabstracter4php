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
<input name=terms size=20 value="{$terms}">
<input type=submit value="Search">
</form>
</div>

<div class="menuitem">

{if $smarty.session.login}
<nobr>
Welcome 
<a href="index.php?action=logout">Log out</a>
</nobr>

{else}
<a href="index.php?action=loginform">Log in</a>
{/if}

</div>

</div>

<div style="clear: both;"></div>
