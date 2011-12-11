<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>

  <div class="session">
    <button id="login" class="dialog-opener logged-out">Login</button>
    <button id="signup" class="dialog-opener logged-out">Sign Up</button>
    <span class="logged-in">Logged In, <?= $this->session->userdata('email') ?></span>
    <?= anchor('/units', 'Teacher Zone', 'class="logged-in"'); ?>
    <?= anchor('/logout', 'Log Out', 'class="logged-in logout"'); ?>
  </div>
</header>
<section id="container">
  <section id="content">
    <h1 class="blurb">Welcome to Word Dog!</h1>
    <h2>An English Practice Application</h2>

      <?= anchor('/users/show',
            img(array(
                  'src' => 'images/dotty-animated.gif',
                  'class' => 'about')),
            'class="logo-holder"'
      ); ?>
    <?= anchor('/users/show', 'Find My Teacher', 'id="teachers"'); ?>
    <!--<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>-->
  </section>
</section>
<div class="dialogs">
  <div class="login dialog">
    <? 
    $attributes = array('class' => 'login');
    echo form_open('login', $attributes);
    ?>
      <h2>Login</h2>

      <label>Email: <input name="email" class="email" type="text" /></label>
      <label>Password: <input name="password" class="password" type="password" /></label>
      <button name="submit" type="submit" value='0'> Login </button>
	  <button name="submit" type="submit" value ='1'> Forgot Password </button>
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
<? $this->load->view('tail'); ?>
