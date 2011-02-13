{if $this->input('id') != null }
<a href="?action=profile/show&clientid={$this->input('id')}">View Profile</a>
<br>
{/if}
{include file=tools/formgen.tpl}
