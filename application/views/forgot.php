  <? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>

  <div class="session">
    <button id="login" class="dialog-opener logged-out">Login</button>
    <button id="signup" class="dialog-opener logged-out">Sign Up</button>
    <span class="logged-in">Logged In, <?= $this->session->userdata('email') ?></span>
    
  </div>
</header>
<section id="container">
  <section id="content">
    
    <?
	$attributes = array('url' => '/users/forgotPassword');
    echo form_open('users/forgotPassword', $attributes);
    ?>
      <h2>Reset password</h2>

      <label>Email: <input name="email" class="email" type="text" /></label>
      <label>Re-type Email: <input name="email2" class="email" type="text" /></label>

      <input class="submit" type="submit" />
    </form>
  </section>
</section>
<? $this->load->view('tail'); ?>
