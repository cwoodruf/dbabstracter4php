<div class="home notcalledlist">
<h1>Clients who have not called in {$this->notcalledinterval}s</h1>

{foreach from=$notcalled key=i item=profile}
<div class="home notcalled">
<b>Last call:</b> {$profile.created} 
<b>Phone:</b> {$profile.phone|phoneformat}
from <a href="?profile/show&clientid={$profile.id}">{$profile.name}</a> - 
{if $profile.email}
<a href="mailto:{$profile.email}">{$profile.email}</a>
{else}
no email
{/if}
</div>

{foreachelse}
<h3>All clients have reported in recently.</h3>

{/foreach}
</div>

<div class="home messages">
<h1>Recent Messages</h1>
{foreach from=$messages key=i item=message}

{splitmsg msg=$message.filename}
<div class="home message">
{$splitmsg.created}
{if $message.iscallback} (callback) {/if}
<a href="{$splitmsg.url}">play</a> &nbsp;&nbsp; 
<b>caller id</b>
{$splitmsg.callerid|phoneformat} &nbsp;&nbsp;
<b>client</b>
(<a href="?action=messages/changeclient&filename={$message.filename}">change</a>)
<a href="?action=profile/show&clientid={$message.id}">{$message.name}</a> - 
{if $message.email}
<a href="mailto:{$message.email}">{$message.email}</a>
{else}
no email
{/if}
</div>

{foreachelse}
<h3>No messages found</h3>

{/foreach}


