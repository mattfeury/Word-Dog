<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>

</header>
<section id="container">
  <section id="content">

    <h2>Pick a teacher below:</h2>
    <ul>
      <?
      
      foreach ($users as $user) {
        echo '<li class="user">' . anchor('/units/show/' . $user->id, $user->name) . '</li>';
      }
      ?>
    </ul>

  </section>
</section>
<? $this->load->view('tail'); ?>
