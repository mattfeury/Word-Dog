<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

  public function index() {
    //TODO load teacher zone view
    //$this->load->view('');
    echo "TEACHAR ZONE";
  }

  public function login() {
    $id = $this->input->post('email', TRUE);
    $password = $this->input->post('password', TRUE);
    if ($id && $password) {
      $u = new User();
      $u->email = $id;
      $u->password = $password;

      $success = $u->login();

      if ($success) {
        //TODO set session stuff
        redirect('/users/index');
      } else {
        //TODO return errors
        redirect(base_url());
      }
    }
  }
}
