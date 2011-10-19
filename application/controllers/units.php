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
    $username = $this->session->userdata('email');
    $user = new User();
    $user->where('email', $username)->get();
    
    $name = $this->input->post('unitname', TRUE);
    //$sentence = $this->input->post('sentence', TRUE);
    //$image = $this->input->post('picture', TRUE);

    //$lesson = new Lesson();
    //$lesson->sentence = $sentence;
    //$lesson->image = $image;

    $unit = new Unit();
    $unit->name = $name;

    $unit->save();
    $user->save($unit);

    //$lessonSuccess = $lesson->add();
    $unitSuccess = $unit->add();

    if ($unitSuccess) {
      redirect('/units');
    } else {
      //TODO return errors
      redirect(base_url());
    }

  }

}
