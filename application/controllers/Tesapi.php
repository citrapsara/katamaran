<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tesapi extends CI_Controller {
	public function index()
	{
		$ceks 		 = $this->session->userdata('username');

		if(!isset($ceks)) {
			redirect('web/login');
		} else {
			redirect('tesapi/v');
		}
	}

	public function v($aksi='',$id='')
	{
		$ceks 	 = $this->session->userdata('username');
		$id_user = $this->session->userdata('id_user');
		$level 	 = $this->session->userdata('level');
		if(!isset($ceks)) {
			redirect('web/login');
		}

		
		$data['tesapi'] = $this->Guzzle_model->getAllTesapi();

		
		if ($aksi == 't') {
			$p = "tambah";
			$data['judul_web'] 	  = "Tesapi";
		}else{
			$p = "index";
			$data['judul_web'] 	  = "Tesapi";
		}

		$this->load->view('header', $data);
		$this->load->view("tesapi/$p", $data);
		$this->load->view('footer');

		date_default_timezone_set('Asia/Singapore');
		$tgl = date('Y-m-d H:i:s');

		if (isset($_POST['btnsimpan'])) {
			$nama = htmlentities(strip_tags($this->input->post('nama')));
			$tanggaljam = htmlentities(strip_tags($this->input->post('tanggaljam')));
			$tanggal = $this->input->post('tanggal');
			$jam = $this->input->post('jam');

			$tanggal_convert = date('Y-m-d', strtotime($tanggal));

			$simpan = 'y';

			if ($simpan=='y') {
				$data = array(
					'nama'	=> $nama,
					'tanggaljam'	=> $tanggaljam,
					'tanggal'	=> $tanggal_convert,
					'jam'	=> $jam
				);
				$this->Guzzle_model->createTesapi($data);

				$this->session->set_flashdata('msg',
					'
					<div class="alert alert-success alert-dismissible" role="alert">
						 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							 <span aria-hidden="true">&times;</span>
						 </button>
						 <strong>Sukses!</strong> Berhasil disimpan.
					</div>
				 <br>'
				);
			}else {
				$this->session->set_flashdata('msg',
					'
					<div class="alert alert-warning alert-dismissible" role="alert">
						 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							 <span aria-hidden="true">&times;</span>
						 </button>
						 <strong>Gagal!</strong>
					</div>
				 <br>'
				);
			}
			redirect("tesapi/v");
		}
	}
}