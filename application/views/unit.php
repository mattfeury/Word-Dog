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
        <? foreach($lessons as $lesson): ?>
          <li class="lesson">
            <label>Sentence: <input type="text" class="sentence" name="sentence" value="<?= $lesson->sentence;?>" /></label>
            <fieldset>
              <label for="picture">Picture:</label>
              <?= $lesson->image != '' ? '<img src="' . base_url()  . 'uploads/' . $lesson->image . '" />' : '' ?>
              <!--<input type="radio" name="image-upload" value="current" checked />Current image
              <input type="radio" name="image-upload" value="new" />New image-->
              <div class='image-name'></div>
              <div class="file-holder">
                <div class="substitute">Upload Image</div>
                <input type="file" class="picture" name="picture" />
              </div>
            </fieldset>
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
      <input type="submit" class="save" value="Save" />
    </form>

  </section>
</section>
<div class="templates">
  <ul>
    <li class="template lesson">
      <label>Sentence: <input type="text" class="sentence" name="sentence" value="" /></label>
      <fieldset>
        <label for="picture">Picture:<span class='image-name'></span></label>
        <div class="file-holder">
          <div class="substitute">Upload Image</div>
          <input type="file" class="picture" name="picture" />
        </div>
      </fieldset>
      <fieldset>
      <!-- Question: <input type="text" class="question" name="question" />
      Three answer choices: Indicate the correct answer by selecting the corresponding radio button.
      <input type="radio" name="answers" value="A"> <input type="text" name="A" />
      <input type="radio" name="answers" value="B"> <input type="text" name="B" />
      <input type="radio" name="answers" value="C"> <input type="text" name="C" />
      <button>Add Question</button>-->
      </fieldset>
      
      <button class="remove">(x)</button>
    </li>
  </ul>
</div>
<script type="text/javascript">
  function renameFileInputs() {
    $('.lesson:not(.template) .picture').each(function(i) {
      $(this)
        .attr('name', 'picture' + i)
        .attr('id', 'picture' + i)
        .closest('.file-holder')
        .siblings('label')
          .attr('for', 'picture' + i)
    });
  }
  $(function() {
    //DOM ready
    renameFileInputs();
    
    $('input[type=file]').change(function(e){
      //$in=$(this);
      //$in.next().html($in.val());
      var $uploadtext = $(this).parent().find('.picture').val().split("\\").pop()
      console.log($(this).parent().siblings('.image-name').text($uploadtext));
      //console.log($lesson.find('.picture').val().split("\\").pop());
    });

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
            sentence = $lesson.find('.sentence').val();
            imgFile = '';
            //question = $lesson.find('.
            
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
        //lesson['question'] = imgFile;

        lessons.push(lesson);
      });
      $('.lessons_json').val(JSON.stringify(lessons));
      //return false;
    });
  });
</script>
<? $this->load->view('tail'); ?>
