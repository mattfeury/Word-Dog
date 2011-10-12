<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Word, Dog (beta)</title>
  <script src="<?= base_url() ?>scripts/jquery-1.6.4.min.js"></script>
  <script>
  $(document).ready(function(){
     $('.dialog-opener').click(function(event){
       var id=$(this).attr('id');
       $('.dialog.' + id).addClass('current');
     });
     $('.dialog .close').click(function(event){
       $(this).closest('.dialog').removeClass('current');
     });
   });
   </script>
  <link href="<?= base_url() ?>stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
</head>
<body class="<?= $this->session->userdata('logged_in') ? 'logged-in' : 'logged-out' ?>">
