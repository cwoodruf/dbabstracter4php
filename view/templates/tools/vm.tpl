<input name="{$field}" value="{$this->input($field)}" size=20>

{if $this->input($field)}
<a href="https://lifelinevm.net/lifeline/admin.php?form=Search&search={$this->input($field)}" target=vm>
view box</a>

{else}
<a href="https://lifelinevm.net/lifeline/admin.php?form=Create+a+new+voicemail+box" target=vm>
create box</a>

{/if}

