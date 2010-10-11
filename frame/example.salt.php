<?php
# copy this file to .salt.php and change the SALT to improve security for the database
# the salt value is used in Login::encode($pw) which provides a basic encoding method for
# passwords - however you can encode them any way you want
define('SALT','some random bunch of characters');
