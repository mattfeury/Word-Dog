<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>

</header>
<section id="container">
  <section id="content">

    <h2>Pick a unit below:</h2>
    <ul class="rows">
      <?
      $attributes = array('id' => 'unit', 'class="units"');
      foreach ($units as $unit) {
        echo '<li class="unit">' . anchor('/activities/with/' . $unit->id , $unit->name) . '</li>';
      }
      ?>
    </ul>

  </section>
</section>
<? $this->load->view('tail'); ?>
