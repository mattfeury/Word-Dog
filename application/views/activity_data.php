<script type="text/javascript">

  // Scores
  var CORRECT_COOKIE = 'WORDDOG_CORRECT';
  var ATTEMPTS_COOKIE = 'WORDDOG_ATTEMPS';
  var CORRECT = createCookieIfNeeded(CORRECT_COOKIE, 0, 1);
  var ATTEMPTS = createCookieIfNeeded(ATTEMPTS_COOKIE, 0, 1);

  function correct() {
    createCookie(CORRECT_COOKIE, ++CORRECT, 1);
    createCookie(ATTEMPTS_COOKIE, ++ATTEMPTS, 1);
    updateScore();
  }
  function incorrect() {
    createCookie(ATTEMPTS_COOKIE, ++ATTEMPTS, 1);
    updateScore();
  }
  function getPercentage() {
    return ((CORRECT / ATTEMPTS * 100 || 0) + '').split('.').shift() + '%';
  }
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
    }
  });

  // Units and lessons
  var unit = <?= $unit_json ?>;
  var currentLesson = -1;
  function getNextLesson() {
    currentLesson++;
    if (currentLesson < unit.lessons.length)
      return unit.lessons[currentLesson];
    else
      return null;
  }
  function renderNextLesson() {
    var lesson = getNextLesson();
    if (lesson)
      defineActivityForLesson(lesson); //defined by the activity in its view
    else
      unitOver();
  }
  function unitOver() {
    alert("You win. Lesson complete. Do something here like redirecting");
  }

  // Utilites
  var BASE_SRC = "<?= base_url() ?>";

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

  function createCookieIfNeeded(name, value, days) {
    if (! readCookie(name))
      createCookie(name, value, days);

    return readCookie(name);
  }
  function incrementCookie(name) {
  }

  function eraseCookie(name) {
    createCookie(name,"",-1);
  }
  
  
</script>
