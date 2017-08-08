<?php
namespace Calendar\mvc;

/**
 * Description of View
 *
 * @author myrmidex
 */
class View {

    private $content;
    private $css;
    private $title;
  
    public function __construct() {}
  
  /*
   * Lay-Outs
   */
  
  
  /* Front
   * 
   * Front layout
  */
    public function front() 
    {
        $this->content = $this->drawCalendar();    
        $this->page();
    }
  
    private function page() {
        echo  '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>'.$this->title.'</title>
    '.$this->css.' 
    <link href="inc/modules/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    '.$this->content.'
    <script src="inc/modules/jquery/jquery-3.2.1.min.js"></script>
    <script src="inc/modules/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>';
    }
  
    private function drawCalendar(): string
    {
        $out = '';
        return $out;
    }
    
}
