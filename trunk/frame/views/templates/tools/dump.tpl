<table cellpadding="5" cellspacing="0" border="0" class="{$class}">

{foreach from=$data key=field item=value}

<tr>
<td>
<b>{$field|@htmlentities}</b>
</td>
<td>
{$value|@htmlentities}
</td>
</tr>

{/foreach}

</table>

