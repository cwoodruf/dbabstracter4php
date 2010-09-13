<html>
<head>
<title>{$this->name}</title>
{$this->css()}
{$this->js()}
</head>
<body>

<div class="toplevel">
<h3>Safety database</h3>

{if $errors}
errors:
<h3 class='errors'>{$errors}</h3>
{/if}

{if $topmsg}
<h3 class='topmsg'>{$topmsg}</h3>
{/if}

