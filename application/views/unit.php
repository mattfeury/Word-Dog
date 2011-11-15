  <? $this->load->view('head'); ?>
<header>
  <?= anchor('/units', 'Teacher Zone', 'class="teacherzone home"'); ?>

  <div class="session">
    <button class="editaccount">Edit Account</button>
    <?= anchor('/logout', 'Log Out', 'class="logged-in logout"'); ?>
  </div>
</header>
<section id="container">
  <section id="content">
    <?
      $attributes = array('id' => 'unit');
      echo form_open_multipart('units/update', $attributes);
    ?>
      <h2>Name of Unit:</h2>
      <input type="text" name="unit" value="<?= $unit->name ?>" />
      <ul class="lessons">
        <? foreach($lessons as $lesson): ?>
          <li class="lesson">
            <label>Sentence: <input type="text" class="sentence" name="sentence" value="<?= $lesson->sentence;?>" /></label>
            <label>Picture: <input type="file" class="picture" name="picture" value="<?= $lesson->image;?>" /></label>
            <fieldset>
            <!-- Question: <input type="text" name="question" />
            Three answer choices: Indicate the correct answer by selecting the corresponding radio button.
            <input type="radio" name="answers1" value="A"> <input type="text" name="A" />
            <input type="radio" name="answers1" value="B"> <input type="text" name="B" />
            <input type="radio" name="answers1" value="C"> <input type="text" name="C" />
            <button>Add Question</button>-->
            </fieldset>
            <button class="remove">(x)</button>
          </li>
        <? endforeach; ?>
      </ul>
      <button id="add-sentence">Add Sentence</button>

      <input type="hidden" class="lessons_json" name="lessons_json" value="[]" />
      <input type="submit" value="Save" />
    </form>

  </section>
</section>
<div class="templates">
  <ul>
    <li class="template lesson">
      <label>Sentence: <input type="text" class="sentence" name="sentence" value="" /></label>
      <label>Picture: <input type="file" class="picture" name="picture" value="" /></label>
      <!-- Question: <input type="text" class="question" name="question" />
      Three answer choices: Indicate the correct answer by selecting the corresponding radio button.
      <input type="radio" name="answers" value="A"> <input type="text" name="A" />
      <input type="radio" name="answers" value="B"> <input type="text" name="B" />
      <input type="radio" name="answers" value="C"> <input type="text" name="C" />
      <button>Add Question</button>-->
      <button class="remove">(x)</button>
    </li>
  </ul>
</div>
<script type="text/javascript">
  function renameFileInputs() {
    $('.lesson:not(.template) .picture').each(function(i) {
      $(this).attr('name', 'picture' + i);
    });
  }
  $(function() {
    //DOM ready
    renameFileInputs();

    $('#add-sentence').click(function() {
      var $newLesson = $('.lesson.template').clone();
      $newLesson.removeClass('template');

      $('.lessons')
        .append($newLesson.hide());
      $newLesson.slideDown();

      renameFileInputs();
      return false;
    });
    $('.lessons').delegate('.lesson .remove', 'click', function() {
      $(this)
        .closest('.lesson')
        .slideUp(function() {
          $(this).remove();
          renameFileInputs();
        });
      return false;
    });

    $('#unit').submit(function() {
      // This is the backbone here.
      var lessons = [];
      $('.lesson:not(.template)').each(function(i, item) {
        var $lesson = $(item),
            sentence = $lesson.find('.sentence').val(),
            imgFile = $lesson.find('.picture').val().split("\\").pop();
            //question = $lesson.find('.

        var lesson = {};
        lesson['sentence'] = sentence;
        lesson['image'] = imgFile;
        //lesson['question'] = imgFile;

        lessons.push(lesson);
      });
      $('.lessons_json').val(JSON.stringify(lessons));
      //return false;
    });
  });
</script>
<? $this->load->view('tail'); ?>
