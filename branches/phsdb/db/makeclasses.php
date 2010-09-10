<?php
if (!isset($schemafile)) 
	die("you need to define \$schemafile!\n");
if (!isset($modeldir)) 
	die("you need to define \$modeldir!\n");

require($schemafile);
if (file_exists($modeldir)) 
	die("models directory $modeldir exists - try another name or rename existing directory!\n");
if (!is_dir($modeldir)) mkdir($modeldir,0777,true);

foreach ($schema as $table => $fields) {
	if (($fh = fopen("$modeldir/$table.php",'w')) !== false) {
		$class = ucfirst($table);
		if (isset($schema['PRIMARY KEY'])) {
			$classdef = <<<PHP
<?php
class $class extends Relation {
     function __construct() {
	 global \$schema, \$db;
	 parent::__construct(\$db,\$schema['$table'],'$table');
     }
 }
PHP;
		} else {
			$classdef = <<<PHP
<?php
 class $class extends Entity {
     function __construct() {
	 global \$schema, \$db;
	 parent::__construct(\$db,\$schema['$table'],'$table');
     }
 }
PHP;
		}
		fwrite($fh,$classdef);
		fclose($fh);
	} else {
		die("can't open $modeldir/$table.php to write!");
	}
}
