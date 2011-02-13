<div class="menu">

<div class="menuitem">
<a href="?">Home</a>
</div>

<div class="menuitem">
<a href="?action=phone">Phones</a>
</div>

<div class="menuitem">
<a href="?action=profile/create">Create Profile</a>
</div>

<div class="menuitem">
<a href="?action=profile">Dump Profiles</a>
</div>

<div class="menuitem">
<form action="index.php" method=get>
<input type="hidden" name="action[]" value="search">
<input name="terms" value="{$terms}" size=30>
<input type="submit" name="button" value="Search">
<div class="instr">
Search for 
<input type="radio" name="findwhat" value="phones" {findwhat isa=Phones}>
phones,  
<input type="radio" name="findwhat" value="profiles" {findwhat isa=Profiles}>
profiles or 
<input type="radio" name="findwhat" value="messages" {findwhat isa=Messages}>
messages
</div>
</form>

</div>
<div style="clear: both;"></div>
</div>

