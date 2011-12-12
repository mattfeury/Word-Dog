<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends CI_Controller {

	/**
	 *
	 * this controller is set as the default controller in 
	 * config/routes.php
	 *
	 * any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
  public function index() {
    $data['errors'] = $this->session->userdata('errors');    
    $this->load->view('landing', $data);
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
