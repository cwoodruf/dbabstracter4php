<html>
<head>
<title>Proof of Concept</title>
{$this->css()}
{$this->js()}
</head>
<body>
<h2>Demo</h2>
<div class="phonesubtitle">Test call in #: 778 374 0308 (Security code 7478)</div>
{include file=menu.tpl}
<div class="error">{$error}</div>
<div class="results">{$results}</div>
{$content}
</body>
</html>
