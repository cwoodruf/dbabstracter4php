<div class="profile">
<h1>Profile for {$this->input('name')}</h1>
<a href="?action=profile/edit&clientid={$clientid}">Edit Profile</a> &nbsp;&nbsp;
<a href="#phones">Phones</a> &nbsp;&nbsp;
<a href="#messages">Messages</a> &nbsp;&nbsp;
<br>
{include file=tools/dump.tpl data=$this->input}
</div>

<div class="profile phones">
<a name="phones"></a>
<h2>Phones</h2>
<form action="index.php#phones" method=post>
<input type="hidden" name="action[]" value="phone">
<input type="hidden" name="action[]" value="lend">
<input type="hidden" name="clientid" value="{$clientid}">
Phone: 
<input size="32" maxlength="32" name="phone">
<input type="submit" value="lend phone">
</form>

{foreach from=$phones id=i item=phone}
<div class="profile phone">
{$phone.phone|phoneformat} 
<b>taken</b> {$phone.taken|regex_replace:"# .*#":""} 
<b>returned</b> 
{if $phone.returned}
{$phone.returned|regex_replace:"# .*#":""|default:"not returned"}
{else}
<a href="?action=phone/return&clientid={$clientid}&phone={$phone.phone}">return phone</a>
{/if}
</div>

{foreachelse}
<h3>No phones found</h3>

{/foreach}

</div>

<div class="profile messages">
<a name="messages"></a>
<h2>Messages</h2>
{foreach from=$messages id=i item=message}

{splitmsg msg=$message.filename}
<div class="profile message">
{$message.created}: 
<a href="{$splitmsg.url}">play</a> from {$splitmsg.callerid|phoneformat}
</div>

{foreachelse}
<h3>No messages found</h3>

{/foreach}
</div>

