<? $this->load->view('head'); ?>
<? $this->load->view('activity_data'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
</header>
<section id="container">
  <section id="content">
    <h1>Memory</h1>
    <h2>Memorize the sentence and type it into the box.</h2>
    <div class="reinforcement"></div>

    <div class="choose-difficulty">
      <ul class="difficulties"></ul>
    </div>
    <div class="activity">
      <div id="lesson">
        <img class="picture" />
        <span class="sentence"></span>
        <input name="sentence" class="sentence covered" type="text" autocomplete="off" />
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
  // Remove correct indicator
  $('.reinforcement')
    .removeClass('incorrect correct')
    .text('');

  var sentence = (config.jumbleSentence) ? jumbleSentence(lesson['sentence']) : lesson['sentence'];
  // because we will check the user's input with 'originalSentence',
  // it should be defined for jumble or otherwise.
  originalSentence = lesson['sentence'];

  // Replace image and sentence
  $('#lesson')
    .find('span.sentence')
      .text(sentence)
    .end()
    .find('input.sentence')
      .val('')
    .end()
    .find('.picture')
      .attr('src', config.base + 'uploads/' + lesson['image']);

  if (COVERED)
    uncover();
  resetCoverTimer(sentence);
}
var difficulties = [ //seconds per word before hiding
  { name: 'Easy', secsPerWord: .5 },
  { name: 'Medium', secsPerWord: .4 },
  { name: 'Hard', secsPerWord: .3}
],
  difficulty = {},
  COVERED = false,
  difficultyTimeout = -1;

function resetCoverTimer(sentence) {
  //if difficulty was set, set the timer to hide
  if (config.chooseDifficulty && difficulty.secsPerWord) {
    var words = sentence.split(' ').length,
        seconds = difficulty.secsPerWord * words;
    
    clearTimeout(difficultyTimeout);
    difficultyTimeout = setTimeout(function() {
      if (! COVERED)
        cover();
    }, seconds * 1000); //must be in ms
  }
}
function cover() {
  // Cover sentence and clear input
  $('#lesson')
    .find('.sentence')
      .toggleClass('covered')
      .filter('input')
        .val('')
        .focus();

  // Cover image
  if (config.coverPicture)
    $('#lesson').find('.picture').addClass('covered');
     
  $('#action-menu button').toggleClass('covered');
  COVERED = true;
}
function uncover() {
  // Uncover sentence and clear input
  $('#lesson').find('.sentence').toggleClass('covered').val('');

  // Uncover image
  if (config.coverPicture)
    $('#lesson').find('.picture').removeClass('covered');

  $('.reinforcement').html('');
  $('#action-menu button').toggleClass('covered');
  COVERED = false;
  resetCoverTimer($('#lesson').find('span.sentence').text());
}

//Cover for memory
$(document).ready(function(){

  // Either choose difficulty or load first lesson
  // This depends on which activity this is: 'static' or 'flash'
  if (config.chooseDifficulty) {
    $('#content .activity').hide();
    $.each(difficulties, function(i, item) {
      $('.difficulties').append(
        $('<li/>')
          .append(
            $('<button/>')
              .text(item.name)
              .click(function() {
                difficulty = item;
                renderNextLesson();
                $('#content .activity').show();    
                $('.difficulties').hide();
              })
        )
      )
    });
  } else {
    renderNextLesson();
  }
  
  $('.cover').click(cover);
  $('.uncover').click(uncover);
  
  //check answer
  $('.go').click(function(event){
    var isCorrect = $('input.sentence').val() == originalSentence;
    $('.reinforcement').text( (isCorrect ? 'Correct!' : 'Incorrect') );
    $('.reinforcement').addClass( (isCorrect ? 'correct' : 'incorrect') ); 
    $('.reinforcement').removeClass( (isCorrect ? 'incorrect' : 'correct') );

    if (isCorrect) {
      correct();
      setTimeout(function() { renderNextLesson(); }, 1000);
    } else {
      incorrect();
    }
       
  });
  $('.sentence').keypress(function(e) {
    if(e.which == 13) {
      $('.go').click();
      return false;
    }
  });
});
</script>
<? $this->load->view('tail'); ?>
