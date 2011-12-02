<? $this->load->view('head'); ?>
<? $this->load->view('activity_data'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
</header>
<section id="container">
  <section id="content">

    <h1>Answer Question</h1>
    <h2>Choose an answer to the question below:</h2>
    <div class="reinforcement"></div>
      <div id="lesson">
        <img class="picture" />
        <div class="question"></div>
        <div class="answers"></div>
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
    answer = answers.indexOf(answerString);
    currLesson = lesson;
  }

$(document).ready(function(){
  questionNum = 0;
  //load first lesson
  renderNextLesson();
  
   //check answer
   $('.go').click(function(event){
     //check if starts with upper case and ends with a period
     $input = $('input[name="answers0"]:checked').val();
     
     var isCorrect = ($input == answer);
     $('.reinforcement').html( (isCorrect ? 'Correct!' : 'Incorrect') );
     $('.reinforcement').addClass( (isCorrect ? 'correct' : 'incorrect') ); 
     $('.reinforcement').removeClass( (isCorrect ? 'incorrect' : 'correct') );

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
