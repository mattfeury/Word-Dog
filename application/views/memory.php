<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>

</header>
<section id="container">
  <section id="content">

    <h1>Memory</h1>
    <h2>Memorize the sentence then type it:</h2>
    <div class="reinforcement"></div>
    <?
    echo '<div id="lesson"><span class="sentence">' . $unit->lesson->get()->sentence . '</span><input name="sentence" class="sentence covered" type="text" autocomplete="off"/></div>';
    ?>
    <div id="action-menu">
      <button class="cover">Cover</button>
      <button class="go covered">Go</button>
    </div>
  </section>
</section>
<script>
//Cover for memory
$(document).ready(function(){
   $('.cover').click(function(event){
     $('.sentence')
      .toggleClass('covered')
      //clear input
      .val('');
     $('.go').toggleClass('covered');
     var isCovered = $('.go').hasClass('covered');
     $('.cover').html( (isCovered ? 'Cover' : 'Uncover') );
   });
   //check answer
   $('.go').click(function(event){
     var isCorrect = ($('input').val()) == ($('.sentence').html());
     $('.reinforcement').html( (isCorrect ? 'Correct!' : 'Incorrect') );
     $('.reinforcement').addClass( (isCorrect ? 'correct' : 'incorrect') ); 
     $('.reinforcement').removeClass( (isCorrect ? 'incorrect' : 'correct') );   
       
   });
 });
 </script>
<? $this->load->view('tail'); ?>
