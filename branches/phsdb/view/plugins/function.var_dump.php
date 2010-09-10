<?php
function smarty_function_var_dump($params,&$smarty) {
	return "<pre>".var_export($params['var'],true)."</pre>\n";
}
