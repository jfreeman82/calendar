<?php
namespace Calendar\mvc;

use Calendar\Modules\DB\DBC as DBC;
/**
 * Description of Model
 *
 * @author myrmidex
 */
class Model {

  public function __construct() {}
  
  
  public function articles_lastx($x) {
    $dbc = new DBC();
    $sql = "SELECT id FROM articles ORDER BY gendate,title DESC LIMIT $x ;";
    $q = $dbc->query($sql) or die("ERROR Model - ".$dbc->error());
    $out = array();
    while ($row = $q->fetch_assoc()) {
      $article = new Article($row['id']);
      //var_dump($article->dataArray());
      array_push($out, $article->dataArray());
    }    
    return $out;
  }
  
  public function article($aid) {
    $article = new Article($aid);
    return $article->dataArray();
  }
  
}
