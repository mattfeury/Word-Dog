<? $this->load->view('head'); ?>
<? $this->load->view('activity_data'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
</header>
<section id="container">
  <section id="content">
    <h1>Multiple Choice / Memory</h1>
    <h2>do something.</h2>

    <div class="activity">
      <div id="lesson">
        <img class="picture covered" />
        <ol class="input choices">
        </ol>
      </div>
      <div id="action-menu">
        <button class="cover">Cover</button>
        <button class="uncover covered">Uncover</button>
        <button class="go covered">Go</button>
      </div>
    </div>
  </section>
</section>
<script>

// This should render the html for a new lesson. 
// It should also handle removing/resetting anything.
function defineActivityForLesson(lesson) {
  var answer = lesson['sentence'],
      otherLessons = getOtherLessons(),
      choices = [];

  // Three choices. Shuffle them.
  choices.push(answer);
  if (otherLessons[0] && otherLessons[0].sentence)
    choices.push(otherLessons[0].sentence)
  if (otherLessons[1] && otherLessons[1].sentence)
    choices.push(otherLessons[1].sentence)

  choices.sort(function() {return 0.5 - Math.random()});

  $('#lesson .choices').empty();
  $.each(choices, function(i, choice) {
    $('#lesson .choices').append(
      $('<li class="choice"></li>')
        .append(
          $('<input type="radio" id="answer' + i + '" class="answer" name="choices" value="' + choice + '" data-answer="' + answer + '" />')
        )
        .append(
          $('<label for="answer' + i + '">' + choice + '</label>')
        )
    )
  });

  // Replace image
  $('#lesson')
    .find('.picture')
      .attr('src', config.base + 'uploads/' + lesson['image']);
 
  if (COVERED)
    uncover();
}
var COVERED = false;


function cover() {
  // Cover choices and show picture
  $('#lesson')
    .find('.input label')
      .addClass('covered')
    .end()
    .find('.picture')
      .removeClass('covered');

  $('#action-menu button').toggleClass('covered');
  COVERED = true;
}
function uncover() {
  // Uncover choices and hide picture
  $('#lesson')
    .find('.input label')
      .removeClass('covered')
    .end()
    .find('.picture')
      .addClass('covered');

  $('.reinforcement').text('');
  $('#action-menu button').toggleClass('covered');
  COVERED = false;
}

//Cover for memory
$(document).ready(function(){

  renderNextLesson();
  
  $('.cover').click(cover);
  $('.uncover').click(uncover);
  
  //check answer
  $('.go').click(function(event){
    var isCorrect = false;
    $('input.answer:checked').each(function() {
      if ($(this).val() == $(this).attr('data-answer')) {
        isCorrect = true;
        return false;
      }
    });

    if (isCorrect) {
      correct();
      setTimeout(function() { renderNextLesson(); }, 1000);
    } else {
      incorrect();
    }
       
  });
});
</script>
<? $this->load->view('tail'); ?>
