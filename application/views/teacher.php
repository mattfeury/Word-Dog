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

    <h2>Edit a Unit</h2>
    <ul>
      <?
      foreach ($units as $unit) {
        echo '<li>' . anchor('/units/edit/' . $unit->id, $unit->name, 'class="unit"') . '</li>';
      }
      ?>
    </ul>
    <section id="action-menu">
      <?= anchor('units/create', 'Create New Unit'); ?>
    </section>
  </section>
</section>
<? $this->load->view('tail'); ?>
