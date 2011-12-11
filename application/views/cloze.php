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
      <ul class="choices">
      </ul>
    </div>
  </section>
</section>
<script>
// We must define this!
// Callback for renderNextLesson()

var numChoices = 3; //number of choices to display.
function defineActivityForLesson(lesson) {
  // Remove a random word from the sentence. Replace with button
  var sentence = lesson.sentence,
      clozeHtml = createCloze(sentence, 1);

  var missingWord = $(clozeHtml).find('.guess').attr('data-answer');

  // Replace image, sentence with missing word, and word choices (if we need to)
  $('#lesson')
    .find('.sentence')
      .html(clozeHtml);

  if (config.displayPicture) {
    $('#lesson')
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

    $('#lesson .choices').empty();
    $.each(choices, function(i, choice) {
      $('#lesson .choices').append(
        $('<li/>').text(choice)
      )
    });
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

  $('.guess').live('keypress', function(e) {
    if(e.which == 13) {
      checkAnswer($(this));
      return false;
    }
  });
 });
 </script>
<? $this->load->view('tail'); ?>
