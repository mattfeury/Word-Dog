  <? $this->load->view('head'); ?>
<header>
  <?= anchor('/units', 'Teacher Zone', 'class="teacherzone home"'); ?>

  <div class="session">
    <?= anchor('/users/modify', 'Edit Account'); ?>
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
      <input type="text" class="unit" name="unit" value="<?= $unit->name ?>" />
      <ul class="lessons">
        <? $i=0; foreach($lessons as $lesson): ?>
          <li class="lesson removable">
            <button class="remove">(x)</button>
            <label>Sentence: <input type="text" class="sentence" name="sentence" value="<?= $lesson->sentence;?>" /></label>
            <fieldset>
              <label for="picture">Picture:</label>
              <?= $lesson->image != '' ? '<img src="' . base_url()  . 'uploads/' . $lesson->image . '" />' : '' ?>
              <!--<input type="radio" name="image-upload" value="current" checked />Current image
              <input type="radio" name="image-upload" value="new" />New image-->
              <div class='image-name'><?= $lesson->image ?></div>
              <div class="file-holder">
                <div class="substitute">Upload Image</div>
                <input type="file" class="picture" name="picture" />
              </div>
            </fieldset>
            <fieldset>
              <ul class="questions">
                <? $j=0; foreach($lesson->questions as $question): ?>        
                  <li class="question removable">
                    <button class="remove">(x)</button>
                    <label>Question: <input type="text" class="question-text" name="question<?= $j ?>" value="<?= $question['question'] ?>" /></label>
                    <label>Answers:
                      <? $k=0; foreach($question['answers'] as $answer): ?> 
                        <input type="radio" class="answer" name="answers<?= $i . '-' . $j ?>" value="<?= $k ?>" <?= ($k==$question['answer']) ? 'checked' : '' ?>>
                        <input type="text" class="answer <?= $k ?>" name="<?= $j ?>" value="<?= $answer ?>" />
                      <? $k++; endforeach; ?>
                    </label>
                  </li>
                <? $j++; endforeach; ?>
              </ul>

              <button class="add-question">Add Question</button>
            </fieldset>
            
          </li>
        <? $i++; endforeach; ?>
      </ul>
      <button id="add-sentence">Add Sentence</button>

      <input type="hidden" class="lessons_json" name="lessons_json" value="[]" />
      <input type="submit" class="save" value="Save" />
    </form>

  </section>
</section>
<div class="templates">
  <ul>
    <li class="template lesson removable">
      <button class="remove">(x)</button>
      <label>Sentence: <input type="text" class="sentence" name="sentence" value="" /></label>
      <fieldset>
        <label for="picture">Picture:</label>
        <!--<input type="radio" name="image-upload" value="current" checked />Current image
        <input type="radio" name="image-upload" value="new" />New image-->
        <div class='image-name'></div>
        <div class="file-holder">
          <div class="substitute">Upload Image</div>
          <input type="file" class="picture" name="picture" />
        </div>
      </fieldset>
      <fieldset>
        <ul class="questions">
          <li class="question removable">
            <button class="remove">(x)</button>
            <label>Question: <input type="text" class="question-text" name="question0" /></label>
            <label>Answers:
              <input type="radio" class="answer" name="answers0" value="0" checked><input type="text" class="answer 0" name="0" />
              <input type="radio" class="answer" name="answers0" value="1"><input type="text" class="answer 1" name="1" />
              <input type="radio" class="answer" name="answers0" value="2"><input type="text" class="answer 2" name="2" />
            </label>
          </li>
        </ul>

        <button class="add-question">Add Question</button>
      </fieldset>
          </li>
  </ul>
</div>
<script type="text/javascript">
  function renameInputs() {
    $('.lesson:not(.template)').each(function(i) {
      $(this)
        .find('.picture')
          .attr('name', 'picture' + i)
          .attr('id', 'picture' + i)
          .closest('.file-holder')
            .siblings('label')
              .attr('for', 'picture' + i);

      var $questions = $(this).find('.questions .question');
      $questions.each(function(j, item) {
        $(this)
          .find('.question-text')
            .attr('name', 'question' + j)
          .end()
          .find('[type=radio]')
            //identify question and answer index in radio button name
            .attr('name', 'answers' + i + '-' + j);
      });
    });
  }
  $(function() {
    //DOM ready
    renameInputs();
    
    $('input[type=file]').live('change', function(e){
      var $uploadtext = $(this).val().split("\\").pop();
      $(this).parent().siblings('.image-name').text($uploadtext);
    });

    $('#add-sentence').click(function() {
      var $newLesson = $('.lesson.template').clone();
      $newLesson.removeClass('template');

      $('.lessons')
        .append($newLesson.hide());
      $newLesson.slideDown();

      renameInputs();
      return false;
    });
    $('.add-question').click(function() {
      var $newQuestion = $('.lesson.template .question').clone();
      
      $(this)
        .siblings('.questions')
        .append($newQuestion.hide());
      $newQuestion.slideDown();
      renameInputs();
      
      return false;
    });
    
    $('.lessons').delegate('.remove', 'click', function() {
      $(this)
        .closest('.removable')
        .slideUp(function() {
          $(this).remove();
          renameInputs();
        });
      return false;
    });

    function decodeQuestionsToJson($questions) {
      var questions = [];

      function decodeQuestion($question) {
        var question = {},
            answers = [];

        question["question"] = ($question.find('.question-text').val() || '').trim();
        question["answer"] = parseInt($question.find('.answer:checked').val());

        $question.find('.answer:text').each(function(i, answer) {
          answers.push($(answer).val());
          //TODO maybe mark the answer here. only if we have issues about ordering returned by .each
        });

        question["answers"] = answers;

        if (question.question && question.answer < answers.length)
          return question;
        else
          return false;
      }
      $questions.find('.question').each(function(i, question) {
        var question = decodeQuestion($(question));
        if (question)
          questions.push(question);
      });
      console.log(questions);
      return JSON.stringify(questions);
    };

    $('#unit').submit(function() {
      // This is the backbone here.
      var lessons = [];
      $('.lesson:not(.template)').each(function(i, item) {
        var $lesson = $(item),
            sentence = $lesson.find('.sentence').val(),
            imgFile = '',
            questionJson = decodeQuestionsToJson($lesson.find('.questions'));
            
        //pass user uploaded image filename   
        if($lesson.find('.picture').val() != '') { 
          imgFile = $lesson.find('.picture').val().split("\\").pop();
        //else, pass image filename that's there
        } else {
          imgFile = $lesson.find('.image-name').text();
        }

        var lesson = {};

        lesson['sentence'] = sentence;
        lesson['image'] = imgFile;
        lesson['questions'] = questionJson;

        lessons.push(lesson);
      });
      $('.lessons_json').val(JSON.stringify(lessons));
      //return false;
    });
  });
</script>
<? $this->load->view('tail'); ?>
