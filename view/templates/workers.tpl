{include file=top.tpl}
{if $this->actions[0] != 'description'}
{include file=menu.tpl}
{/if}

<h3>workers: {$this->actions[0]}</h3>
{include file="workers/`$this->actions[0]`.tpl"}
{include file=bottom.tpl}
