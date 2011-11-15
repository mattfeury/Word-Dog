<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activities extends CI_Controller {

  public static $activitiesById = array(
    0 => 'write_sentence',
    1 => 'answer_questions',
    2 => 'memory',
    3 => 'fill_blank',
    4 => 'jumble',
    5 => 'multiple_choice'
  );

  public function index() {
  }

  public function with($id) {
    $unit = new Unit();
    $unit->id = $id;
    $unit->validate()->get();
    
    $data = array();
    $data['unit'] = $unit;
    $data['activities'] = self::$activitiesById;
    
		$this->load->view('activity', $data);
  }
	
	public function play($activity, $unitId) {
    $unit = new Unit();
    $unit->id = $unitId;
    $unit->validate()->get();
    
    $data = array();
    $data['unit'] = $unit;

    $activityView = self::$activitiesById[$activity];
 
		$this->load->view($activityView, $data);
	}
}
