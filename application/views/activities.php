<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>

</header>
<section id="container">
  <section id="content">

    <h2>Pick an activity and a level:</h2>
    <ul>
      <?
      echo '<li class="activity">' . anchor('/memory/show/' . $unit->id , 'Memory') . '</li>';
      ?>
    </ul>

  </section>
</section>
<? $this->load->view('tail'); ?>
