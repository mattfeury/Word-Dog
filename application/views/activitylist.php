<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>

</header>
<section id="container">
  <section id="content">

    <h2>Pick an activity and a level:</h2>
    <ul>
      <?
      echo '<li>' . anchor('/activities/show/' . $unit->id , 'Writing Sentences', 'class="activity"');
      ?>
    </ul>

  </section>
</section>
<? $this->load->view('tail'); ?>
