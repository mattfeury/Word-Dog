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
      foreach ($units as $unit) {
        echo '<li>' . $unit->name . ' ' . anchor('/units/edit/' . $unit->id, 'Edit', 'class="editunit"') . '</li>';
      }
      ?>
    </ul>

    <?= anchor('units/create', 'Create New Unit'); ?>
  </section>
</section>
<? $this->load->view('tail'); ?>
