<div class="menu">

<div class="menuitem">
<a href="index.php">Home</a>
</div>

<div class="menuitem">
<a href="index.php?action=restricted">Add Note</a> (requires login)
</div>

<div class="menuitem">
<a href="index.php?action=calendars/month">Calendar</a>
</div>

<div class="menuitem">

{if $smarty.session.login}
<nobr>
Welcome
<a href="?action=register/edit&email={$smarty.session.login.login}">
<b>{$smarty.session.login.login}</b></a>
&nbsp;
<a href="index.php?action=logout">Log out</a>
</nobr>

{else}
<a href="index.php?action=loginform">Log in</a>
&nbsp;
<a href="index.php?action=register">Create a log in</a>
{/if}

</div>

<div class="menuitem">
<a href="/group8wiki/index.php/Framework_Docs">Framework docs</a>
</div>

</div>

<div style="clear: both;"></div>
