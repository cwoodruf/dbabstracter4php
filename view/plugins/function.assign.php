<?php
function smarty_function_assign($params,&$smarty) {
	$smarty->assign($params['var'],$params['value']);
}

