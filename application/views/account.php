<? $this->load->view('head'); ?>
<header>
  <?= anchor('/units', 'Teacher Zone', 'class="teacherzone home"'); ?>

  <div class="session">
    <?= anchor('/logout', 'Log Out', 'class="logged-in logout"'); ?>
  </div>
</header>
<section id="container">
  <section id="content">
    
    <?     
	  echo form_open('users/changeAccount');
    ?>
	  
	  <h2>Account Information</h2>
	  
	  <label>Name: <input type="text" class="info" name="name" value= "<?= $user->name ?>"/></label>
    <label>Email: <input type="email" class="info" name="email" value= "<?= $user->email ?>"/></label>
    <label>School: <input type="text" class="info" name="school" value= "<?= $user->school ?>"/></label>
    <label>Grade: <input type="text" class="info" name="grade" value= "<?= $user->grade ?>"/></label>
			
    <label>Old Password: <input type="password" class="info" name="oldpassword" /></label>
	  <label>New Password: <input type="password" class="info" name="newpassword1" /></label>
	  <label>Re-type Password: <input type="password" class="info" name="newpassword2" /></label>
	  
      
	  <input class="submit" type="submit" />
    </form>
    
  </section>
</section>
<? $this->load->view('tail'); ?>
