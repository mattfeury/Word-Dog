<script type="text/javascript">
  
  /**
   * Holds functions and data used by all activities.
   */
   
  // Scores
  var CORRECT_COOKIE = 'WORDDOG_CORRECT';
  var ATTEMPTS_COOKIE = 'WORDDOG_ATTEMPS';
  var CORRECT = createCookieIfNeeded(CORRECT_COOKIE, 0, 1);
  var ATTEMPTS = createCookieIfNeeded(ATTEMPTS_COOKIE, 0, 1);
  
  // Reinforcement wait time before fadeout in milliseconds
  var DELAY_SPEED = 1600;

  // Handles updates if a lesson is correct
  function correct() {
    createCookie(CORRECT_COOKIE, ++CORRECT, 1);
    createCookie(ATTEMPTS_COOKIE, ++ATTEMPTS, 1);
    updateScore();

    $('.reinforcement').show();
    $('.reinforcement').text('Correct!').delay(DELAY_SPEED).fadeOut();
    $('.reinforcement').addClass('correct'); 
    $('.reinforcement').removeClass('incorrect');
  }
  // Handles updates if a lesson is incorrect
  function incorrect() {
    createCookie(ATTEMPTS_COOKIE, ++ATTEMPTS, 1);
    updateScore();

    $('.reinforcement').show();
    $('.reinforcement').text('Incorrect').delay(DELAY_SPEED).fadeOut();
    $('.reinforcement').addClass('incorrect'); 
    $('.reinforcement').removeClass('correct');    
  }
  // Creates percentage from corrects and attempts
  function getPercentage() {
    return ((CORRECT / ATTEMPTS * 100 || 0) + '').split('.').shift() + '%';
  }
  // Updates the user's score
  function updateScore() {
    $('header .score')
      .find('.correct')
        .text(CORRECT)
      .end()
      .find('.attempts')
        .text(ATTEMPTS)
      .end()
      .find('.percentage')
        .text(getPercentage());
  }
  $(function() {
    //Add score tracker
    var $header = $('header');
    if (! $header.find('.score').length) {
      $header.append(
        $('<div/>')
          .addClass('score')
          .html('<span class="correct">' + CORRECT + '</span>/<span class="attempts">' + ATTEMPTS + '</span><span class="percentage">' + (getPercentage()) + '</span>')
      )
      $header
        .find('.score')
          .append(
            $('<button/>')
              .addClass('reset-score')
              .text('Reset')
              .click(function() {
                //reset
                CORRECT = 0;
                ATTEMPTS = 0;
                updateScore();
                eraseCookie(CORRECT_COOKIE);
                eraseCookie(ATTEMPTS_COOKIE);
              })
          )
    }

    // Add reinforcement
    var $instructions = $('#content h1 + h2');
    if (! $instructions.siblings('.reinforcement').length) {
      $instructions.after(
        $('<div/>').addClass('reinforcement')
      )
    }

  });

  // "Distractor" character
  var distractionTimer = -1,
      distractorHeight = 451,
      distractorWidth = 252,
      distractorLength = 3500, //length of distraction animation in millis
      waitTimeBetweenDistractions = 12; //10 seconds average between distractions
  $(function() {
    function makeDistractor() {
      if (! $('body').find('#distractor').length) {

        $('body')
          .append(
            $('<div/>')
              .attr('id', 'distractor')
              .addClass('shades')
          );
      }
      var height = $(document).height(),
          randomTop = Math.random() * (height - distractorHeight);

      $('#distractor')
        .stop(true, false)
        .animate({ 'top': randomTop + 'px', 'right': 0 }, 'slow');
    }
    function removeDistractor() {
      $('#distractor').stop(true, false).animate({ right: -1 * distractorWidth + 'px' }, 'slow');
    }

    if (unit.showDistractor) {
      distractionTimer = setInterval(function() {
        removeDistractor();
        makeDistractor();
        setTimeout(removeDistractor, distractorLength);
      }, distractorLength + waitTimeBetweenDistractions * 1000);
    }
  });
   
  // Units and lessons
  var unit = <?= $unit_json ?>;
  var activity_config = <?= $activity_data ?>;
  window.config = $.extend(window.config || {}, activity_config);
  var currentLesson = -1;

  // Returns if print is passed in URL parameter
  var isPrint = <?= ($print == '') ? 0 : 1 ?>;

  // Difficulty data for activities with difficulties
  var difficulties = [];
  switch (config.difficulties) {
    case 'time':
      difficulties = [ //seconds per word before hiding
        { name: 'Easy', secsPerWord: .5 },
        { name: 'Medium', secsPerWord: .4 },
        { name: 'Hard', secsPerWord: .3}
      ];
      break;
    case 'numBlanks':
      difficulties = [
        { name: 'Easy', numBlanks: 1 },
        { name: 'Medium', numBlanks: 2 },
        { name: 'Hard', numBlanks: 3 }
      ];
      break;
    case 'numBlanksAndTime':
      difficulties = [
        { name: 'Easy', secsPerWord: .5, numBlanks: 1 },
        { name: 'Medium', secsPerWord: .4, numBlanks: 2 },
        { name: 'Hard', secsPerWord: .3, numBlanks: 3 }
      ];
      break;
  }
  config.difficulties = difficulties;

  // Gets the next lesson in the unit to be loaded
  function getNextLesson() {
    currentLesson++;
    if (currentLesson < unit.lessons.length)
      return unit.lessons[currentLesson];
    else
      return null;
  }
  // Loads the next lesson in the unit
  function renderNextLesson() {
    // Remove correct indicator
    $('.reinforcement')
      .removeClass('incorrect correct')
      .text('');
    
    var lesson = getNextLesson();
    if (lesson)
      defineActivityForLesson(lesson); //defined by the activity in its view
    else
      unitOver();
  }
  // Shows message after lesson is complete and redirects
  function unitOver() {
    alert("Lesson complete. Great job!");
    redirectToActivities();
  }
  //for multiple choice: gets other lessons
  function getOtherLessons() {
    var randomLessons = new Array();
    for(var i=0;i < unit.lessons.length;i++) {
      if(unit.lessons[i]['id'] != unit.lessons[currentLesson]['id']) 
        randomLessons.push(unit.lessons[i]);
    }
    return randomLessons.sort(function() {return 0.5 - Math.random()});
  }
  
  // Open up a new document for printing and write html to it
  function printActivity(html) {
    document.innerHTML='';
    document.title = unit.name;
    document.write('<a href="javascript:window.print()">print</a>');
    $(document).find('head').append('<link href="' + BASE_SRC + 'stylesheets/print.css" rel="stylesheet" type="text/css" />');
    document.write(html);
    document.close();
  }
  
  // Redirects to activities view
  function redirectToActivities() {
    var redirect_url = "<?= site_url('activities/with') ?>" + '/' + unit.id;
    window.location = redirect_url;
  }

  // Utilites
  var BASE_SRC = "<?= base_url() ?>";
  Array.prototype.removeWhere = function() {
      var what, a= arguments, L= a.length, ax;
      while(L && this.length){
          what= a[--L];
          while((ax= $.inArray(what, this))!= -1){
              this.splice(ax, 1);
          }
      }
      return this;
  }

  // Helper functions used for certain activites (e.g. jumbling, creating 'blanks')
  // We put them here because they are sometimes used in multiple activity views
  // (ones that mix with memory)
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
  var originalSentence;
  function jumbleSentence(original) {
    //prevent a jumbed sentence that's the same
    var jumbledSentence = original,
        originalSentence = original;
    while(jumbledSentence == original) {
      jumbledSentence = jumble(original);
    }
    return jumbledSentence;
  }

  // Returns HTML
  var totalBlanksCreated = 0;
  function createCloze(sentence, numBlanks) {
    totalBlanksCreated = 0;
    return createClozeFromSentence(sentence, numBlanks);
  }
  // Removes words from sentence for cloze
  function createClozeFromSentence(sentence, numBlanks) {
    // Base case. If we don't need to create any more blanks, just return the text.
    if (totalBlanksCreated >= numBlanks)
      return document.createTextNode(sentence);

    totalBlanksCreated++;

    var split = sentence.split(/\W+/).removeWhere(''), //splits words only (no punctuation)
        toRemove = Math.floor(Math.random()* split.length),
        missingWord = split[toRemove];

    // Find the two sentence fragments surrounding the word
    var regexSplit = new RegExp('\\b' + missingWord + '\\b', 'g');
    var sandwich = sentence.split(regexSplit),
        left = sandwich.shift(),
        right = sandwich.join(missingWord);

    // Create a button for the missing word that, when clicked, shows the input
    var $missingWordButton =
      $('<span/>')
        .addClass('missing')
        .append(
          $('<span class="filler">' + missingWord + '</span>')
        )
        .append(
          $('<input id="answer'+totalBlanksCreated+'" name="answer'+totalBlanksCreated+'" type="text" />')
            .addClass('answer cloze')
            .attr('data-answer', missingWord)
        )
        .append(
          $('<label for="answer'+totalBlanksCreated+'" />')
            .text('?')
        );

    var leftHtml, rightHtml,
        leftLength = $.trim(left).split(' ').length,
        rightLength = $.trim(right).split(' ').length;

    // Recurse on the side with more words first
    if (leftLength > rightLength) {
      leftHtml = createClozeFromSentence(left, numBlanks);
      if (rightLength)
        rightHtml = createClozeFromSentence(right, numBlanks);
    } else {
      rightHtml = createClozeFromSentence(right, numBlanks);
      if (leftLength)
        leftHtml = createClozeFromSentence(left, numBlanks);
    }

    var $sentenceWithBlank = 
      $('<div/>')
        .append(leftHtml)
        .append($missingWordButton)
        .append(rightHtml);

    // Set a rule to handle the button covers
    $('.missing input').live('focus', function() {
      $(this)
        .closest('.missing')
          .addClass('guessing')
    }).live('blur', function() {
      if ($.trim($(this).val()) === '')
        $(this)
          .closest('.missing')
          .removeClass('guessing')
    })

    return $sentenceWithBlank.html()
  }
  

  // Cookie helper functions borrowed from quirksmode.org
  function createCookie(name,value,days) {
    if (days) {
      var date = new Date();
      date.setTime(date.getTime()+(days*24*60*60*1000));
      var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
  }
  // Parses javascript cookie
  function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
  }

  // Creates cookie for given duration. Used for score.
  function createCookieIfNeeded(name, value, days) {
    if (! readCookie(name))
      createCookie(name, value, days);

    return readCookie(name);
  }

  // Removes cookie
  function eraseCookie(name) {
    createCookie(name,"",-1);
  }
  
  
</script>
