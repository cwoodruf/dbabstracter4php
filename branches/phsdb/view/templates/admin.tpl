{include file=top.tpl}
{include file=menu.tpl}
<a href="https://lifelinevm.net/lifeline/admin.php" target=vm>Login to voice mail</a>
<p>
{if $ldata.perms == 'superuser'}
<a href="index.php?action=admin/import">Import admins from voice mail system</a>
{/if}

<h3>Current administrators</h3>
{admins}
{foreach from=$admins key=login item=admin}

{if $ldata.perms == 'superuser' and $ldata.login != $login}
  <a href="index.php?action=admin/delete&login={$login}">delete</a>
{/if}

{$login} ({$admin.perms})<br>

{/foreach}

{include file=bottom.tpl}
