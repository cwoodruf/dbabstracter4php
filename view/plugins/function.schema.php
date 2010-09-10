<?php
/**
 * grab data from dbabstracter4php's schema file
 */
function smarty_function_schema($params,&$smarty) {
	global $schema;
	# error
	if (!is_array($schema)) return;
	$tables = $schema;

	if (preg_match('#^\w+$#',$params['assign'])) 
		$output = $params['assign'];
	else $output = 'schema';

	$table = $params['table'];
	if (!$table) {
		foreach ($tables as $table => $tdata) {
			schema_data($table,$tdata,$tables);
		}
		$smarty->assign($output,$tables);
		return;
	}

	# error
	if (!isset($tables[$table])) return;

	schema_data($table,$tables[$table],$tables);
	$smarty->assign($output,$tables[$table]);
}

function schema_data($table,$tdata,&$tables) {
	foreach ($tdata as $field => $fdata) {
		if ($field == 'PRIMARY KEY') continue;
		switch($fdata['type']) {
		case 'text': 
			if (!$fdata['rows']) $tables[$table][$field]['rows'] = View::DEFROWS;
			if (!$fdata['cols']) $tables[$table][$field]['cols'] = View::DEFCOLS;
		break;
		case 'varchar': 
			unset($size);
			if (!$fdata['size']) $size = View::DEFSIZE;
			if ($fdata['size'] > View::MAXSIZE) $size = View::MAXSIZE;
			if ($size) $tables[$table][$field]['size'] = $size;
		break;
		}
	}
	return $tables;
}
