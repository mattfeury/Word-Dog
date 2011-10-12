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
      <li>Dick and Jane <button>Edit</button></li> 
      <li>Little Red Riding Hood <button>Edit</button></li>
      <li>See Spot Run <button>Edit</button></li>   
      <li>The Three Little Pigs <button>Edit</button></li>   
    </ul>

    <?= anchor('users/create', 'Create New Unit'); ?>
  </section>
</section>
<? $this->load->view('tail'); ?>
