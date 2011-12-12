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
     //check if starts with upper case and ends with a period, comma or question mark
     $input = $('input[name="sentence"]').val();

     var isCorrect = ($input !== '' && (endsWith($input, '.') || endsWith($input, '!') || endsWith($input, '?')) && isUpperCase($input.slice(0, 1)));
     if (isCorrect) {
       correct();
       setTimeout(function() { renderNextLesson(); $('#lesson input').val(''); }, 1000);
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
       $print
        .append('<img src = "' + BASE_SRC + 'uploads/' + this['image'] + '"/>')
        .append('<div class="handwrite top-line"> </div>')
        .append('<div class="handwrite"> </div>')
        .append('<div class="handwrite bottom-line"> </div>');
     });
     printActivity($print.html());
   }
   $('.sentence').keypress(function(e) {
           if(e.which == 13) {
               $('.go').click();
           }
       });
 });
 </script>
<? $this->load->view('tail'); ?>
