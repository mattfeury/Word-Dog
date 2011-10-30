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
    <h1 class="blurb">Welcome to English Practice App!</h1>

    <?= img(array(
        'src' => 'images/12-oz.gif',
        'class' => 'about'
      )); ?>
    <?= anchor('/users/show', 'Find My Teacher', 'id="teacherlist"'); ?>
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
<? $this->load->view('tail'); ?>
