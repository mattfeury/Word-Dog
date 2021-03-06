<? $this->load->view('head'); ?>
<? $this->load->view('activity_data'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
</header>
<section id="container">
  <section id="content">

    <h1 id="name"><?= $activity["name"] ?></h1>
    <h2 id="instruction"><?= $activity["instruction"] ?></h2>
    <div id="lesson">
      <img class="picture" />
      <div class="question"></div>
      <ul class="answers"></ul>
      <input name="answer" class="sentence" type="text" autocomplete="off"/>
    </div>
    <div id="action-menu">
      <button class="go">Go</button>
    </div>
  </section>
</section>
<script>
  var answer;
  var questionNum;
  var currLesson;
  // We must define this!
  // Callback for renderNextLesson()
  function defineActivityForLesson(lesson, $target) {
    //move on to next lesson if this has no questions
    if(lesson['questions'].length < 1) renderNextLesson();
    var forPrint = ! $target ? false : true;
    $target = ! $target ? $('#lesson') : $target;
      
    if(questionNum == 0) {
      $target
        .find('.picture')
          .attr('src', BASE_SRC + 'uploads/' + lesson['image']);
    } else if (forPrint) {
      $target
        .find('.picture')
          .removeAttr('src');
    }
    //show question    
    $target
      .find('.question')
        .text(lesson['questions'][questionNum]['question'])
      .end()
      .find('input:text').val('')
        .focus();
    
    // Remove correct indicator
    $('.reinforcement')
      .removeClass('incorrect correct')
      .text('');

    //clear previous buttons    
    $target
      .find('.answers')
        .empty();
    var answers = lesson['questions'][questionNum]['answers'];
    var answerIndex = lesson['questions'][questionNum]['answer'];
    var answerString = lesson['questions'][questionNum]['answers'][answerIndex];
    //randomize answers
    answers.sort(function() {return 0.5 - Math.random()});
    
    $.each(answers, function(i) { 
      $target
        .find('.answers')                                                           
          .append('<li><label><input type="radio" name="answers0" value="' + i + '"/>' + answers[i] + '</label></li>');
    });
    //check first radio button
    if (!forPrint) 
      $target
        .find('input[value="0"]')
          .attr('checked', true);
    if(!config.hideChoices) {
      $('.sentence').hide();
      $('.answers').show();
      answer = answers.indexOf(answerString);
    } else {
      if(!forPrint) {
        $('.answers').hide();
        $('.sentence').show();
        //strip period and make lower case for comparison
        answer = answerString.toLowerCase().replace(/\./g,'');
      } else {
        $target.find('.answers').hide();
        $target.find('.sentence').hide();
        //handwriting space for print version
        $target
          .append('<div class="handwrite top-line"> </div>')
          .append('<div class="handwrite"> </div>')
          .append('<div class="handwrite bottom-line"> </div>');
      }
    }
    currLesson = lesson;
    
    return $target;
  }

$(document).ready(function(){
  questionNum = 0;
  //load first lesson
  renderNextLesson();

   //check answer
   $('.go').click(function(event){
     var $input;
     if(!config.hideChoices)
      $input = $('input[name="answers0"]:checked').val();
     else
      //strip period and make lower case for comparison 
      $input = $('input[name="answer"]').val().toLowerCase().replace(/\./g,'');     
     
     var isCorrect = ($input == answer);

     if (isCorrect && questionNum < currLesson['questions'].length - 1) {
       correct();
       setTimeout(function() { questionNum++; defineActivityForLesson(currLesson); }, 1000);
     } else if(isCorrect) {
       correct();
       setTimeout(function() { questionNum = 0; renderNextLesson(); }, 1000);
     // TODO: skip over lesson if no questions
     } else {
       incorrect();
     }     
   });
    //specify html for printing for every lesson in the unit
    if(isPrint){
      // Set print instructions only if defined
      var printInstruction = config.printInstruction ? config.printInstruction : '';
      var $print = $('<div/>')
       .append('<h1>' + $('h1').text() + '</h1>')
       .append('<h2>' +  printInstruction  + '</h2>');
      $.each(unit.lessons, function(i, lesson) {
        $.each(lesson['questions'], function(j, question) {
          var $template = $('<div><img class="picture" /><div class="question"></div><ul class="answers"></ul></div>');
          defineActivityForLesson(lesson, $template);
          $print.append($template.html());        
          questionNum++;
        });
        questionNum = 0;
      });
      printActivity($print.html());
    }
    // Mimics 'go' press on enter key press
   $('.sentence').keypress(function(e) {
           if(e.which == 13) {
               $('.go').click();
           }
       });
 });
 </script>
<? $this->load->view('tail'); ?>
