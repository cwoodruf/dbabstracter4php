<html>
<head>
<title>{$this->name}</title>
{$this->css()}
{$this->js()}
</head>
<body>

{if $errors}
errors:
<h3 class='errors'>{$errors}</h3>
{/if}

