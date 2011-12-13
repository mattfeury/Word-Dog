<? $this->load->view('head'); ?>
<? $this->load->view('activity_data'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
</header>
<section id="container">
  <section id="content">
    <h1 id="name"><?= $activity["name"] ?></h1>
    <h2 id="instruction"><?= $activity["instruction"] ?></h2>

    <div class="choose-difficulty">
      <h3>Choose a Difficulty to begin.</h3>
      <ul class="rows difficulties"></ul>
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
function defineActivityForLesson(lesson, $target) {
  var forPrint = ! $target ? false : true;
  $target = ! $target ? $('#lesson') : $target;
  var sentence = (config.jumbleSentence) ? jumbleSentence(lesson['sentence']) : lesson['sentence'];

  // Replace image and sentence
  $target
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
      var numBlanks = difficulty.numBlanks || 1;
      $target
        .find('.input')
          .html(createCloze(sentence, numBlanks))
      break;
    default:
  }
  
  if (COVERED)
    uncover();
  resetCoverTimer(sentence);
  
  // Printing
  if(forPrint) {
    // Hide input boxes
    $target.find('input').hide();
    // Put in handwritten blanks
    $target.find('.missing').replaceWith('<span class="blank"></span>');
    // Hides picture for all coverPictures and special case where print is different than game
    if(config.coverPicture || config.coverPrintPicture) $target.find('.picture').hide();
  }
  
}
var difficulty = {},
  COVERED = false,
  difficultyTimeout = -1;

function resetCoverTimer(sentence) {
  //if difficulty was set, set the timer to hide
  if (config.difficulties.length && difficulty.secsPerWord) {
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
    .find('input:visible:not(.cloze)')
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

function renderPrint() {
  // Set print instructions only if defined
  var printInstruction = config.printInstruction ? config.printInstruction : '';
  var $print = $('<div/>')
   .append('<h1>' + $('h1').text() + '</h1>')
   .append('<h2>' +  printInstruction  + '</h2>');
   $.each(unit.lessons, function(index, lesson) {
     var $template = $('<div><img class="picture" /><div class="sentence"></div><div class="input covered"><input name="sentence" class="answer" type="text" autocomplete="off" /></div></div>');
     defineActivityForLesson(lesson, $template);
     $print.append($template.html());
   });
   //break page so users write on back - only for memory activities
   if(config.needsHandwriting) {
     $print
      .append('<p class="pagebreak"></p>');
     $.each(unit.lessons, function() {
       $print
        .append('<div class="handwrite top-line"> </div>')
        .append('<div class="handwrite"> </div>')
        .append('<div class="handwrite bottom-line"> </div>');
     });
   }
   // Move blank sentences to bottom and randomize for memory-cloze
   if(config.randomizePrintSentences) {
     var blankSentences = $print.find('.input');
     // Randomize
     blankSentences.sort(function() {return 0.5 - Math.random()});
     $print.append('<div class="random-sentences"></div');
     $print.find('.random-sentences').append(blankSentences);
   }
   printActivity($print.html());
}

//Cover for memory
$(document).ready(function(){

  // Either choose difficulty or load first lesson
  // This depends on which activity this is: 'static' or 'flash'
  if (config.difficulties.length) {
    $('#content .activity').hide();
    $.each(config.difficulties, function(i, item) {
      $('.difficulties').append(
        $('<li/>')
          .append(
            $('<button/>')
              .text(item.name)
              .click(function() {
                difficulty = item;
                renderNextLesson();
                $('#content .activity').show();    
                $('.choose-difficulty').remove();
                // Print after difficulty has been chosen
                if(isPrint) renderPrint();
              })
        )
      )
    });
  } else {
    $('.choose-difficulty').remove();
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
  // Print if in print mode and activity has no difficulties
  if(isPrint && !config.printWithDifficulties){
    renderPrint();
   }
  // Mimics 'go' press on enter key press
  $('.answer').live('keypress', function(e) {
    if(e.which == 13) {
      $('.go').click();
      return false;
    }
  });
});
</script>
<? $this->load->view('tail'); ?>
