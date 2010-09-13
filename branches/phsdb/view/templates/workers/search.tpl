{if $terms}
<h4>Looking for "{$terms}"</h4>
{else}
<h4>Showing all</h4>
{/if}

{foreach from=$results key=i item=worker}

<b>{$i+1}</b> 
<a href="index.php?action=workers/edit&worker_id={$worker.worker_id}">edit</a>

{$worker.handle} 
({$worker.worker_id} {$worker.name} {$worker.status}) 
location: {$worker.city} /  {$worker.neighbourhood}
<p>

{/foreach}
