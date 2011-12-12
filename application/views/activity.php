<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>

</header>
<section id="container">
  <section id="content">

    <h2>Pick an activity:</h2>
    <ul class="activities rows">
      <? $attr = array('target'=>'_blank', 'class' => 'print'); ?>
      <? foreach($activities as $key => $activity): ?>
        <? if ( (($activity['requires_questions'] && $unit->hasQuestions()) || ! $activity['requires_questions']) &&
                (($activity['requires_images'] && $unit->hasImages()) || ! $activity['requires_images'])): ?>
          <li class="activity" data-id="<?= $key ?>">
            <?= anchor('/activities/play/' . $key . '/' . $unit->id , $activity['name']) ?>
            <?= anchor('/activities/play/' . $key . '/' . $unit->id . '/print', 'Print', $attr) ?>
          </li>
        <? endif; ?>
      <? endforeach; ?>
    </ul>

  </section>
</section>
<? $this->load->view('tail'); ?>
