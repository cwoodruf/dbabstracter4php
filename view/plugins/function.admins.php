<?php
/**
 * grab a list of admins from the db
 */
function smarty_function_admins($params,&$smarty) {
	$a = new Admins;
	$rows = $a->getall();
	foreach ($rows as $admin) {
		$admins[$admin['login']] = $admin;
	}
	$smarty->assign('admins',$admins);
}

