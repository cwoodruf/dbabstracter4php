{if $terms}

<h1>{$this->searchtype} search results for 
<a href="?action=search&terms={$terms}&findwhat={$smarty.get.findwhat|@htmlentities}">
{$terms}</a></h1>

{foreach from=$results key=i item=result}

<div class="searchresults">

{if $result.filename}
{splitmsg msg=$result.filename}
{$result.created}: 
<a href="{$splitmsg.url}">play</a> from 

{elseif $result.phone}
<a href="?action=phone/show&phone={$result.phone}">{$result.phone}</a>
taken: {$result.taken}, returned: {$result.returned} by
{/if}

<a href="?action=profile/show&clientid={$result.id}">{$result.name}</a>, 
{if $result.email}
<a href="mailto:{$result.email}">{$result.email}</a>
{else}
no email
{/if}

(status {$result.status|default:active})

</div>

{foreachelse}
<h3>Nothing found!</h3>
{/foreach}

{else}

<h1>Nothing to search for!</h1>

{/if}
