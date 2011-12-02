<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activities extends CI_Controller {

  // TODO INSTRUCTIONS
  public static $activitiesById = array(
    0 => array(
          'view' => 'write_sentence',
          'name' => 'Write Sentence',
          'data' => array()),
    1 => array(
          'view' => 'answer_questions', //TODO
          'name' => 'Answer Questions1',
          'data' => array(
                      'showChoices' => true
                    )),
    2 => array(
          'view' => 'answer_questions', //TODO
          'name' => 'Answer Questions2',
          'data' => array(
                      'showChoices' => false
                    )),

    // Memory
    3 => array(
          'view' => 'memory',
          'name' => 'Memory Static1',
          'data' => array()),
    4 => array(
          'view' => 'memory',
          'name' => 'Memory Static2',
          'data' => array(
                      'coverPicture' => true
                    )),
    5 => array(
          'view' => 'memory',
          'name' => 'Memory Flash1',
          'data' => array(
                      'chooseDifficulty' => true
                    )),
    6 => array(
          'view' => 'memory',
          'name' => 'Memory Flash2',
          'data' => array(
                      'coverPicture' => true,
                      'chooseDifficulty' => true                      
                    )),

    // Jumble
    7 => array(
          'view' => 'jumble',
          'name' => 'Word Jumble1',
          'data' => array(
                      'hidePicture' => false
                    )),
    8 => array(
          'view' => 'jumble',
          'name' => 'Word Jumble2',
          'data' => array(
                      'hidePicture' => true            
                    )),
    9 => array(
          'view' => 'memory',
          'name' => 'Jumble / Memory Static1',
          'data' => array(
                      'jumbleSentence' => true
                    )),
    10 => array(
          'view' => 'memory',
          'name' => 'Jumble / Memory Static2',
          'data' => array(
                      'jumbleSentence' => true,
                      'coverPicture' => true
                    )),
    11 => array(
          'view' => 'memory',
          'name' => 'Jumble / Memory Flash1',
          'data' => array(
                      'jumbleSentence' => true,
                      'chooseDifficulty' => true
                    )),
    12 => array(
          'view' => 'memory',
          'name' => 'Jumble / Memory Flash2',
          'data' => array(
                      'jumbleSentence' => true,
                      'coverPicture' => true,
                      'chooseDifficulty' => true
                    )),

    // Cloze
    13 => array(
          'view' => 'cloze',
          'name' => 'Fill in the Blank1',
          'data' => array(
                      'displayPicture' => true,
                      'showChoices' => true
                    )),
    14 => array(
          'view' => 'cloze',
          'name' => 'Fill in the Blank2',
          'data' => array(
                      'displayPicture' => false,
                      'showChoices' => true
                    )),
    15 => array(
          'view' => 'cloze',
          'name' => 'Fill in the Blank3',
          'data' => array(
                      'displayPicture' => false,
                      'showChoices' => false
                    )),
    16 => array(
          'view' => 'cloze',
          'name' => 'Fill in the Blank / Memory Static',
          'data' => array()),
    17 => array(
          'view' => 'cloze',
          'name' => 'Fill in the Blank / Memory Flash',
          'data' => array()),
    
    // Multiple Choice
    18 => array(
          'view' => 'multiple_choice',
          'name' => 'Multiple Choice',
          'data' => array()),
    19 => array(
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

    $activity = self::$activitiesById[$activityId];
    $data['activity_data'] = json_encode($activity['data']);
 
		$this->load->view($activity['view'], $data);
	}
}
