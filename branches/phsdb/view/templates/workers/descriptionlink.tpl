{if $this->input('worker_id')}
<a href="javascript: void(0);" 
   onclick="window.open(
	'index.php?action=workers/description&worker_id={$this->input('worker_id')}',
	'description',
	'width=500,height=300,toolbar=no,menubar=no'); return false;"
>add description</a>

{else}
<i>create record before adding description</i>

{/if}
