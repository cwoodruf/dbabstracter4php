{assign var=table value="`$this->table`"}
{schema}

<form name=formgen id=formgen action=index.php method=post>
<table cellspacing=0 cellpadding=5 border=0 class="formgen">
<tr class="formgen formbuttons">
<td class="formgen formbuttons">
<input type=reset value="reset">
</td>
<td class="formgen formbuttons" align=right>
<input type=hidden name="action" value="{$this->action}">
<input type=submit name="step" value="save">
</td>
</tr>

{foreach from=$schema[$table] key=field item=fdata}

{if $fdata.hide}{php}continue;{/php}{/if}

<tr class="formgen">
<td class="formgen"><b>{$field}</b></td>
<td class="formgen">

{if $fdata.plugin}
{$fdata.plugin field=$field data=$fdata}

{elseif $fdata.template}
{include file=$fdata.template field=$field data=$fdata}

{elseif $fdata.key}
 {if $this->input($field)}
  {$this->input($field)}
  <input type=hidden name="{$field}" value="{$this->input($field)}">
 {else}
  <i>{$fdata.alt}</i>
 {/if}
&nbsp;

{elseif $fdata.type == 'text'}
<textarea name="{$field}" rows="{$fdata.rows}" cols="{$fdata.cols}">{$this->input($field)}</textarea>

{elseif $fdata.type == 'varchar'}
<input name="{$field}" size="{$fdata.size}" value="{$this->input($field)}"> 

{elseif $fdata.type == 'select' and $fdata.options}
<select name="$field"><option>
{$fdata.options}
</select>

{elseif $fdata.type == 'password'}
<input type="password" name="{$field}" value="{$this->input($field)}"> 

{elseif $fdata.type == 'hidden'}
<input type=hidden name="{$field}" value="{$this->input($field)}">

{else}
<input name="{$field}" value="{$this->input($field)}"> 
	
{/if}

</td>
</tr>

{/foreach}

</table>
</form>
