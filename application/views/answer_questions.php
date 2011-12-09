<? $this->load->view('head'); ?>
<? $this->load->view('activity_data'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
</header>
<section id="container">
  <section id="content">

    <h1>Answer Question</h1>
    <h2>Choose the correct answer to the question.</h2>
    <div id="lesson">
      <img class="picture" />
      <div class="question"></div>
      <div class="answers"></div>
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
  function defineActivityForLesson(lesson) {
    if(questionNum == 0) {
      $('#lesson')
        .find('.picture')
          .attr('src', BASE_SRC + 'uploads/' + lesson['image']);
    }
    //show question    
    $('#lesson')
      .find('.question')
        .text(lesson['questions'][questionNum]['question']);
    
    //clear previous buttons
    $('#lesson')
      .find('.answers')
        .empty();
    var answers = lesson['questions'][questionNum]['answers'];
    var answerIndex = lesson['questions'][questionNum]['answer'];
    var answerString = lesson['questions'][questionNum]['answers'][answerIndex];
    //randomize answers
    answers.sort(function() {return 0.5 - Math.random()});
    
    $.each(answers, function(i) { 
      $('#lesson')
        .find('.answers')                                                           
          .append('<p><input type="radio" name="answers0" value="' + i + '"/><label>' + answers[i] + '</label></p>');
    });
    //check first radio button
    $('#lesson')
      .find('input[value="0"]')
        .attr('checked', true);
    if(!config.hideChoices) {
      $('.sentence').hide();
      $('.answers').show();
      answer = answers.indexOf(answerString);
    } else {
      $('.answers').hide();
      $('.sentence').show();
      //strip period and make lower case for comparison
      answer = answerString.toLowerCase().replace(/\./g,'');
    }
    currLesson = lesson;
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
   $('.sentence').keypress(function(e) {
           if(e.which == 13) {
               $('.go').click();
           }
       });
 });
 </script>
<? $this->load->view('tail'); ?>
