<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit extends DataMapper {
  
  var $has_one = array('user');
  var $has_many = array('lesson');
  
  var $default_order_by = array('id' => 'asc');
  
  var $validation = array(
    'name' => array(
      'label' => 'Name',
      'rules' => array('trim', 'required'),
    )    
  );

  function pruned() {
    $pruned = new stdClass;
    $pruned->id = $this->id;
    $pruned->name = $this->name;
    $pruned->lessons = array();
    foreach ($this->lessons->get() as $lesson)
      $pruned->lessons[] = $lesson->pruned();

    return $pruned;
  }
}