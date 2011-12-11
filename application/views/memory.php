<? $this->load->view('head'); ?>
<? $this->load->view('activity_data'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
</header>
<section id="container">
  <section id="content">
    <h1>Memory</h1>
    <h2>Memorize the sentence and type it into the box.</h2>

    <div class="choose-difficulty">
      <ul class="difficulties"></ul>
    </div>
    <div class="activity">
      <div id="lesson">
        <img class="picture" />
        <div class="sentence"></div>
        <div class="input covered">
          <input name="sentence" class="answer" type="text" autocomplete="off" />
        </div>
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
  var sentence = (config.jumbleSentence) ? jumbleSentence(lesson['sentence']) : lesson['sentence'];

  // Replace image and sentence
  $('#lesson')
    .find('.sentence')
      .text(sentence)
    .end()
    .find('input.answer')
      .val('')
      .attr('data-answer', lesson['sentence']) //by default, the answer is the sentence. may get overriden below (for things like cloze)
    .end()
    .find('.picture')
      .attr('src', config.base + 'uploads/' + lesson['image']);

  switch (config.cover) {
    case 'cloze':
      $('#lesson')
        .find('.input')
          .html(createCloze(sentence, 1))
      break;
    default:
  }
  
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
    .find('.sentence, .input')
      .toggleClass('covered')
    .end()
    .find('input:visible')
      .val('')
      .focus()
    .end()
    .find('.missing.guessing') //for cloze
      .removeClass('guessing');

  // Cover image
  if (config.coverPicture)
    $('#lesson').find('.picture').addClass('covered');

  $('#action-menu button').toggleClass('covered');
  COVERED = true;
}
function uncover() {
  // Uncover sentence and hide input
  $('#lesson')
    .find('.sentence, .input')
    .toggleClass('covered');

  // Uncover image
  if (config.coverPicture)
    $('#lesson').find('.picture').removeClass('covered');

  $('.reinforcement').text('');
  $('#action-menu button').toggleClass('covered');
  COVERED = false;
  resetCoverTimer($('#lesson').find('.sentence').text());
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
    var isCorrect = true;
    $('input.answer').each(function() {
      if ($(this).val() != $(this).attr('data-answer')) {
        isCorrect = false;
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
  $('.answer').live('keypress', function(e) {
    if(e.which == 13) {
      $('.go').click();
      return false;
    }
  });
});
</script>
<? $this->load->view('tail'); ?>
