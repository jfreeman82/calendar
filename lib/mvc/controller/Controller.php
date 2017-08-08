<?php
namespace Calendar\mvc;

use Calendar\mvc\Model as Model;
use Calendar\mvc\View as View;

/**
 * Description of Controller
 *
 * @author myrmidex
 */
class Controller {

    private $model;
    private $view;
    
    public function __construct()
    {
        $this->model = new Model();
        $this->view = new View();
    }
    
    public function invoke() {
        $this->view->front();
    }
}
