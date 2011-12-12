<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Word, Dog (beta)</title>
  <script src="<?= base_url() ?>scripts/jquery-1.6.4.min.js"></script>
  <!--[if lt IE 9]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
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
  <?= link_tag(array(
                    'href' => 'stylesheets/screen.css',
                    'rel' => 'stylesheet',
                    'type' => 'text/css',
                    'media' => 'screen, projection'
              )); ?>
</head>
<body class="<?= $this->router->class . ' ' . ($this->session->userdata('logged_in') ? 'logged-in' : 'logged-out') ?>">
