  <? $this->load->view('head'); ?>
<header>
  <?= anchor('/users', 'Teacher Zone', 'class="teacherzone home"'); ?>

  <div class="session">
    <button class="editaccount">Edit Account</button>
    <?= anchor('/logout', 'Log Out', 'class="logged-in logout"'); ?>
  </div>
</header>
<section id="container">
  <section id="content">
      
    <? 
    $attributes = array('class' => 'edit');
    echo form_open('units/update/' . $id, $attributes);
    ?>
      Name of Unit: <input type="text" name="unitname" value="<?= $name;?>" />
      <p>
        <!--The names should be incremented for each new sentence-->
        Sentence: <input type="text" name="sentence" value = "<?= $lesson->sentence;?>" />
        Picture: <input type="file" name="picture" value = "<?= $lesson->image;?>"/>
        <!--Question: <input type="text" name="question" />
        Three answer choices: Indicate the correct answer by selecting the corresponding radio button.
        <input type="radio" name="answers1" value="A"> <input type="text" name="A" />
        <input type="radio" name="answers1" value="B"> <input type="text" name="B" />
        <input type="radio" name="answers1" value="C"> <input type="text" name="C" />
        <button>Add Question</button>-->
      </p>
      <button>Add Sentence</button>
      <input type="submit" value="Save" /> 
    </form>
    
  </section>
</section>
<? $this->load->view('tail'); ?>