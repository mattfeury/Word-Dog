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

  //TODO consider making 'upsert'
}
