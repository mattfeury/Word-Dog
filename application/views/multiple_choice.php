<? $this->load->view('head'); ?>
<? $this->load->view('activity_data'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
</header>
<section id="container">
  <section id="content">

    <h1 id="name"><?= $activity["name"] ?></h1>
    <h2 id="instruction"><? $activity["instruction"] ?></h2>
    <div id="lesson">
      <img class="picture" />
      <ul class="answers"></ul>
    </div>
    <div id="action-menu">
      <button class="go">Go</button>
    </div>
  </section>
</section>
<script>
  var answer;

  // We must define this!
  // Callback for renderNextLesson()
  function defineActivityForLesson(lesson, $target) {
    //define elements in the DOM or target for printing
    var forPrint = ! $target ? false : true;
    $target = ! $target ? $('#lesson') : $target;
    //show image
    $target
      .find('.picture')
        .attr('src', BASE_SRC + 'uploads/' + lesson['image']);
    
    var randomLessons = getOtherLessons();
    
    choices = [];

    //make sure length 2
    if (randomLessons.length > 1) { 
      choices.push(randomLessons.pop().sentence);
      choices.push(randomLessons.pop().sentence);
      choices.push(lesson.sentence);
    }
    //randomize choices
    choices.sort(function() {return 0.5 - Math.random()});
    //clear previous buttons
    $target
      .find('.answers')
        .empty();
    //render as buttons
    $.each(choices, function(i) { 
     $target
      .find('.answers')                                                           
        .append('<li><label><input type="radio" name="answers" value="' + i + '"/>' + choices[i] + '</label></li>');
    });
    //check first radio button
    if(!forPrint) $target
      .find('input[value="0"]')
        .attr('checked', true);
     
    answer = choices.indexOf(lesson.sentence);
    
    return $target;
  }

$(document).ready(function(){
  //load first lesson
  renderNextLesson();
  
   //check answer
   $('.go').click(function(event){

     var input = $('input[name="answers"]:checked').val();

     var isCorrect = input == answer;
     
     if (isCorrect) {
       correct();
       setTimeout(function() { renderNextLesson(); }, 1000);
     } else {
       incorrect();
     }
           
   });
   //specify html for printing for every lesson in the unit
   if(isPrint){
     var $print = $('<div/>')
      .append('<h1>' + $('h1').text() + '</h1>')
      .append('<h2>' + $('h2').text() + '</h2>');
     $.each(unit.lessons, function(i, lesson) {
       var $template = $('<div><img class="picture" /><ul class="answers"></ul></div>');
       defineActivityForLesson(lesson, $template);
       $print.append($template.html());        
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
