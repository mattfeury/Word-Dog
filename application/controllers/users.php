<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

  public function index() {
    $this->load->view('teacher');
  }

  public function login() {
    $id = $this->input->post('email', TRUE);
    $password = $this->input->post('password', TRUE);

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
  public function create() {
    $this->load->view('newunit');
  }

  public function register() {
    $email = $this->input->post('email', TRUE);
    $password = $this->input->post('password', TRUE);
    $name = $this->input->post('name', TRUE);
    $school = $this->input->post('school', TRUE);
    $grade = $this->input->post('grade', TRUE);

    $u = new User();
    $u->email = $email;
    $u->password = $password;
    $u->name = $name;
    $u->school = $school;
    $u->grade = $grade;

    $u->save();

    if (! empty($u->id)) {
      //TODO set session stuff
      redirect('/users/index');
    } else {
      //TODO return errors
      redirect(base_url());
    }
  }
}
