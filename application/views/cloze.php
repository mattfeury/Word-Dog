<? $this->load->view('head'); ?>
<? $this->load->view('activity_data'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
</header>
<section id="container">
  <section id="content">

    <h1>Fill in the Blank</h1>
    <h2>Write a sentence for the picture below:</h2>
    <div class="reinforcement"></div>
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
var missingWord,
    numChoices = 3; //number of choices to display.
function defineActivityForLesson(lesson) {
  // Remove a random word from the sentence. Replace with button
  var sentence = lesson.sentence,
      split = sentence.split(/\W+/).removeWhere(''), //splits words only (no punctuation)
      toRemove = Math.floor(Math.random()* split.length);

  missingWord = split[toRemove];
  // Find the two sentence fragments surrounding the word
  var sandwich = sentence.split(missingWord);

  // Create a button for the missing word that, when clicked, shows the input
  var $missingWordButton =
    $('<span/>')
      .addClass('missing')
      .append(
        $('<button/>')
          .addClass('cover')
          .text('______')
      )
      .append(
        $('<input type="text" />')
          .addClass('guess')
      );
  var $sentenceWithBlank = 
    $('<div/>')
      .append(document.createTextNode(sandwich.shift()))
      .append($missingWordButton)
      .append(document.createTextNode(sandwich.join(missingWord)));

  // Replace image, sentence with missing word, and word choices (if we need to)
  $('#lesson')
    .find('.picture')
      .attr('src', BASE_SRC + 'uploads/' + lesson['image'])
    .end()
    .find('.sentence')
      .html($sentenceWithBlank.html());

  //if choices
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

//check answer
function checkAnswer() {
  //check if starts with upper case and ends with a period
  var input = $('input.guess').val();
  var isCorrect = input == missingWord;
  $('.reinforcement').html( (isCorrect ? 'Correct!' : 'Incorrect') );
  $('.reinforcement').addClass( (isCorrect ? 'correct' : 'incorrect') ); 
  $('.reinforcement').removeClass( (isCorrect ? 'incorrect' : 'correct') );

  if (isCorrect)
    setTimeout(function() { renderNextLesson(); }, 1000);

};

$(document).ready(function(){
  
  //load first lesson
  renderNextLesson();

  $('.cover').live('click', function() {
    $(this).closest('.missing').addClass('guessing');
  })
  $('.guess').live('keypress', function(e) {
    if(e.which == 13) {
      checkAnswer();
      return false;
    }
  });
 });
 </script>
<? $this->load->view('tail'); ?>
