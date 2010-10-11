{include file=top.tpl}
{include file=menu.tpl}

<h1>Note</h1>

{if $smarty.session.login.login == $note.email}
<a href="?action=restricted&numbered_id={$note.numbered_id}">edit</a>
&nbsp;&nbsp;
<a href="?action=restricted/confirmdelete&numbered_id={$note.numbered_id}">delete</a>
<br>
<br>
{/if}

{include file=tools/dump.tpl data=$note class="bordered white"}

{* $note must exist *}
{include file=viewers.tpl}

{include file=bottom.tpl}

