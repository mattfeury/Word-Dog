<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>

  <div class="session">
    <span class="logged-in">Logged In, <?= $this->session->userdata('email') ?></span>
    <button class="editaccount">Edit Account</button>
    <?= anchor('/logout', 'Log Out', 'class="logged-in logout"'); ?>
  </div>
</header>
<section id="container">
  <section id="content">

    <h2>List of Units</h2>
    <ul>
      <?
      $u = new Unit();
      $u->get();
      foreach ($u->all as $unit) {
          $unit->user->get();
          echo '<li>' . $unit->name . ' by ' . $unit->user->name . anchor('/units/edit/' . $unit->id, 'Edit', 'class="editunit"');
      }
      ?>
    </ul>

    <?= anchor('units/create', 'Create New Unit'); ?>
  </section>
</section>
<? $this->load->view('tail'); ?>
