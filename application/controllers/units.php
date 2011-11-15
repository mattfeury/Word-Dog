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
    
		$this->load->view('units', $data);
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

    // Config image upload goodies
    $field_name = 'picture';
    $config['upload_path'] = './uploads';
    $config['allowed_types'] = 'gif|jpg|jpeg|png';
    $config['max_size'] = '2024';
    $config['max_width']  = '1024';
    $config['max_height']  = '768';
    $config['overwrite']     = FALSE;

    $this->load->library('upload', $config);

    // Save the shtuffs
    $lessons = json_decode($lessonsJson);

    $email = $this->session->userdata('email');
    $user = new User();
    $user->email = $email;
    $user->validate()->get();

    // Top level unit. Add or modify existing
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

    // Delete old lessons for this unit, if any.
    $old = $unit->lessons->get();
    $old->delete_all();

    // Insert lessons
    $i = 0;
    foreach($lessons as $lesson) {
      $imageUploaded = false;
      $image = null;

      if ($this->upload->do_upload($field_name . $i)) {
        $data = $this->upload->data();
        $imageUploaded = $data['is_image'];
        $image = $data['file_name'];
      }
      
      if (isset($lesson->sentence)) {
        $newLesson = new Lesson();
        $newLesson->sentence = $lesson->sentence;
        if ($imageUploaded)
          $newLesson->image = $image;
        if (isset($lesson->question))
          $newLesson->question = $lesson->question;
        $newLesson->save($unit);
      }

      $i++;
    }

    //TODO handle errors and return

    redirect('/units');
  }

}
