<?php
	class Logout_controller extends CI_Controller
	 {
		public function generalPage()
		{
			//make user logged out
			$this->Logout_user_model->logout();
			
			$this->load->view('login/logout');



		}

	}