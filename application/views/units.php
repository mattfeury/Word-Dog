<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>

</header>
<section id="container">
  <section id="content">

    <h2>Pick a unit below:</h2>
    <ul class="rows">
      <?
      foreach ($units as $unit) {
        echo '<li class="unit">';
        echo anchor('/activities/with/' . $unit->id , $unit->name);
        if ($sessionUser->admin == 1)
          echo anchor('/units/edit/' . $unit->id , 'Edit', array('class' => 'edit'));
        echo '</li>';
      }
      ?>
    </ul>

  </section>
</section>
<? $this->load->view('tail'); ?>
