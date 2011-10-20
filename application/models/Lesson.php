<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lesson extends DataMapper {
  
  var $has_one = array('unit');
  var $default_order_by = array('id' => 'asc');
  
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
}
