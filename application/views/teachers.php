<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>

</header>
<section id="container">
  <section id="content">

    <h2>Pick a teacher below:</h2>
    <ul class="rows">
      <?
      
      foreach ($users as $user) {
        echo '<li class="user">' . anchor('/units/show/' . $user->id, 
          '<span class="name">'.$user->name.'</span><span class="school">'.$user->school.'</span><span class="grade">'.$user->grade.'</span>'
        , 'class="user-link"') . '</li>';
      }
      ?>
    </ul>

  </section>
</section>
<? $this->load->view('tail'); ?>
