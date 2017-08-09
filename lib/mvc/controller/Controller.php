<?php
namespace freest\calendar\mvc\controller;

use freest\calendar\mvc\model\Model as Model;
use freest\calendar\mvc\view\View as View;

/**
 * Description of Controller
 *
 * @author myrmidex
 */
class Controller 
{
    private $model;
    private $view;
    
    public function __construct()
    {
        $this->model = new Model();
        $this->view = new View();
    }
    
    public function invoke() 
    {
        if (filter_input(INPUT_GET, 'action') == "new") {
            $check = $this->model->fp_event_new();
            if ($check['status'] == '1') {  
                header("Location: index.php");                
            }
            else {
                die($check['status']);
            }
        }
        else {
            $this->view->front();
        }
    }
}
