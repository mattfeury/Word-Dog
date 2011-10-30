<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>

</header>
<section id="container">
  <section id="content">

    <h2>Pick a Unit Below:</h2>
    <ul>
      <?
      $attributes = array('id' => 'unit');
      foreach ($units as $unit) {
        echo '<li>' . anchor('' , $unit->name, 'class="activitylist"');
      }
      ?>
    </ul>

  </section>
</section>
<? $this->load->view('tail'); ?>
