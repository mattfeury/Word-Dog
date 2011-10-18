<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Units extends CI_Controller {

  public function index() {
    if (! $this->session->userdata('logged_in')) {
      redirect(base_url());
      return;
    }

    $this->load->view('teacher');
  }

  public function create() {
    $this->load->view('newunit');
  }

  public function add() {
    $name = $this->input->post('unitname', TRUE);

    $u = new Unit();
    $u->name = $name;

    $u->save();

    $success = $u->add();

    if ($success) {
      //$this->_setSessionForUser($email);
      redirect('/units');
    } else {
      //TODO return errors
      redirect(base_url());
    }

  }

}
