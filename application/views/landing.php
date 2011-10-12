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

<header>
  <button class="home">Home</button>

  <div class="session">
    <button id="login" class="dialog-opener">Login</button>
    <button id="signup" class="dialog-opener">Sign Up</button>
  </div>
</header>
<section id="container">
  <section id="content">
    <h1>WordDog. Putting the Word in Word, Dog.</h1>

    <button>Do Something</button>

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

      <label>Email: <input name="email" class="email" type="text" /></label>
      <label>Password: <input name="password" class="password" type="password" /></label>
      <input class="submit" type="submit" />
    </form>
    <button class="close">Close</button>
  </div>
  <div class="signup dialog">
    <? 
    $attributes = array('class' => 'signup');
    echo form_open('users/register', $attributes);
    ?>
      <h2>Sign Up</h2>

      <label>Email: <input name="email" class="email" type="text" /></label>
      <label>Password: <input name="password" type="password" /></label>
      <label>Name: <input name="name" type="text" /></label>
      <label>School: <input name="school" type="text" /></label>
      <label>Grade: <input name="grade" type="text" /></label>

      <input class="submit" type="submit" />
    </form>
    <button class="close">Close</button>
  </div>
  <div id="shim"></div>
</div>
</body>
</html>
