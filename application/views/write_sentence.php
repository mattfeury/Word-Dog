<? $this->load->view('head'); ?>
<? $this->load->view('activity_data'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
</header>
<section id="container">
  <section id="content">

    <h1>Write Sentence</h1>
    <h2>Write a sentence for the picture below. Be sure to use correct capitalization and punctuation!</h2>
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
   var isPrint = <?= ($print == '') ? 0 : 1 ?>;
   //specify html for printing for every lesson in the unit
   if(isPrint){
     var $print = $('<div/>')
      .append('<h1>' + $('h1').text() + '</h1>')
      .append('<h2>' + $('h2').text() + '</h2>');
     $.each(unit.lessons, function() {
       $print
        .append('<p><img src = "' + BASE_SRC + 'uploads/' + this['image'] + '"/></p>')
        .append('<p><span class="handwrite"> </span></p>')
        .append('<p><span class="handwrite"> </span></p>')
        .append('<p><span class="handwrite"> </span></p>');
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
