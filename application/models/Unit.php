<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit extends DataMapper {
  
  var $has_one = array('user');
  var $has_many = array('lesson');
  
  var $validation = array(
    'name' => array(
      'label' => 'Name',
      'rules' => array('trim', 'required'),
    )    
  );

  function add() {
    $this->validate()->get();

    // if there was no matching record, this user would be completely cleared.
    if (empty($this->id)) {
      $this->error_message('add', 'Unit name required');
      return false;
    }
    else {
      return true;
    }
  }
  
  function edit() {
    $this->validate()->get();

    // if there was no matching record, this user would be completely cleared.
    if (empty($this->id)) {
      $this->error_message('edit', 'Unit name required');
      return false;
    }
    else {
      return true;
    }
  }
}
