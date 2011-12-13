<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * A unit object is a collection of lessons that is used to play an activity.
 */
class Unit extends DataMapper {
  
  // Define relationships for Unit object
  var $has_one = array('user');
  var $has_many = array('lesson');
  
  var $default_order_by = array('id' => 'asc');
  
  // Validation for forms  
  var $validation = array(
    'name' => array(
      'label' => 'Name',
      'rules' => array('trim', 'required'),
    )    
  );

  /**
   * Determines if this unit has images
   */
  function hasImages() {
    if ($this->lessons->count() == 0)
      return false;

    foreach ($this->lessons->get() as $lesson)
      if (! $lesson->hasImage())
        return false;

    return true;
  }
  
  /**
   * Determines if this unit has questions
   */
  function hasQuestions() {
    if ($this->lessons->count() == 0)
      return false;

    foreach ($this->lessons->get() as $lesson)
      if (! $lesson->hasQuestion())
        return false;

    return true;
  }

  /**
   * Creates a new object to pass as JSON since datamapper adds too much data to JSON encoded objects
   */
  function pruned() {
    $pruned = new stdClass;
    $pruned->id = $this->id;
    $pruned->name = $this->name;
    $pruned->showDistractor = intval($this->showDistractor);

    $pruned->lessons = array();
    foreach ($this->lessons->get() as $lesson)
      $pruned->lessons[] = $lesson->pruned();

    return $pruned;
  }
}
