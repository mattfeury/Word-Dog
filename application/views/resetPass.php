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
    
    <?
	$attributes = array('url' => '/users/resetPassword');
    echo form_open('users/resetPassword', $attributes);
    ?>
      <h2>Reset password</h2>

	  <label>Email: <input type="email" class="info" name="email" value= "<?= $user->email ?>"/></label>
	  <label>Password: <input name="password" class="info" type="password" /></label>
      <label>Re-type Password: <input name="password2" class="info" type="password" /></label>
	  <input type="hidden" name="token" value="<?= $user->tokenhash?>">
      <input class="submit" type="submit" />
    </form>
        
  </section>
</section>
<? $this->load->view('tail'); ?>
