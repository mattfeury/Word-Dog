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
  <button class="home">Home</button>

  <div class="session">
    <button class="login">Login</button>
    <button class="signup">Sign Up</button>
  </div>
</header>
<section id="content">
  <section id="container">
    <h1>WordDog. Putting the Word in Word, Dog.</h1>

    <div>
      <p>
        <button>Do Something</button>
      </p>
    </div>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
  </section>
</section>
<div class="dialogs">
  <div class="login dialog">
    <? 
    $attributes = array('class' => 'login');
    echo form_open('users/login', $attributes);
    ?>
      <h2>Login</h2>

      <input name="email" class="email" type="text" />
      <input name="password" class="password" type="password" />
      <input class="submit" type="submit" />
    </form>
  </div>
  <div class="signup dialog">
  </div>
  <div id="shim"></div>
</div>
</body>
</html>
