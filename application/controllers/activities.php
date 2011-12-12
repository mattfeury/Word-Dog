<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// How we define what to do in memory when covered
// Since there are many combinations with memory, we pass through
// a condition that tells it what to present and determine how to win.
class CoverConditions {
  const CLOZE = 'cloze'; // Fill in the blank
  const RETYPE = 'retype'; // Basic memory. Just retype the original sentence.
}

class Activities extends CI_Controller {

  // TODO INSTRUCTIONS
  public static $activitiesById = array(
    0 => array(
          'view' => 'write_sentence',
          'name' => 'Write Sentence',
          'instruction' => 'Write a sentence for the picture below. Be sure to use correct capitalization and punctuation!',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array()),
    1 => array(
          'view' => 'answer_questions',
          'name' => 'Answer Questions 1',
          'instruction' => 'Choose the correct answer to the question from the choices below.',
          'requires_images' => true,
          'requires_questions' => true,
          'data' => array(
                      'hideChoices' => false
                    )),
    2 => array(
          'view' => 'answer_questions',
          'name' => 'Answer Questions 2',
          'instruction' => 'Type the correct answer to the question into the box below.',
          'requires_images' => true,
          'requires_questions' => true,
          'data' => array(
                      'hideChoices' => true
                    )),

    // Memory
    3 => array(
          'view' => 'memory',
          'name' => 'Memory Static 1',
          'instruction' => 'Memorize the sentence. When you are ready, select "Cover" and type the sentence into the box. You may view the sentence again by clicking "Uncover".',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'cover' => CoverConditions::RETYPE,
                      'needsHandwriting' => true
                    )),
    4 => array(
          'view' => 'memory',
          'name' => 'Memory Static 2',
          'instruction' => 'Memorize the sentence. When you are ready, select "Cover" and type the sentence into the box. You may view the sentence again by clicking "Uncover".',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'cover' => CoverConditions::RETYPE,
                      'coverPicture' => true,
                      'needsHandwriting' => true
                    )),
    5 => array(
          'view' => 'memory',
          'name' => 'Memory Flash 1',
          'instruction' => 'Memorize the sentence and type it into the box that appears. You may view the sentence again by clicking "Uncover".',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'cover' => CoverConditions::RETYPE,
                      'difficulties' => 'time',
                      'needsHandwriting' => true,
                      'coverPrintPicture' => true
                    )),
    6 => array(
          'view' => 'memory',
          'name' => 'Memory Flash 2',
          'instruction' => 'Memorize the sentence and type it into the box that appears. You may view the sentence again by clicking "Uncover".',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'cover' => CoverConditions::RETYPE,
                      'coverPicture' => true,
                      'difficulties' => 'time',
                      'needsHandwriting' => true
                    )),

    // Jumble
    7 => array(
          'view' => 'jumble',
          'name' => 'Word Jumble 1',
          'instruction' => 'Unjumble the sentence and type the unjumbled sentence into the box.',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'hidePicture' => false
                    )),
    8 => array(
          'view' => 'jumble',
          'name' => 'Word Jumble 2',
          'instruction' => 'Unjumble the sentence and type the unjumbled sentence into the box.',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'hidePicture' => true            
                    )),
    9 => array(
          'view' => 'memory',
          'name' => 'Jumble / Memory Static 1',
          'instruction' => 'Unjumble the sentence. When you are ready, click "Cover" and type the unjumbled sentence into the box that appears. You may view the jumbled sentence again by clicking "Uncover".',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'cover' => CoverConditions::RETYPE,
                      'jumbleSentence' => true
                    )),
    10 => array(
          'view' => 'memory',
          'name' => 'Jumble / Memory Static 2',
          'instruction' => 'Unjumble the sentence. When you are ready, click "Cover" and type the unjumbled sentence into the box that appears. You may view the jumbled sentence again by clicking "Uncover".',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'cover' => CoverConditions::RETYPE,
                      'jumbleSentence' => true,
                      'coverPicture' => true
                    )),
    11 => array(
          'view' => 'memory',
          'name' => 'Jumble / Memory Flash 1',
          'instruction' => 'Unjumble the sentence and type the unjumbled sentence into the box that appears. You may view the jumbled sentence again by clicking "Uncover".',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'cover' => CoverConditions::RETYPE,
                      'jumbleSentence' => true,
                      'difficulties' => 'time'
                    )),
    12 => array(
          'view' => 'memory',
          'name' => 'Jumble / Memory Flash 2',
          'instruction' => 'Unjumble the sentence and type the unjumbled sentence into the box that appears. You may view the jumbled sentence again by clicking "Uncover".',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'cover' => CoverConditions::RETYPE,
                      'jumbleSentence' => true,
                      'coverPicture' => true,
                      'difficulties' => 'time'
                    )),

    // Cloze
    13 => array(
          'view' => 'cloze',
          'name' => 'Fill in the Blank 1',
          'instruction' => 'Find the missing word from the choices below. Type the correct answer into the box.',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'displayPicture' => true,
                      'showChoices' => true
                    )),
    14 => array(
          'view' => 'cloze',
          'name' => 'Fill in the Blank 2',
          'instruction' => 'Find the missing word from the choices below. Type the correct answer into the box.',
          'requires_images' => false,
          'requires_questions' => false,
          'data' => array(
                      'displayPicture' => false,
                      'showChoices' => true
                    )),
    15 => array(
          'view' => 'cloze',
          'name' => 'Fill in the Blank 3',
          'instruction' => 'Find the missing word from the choices below. Type the correct answer into the box.',
          'requires_images' => false,
          'requires_questions' => false,
          'data' => array(
                      'displayPicture' => false,
                      'showChoices' => false
                    )),
    16 => array(
          'view' => 'memory',
          'name' => 'Fill in the Blank / Memory Static 1',
          'instruction' => 'Read the sentence.  When you are ready click "Cover" and type the missing word into the box. You may view the complete sentence again by clicking "Uncover".',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'cover' => CoverConditions::CLOZE,
                      'difficulties' => 'numBlanks',
                      'randomizePrintSentences' => true
                    )),
    17 => array(
          'view' => 'memory',
          'name' => 'Fill in the Blank / Memory Static 2',
          'instruction' => 'Read the sentence.  When you are ready click "Cover" and type the missing word into the box. You may view the complete sentence again by clicking "Uncover".',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'cover' => CoverConditions::CLOZE,
                      'difficulties' => 'numBlanks',
                      'coverPicture' => true,
                      'randomizePrintSentences' => true
                    )),
    18 => array(
          'view' => 'memory',
          'name' => 'Fill in the Blank / Memory Flash 1',
          'instruction' => 'Read the sentence.  Type the missing word into the box that appears. You may view the complete sentence again by clicking "Uncover".',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'cover' => CoverConditions::CLOZE,
                      'difficulties' => 'numBlanksAndTime',
                      'chooseDifficulty' => true,
                      'randomizePrintSentences' => true
                    )),
    19 => array(
          'view' => 'memory',
          'name' => 'Fill in the Blank / Memory Flash 2',
          'instruction' => 'Read the sentence.  Type the missing word into the box that appears. You may view the complete sentence again by clicking "Uncover".',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array(
                      'cover' => CoverConditions::CLOZE,
                      'difficulties' => 'numBlanksAndTime',
                      'coverPicture' => true,
                      'chooseDifficulty' => true,
                      'randomizePrintSentences' => true
                    )),
    
    // Multiple Choice
    20 => array(
          'view' => 'multiple_choice',
          'name' => 'Multiple Choice',
          'instruction' => 'Choose the sentence that best describes the picture.',
          'requires_images' => true,
          'requires_questions' => false,
          'data' => array()),
    21 => array(
          'view' => 'multiple_choice',
          'name' => 'Multiple Choice / Memory',
          'instruction' => 'Read the sentences and click "Continue".  Look at the picture and select the button of the sentence that best describes the picture.',
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
    $data['activity'] = $activity;
    $isPrint = false;
    $data['print'] = $print;
		$this->load->view($activity['view'], $data);
	}
}
