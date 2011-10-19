<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>

  <div class="session">
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
          echo '<li>' . $unit->name . ' by ' . $unit->user->name . '<button>Edit</button></li>';
      }
      ?>
    </ul>

    <?= anchor('users/create', 'Create New Unit'); ?>
  </section>
</section>
<? $this->load->view('tail'); ?>
