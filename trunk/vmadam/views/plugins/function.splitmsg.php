<?php
/**
 * split out the callerid and make a url for this message
 */
function smarty_function_splitmsg($params,&$smarty) {
	if (!preg_match('#.*(/\w+/(\d+|unknown)-(\d+)(?:\.deleted|)\.gsm)$#', $params['msg'], $m)) return;
	$splitmsg['url'] = "messages{$m[1]}";
	$splitmsg['created'] = date('Y-m-d H:i:s', $m[3]);
	$splitmsg['callerid'] = $m[2];
	$smarty->assign('splitmsg', $splitmsg);
}
