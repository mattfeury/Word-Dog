<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lesson extends DataMapper {
  
  var $validation = array(
    'sentence' => array(
      'label' => 'Sentence',
      'rules' => array('trim', 'required'),
    ),
    'image' => array(
      'label' => 'Image',
      'rules' => array('trim')
    )    
  );

  function add() {
    // this will encrypt the password
    $this->validate()->get();

    // if there was no matching record, this user would be completely cleared.
    if (empty($this->id)) {
      $this->error_message('add', 'Sentence required');
      return false;
    }
    else {
      return true;
    }
  }
}
