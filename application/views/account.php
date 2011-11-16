  <? $this->load->view('head'); ?>
<header>
  <?= anchor('/users', 'Teacher Zone', 'class="teacherzone home"'); ?>

  <div class="session">
    <?= anchor('/logout', 'Log Out', 'class="logged-in logout"'); ?>
  </div>
</header>
<section id="container">
  <section id="content">
    
    <?     
    //print_r( $user);
	  echo form_open('users/changeAccount');
    ?>
	
	  Name: <input type="text" name="name" value= "<?= $user->name ?>"/><br>
      Email: <input type="email" name="email" value= "<?= $user->email ?>"/><br>
      School: <input type="text" name="school" value= "<?= $user->school ?>"/><br>
      Grade: <input type="text" name="grade" value= "<?= $user->grade ?>"/><br>
			
      Old Password: <input type="password" name="oldpassword" /><br>
	  New Password: <input type="password" name="newpassword1" /><br>
	  Re-type Password: <input type="password" name="newpassword2" /><br>
	  
      
	  <input class="submit" type="submit" />
    </form>
    
  </section>
</section>
<? $this->load->view('tail'); ?>
