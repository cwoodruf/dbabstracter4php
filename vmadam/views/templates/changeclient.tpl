<h1>Change client</h1>
<div class="messages changeclient">
<h3>Message: {$smarty.get.filename|@htmlentities}</h3>
<form action="index.php" method=post>
<input type="hidden" name="filename" value="{$smarty.get.filename|@htmlentities}">
<b>Clients:</b>
<select name="clientid">
{foreach from=$clients key=i item=client}
<option value="{$client.id}">
({$client.id}) 
{$client.name} 
{$client.email}
</option>
{foreachelse}
<option value="0">No clients available!</option>
{/foreach}
</select>
<input type="hidden" name="action[]" value="messages">
<input type="hidden" name="action[]" value="setclient">
<input type="submit" value="Change client">
</form>
</div>
