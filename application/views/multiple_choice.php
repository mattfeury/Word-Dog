<? $this->load->view('head'); ?>
<? $this->load->view('activity_data'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
</header>
<section id="container">
  <section id="content">

    <h1>Multiple Choice</h1>
    <h2>Choose the sentence that best describes the picture.</h2>
    <div class="reinforcement"></div>
      <div id="lesson">
        <img class="picture" />
        <ul class="answers"></ul>
      </div>
    <div id="action-menu">
      <button class="go">Go</button>
    </div>
  </section>
</section>
<script>
  var answer;

  // We must define this!
  // Callback for renderNextLesson()
  function defineActivityForLesson(lesson) {
    //show image
    $('#lesson')
      .find('.picture')
        .attr('src', BASE_SRC + 'uploads/' + lesson['image']);
    
    var randomLessons = getOtherLessons();
    
    choices = [];

    //make sure length 2
    if (randomLessons.length > 1) { 
      choices.push(randomLessons.pop().sentence);
      choices.push(randomLessons.pop().sentence);
      choices.push(lesson.sentence);
    }
    //randomize choices
    choices.sort(function() {return 0.5 - Math.random()});
    //clear previous buttons
    $('#lesson')
      .find('.answers')
        .empty();
    //render as buttons
    $.each(choices, function(i) { 
     $('#lesson')
      .find('.answers')                                                           
        .append('<li><label><input type="radio" name="answers" value="' + i + '"/>' + choices[i] + '</label></li>');
    });
    //check first radio button
    $('#lesson')
      .find('input[value="0"]')
        .attr('checked', true);
     
    answer = choices.indexOf(lesson.sentence);
  }

$(document).ready(function(){
  //load first lesson
  renderNextLesson();
  
   //check answer
   $('.go').click(function(event){

     var $input = $('input[name="answers"]:checked').val();

     var isCorrect = ($input == answer);
     $('.reinforcement').html( (isCorrect ? 'Correct!' : 'Incorrect') );
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
           }
       });
 });
 </script>
<? $this->load->view('tail'); ?>
