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
      <span class="sentence"></span>
      <input name="sentence" class="sentence" type="text" autocomplete="off"/>
    </div>
    <div id="action-menu">
      <button class="go">Go</button>
    </div>
  </section>
</section>
<script>
  function jumble(word) {

      // Rand function will return 2-part array
      // [0] -> Index of rand, [1] -> random found value (from args)
      var rand = function(){
          var myRand = Math.floor(Math.random() * arguments.length);
          return [myRand, arguments[myRand]];
      },

      // Split passed word into array
      word = word.split(' '),

      // Cache word length for easy looping
      length = word.length,

      // Prepate empty string for jumbled word
      jumbled = '',

      // Get array full of all available indexes:
      // (Reverse while loops are quickest: http://reque.st/1382)
      arrIndexes = [];
      while (length--) {
          arrIndexes.push(length);
      }

      // Cache word length again:
      length = word.length;

      // Another loop
      while (length--) {
          // Get a random number, must be one of
          // those found in arrIndexes
          var rnd = rand.apply(null,arrIndexes);
          // Append random character to jumbled
          jumbled += word[rnd[1]] + ' ';
          // Remove character from arrIndexes
          // so that it is not selected again:
          arrIndexes.splice(rnd[0],1);
      }

      // Return the jumbled word
      return jumbled;

  }
  
  // We must define this!
  // Callback for renderNextLesson()
  function defineActivityForLesson(lesson) {
    $('#lesson')
      .find('.sentence')
        .text(lesson['sentence']);

    originalSentence = $('#lesson span.sentence').text();
    jumbledSentence = originalSentence;

    //prevent a jumbed sentence that's the same
    while(jumbledSentence == originalSentence) {
      jumbledSentence = jumble(originalSentence);
    }

    //remove commas and uppercase on presentation
    $('#lesson span.sentence').text(jumbledSentence.toLowerCase().replace(/\./g,' '));
  }

$(document).ready(function(){
  
  //load first lesson
  renderNextLesson();
  
   //check answer
   $('.go').click(function(event){
     var isCorrect = ($('input').val()) === originalSentence;
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
