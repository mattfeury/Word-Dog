<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Word, Dog (beta)</title>

  <script src="<?= base_url() ?>scripts/jquery-1.6.4.min.js"></script>
  <link href="<?= base_url() ?>stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
</head>
<body>

<header>
  <?= anchor('/users', 'Teacher Zone', 'class="teacherzone home"'); ?>

  <div class="session">
    <button class="editaccount">Edit Account</button>
    <?= anchor('/logout', 'Log Out', 'class="logout"'); ?>
  </div>
</header>
<section id="container">
  <section id="content">
      
    <form>
      Name of Unit: <input type="text" name="unitname" />
      <p>
        <!--The names should be incremented for each new sentence-->
        Sentence: <input type="text" name="sentence" />
        Picture: <input type="file" name="picture" />
        Question: <input type="text" name="question" />
        Three answer choices: Indicate the correct answer by selecting the corresponding radio button.
        <input type="radio" name="answers1" value="A"> <input type="text" name="A" />
        <input type="radio" name="answers1" value="B"> <input type="text" name="B" />
        <input type="radio" name="answers1" value="C"> <input type="text" name="C" />
        <button>Add Question</button>
      </p>
      <button>Add Sentence</button>
      <input type="submit" value="Save" /> 
    </form>
    
  </section>
</section>
</body>
</html>
