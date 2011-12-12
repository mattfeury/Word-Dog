<? $this->load->view('head'); ?>
<? $this->load->view('activity_data'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
</header>
<section id="container">
  <section id="content">
    <h1 id="name"><?= $activity["name"] ?></h1>
    <h2 id="instruction"><?= $activity["instruction"] ?></h2>

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
function defineActivityForLesson(lesson, $target) {
  //define elements in the DOM or target for printing
  var forPrint = ! $target ? false : true;
  $target = ! $target ? $('#lesson') : $target;
  
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

  $target.find('.choices').empty();
  $.each(choices, function(i, choice) {
    $target.find('.choices').append(
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
  $target
    .find('.picture')
      .attr('src', config.base + 'uploads/' + lesson['image']);
 
  if (COVERED)
    uncover();
  
  return $target;
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
  
  //specify html for printing for every lesson in the unit
   if(isPrint){
     var $print = $('<div/>')
      .append('<h1>' + $('h1').text() + '</h1>')
      .append('<h2>' + $('h2').text() + '</h2>');
     $.each(unit.lessons, function(i, lesson) {
       var $template = $('<div><img class="picture" /><ol class="input choices"></ol></div>');
       defineActivityForLesson(lesson, $template);
       $print.append($template.html());        
     });
     // Create bank
     $print.append('<ul class="connector-bank"></ul>');
     $allChoices = $print.find('.choices').find('li');
     $print.find('.connector-bank').append($allChoices);
     
     // Restyle images
     //$print.find('img').wrap('<div class="connector-image" />');
     $print.find('img').wrapAll('<div class="connector-images" />');
     
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
