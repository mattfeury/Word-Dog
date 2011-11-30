<? $this->load->view('head'); ?>
<? $this->load->view('activity_data'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
</header>
<section id="container">
  <section id="content">

    <h1>Write Sentence</h1>
    <h2>Write a sentence for the picture below:</h2>
    <div class="reinforcement"></div>
    <?
    echo '<div id="lesson"><img class="picture" src="' . base_url() . '"/><input name="sentence" class="sentence" type="text" autocomplete="off"/></div>';
    ?>
    <div id="action-menu">
      <button class="go">Go</button>
    </div>
  </section>
</section>
<script>
  // We must define this!
  // Callback for renderNextLesson()
  function defineActivityForLesson(lesson) {
    baseURL = $('#lesson')
      .find('.picture')
        .attr('src');
    $('#lesson')
      .find('.picture')
        .attr('src', baseURL + '/uploads/' + lesson['image']);
  }
  
  function endsWith(str, suffix) {
    return str.indexOf(suffix, str.length - suffix.length) !== -1;
  }
  
  function isUpperCase( string ) {
    return string == string.toUpperCase();
  }

$(document).ready(function(){
  
  //load first lesson
  renderNextLesson();
  
   //check answer
   $('.go').click(function(event){
     //check if starts with upper case and ends with a period
     $input = $('input').val();
     var isCorrect = ($input !== '' && endsWith($input, '.') && isUpperCase($input.slice(0, 1)));
     $('.reinforcement').html( (isCorrect ? 'Correct!' : 'Incorrect') );
     $('.reinforcement').addClass( (isCorrect ? 'correct' : 'incorrect') ); 
     $('.reinforcement').removeClass( (isCorrect ? 'incorrect' : 'correct') );

     if (isCorrect)
       setTimeout(function() { renderNextLesson(); $('#lesson input').val(''); }, 1000);
       
   });
   $('.sentence').keypress(function(e) {
           if(e.which == 13) {
               $('.go').click();
           }
       });
 });
 </script>
<? $this->load->view('tail'); ?>