<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Units extends CI_Controller {

  public function index() {
    if (! $this->session->userdata('logged_in')) {
      redirect(base_url());
      return;
    }

    $email = $this->session->userdata('email');
    $user = new User();
    $user->email = $email;
    $user->validate()->get();

    $units = $user->units->get();

    $data['units'] = $units;

    $this->load->view('teacher', $data);
  }
  
  public function show($id) {
    $user = new User();
    $user->id = $id;
    $user->validate()->get();
    
    $units = $user->unit->get();
    
    $data = array();
    $data['units'] = $units;
    
		$this->load->view('unitlist', $data);
	}

  public function create() {
    $data = array();
    $data['unit'] = new Unit();
    $data['lessons'] = array();

    $session_data = array('current_unit' => false);
    $this->session->set_userdata($session_data);    

    $this->load->view('unit', $data);
  }
 
  public function edit($id) {
    $unit = new Unit();

    $unit->id = $id;
    $unit->validate()->get();

    $lessons = $unit->lesson->get();

    $session_data = array('current_unit' => $id);
    $this->session->set_userdata($session_data);    

    $data = array();
    $data['unit'] = $unit;
    $data['lessons'] = $lessons;

    $this->load->view('unit', $data);
  }

  /**
   * Handles form input to upsert a unit/lesson
   */
  public function update() {

    $unitId = $this->session->userdata('current_unit');
    $isNew = $unitId == false;

    $lessonsJson = $this->input->post('lessons_json', TRUE);
    $unitName = $this->input->post('unit', TRUE);

    /*
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
    $config['overwrite']     = FALSE;

		$this->load->library('upload', $config);
    $field_name = 'picture';
    $this->upload->do_upload($field_name);
    */

    $lessons = json_decode($lessonsJson);

    $email = $this->session->userdata('email');
    $user = new User();
    $user->email = $email;
    $user->validate()->get();
    
    $unit = new Unit();

    if ($isNew) {
      //echo 'new';
      //
    } else {
      $unit->id = $unitId;
      $unit->where('id', $unitId)->get();
    }

    $unit->name = $unitName;
    $unit->save();

    if ($isNew)
      $user->save($unit);

    $old = $unit->lessons->get();
    $old->delete_all();

    // insert lessons
    foreach($lessons as $lesson) {
      if (isset($lesson->sentence)) {
        $newLesson = new Lesson();
        $newLesson->sentence = $lesson->sentence;
        if (isset($lesson->image))
          $newLesson->image = $lesson->image;
        if (isset($lesson->question))
          $newLesson->question = $lesson->question;
        $newLesson->save($unit);
      }
    }

    //TODO handle errors and return

    redirect('/units');
  }

}
