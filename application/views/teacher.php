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
  <button class="teacherzone">Teacher Zone</button>

  <div class="session">
    <button class="editaccount">Edit Account</button>
    <button class="logout">Log Out</button>
  </div>
</header>
<section id="content">
  <section id="container">
    <h2>List of Units</h2>

    <ul>
      <li>Dick and Jane <button>Edit</button></li> 
      <li>Little Red Riding Hood <button>Edit</button></li>
      <li>See Spot Run <button>Edit</button></li>   
      <li>The Three Little Pigs <button>Edit</button></li>   
    </ul>
    
    <button>Create New Unit</button>
  </section>
</section>
</body>
</html>
