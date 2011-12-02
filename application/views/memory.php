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
      <img class="picture" />
      <span class="sentence"></span>
      <input name="sentence" class="sentence covered" type="text" autocomplete="off" />
    </div>
    <div id="action-menu">
      <button class="cover">Cover</button>
      <button class="uncover covered">Uncover</button>
      <button class="go covered">Go</button>
    </div>
  </section>
</section>
<script>
// We must define this!
// Callback for renderNextLesson()
function defineActivityForLesson(lesson) {
  // Remove correct indicator
  $('.reinforcement')
    .removeClass('incorrect correct')
    .text('');

  // Replace image and sentence
  $('#lesson')
    .find('span.sentence')
      .text(lesson['sentence'])
    .end()
    .find('input.sentence')
      .val('')
    .end()
    .find('.picture')
      .attr('src', config.base + 'uploads/' + lesson['image']);      
}

//Cover for memory
$(document).ready(function(){

  //load first lesson
  renderNextLesson();
  
  $('.cover').click(function(event){
    // Cover sentence and clear input
    $('#lesson')
      .find('.sentence')
        .toggleClass('covered')
        .filter('input')
          .val('')
          .focus();

    // Cover image
    if (config.coverPicture)
      $('#lesson').find('.picture').addClass('covered');
       
    $('#action-menu button').toggleClass('covered');
  });
  $('.uncover').click(function(event){
    // Uncover sentence and clear input
    $('#lesson').find('.sentence').toggleClass('covered').val('');

    // Uncover image
    if (config.coverPicture)
      $('#lesson').find('.picture').removeClass('covered');

    $('.reinforcement').html('');
    $('#action-menu button').toggleClass('covered');
  });
  
  //check answer
  $('.go').click(function(event){
    var isCorrect = ($('input').val()) === ($('.sentence').html());
    $('.reinforcement').text( (isCorrect ? 'Correct!' : 'Incorrect') );
    $('.reinforcement').addClass( (isCorrect ? 'correct' : 'incorrect') ); 
    $('.reinforcement').removeClass( (isCorrect ? 'incorrect' : 'correct') );

    if (isCorrect) {
      correct();
      setTimeout(function() { renderNextLesson(); $('.uncover').click() }, 1000);
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
