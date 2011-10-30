<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>

</header>
<section id="container">
  <section id="content">

    <h2>Pick a Teacher Below</h2>
    <ul>
      <?
      
      foreach ($users as $user) {
        echo '<li>' . anchor('/units/show/' . $user->id, $user->name . ' ' . $user->school . ' ' . $user->grade, 'class="unitlist"');
      }
      ?>
    </ul>

  </section>
</section>
<? $this->load->view('tail'); ?>
