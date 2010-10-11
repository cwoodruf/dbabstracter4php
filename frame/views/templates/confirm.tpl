{include file=top.tpl}
{include file=menu.tpl}

<h3>{$confirm}<h3>

<form name="confirm" method="post">
{if $action}
<input type="hidden" name="action[]" value="{$this->controller}">
<input type="submit" name="action[]" value="{$action}">
{/if}
</form>

{include file=bottom.tpl}
