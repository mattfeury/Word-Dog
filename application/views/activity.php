<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>

</header>
<section id="container">
  <section id="content">

    <h2>Pick an activity:</h2>
    <div class="play">
      <ul class="activities">
        <? $attr = array('target'=>'_blank'); ?>
        <? foreach($activities as $key => $activity): ?>
          <? if ( (($activity['requires_questions'] && $unit->hasQuestions()) || ! $activity['requires_questions']) &&
                  (($activity['requires_images'] && $unit->hasImages()) || ! $activity['requires_images'])): ?>
            <li class="activity" data-id="<?= $key ?>"><?= anchor('/activities/play/' . $key . '/' . $unit->id , $activity['name']) ?></li>
            <li class="activity" data-id="<?= $key ?>"><?= anchor('/activities/play/' . $key . '/' . $unit->id . '/' . '1' . '/' . 'print', 'Print', $attr) ?></li>
          <? endif; ?>
        <? endforeach; ?>
      </ul>
      <ol class="levels">
      </ol>
    </div>

  </section>
</section>
<script type="text/javascript">
  $(document).ready(function() {
    //Hide at first so we initially slide down. Purely asthetic
    $('.levels').hide();

    function addLevelForUnit(level, unit) {
      $('.levels').append(
        $('<li/>')
          .append(
            $('<button />')
              .addClass('level')
              .attr('data-id', level)
              .text('Level ' + level)
          )
      )
    }

    $('.activity a').live('click', function() {
      $('.activity a').removeClass('selected');

      var $activity = $(this).closest('.activity'),
          levels = $activity.attr('data-levels'),
          unit = $activity.attr('data-id');
  
      $activity.addClass('selected');
      $('.levels').slideUp(function() { 
        $(this).empty();

        for(var i=1; i <= levels; i++)
          addLevelForUnit(i, unit);

        $('.levels').slideDown();
      });
      //return false;
    });
    $('.level').live('click', function() {
      var $activity = $('.activity.selected');

      location.href = $activity.find('a').attr('href') + '#' + $(this).attr('data-id');
    });
  });
</script>
<? $this->load->view('tail'); ?>
