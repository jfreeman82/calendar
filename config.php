<?php

ini_set('error_reporting', E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 'STDOUT');

define('BASE_URL', 'http://localhost/cal/');

define("MYSQL_HOST","localhost");
define("MYSQL_USER","calendaruser");
define("MYSQL_PASS","calendaruser12345");
define("MYSQL_DB","calendar");


define('SITE_TITLE', 'calendar');

// Requires
require_once 'lib/modules/DBC.php';

require_once 'lib/mvc/controller/Controller.php';
require_once 'lib/mvc/model/Model.php';
require_once 'lib/mvc/view/View.php';

require_once 'lib/modules/Event.php';
require_once 'lib/modules/time.php';