<?php
require_once('init.php');
$b = new BoxesEntity();
var_export($b->getone('6040'));
print "\n".$b->err()."\n".$b->query."\n";

