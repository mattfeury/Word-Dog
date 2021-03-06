<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  <title>Word, Dog (beta)</title>
  <?= link_tag(array(
                    'href' => 'stylesheets/screen.css',
                    'rel' => 'stylesheet',
                    'type' => 'text/css',
                    'media' => 'screen, projection'
              )); ?>
  <script src="<?= base_url() ?>scripts/jquery-1.6.4.min.js"></script>
  <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <!--[if lte IE 7]>
    <script src="<?= base_url() ?>scripts/json2.js"></script>
    <?= link_tag(array(
                    'href' => 'stylesheets/ie.css',
                    'rel' => 'stylesheet',
                    'type' => 'text/css',
                    'media' => 'screen, projection'
              )); ?>

  <![endif]-->

  <script>
    var config = {
      base: "<?php echo base_url(); ?>",
      site: "<?= site_url(); ?>"
    };

    $(document).ready(function(){
      $('.dialog-opener').click(function(event){
        var id=$(this).attr('id');
        $('.dialog.' + id).addClass('current');
      });
      $('.dialog .close').click(function(event){
        $(this).closest('.dialog').removeClass('current');
      });

      $('.delete').live('click', function() {
        var doIt = confirm("Are you sure you want to delete this unit? (Cannot be undone)");
        if (! doIt) return false;
      });
    });
  </script>
  <script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-20461357-1']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

  </script>
</head>
<body class="<?= $this->router->class . ' ' . ($this->session->userdata('logged_in') ? 'logged-in' : 'logged-out') ?>">
