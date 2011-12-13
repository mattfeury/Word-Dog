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
    if (isCorrect) {
      correct();
      setTimeout(function() { renderNextLesson(); }, 1000);
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
     $.each(unit.lessons, function() {
       if(!config.hidePicture) $print.append('<img src = "' + BASE_SRC + 'uploads/' + this['image'] + '"/>');      
        $print
        .append('<p>' + jumbleSentence(this['sentence']) + '</p>')
        .append('<div class="handwrite top-line"> </div>')
        .append('<div class="handwrite"> </div>')
        .append('<div class="handwrite bottom-line"> </div>');
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
