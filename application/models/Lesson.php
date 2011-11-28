<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lesson extends DataMapper {
  
  var $has_one = array('unit');
  var $default_order_by = array('id' => 'asc');

  // IMPORTANT
  //
  // Questions are stored as a stringified JSON data structure. It is simply an array of a "Question" object.
  // It is defined as such:
  //
  // var question1 = {
  //   // Question text
  //   question: "Who is your daddy, and what does he do?",
  //   
  //   // Index of correct answer
  //   answer: 0,
  //   
  //   // Array of answers. NOTE: order is important as the answer field corresponds with index of this array.
  //   answers: [
  //     "Cop",
  //     "Doctor",
  //     "Lawyer"
  //   ]
  //
  // }  
  var $validation = array(
    'sentence' => array(
      'label' => 'Sentence',
      'rules' => array('trim', 'required'),
    ),
    'image' => array(
      'label' => 'Image',
      'rules' => array('trim')
    ),
    // See note above about questions
    'questions' => array(
      'get_rules' => array('json_to_questions')
    )
  );

  function pruned() {
    $pruned = new stdClass;
    $pruned->id = $this->id;
    $pruned->sentence = $this->sentence;
    $pruned->image = $this->image;
    $pruned->questions = $this->questions;

    return $pruned;
  }

  function _json_to_questions($field) // optional second parameter is not used
  {
    if (!empty($this->{$field})) {
      $this->{$field} = json_decode($this->{$field}, true);
    } else {
      $this->{$field} = json_decode('[]', true);
    }
  }
    
  
}
