<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>

  <div class="session">
    <span class="logged-in">Logged in as <?= $this->session->userdata('name') ?></span>
    <?= anchor('/users/modify', 'Edit Account'); ?>
	<?= anchor('/logout', 'Log Out', 'class="logged-in logout"'); ?>
  </div>
</header>
<section id="container">
  <section id="content">

    <h2>Edit a Unit</h2>
    <ul class="rows units">
      <?
      foreach ($units as $unit) {
        echo '<li class="unit">' . anchor('/units/edit/' . $unit->id, $unit->name) . '</li>';
      }
      ?>
    </ul>
    <div id="action-menu">
      <?= anchor('units/create', 'Create New Unit'); ?>
    </div>
  </section>
</section>
<? $this->load->view('tail'); ?>
