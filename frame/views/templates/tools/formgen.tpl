{* 
   basic data entry form scaffold - 
   use the $schema array to determine how 
   information is input into the form 
*}
{schema schema=$schema}
<form name=formgen id=formgen action=index.php method=post>
<table cellspacing=0 cellpadding=5 border=0 class="formgen">
<tr class="formgen formbuttons">
<td class="formgen formbuttons">
<input type=reset value="reset">
</td>
<td class="formgen formbuttons" align=right>

{* you can use an array instead of action=controller/modifier form *}
<input type=hidden name="action[]" value="{$this->controller}">

{foreach from=$this->hidden key=field item=value}
<input type=hidden name="{$field}" value="{$value}">
{/foreach}

<input type=submit name="action[]" value="save">

</td>
</tr>

{foreach from=$schema key=field item=fdata}

{if $fdata.hide}{php}continue;{/php}{/if}

<tr class="formgen" valign="top">
<td class="formgen"><b>{$field}</b></td>
<td class="formgen">

{if $fdata.auto}
 {if $this->input($field)}
  {$this->input($field)}
  <input type=hidden name="{$field}" value="{$this->input($field)}">
 {else}
  <i>{$fdata.alt}</i>
 {/if}
&nbsp;
{php}continue;{/php}
{/if}

{if $fdata.plugin}
{$fdata.plugin field=$field data=$fdata}

{elseif $fdata.template}
{include file=$fdata.template field=$field data=$fdata}

{elseif $fdata.type == 'text'}
<textarea name="{$field}" rows="{$fdata.rows}" cols="{$fdata.cols}">{$this->input($field)}</textarea>

{elseif $fdata.type == 'varchar'}
<input name="{$field}" size="{$fdata.size}" value="{$this->input($field)}"> 

{elseif $fdata.type == 'select' and $fdata.options}
<select name="$field"><option>
{$fdata.options}
</select>

{elseif $fdata.type == 'password'}
<input type="password" name="{$field}" size="{$fdata.size}" value="{$this->input($field)}"> 

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
