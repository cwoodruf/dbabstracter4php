{* 
   basic data entry form scaffold - 
   use the $schema array to determine how 
   information is input into the form 
*}
{if !isset($schema) and isset($this->schema)}
	{assign var=schema value=$this->schema}
{/if}
{if !isset($input) and isset($this->input)}
	{assign var=input value=$this->input}
{/if}
{schema schema=$schema}
<form id="formgen" action="index.php" method="post">
<table cellspacing="0" cellpadding="5" border="0" class="formgen">
<tr class="formgen formbuttons">
<td class="formgen formbuttons">
<input type="reset" value="reset" />
</td>
<td class="formgen formbuttons" align="right">

{* you can use an array instead of action=controller/modifier form *}
<input type="hidden" name="action[]" value="{$this->controller}" />

{include file=tools/hiddenfields.tpl}
<input type="submit" name="action[]" value="save" />

</td>
</tr>

{foreach from=$schema key=field item=fdata}

{if $fdata.hide}{php}continue;{/php}{/if}

<tr class="formgen" valign="top">
<td class="formgen"><b>{$field}</b></td>
<td class="formgen">
{assign var=value value=$input[$field]}

{if $fdata.auto}
 {if $value}
  {$value}
  <input type="hidden" name="{$field}" value="{$value}">
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
<textarea name="{$field}" rows="{$fdata.rows}" cols="{$fdata.cols}">{$value}</textarea>

{elseif $fdata.type == 'varchar'}
<input name="{$field}" size="{$fdata.size}" value="{$value}" /> 

{elseif $fdata.type == 'select' and $fdata.options}
<select name="$field"><option></option>
{$fdata.options}
</select>

{elseif $fdata.type == 'password'}
<input type="password" name="{$field}" size="{$fdata.size}" value="{$value}" /> 

{elseif $fdata.type == 'hidden'}
<input type="hidden" name="{$field}" value="{$value}" />

{else}
<input name="{$field}" value="{$value}" /> 
	
{/if}

</td>
</tr>

{/foreach}

</table>
</form>
