<?php
define ('BASEPATH',dirname(__FILE__).DIRECTORY_SEPARATOR);
//prado framework
$framework='framework/pradolite.php';
require_once ($framework);
$application = new TApplication;
$application->run();