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

      <div class="mgmt">
        <label><input type="checkbox" name="show_distractor" value="true" <?= ($unit->showDistractor == 1) ? 'checked' : '' ?> /> Show Distractor</label>
        <input type="submit" class="save" value="Save" />
        <?= anchor('/units/delete/'.$unit->id, 'Delete', array('class' => 'delete')); ?>
      </div>

      <ul class="lessons">
        <? $i=0; foreach($lessons as $lesson): ?>
          <li class="lesson removable">
            <button class="remove">(x)</button>
            <label class="stretch"><span>Sentence: </span><div><input type="text" class="sentence" name="sentence" value="<?= $lesson->sentence;?>" /></div></label>
            <fieldset class="upload-picture">
              <label>Picture:</label>
              <div class="image-holder">
                <div class="image active old-image">
                  <label>
                    <?= $lesson->image != '' ? '<img src="' . base_url()  . 'uploads/' . $lesson->image . '" />' : '' ?>
                    <input type="radio" name="image-upload<?=$i?>" value="current" checked />
                    <div class='image-name'><?= $lesson->image ?></div>
                  </label>
                </div>
                <div class="image new-image">
                  <label>
                    <input type="radio" name="image-upload<?=$i?>" value="new" />
                    <div class='image-name'></div>
                    <div class="file-holder">
                      <div class="substitute">New Image</div>
                      <input type="file" class="picture" name="picture" />
                    </div>
                  </label>
                </div>
              </div>
            </fieldset>
            <fieldset>
              <ul class="questions">
                <? $j=0; foreach($lesson->questions as $question): ?>        
                  <li class="question removable">
                    <button class="remove">(x)</button><label class="stretch"><span>Question: </span><div><input type="text" class="question-text" name="question<?= $j ?>" value="<?= $question['question'] ?>" /></div></label>
                    <div class="answer">
                      <div class="help">
                        <h4>Three Answer Choices:</h4>
                        <p>Indicate the correct answer 
                        by selecting the corresponding 
                        radio button.</p>
                      </div>
                      <div class="answers">
                        <? $k=0; foreach($question['answers'] as $answer): ?>
                          <fieldset class="answer">
                            <input type="radio" class="answer" name="answers<?= $i . '-' . $j ?>" value="<?= $k ?>" <?= ($k==$question['answer']) ? 'checked' : '' ?>>
                            <input type="text" class="answer <?= $k ?>" name="<?= $j ?>" value="<?= $answer ?>" />
                          </fieldset>
                        <? $k++; endforeach; ?>
                      </div>
                    </div>
                    
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
            <label class="stretch"><span>Sentence: </span><div><input type="text" class="sentence" name="sentence" value="" /></div></label>
      <fieldset class="upload-picture">
        <label>Picture:</label>
        <div class="image-holder">
          <div class="image active new-image">
            <label>
              <input type="radio" name="image-upload1" value="new" checked />
              <div class='image-name'></div>
              <div class="file-holder">
                <div class="substitute">New Image</div>
                <input type="file" class="picture" name="picture" />
              </div>
            </label>
          </div>
        </div>
      </fieldset>
      <fieldset>
        <ul class="questions">
          <li class="question removable">
            <button class="remove">(x)</button>
            <label class="stretch"><span>Question: </span><div><input type="text" class="question-text" name="question0" /></div></label>
            <div class="answer">
              <div class="help">
                <h4>Three Answer Choices:</h4>
                <p>Indicate the correct answer 
                by selecting the corresponding 
                radio button.</p>
              </div>
              <div class="answers">
                <fieldset class="answer">
                  <input type="radio" class="answer" name="answers0" value="0" checked />
                  <input type="text" class="answer 0" name="0" />
                </fieldset>
                <fieldset class="answer">
                  <input type="radio" class="answer" name="answers0-1" value="1">
                  <input type="text" class="answer 1" name="1" />
                </fieldset>
                <fieldset class="answer">
                  <input type="radio" class="answer" name="answers0-1" value="2">
                  <input type="text" class="answer 2" name="2" />
                </fieldset>
              </div>
            </div>
          </li>
        </ul>

        <button class="add-question">Add Question</button>
      </fieldset>
    </li>
  </ul>
</div>
<script type="text/javascript">
  // Renames inputs based on lesson index so that inputs are unique
  function renameInputs() {
    $('.lesson:not(.template)').each(function(i) {
      $(this)
        .find('.picture')
          .attr('name', 'picture' + i)
          .attr('id', 'picture' + i);

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
    
    // Uploading
    $('input[type=file]').live('change', function(e){
      var $uploadtext = $(this).val().split("\\").pop();
      $(this).closest('.file-holder').siblings('.image-name').text($uploadtext).addClass('changed');
    });
    $('.upload-picture input:radio').live('change', function() {
      var $holder = $(this).closest('.image');
      $holder
        .siblings('.image')
          .removeClass('active')
        .end()
        .addClass('active');
    });
    
    // Add a sentence
    $('#add-sentence').click(function() {
      var $newLesson = $('.lesson.template').clone();
      $newLesson.removeClass('template');

      $('.lessons')
        .append($newLesson.hide());
      $newLesson.slideDown();

      renameInputs();
      return false;
    });
    // Add a question
    $('.add-question').live('click', function() {
      var $newQuestion = $('.lesson.template .question').clone();
      
      $(this)
        .siblings('.questions')
        .append($newQuestion.hide());
      $newQuestion.slideDown();
      renameInputs();
      $newQuestion
        .addClass('ie-fixer')
        .find('input:radio:first')
          .attr('checked','checked');

      // IE7 won't auto render the styles so we trigger it hackishly
      setTimeout(function() { $newQuestion.removeClass('ie-fixer') }, 50);
      return false;
    });
    
    // Remove lesson 
    $('.lessons').delegate('.remove', 'click', function() {
      $(this)
        .closest('.removable')
        .slideUp(function() {
          $(this).remove();
          renameInputs();
        });
      return false;
    });

    // Prepare questions for JSON storage
    function decodeQuestionsToJson($questions) {
      var questions = [];

      function decodeQuestion($question) {
        var question = {},
            answers = [];

        question["question"] = $.trim($question.find('.question-text').val() || '');
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
      return JSON.stringify(questions);
    };

    // Saves a unit. Sends questions as JSON and updates lessons
    $('#unit').submit(function() {
      // This is the backbone here.
      var lessons = [];
      $('.lesson:not(.template)').each(function(i, item) {
        var $lesson = $(item),
            sentence = $lesson.find('.sentence').val(),
            imgFile = '',
            questionJson = decodeQuestionsToJson($lesson.find('.questions'));
            
        //pass user uploaded image filename   
        if($lesson.find('.image :radio:checked').val() == 'new') { 
          imgFile = $lesson.find('.picture').val().split("\\").pop();
        //else, pass image filename that's there
        } else {
          imgFile = $lesson.find('.old-image .image-name').text();
          $lesson.find('.picture').remove();
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
