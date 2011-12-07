<? $this->load->view('head'); ?>
<? $this->load->view('activity_data'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
</header>
<section id="container">
  <section id="content">

    <h1>Jumble</h1>
    <h2>Unjumble the sentence below:</h2>
    <div class="reinforcement"></div>
    <div id="lesson">
      <img class="picture" />
      <div class="sentence"></div>
      <input name="sentence" class="sentence" type="text" autocomplete="off"/>
    </div>
    <div id="action-menu">
      <button class="go">Go</button>
    </div>
  </section>
</section>
<script>
 
// We must define this!
// Callback for renderNextLesson()
function defineActivityForLesson(lesson) {
  $('.reinforcement')
    .removeClass('incorrect correct')
    .text('');
  
  $('#lesson')
    .find('.picture')
      .attr('src', BASE_SRC + 'uploads/' + lesson['image']);

  originalSentence = lesson['sentence'];
  var jumbledSentence = jumbleSentence(originalSentence);

  //remove commas and uppercase on presentation
  $('#lesson div.sentence').text(jumbledSentence);
  $('#lesson input').val('');
}

$(document).ready(function(){
  
  //load first lesson
  renderNextLesson();

  // remove picture if we shouldn't show it.
  if (config.hidePicture)
    $('#lesson .picture').remove();
  
  //check answer
  $('.go').click(function(event){
    var isCorrect = ($('input').val()) === originalSentence;
    $('.reinforcement').html( (isCorrect ? 'Correct!' : 'Incorrect') );
    $('.reinforcement').addClass( (isCorrect ? 'correct' : 'incorrect') ); 
    $('.reinforcement').removeClass( (isCorrect ? 'incorrect' : 'correct') );

    if (isCorrect)
      setTimeout(function() { renderNextLesson(); }, 1000);
       
  });
  $('.sentence').keypress(function(e) {
    if(e.which == 13) {
        $('.go').click();
    }
  });
 });
 </script>
<? $this->load->view('tail'); ?>
