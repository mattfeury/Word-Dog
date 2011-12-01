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
        <input type="hidden" id="baseURL" value="<?=base_url() ?>">
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
      //show image
      baseURL = $('#lesson')
        .find('#baseURL')
          .val();
      $('#lesson')
        .find('.picture')
          .attr('src', baseURL + '/uploads/' + lesson['image']);
    }
    //show question    
    $('#lesson')
      .find('.question')
        .text(lesson['questions'][questionNum]['question']);
    //show answers    
    $('#lesson')
      .find('.answers')
        .html('<p><input type="radio" name="answers0" value="0" checked><label>' + lesson['questions'][questionNum]['answers'][0] + '</label></p><p><input type="radio"  name="answers0" value="1"><label>' + lesson['questions'][questionNum]['answers'][1] + '</label></p><p><input type="radio" name="answers0" value="2"><label>' + lesson['questions'][questionNum]['answers'][2] + '</label></p>');

    answer = lesson['questions'][questionNum]['answer'];
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

     if (isCorrect && questionNum < currLesson['questions'].length - 1)
       setTimeout(function() { questionNum++; defineActivityForLesson(currLesson); }, 1000);
     else if(isCorrect)
       setTimeout(function() { questionNum = 0; renderNextLesson(); }, 1000);       
   });
   $('.sentence').keypress(function(e) {
           if(e.which == 13) {
               $('.go').click();
           }
       });
 });
 </script>
<? $this->load->view('tail'); ?>
