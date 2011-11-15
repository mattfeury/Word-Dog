<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>

</header>
<section id="container">
  <section id="content">

    <h2>Pick an activity and a level:</h2>
    <ul>
      <? foreach($activities as $key => $activity): ?>

      <?= '<li class="activity">' . anchor('/activities/play/' . $key . '/' . $unit->id , $activity) . '</li>' ?>
        <? endforeach; ?>

    </ul>

  </section>
</section>
<? $this->load->view('tail'); ?>
