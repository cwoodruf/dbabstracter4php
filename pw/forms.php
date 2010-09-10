<?php

function login_form ($redirecturl,$app,$callback) {
	global $lib,$css,$contactlink;
	if (@include_once("$lib/asterisk.php")) {
		$uptime = get_uptime();
	}
	$vars = $_REQUEST; # array_merge($_GET,$_POST);
	foreach ($vars as $key => $val) {
		if (preg_match('#^(login|password|cache|app|callback)$#',$key)) continue;
		$hidden .= "<input type=hidden name=\"$key\" value=\"$val\">\n";
	}
	$login = htmlentities($vars['login']);
	return <<<HTML
<html>
<head>
<title>Login</title>
$css
</head>
<body>
<center>
<h3>{$_SERVER['SERVER_NAME']} log in</h3>
<div>
<form name=form_login action="$redirecturl" method=post>
<input type=hidden name=app value="$app">
<input type=hidden name=callback value="$callback">
$hidden
<table cellpadding=3 cellspacing=0 border=0>
<tr><td><b>Login:</b></td>
    <td><input name=login size=64 maxlength=64 value="$login">
    <script>document.form_login.login.focus()</script></td></tr>
<tr><td><b>Password:</b></td>
    <td><input type=password name=password size=64 maxlength=64></td></tr>
<tr><td><input type=reset value='Reset'></td>
    <td align=right><input type=submit name=action value="Log In"></td></tr>
</table>
</form>
</div>
$contactlink
</center>
</body>
</html>
HTML;
}

function print_login ($redirecturl,$app,$callback) {
	echo login_form($redirecturl,$app,$callback);
	exit;
}

?>
