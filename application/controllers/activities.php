<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activities extends CI_Controller {

  public static $activitiesById = array(
    0 => array(
          'id' => 'write_sentence',
          'name' => 'Write Sentence',
          'numLevels' => 3),
    1 => array(
          'id' => 'answer_questions',
          'name' => 'Answer Questions',
          'numLevels' => 3),
    2 => array(
          'id' => 'memory',
          'name' => 'Memory',
          'numLevels' => 3),
    3 => array(
          'id' => 'fill_blank',
          'name' => 'Fill in the Blank',
          'numLevels' => 3),
    4 => array(
          'id' => 'jumble',
          'name' => 'Word Jumble',
          'numLevels' => 3),
    5 => array(
          'id' => 'multiple_choice',
          'name' => 'Multiple Choice',
          'numLevels' => 3)
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
	
	public function play($activity, $unitId, $level = 1) {
    $unit = new Unit();
    $unit->id = $unitId;
    $unit->validate()->get();
    
    // Get a "pruned" version of the object to encode as JSON
    // the DataMapper adds all sorts of helper fields so we don't want to encode those
    $pruned = $unit->pruned();

    $data = array();
    $data['unit_json'] = json_encode($pruned);
    $data['level'] = $level;

    $activityView = self::$activitiesById[$activity];
 
		$this->load->view($activityView['id'], $data);
	}
}
