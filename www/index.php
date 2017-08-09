<?php
namespace freest\calendar;

use freest\calendar\mvc\controller\Controller as Controller;

require '../config.php';

$controller = new Controller();
$controller->invoke();