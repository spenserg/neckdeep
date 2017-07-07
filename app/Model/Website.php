<?php
/**
 * Website Model
 * 
 * app/Model/Website.php
 */

class Website extends AppModel {
  
  function make_new($str) {
    $this->create();
    $this->set(array('name'=>$str));
    $this->save();
  }
  
  function get_all() {
    $x = $this->find('all', array('conditions'=> array('desc !='=>null)));
    $arr = [];
    foreach($x as $val) {
      array_push($arr, array(
        'name' => $val['Website']['name'],
        'email' => $val['Website']['email'],
        'phoneNumber' => $val['Website']['phoneNumber'],
        'desc' => $val['Website']['desc'],
        //'tags' => $val['Website']['name'], //TODO
        'tags' => "{}",
        'category' => $val['Website']['category']
      ));
    }
    return json_encode($arr);
  }
  
}