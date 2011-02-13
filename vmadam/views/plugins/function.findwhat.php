<?php
/**
 * based on the value of the smarty 'this->search' variable
 * decide whether to return 'checked' or nothing
 */
function smarty_function_findwhat($params, &$smarty) {
	if (!$params['isa']) return;
	$iam = $smarty->get_template_vars('this');
	if ($params['isa'] == $iam->searchtype) return 'checked';
}

