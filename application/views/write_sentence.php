<? $this->load->view('head'); ?>
<? $this->load->view('activity_data'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
</header>
<section id="container">
  <section id="content">

    <h1>Write Sentence</h1>
    <h2>Write a sentence for the picture below. Be sure to use correct capitalization and punctuation!</h2>
    <div class="reinforcement"></div>
    <div id="lesson">
      <img class="picture" />
      <input name="sentence" class="sentence" type="text" autocomplete="off"/>
    </div>
    <div id="action-menu">
      <button class="go">Go</button>
      <button class="print">Print</button>
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
     $('.reinforcement').html( (isCorrect ? 'Correct!' : 'Incorrect') );
     $('.reinforcement').addClass( (isCorrect ? 'correct' : 'incorrect') ); 
     $('.reinforcement').removeClass( (isCorrect ? 'incorrect' : 'correct') );

     if (isCorrect) {
       correct();
       setTimeout(function() { renderNextLesson(); $('#lesson input').val(''); }, 1000);
      } else {
        incorrect();
      }
   });
   $('.print').click(function(event){
     var printWindow = window.open();
     printWindow.document.write('<a href="javascript:window.print()">print</a>');
     printWindow.document.write('<h1>' + $('h1').text() + '<h1>');
     printWindow.document.write('<h2>' + $('h2').text() + '<h2>');
     $.each(unit.lessons, function() {
       printWindow.document.write('<p><img src = "' + BASE_SRC + 'uploads/' + this['image'] + '"/></p>');
       printWindow.document.write('<p><span style="border-bottom: 1px solid black; display: inline-block; width: 600px;"> </span></p>');
       printWindow.document.write('<p><span style="border-bottom: 1px solid black; display: inline-block; width: 600px;"> </span></p>');
       printWindow.document.write('<p><span style="border-bottom: 1px solid black; display: inline-block; width: 600px;"> </span></p>');
     });
     printWindow.document.close();
   });
   $('.sentence').keypress(function(e) {
           if(e.which == 13) {
               $('.go').click();
           }
       });
 });
 </script>
<? $this->load->view('tail'); ?>
