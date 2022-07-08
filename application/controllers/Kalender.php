<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kalender extends CI_Controller {

	public function index()
	{
		$ceks = $this->session->userdata('token_katamaran');
		$id_user = $this->session->userdata('id_user');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['judul_web'] = "Kalender";

			date_default_timezone_set('Asia/Singapore');
			$data['time_now'] = date('H:i');
			
			$data['hari_ini'] = date('Y-m-d');
			
			$data['agenda'] = $this->Guzzle_model->getAllAgenda();
			

			$this->load->view('header', $data);
			$this->load->view('kalender', $data);
			$this->load->view('footer');

		}
	}

}
