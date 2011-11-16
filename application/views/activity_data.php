<script type="text/javascript">
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
      defineActivityForLesson(lesson);
    else
      unitOver();
  }
  function unitOver() {
    alert("You win. Lesson complete. Do something here like redirecting");
  }
  
</script>
