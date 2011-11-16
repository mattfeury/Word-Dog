<? $this->load->view('head'); ?>
<? $this->load->view('activity_data'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
</header>
<section id="container">
  <section id="content">
    <h1>Memory</h1>
    <h2>Memorize the sentence then type it:</h2>
    <div class="reinforcement"></div>
  
    <div id="lesson">
      <span class="sentence"></span>
      <input name="sentence" class="sentence covered" type="text" autocomplete="off" />
    </div>
    <div id="action-menu">
      <button class="cover">Cover</button>
      <button class="go covered">Go</button>
    </div>
  </section>
</section>
<script>
  // We must define this!
  // Callback for renderNextLesson()
  function defineActivityForLesson(lesson) {
    $('#lesson')
      .find('.sentence')
        .text(lesson['sentence']);
  }

//Cover for memory
$(document).ready(function(){

  //load first lesson
  renderNextLesson();

   $('.cover').click(function(event){
     $('.sentence')
      .toggleClass('covered')
      //clear input
      .val('');
     $('.reinforcement').html('');
     $('.go').toggleClass('covered');
     var isCovered = $('.go').hasClass('covered');
     $('.cover').html( (isCovered ? 'Cover' : 'Uncover') );
   });
   //check answer
   $('.go').click(function(event){
     console.log(($('span.sentence').text()));
     var isCorrect = ($('input').val()) === ($('.sentence').html());
     $('.reinforcement').html( (isCorrect ? 'Correct!' : 'Incorrect') );
     $('.reinforcement').addClass( (isCorrect ? 'correct' : 'incorrect') ); 
     $('.reinforcement').removeClass( (isCorrect ? 'incorrect' : 'correct') );

     if (isCorrect)
       setTimeout(function() { renderNextLesson(); $('.cover').click() }, 1000);
       
   });
   $('.sentence').keypress(function(e) {
           if(e.which == 13) {
               $('.go').click();
           }
       });
 });
 </script>
<? $this->load->view('tail'); ?>
