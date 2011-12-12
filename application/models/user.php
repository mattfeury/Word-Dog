<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends DataMapper {
  
  var $has_many = array('unit');

  var $validation = array(
    'email' => array(
      'label' => 'Email Address',
      'rules' => array('required', 'trim', 'unique', 'valid_email')
    ),    
    'password' => array(
      'label' => 'Password',
      'rules' => array('required', 'min_length' => 4, 'encrypt'),
    ),
    'name' => array(
      'label' => 'Name',
      'rules' => array('trim', 'required'),
    )    
  );

  function login() {
    // this will encrypt the password
    $this->validate()->get();

    // if there was no matching record, this user would be completely cleared.
    if (empty($this->id)) {
      $this->error_message('login', 'Username or password invalid');
      return false;
    }
    else {
      return true;
    }
  }

  function canEdit($unit) {
    if ($unit->user->get()->id == $this->id || $this->admin == 1) {
      return true;
    } else {
      return false;
    }
  }

  // md5 encryption
  function _encrypt($field) {
    if (!empty($this->{$field})) {
      $this->{$field} = md5($this->{$field});
    }
  }
}
