<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	var $helpers = array('Html', 'Form');
	var $components = array('Email');

  public function index() {
    if (! $this->session->userdata('logged_in')) {
      redirect(base_url());
      return;
    }
  }
  
  public function show() {
    $user = new User();
		$user->limit(5)->get();
    $data['users'] = $user;
		$this->load->view('teachers', $data);
	}

  public function logout() {
    //TODO decide if we should destroy everything here
    //we could just as well unset the necessary fields
    $this->session->sess_destroy();
    redirect(base_url());
  }

  public function login() {
  
    $email = $this->input->post('email', TRUE);
    $password = $this->input->post('password', TRUE);
    $u = new User();
    $u->email = $email;
    $u->password = $password;

    $success = $u->login();

    if ($success) {
      $this->_setSessionForUser($u);
      redirect('/units');
    } else {
      $this->session->set_userdata(array('errors' => $u->error->string));
      redirect(base_url() . '?error=login');
    }

  }

  public function register() {
    $email = $this->input->post('email', TRUE);
    $password = $this->input->post('password', TRUE);
    $name = $this->input->post('name', TRUE);
    $school = $this->input->post('school', TRUE);
    $grade = $this->input->post('grade', TRUE);

    $u = new User();
    $u->email = $email;
    $u->password = $password;
    $u->name = $name;
    $u->school = $school;
    $u->grade = $grade;

    // This will attempt to upsert into the database.
    // It'll also check all the model's validation rules.
    // If it is successful, the user object will be updated (with a unique id)
    $u->save();

    if (! empty($u->id)) {
      $this->_setSessionForUser($u);
      redirect('/units');
    } else {
      $this->session->set_userdata(array('errors' => $u->error->string));
      redirect(base_url() . '?error=signup');
    }
  }

  private function _setSessionForUser($user) {
    $session_data = array(
                      'email'     => $user->email,
                      'name'      => $user->name,
                      'logged_in' => TRUE
                    );
    $this->session->set_userdata($session_data);

  }
  
  public function modify() {
    $email = $this->session->userdata('email');
	
    $user = new User();
    $user->where('email', $email)->get();
		
    $data['user'] = $user;
    $this->load->view('account', $data);

  }
  
  public function forgotPage(){
	$data = new User();
	$this->load->view('forgot',$data);
	}
  
  public function changeAccount() {
    $email = $this->input->post('email', TRUE);
	$oldpassword = $this->input->post('oldpassword', TRUE);
	$newpassword1 = $this->input->post('newpassword1', TRUE);
    $newpassword2 = $this->input->post('newpassword2', TRUE);
    $name = $this->input->post('name', TRUE);
	$school = $this->input->post('school', TRUE);
    $grade = $this->input->post('grade', TRUE);

	$u = new User();
	$oldemail = $this->session->userdata('email');
    $u->where('email', $oldemail)->get();
		
    $u->email = $email;
    $u->name = $name;
    $u->school = $school;
    $u->grade = $grade;
	
	if(md5($oldpassword) == $u->password)
		if($newpassword1 == $newpassword2)
			$u->password = $newpassword1;				

    $u->save();
	$data['user'] = $u;
	$this->load->view('account', $data);
	}
	
	function forgotPassword() {
	
		$email = $this->input->post('email',TRUE);
		$email2 = $this->input->post('email2',TRUE);
		if($email != $email2){
			echo("<p> Your emails did not match. Please re-enter </p>");
		}
		else{
			$user = new User();
			$user->where('email', $email)->get();		
			$hash=sha1($user->email.rand(0,100));
			$user->tokenhash=$hash;			
			$user->save();
			
			$ms='Click on the link below to reset your password ';
			$ms.=site_url().'/users/verify?t='.$hash.'&n='.$email.'';
			$ms=wordwrap($ms,70);

			$to = $this->input->post('email', TRUE);;
			$subject = "Hi!";
			$body = $ms;
			$from = "worddog.forgot.pass@gmail.com";
			$headers = "From: $from";
			if (mail($to, $subject, $body, $headers)) {
			  echo "<script>alert('The reset link has been sent to the email address in our records.'); window.location = '" . SITE_URL() . "'</script>";
			  			  
			}
			else {
			  echo "<script>alert('Message delivery failed. Please try again.'); history.back();</script>";
			  
			}
			
		}
	}
	
	function verify()
	{	
	$token = $_GET['t'];	
	$email = $_GET['n'];	
		if (!empty($token) && !empty($email))
		{
			$results = new User();
			$results->where('email', $email)->get();	
			if (!empty($results->tokenhash))
			{	
				if($results->tokenhash==$token)
				{						
					$results->save();
					$data['user'] = $results;
					$this->load->view('resetPass', $data);
				}
				else
				{
					echo("Wrong token. Please request a new token.");
					$this->load->view('forgot');
				}
			}
			else 
			{
				echo("Token has alredy been used");				
				$this->load->view('forgot');
			}
		}
		else
		{
			echo("Token corrupted. Please re-register");
			$this->redirect('/users/forgotPassword');
		}
	}
	


	function resetPassword() 
	{
		$token = $this->input->post('token',TRUE);
		$email = $this->input->post('email',TRUE);
		$password = $this->input->post('password',TRUE);
		$password2 = $this->input->post('password2',TRUE);
		$user = new User();
		$user->where('email', $email)->get();
		
		if($token != $user->tokenhash){
			echo "<script>alert('Incorrect token. Please retry.'); window.location = '" . SITE_URL() . "'</script>";			
		}
		else{
			if($password == $password2){
				$u = new User();
				$u->where('email', $email)->get();
				$u->password = $password;
				$u->tokenhash = null;
				$u->save();
				echo "<script>alert('Your password has successfully been changed.'); window.location = '" . SITE_URL() . "'</script>";			
			}
			else{
				echo "<script>alert('Your passwords did not match. Please try again')</script>";			
			}
		}
	}

	
}
