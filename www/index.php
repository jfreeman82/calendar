<?php
namespace Calendar;

use Calendar\mvc\Controller as Controller;

require '../config.php';

$controller = new Controller();
$controller->invoke();