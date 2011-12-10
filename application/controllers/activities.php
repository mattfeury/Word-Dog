<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activities extends CI_Controller {

  // TODO INSTRUCTIONS
  public static $activitiesById = array(
    0 => array(
          'view' => 'write_sentence',
          'name' => 'Write Sentence',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array()),
    1 => array(
          'view' => 'answer_questions',
          'name' => 'Answer Questions1',
          'requires_images' => true,
          'requires_questions' => true,
          'data' => array(
                      'hideChoices' => false
                    )),
    2 => array(
          'view' => 'answer_questions',
          'name' => 'Answer Questions2',
          'requires_images' => true,
          'requires_questions' => true,
          'data' => array(
                      'hideChoices' => true
                    )),

    // Memory
    3 => array(
          'view' => 'memory',
          'name' => 'Memory Static1',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array()),
    4 => array(
          'view' => 'memory',
          'name' => 'Memory Static2',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'coverPicture' => true
                    )),
    5 => array(
          'view' => 'memory',
          'name' => 'Memory Flash1',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'chooseDifficulty' => true
                    )),
    6 => array(
          'view' => 'memory',
          'name' => 'Memory Flash2',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'coverPicture' => true,
                      'chooseDifficulty' => true                      
                    )),

    // Jumble
    7 => array(
          'view' => 'jumble',
          'name' => 'Word Jumble1',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'hidePicture' => false
                    )),
    8 => array(
          'view' => 'jumble',
          'name' => 'Word Jumble2',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'hidePicture' => true            
                    )),
    9 => array(
          'view' => 'memory',
          'name' => 'Jumble / Memory Static1',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'jumbleSentence' => true
                    )),
    10 => array(
          'view' => 'memory',
          'name' => 'Jumble / Memory Static2',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'jumbleSentence' => true,
                      'coverPicture' => true
                    )),
    11 => array(
          'view' => 'memory',
          'name' => 'Jumble / Memory Flash1',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'jumbleSentence' => true,
                      'chooseDifficulty' => true
                    )),
    12 => array(
          'view' => 'memory',
          'name' => 'Jumble / Memory Flash2',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'jumbleSentence' => true,
                      'coverPicture' => true,
                      'chooseDifficulty' => true
                    )),

    // Cloze
    13 => array(
          'view' => 'cloze',
          'name' => 'Fill in the Blank1',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'displayPicture' => true,
                      'showChoices' => true
                    )),
    14 => array(
          'view' => 'cloze',
          'name' => 'Fill in the Blank2',
          'requires_images' => false,
          'requires_questions' => false,
          'data' => array(
                      'displayPicture' => false,
                      'showChoices' => true
                    )),
    15 => array(
          'view' => 'cloze',
          'name' => 'Fill in the Blank3',
          'requires_images' => false,
          'requires_questions' => false,
          'data' => array(
                      'displayPicture' => false,
                      'showChoices' => false
                    )),
    16 => array(
          'view' => 'cloze',
          'name' => 'Fill in the Blank / Memory Static', //TODO
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array()),
    17 => array(
          'view' => 'cloze',
          'name' => 'Fill in the Blank / Memory Flash', //TODO
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array()),
    
    // Multiple Choice
    18 => array(
          'view' => 'multiple_choice',
          'name' => 'Multiple Choice',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array()),
    19 => array(
          'view' => 'multiple_choice',
          'requires_images' => true,
          'requires_questions' => false,
          'name' => 'Multiple Choice / Memory', //TODO
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

    // has images?
    $hasImages = true;
    foreach ($unit->lessons->get() as $lesson)
      if (! isset($lesson->image) || $lesson->image == "")
        $hasImages = false;

    // has questions?
    $hasQuestions = true;
    foreach ($unit->lessons->get() as $lesson)
      if (! isset($lesson->questions) || $lesson->questions == "[]" || count($lesson->questions) == 0)
        $hasQuestions = false;

    $unit->hasImages = $hasImages;
    $unit->hasQuestions = $hasQuestions;

    $data['activities'] = self::$activitiesById;
    
		$this->load->view('activity', $data);
  }
	
	public function play($activityId, $unitId, $level = 1, $print = false) {
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
    $isPrint = false;
    $data['print'] = $print;
		$this->load->view($activity['view'], $data);
	}
}
