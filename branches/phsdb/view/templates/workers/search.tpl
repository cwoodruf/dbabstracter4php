{if $terms}
<h4>Looking for "{$terms}"</h4>
{else}
<h4>Showing all</h4>
{/if}

{foreach from=$results key=i item=worker}

<b>{$i+1}</b> 
<a href="index.php?action=workers/edit&worker_id={$worker.worker_id}">edit</a>

<b>{$worker.handle}</b>
({$worker.worker_id} {$worker.name} <b>{$worker.status}</b>) 
<b>voicemail:</b> {$worker.voicemail}
<b>location:</b> {$worker.city} /  {$worker.neighbourhood}
<p>

{/foreach}
