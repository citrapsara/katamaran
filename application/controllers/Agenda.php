<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {
	public function index()
	{
		$ceks 	 = $this->session->userdata('username');

		if(!isset($ceks)) {
			redirect('web/login');
		} else {
			redirect('dashboard');
		}

	}

	public function v($aksi='',$tanggal='',$tanggal2='')
	{
		$ceks 	 = $this->session->userdata('username');
		$id_user = $this->session->userdata('id_user');
		$level 	 = $this->session->userdata('level');

		if(!isset($ceks)) {
			redirect('web/login');
		}

		date_default_timezone_set('Asia/Singapore');
		$data['time_now'] = date('H:i');
		$today = date('Y-m-d');

		$lokasi = 'file/daduk';
		$file_size = 1024 * 100; // 10 MB
		$this->upload->initialize(array(
			"upload_path"   => "./$lokasi",
			"allowed_types" => "*",
			"max_size" => "$file_size"
		));
		
		if ($aksi == 't') {
			$nama = $this->input->post('nama');
			$tanggal = $this->input->post('tanggal');
			$waktu = $this->input->post('waktu');
			$tempat = $this->input->post('tempat');
			$peserta = $this->input->post('peserta');
			$pakaian = $this->input->post('pakaian');
			$deskripsi = $this->input->post('deskripsi');

			$tanggal_convert = date('Y-m-d', strtotime($tanggal));

			$pesan = '';

			if (!is_dir($lokasi)) {
				# jika tidak maka folder harus dibuat terlebih dahulu
				mkdir($lokasi, 0777, $rekursif = true);
			}

			$count = count($_FILES['files']['name']);

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

			if ($simpan == 'y') {
			$data = array(
				'nama'		=> $nama,
				'tanggal'	=> $tanggal_convert,
				'waktu'		=> $waktu,
				'tempat'	=> $tempat,
				'peserta'	=> $peserta,
				'pakaian'	=> $pakaian,
				'deskripsi'	=> $deskripsi,
				'url_data_dukung' => json_encode($url_file)
			);

			$this->Guzzle_model->createAgenda($data);
				
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
						 <strong>Gagal!</strong> '.$pesan.'.
					</div>
				 <br>'
				);
			}
			redirect('dashboard');

		} elseif ($aksi == 'e') {
			$id_agenda = $this->input->post('id_agenda');
			$nama = $this->input->post('nama');
			$tanggal = $this->input->post('tanggal');
			$waktu = $this->input->post('waktu');
			$tempat = $this->input->post('tempat');
			$peserta = $this->input->post('peserta');
			$pakaian = $this->input->post('pakaian');
			$deskripsi = $this->input->post('deskripsi');

			
			$tanggal_convert = date('Y-m-d', strtotime($tanggal));
			
			$pesan = '';
			$simpan = 'y';
			
			if ($simpan == 'y') {
			$data = array(
				'nama'		=> $nama,
				'tanggal'	=> $tanggal_convert,
				'waktu'		=> $waktu,
				'tempat'	=> $tempat,
				'peserta'	=> $peserta,
				'pakaian'	=> $pakaian,
				'deskripsi'	=> $deskripsi
			);


			$this->Guzzle_model->updateAgenda($id_agenda, $data);
				
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
						 <strong>Gagal!</strong> '.$pesan.'.
					</div>
				 <br>'
				);
			}
			redirect('dashboard');
		} elseif ($aksi == 'h') {
			$id_agenda = $this->input->post('id_agenda');
			$cek_data = $this->Guzzle_model->getAgendaById($id_agenda);

			if ($cek_data == null) {redirect('404');} else {
				$this->Guzzle_model->deleteAgenda($id_agenda);
			}
			

			$this->session->set_flashdata('msg',
				'
				<div class="alert alert-success alert-dismissible" role="alert">
					 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						 <span aria-hidden="true">&times;</span>
					 </button>
					 <strong>Sukses!</strong> Berhasil dihapus.
				</div>
				<br>'
			);
			redirect('dashboard');
		} elseif ($aksi == 'harian') {
			$p = 'list_jadwal';

			if ($tanggal == '') {
				$data['header_hari'] = $today;
			} else {
				$data['header_hari'] = $tanggal;
			}
			
			$data['agenda'] = $this->Guzzle_model->getAgendaByTanggal($data['header_hari']);
		} elseif ($aksi == 'mingguan') {
			$p = 'list_jadwal';

			if ($tanggal == '' AND $tanggal2 == '') {
				$data['header_hari1'] = date("Y-m-d", strtotime("Monday this week"));
				$data['header_hari2'] = date("Y-m-d", strtotime("Sunday this week"));
				$data['agenda'] = $this->Guzzle_model->getAgendaMingguIni();
			} else {
				$data['header_hari1'] = $tanggal;
				$data['header_hari2'] = $tanggal2;
				$data['agenda'] = $this->Guzzle_model->getAgendaByRangeTanggal($tanggal, $tanggal2);
			}
		} elseif ($aksi == 'bulanan') {
			$p = 'list_jadwal';

			if ($tanggal == '' AND $tanggal2 == '') {
				$data['header_bulan'] = $this->Mcrud->bulan_id($today);
				$data['header_tahun'] = date('Y', strtotime($today));
				$data['agenda'] = $this->Guzzle_model->getAgendaBulanIni();
			} else {
				$data['header_bulan'] = $this->Mcrud->bulan_id($tanggal);
				$data['header_tahun'] = date('Y', strtotime($tanggal));
				$data['agenda'] = $this->Guzzle_model->getAgendaByRangeTanggal($tanggal, $tanggal2);
			}
		}
		else{
			$p = "list_jadwal";
		}

		$this->load->view('header', $data);
		$this->load->view("agenda/$p", $data);
		$this->load->view('footer');

		
			
	}

}