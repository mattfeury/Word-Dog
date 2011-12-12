<? $this->load->view('head'); ?>
<? $this->load->view('activity_data'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
</header>
<section id="container">
  <section id="content">

    <h1>Fill in the Blank</h1>
    <h2>Find the missing word from the choices below. Type the correct answer into the box.</h2>
    <div id="lesson">
      <img class="picture" />
      <span class="sentence"></span>
      <ul class="choices"></ul>
    </div>
  </section>
</section>
<script>
// We must define this!
// Callback for renderNextLesson()

var numChoices = 3; //number of choices to display.
function defineActivityForLesson(lesson, $target) {
  var forPrint = ! $target ? false : true;
  $target = ! $target ? $('#lesson') : $target;
  // Remove a random word from the sentence. Replace with button
  var sentence = lesson.sentence,
      clozeHtml = createCloze(sentence, 1);

  var missingWord = $(clozeHtml).find('.answer').attr('data-answer');

  // Replace image, sentence with missing word, and word choices (if we need to)
  $target
    .find('.sentence')
      .html(clozeHtml);

  if (config.displayPicture) {
    $target
      .find('.picture')
        .attr('src', BASE_SRC + 'uploads/' + lesson['image'])
      .end();
  }

  if (config.showChoices) {
    var otherLessons = getOtherLessons(),  
        choices = [];
    choices.push(missingWord);
    for(var i = 0; i < numChoices - 1; i++)
      if (otherLessons.length)
        choices.push(otherLessons.shift().sentence.split(/\W+/).removeWhere('').sort(function() {return 0.5 - Math.random()}).pop());

    $target.find('.choices').empty();
    $.each(choices, function(i, choice) {
      $target.find('.choices').append(
        $('<li/>').text(choice)
      )
    });
  } 
  // Remove button and inputs when printing
  if(forPrint) { 
    $target.find('.missing').replaceWith('<span class="blank"></span>');
  }
}

//check answer
function checkAnswer($input) {
  //check if starts with upper case and ends with a period
  var input = $input.val();
  var isCorrect = input == $input.attr('data-answer');

  if (isCorrect) {
    correct();
    setTimeout(function() { renderNextLesson(); }, 1000);
  } else {
    incorrect();
  }

};

$(document).ready(function(){
  
  //load first lesson
  renderNextLesson();

  //specify html for printing for every lesson in the unit
  if(isPrint){
    var $print = $('<div/>')
      .append('<h1>' + $('h1').text() + '</h1>')
      .append('<h2>Find the missing word.</h2>');
    $.each(unit.lessons, function(i, lesson) {
      var $template = $('<div><img class="picture" /><div class="sentence"><span class="missing"></span></div><ul class="choices"></ul></div>');
      defineActivityForLesson(lesson, $template);
      $print.append($template.html());        
    });
    // Create bank
    $print.append('<ul class="bank"></ul>');
    $allChoices = $print.find('.choices').find('li');
    $print.find('.bank').append($allChoices);
    // Remove duplicates
    var seen = {};
    $print.find('li').each(function() {
        var txt = $(this).text();
        if (seen[txt])
            $print.find(this).remove();
        else
            seen[txt] = true;
    });
    
    printActivity($print.html());
  }
  $('.answer').live('keypress', function(e) {
    if(e.which == 13) {
      checkAnswer($(this));
      return false;
    }
  });
 });
 </script>
<? $this->load->view('tail'); ?>
