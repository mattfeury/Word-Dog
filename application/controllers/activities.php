<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activities extends CI_Controller {

  public static $activitiesById = array(
    0 => array(
          'view' => 'write_sentence',
          'name' => 'Write Sentence',
          'data' => array()),
    1 => array(
          'view' => 'answer_questions', //TODO
          'name' => 'Answer Questions1',
          'data' => array(
                      'show-choices' => true
                    )),
    2 => array(
          'view' => 'answer_questions', //TODO
          'name' => 'Answer Questions2',
          'data' => array(
                      'show-choices' => false
                    )),

    // Memory
    3 => array(
          'view' => 'memory',
          'name' => 'Memory Static1',
          'data' => array(
                      'hide-picture' => false
                    )),
    4 => array(
          'view' => 'memory', //TODO
          'name' => 'Memory Static2',
          'data' => array(
                      'hide-picture' => true,
                      'choose-timer' => true
                    )),
    5 => array(
          'view' => 'memory', //TODO
          'name' => 'Memory Flash',
          'data' => array(
                      'hide-picture' => true
                    )),

    // Jumble
    6 => array(
          'view' => 'jumble',
          'name' => 'Word Jumble1',
          'data' => array()),
    7 => array(
          'view' => 'jumble',
          'name' => 'Word Jumble2',
          'data' => array()),
    8 => array(
          'view' => 'jumble',
          'name' => 'Jumble / Memory Static1',
          'data' => array()),
    9 => array(
          'view' => 'jumble',
          'name' => 'Jumble / Memory Static2',
          'data' => array()),
    10 => array(
          'view' => 'jumble',
          'name' => 'Jumble / Memory Flash1',
          'data' => array()),
        
    // Cloze
    11 => array(
          'view' => 'cloze',
          'name' => 'Fill in the Blank1',
          'data' => array()),
    12 => array(
          'view' => 'cloze',
          'name' => 'Fill in the Blank2',
          'data' => array()),
    13 => array(
          'view' => 'cloze',
          'name' => 'Fill in the Blank3',
          'data' => array()),
    14 => array(
          'view' => 'cloze',
          'name' => 'Fill in the Blank / Memory Static',
          'data' => array()),
    15 => array(
          'view' => 'cloze',
          'name' => 'Fill in the Blank / Memory Flash',
          'data' => array()),
    
    // Multiple Choice
    16 => array(
          'view' => 'multiple_choice',
          'name' => 'Multiple Choice',
          'data' => array()),
    17 => array(
          'view' => 'multiple_choice',
          'name' => 'Multiple Choice / Memory',
          'data' => array()),
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
	
	public function play($activityId, $unitId, $level = 1) {
    $unit = new Unit();
    $unit->id = $unitId;
    $unit->validate()->get();
    
    // Get a "pruned" version of the object to encode as JSON
    // the DataMapper adds all sorts of helper fields so we don't want to encode those
    $pruned = $unit->pruned();

    $data = array();
    $data['unit_json'] = json_encode($pruned);
    $data['level'] = $level;

    $activity = self::$activitiesById[$activityId];
 
		$this->load->view($activity['view'], $data);
	}
}
