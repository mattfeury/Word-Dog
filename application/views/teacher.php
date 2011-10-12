<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Word, Dog (beta)</title>

  <script src="<?= base_url() ?>scripts/jquery-1.6.4.min.js"></script>
  <link href="<?= base_url() ?>stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
</head>
<body>

<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>

  <div class="session">
    <button class="editaccount">Edit Account</button>
    <?= anchor('/logout', 'Log Out', 'class="logout"'); ?>
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
</body>
</html>
