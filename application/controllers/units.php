<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Handles data for unit views.
 */
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

  /**
   * Show a list of units by userId
   */
  public function show($userId) {
    $user = new User();
    $user->id = $userId;
    $user->validate()->get();
    
    $units = $user->unit->get();
    
    $data = array();
    $data['units'] = $units;

    $email = $this->session->userdata('email');	
    $sessionUser = new User();
    $sessionUser->where('email', $email)->get();
    if ($email && isset($sessionUser->id)) {
      $data['sessionUser'] = $sessionUser;
    }
    
		$this->load->view('units', $data);
	}

  /**
   * Create a unit in the database
   */
  public function create() {
    if (! $this->session->userdata('logged_in')) {
      redirect(base_url());
      return;
    }
    
    $data = array();
    $data['unit'] = new Unit();
    $data['lessons'] = array();

    $session_data = array('current_unit' => false);
    $this->session->set_userdata($session_data);    

    $this->load->view('unit', $data);
  }

  /**
   * Delete a unit from the database
   */
  public function delete($unitId = false) {
    if (! $this->session->userdata('logged_in') || ! $unitId) {
      redirect(base_url());
      return;
    }
    $unit = new Unit();
    $unit->id = $unitId;
    $unit->validate()->get();
    
    // Only allow certain people to delete (creator + admins)
    $email = $this->session->userdata('email');
    $user = new User();
    $user->email = $email;
    $user->validate()->get();    
    if (! $user->canEdit($unit)) {
      show_error('You are not authorized to delete this unit.', 403);
      return false;
    }

    // Delete old lessons for this unit, if any.
    $old = $unit->lessons->get();
    $old->delete_all();

    // Delete unit
    $unit->delete();

    redirect('/units');
  }
  
  /**
   * Edit a unit of the given id.
   */
  public function edit($id) {
    if (! $this->session->userdata('logged_in')) {
      redirect(base_url());
      return;
    }
    
    $unit = new Unit();

    $unit->id = $id;
    $unit->validate()->get();

    // Only allow certain people to edit (creator + admins)
    $email = $this->session->userdata('email');
    $user = new User();
    $user->email = $email;
    $user->validate()->get();    
    if (! $user->canEdit($unit)) {
      show_error('You are not authorized to edit this unit.', 403);
      return false;
    }

    $lessons = $unit->lesson->get();

    $session_data = array('current_unit' => $id);
    $this->session->set_userdata($session_data);    

    $data = array();
    $data['unit'] = $unit;
    $data['lessons'] = $lessons;

    $this->load->view('unit', $data);
  }

  /**
   * Handles form input to upsert a unit and its lessons
   */
  public function update() {
    if (! $this->session->userdata('logged_in')) {
      redirect(base_url());
      return;
    }
    
    $unitId = $this->session->userdata('current_unit');
    $isNew = $unitId == false;

    $lessonsJson = $this->input->post('lessons_json', TRUE);
    $unitName = $this->input->post('unit', TRUE);
    $showDistractor = $this->input->post('show_distractor', TRUE);

    // Config image upload goodies
    $field_name = 'picture';
    //unique filename based on timestamp and unit id
    $config['file_name'] = uniqid($unitId . "-0-");
    $config['upload_path'] = './uploads';
    $config['allowed_types'] = 'gif|jpg|jpeg|png';
    $config['max_size'] = '4048';
    $config['max_width']  = '2048';
    $config['max_height']  = '1600';
    $config['overwrite']     = FALSE;

    $this->load->library('upload', $config);

    // Save the shtuffs
    $lessons = json_decode($lessonsJson);

    $email = $this->session->userdata('email');
    $user = new User();
    $user->email = $email;
    $user->validate()->get();

    if (! $email || empty($user->id)) {
      show_error('You are not logged in.', 404);
      return false;
    }

    // Top level unit. Add or modify existing
    $unit = new Unit();

    if (! $isNew) {
      $unit->id = $unitId;
      $unit->where('id', $unitId)->get();

      if (! $user->canEdit($unit)) {
        show_error('You are not authorized to edit this unit.', 403);
        return false;
      }
    }

    $unit->name = $unitName;
    $unit->showDistractor = $showDistractor == "true" ? 1 : 0;
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
      $config['file_name'] = uniqid($unitId . "-".$i."-");
      $this->upload->initialize($config);

      // If sentence is defined, this is a valid lesson as everything else is optional.
      if (isset($lesson->sentence)) {
        $newLesson = new Lesson();
        $newLesson->sentence = $lesson->sentence;

        // Image
        // If one was sent to be uploaded, use it. Otherwise, use the old one (may not exist)
        if ($this->upload->do_upload($field_name . $i)) {
          $data = $this->upload->data();
          $imageUploaded = $data['is_image'];
          $image = $data['file_name'];
        }

        if ($imageUploaded)
          $newLesson->image = $image;
        else if (isset($lesson->image))
          $newLesson->image = $lesson->image;

        // Questions
        // These should be encoded as json (prior to this point by the client)
        if (isset($lesson->questions))
          $newLesson->questions = $lesson->questions;

        // Save new lesson. Reference it to the unit
        $newLesson->save($unit);
      }

      $i++;
    }

    redirect('/units');
  }
}
