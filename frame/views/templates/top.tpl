{include file=tools/xmljunk.tpl}
<head>
<title>{$this->name|default:"example site"}</title>
{$this->css()}
{$this->js()}
</head>
<body>

<div class="toplevel">
<h3>Example site</h3>

{if $errors}
errors:
<h3 class="errors">{$errors}</h3>
{/if}

{if $topmsg}
<h3 class="topmsg">{$topmsg}</h3>
{/if}

