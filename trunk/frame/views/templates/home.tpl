{include file=top.tpl}
{include file=menu.tpl}

<h1>Notes:</h1>
{include file=tools/navcapture.tpl}
{$smarty.capture.nav}
{assign var=count value=$offset}

{foreach from=$notes key=i item=note}
{assign var=count value=$count+1}
{$count} ({$note.characters} character{if $note.characters != 1}s{/if})

<blockquote>{$note.notes|@htmlentities}</blockquote>
<div class="byline">

{if $note.email==$smarty.session.login.login}
<a href="index.php?action=restricted&numbered_id={$note.numbered_id}">
edit</a>
<a href="index.php?action=restricted/confirmdelete&numbered_id={$note.numbered_id}">
delete</a>
{/if}

{$note.email|@htmlentities} - {$note.created|@htmlentities}

</div>
<hr>

{/foreach}

{$smarty.capture.nav}

{include file=bottom.tpl}

