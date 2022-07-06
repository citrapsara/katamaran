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

		$lokasi = 'file/daduk';
		$this->upload->initialize(array(
			"upload_path"   => "./$lokasi",
			"allowed_types" => "*"
		));

		if (isset($_POST['btnsimpan'])) {
			$nama = htmlentities(strip_tags($this->input->post('nama')));
			$tanggaljam = htmlentities(strip_tags($this->input->post('tanggaljam')));
			$tanggal = $this->input->post('tanggal');
			$jam = $this->input->post('jam');
			

			$tanggal_convert = date('Y-m-d', strtotime($tanggal));

			if ($_FILES['files']['name'][0] == null) {
				$count = 0;
			} else {
				$count = count($_FILES['files']['name']);
			}

			if($count != 0) {
				for($i=0;$i<$count;$i++){
				
					if(!empty($_FILES['files']['name'][$i])){
				
					$_FILES['file']['name'] = $_FILES['files']['name'][$i];
					$_FILES['file']['type'] = $_FILES['files']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['files']['error'][$i];
					$_FILES['file']['size'] = $_FILES['files']['size'][$i];
	
					if ( ! $this->upload->do_upload('file'))
						{
							$simpan = 'n';
							$pesan  = htmlentities(strip_tags($this->upload->display_errors('<p>', '</p>')));
						}
						else
						{
							$gbr = $this->upload->data();
							$filename = "$lokasi/".$gbr['file_name'];
							$url_file[$i] = preg_replace('/ /', '_', $filename);
							$simpan = 'y';
						}
					}
				}
			} else {
				$simpan = 'y';
			}

			$simpan = 'y';

			if ($simpan=='y') {
				$data = array(
					'nama'	=> $nama,
					'tanggaljam'	=> $tanggaljam,
					'tanggal'	=> $tanggal_convert,
					'jam'	=> $jam,
					'files' => json_encode($url_file)

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