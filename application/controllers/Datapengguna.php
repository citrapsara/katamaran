<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datapengguna extends CI_Controller {

	public function index()
	{
		redirect('datapengguna/v');
	}

	public function v($aksi='', $id='')
	{
		$id = hashids_decrypt($id);
		$ceks 	 = $this->session->userdata('username');
		$id_user = $this->session->userdata('id_user');
		$level 	 = $this->session->userdata('level');
		
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			
			if ($level != 'superadmin') {
				redirect('404_content');
			}

			$user_list = $this->Guzzle_model->getAllUser();
			foreach ($user_list as $key => $value) {
				if ($value['role'] == 'superadmin') continue;
				$data['user_list'][$key] = $value;
			}

			if ($aksi == 't') {
				$nama = $this->input->post('nama');
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$password2 = $this->input->post('password2');
				
				$pesan = '';
				$simpan = 'y';

				if ($simpan == 'y') {
				$data = array(
					'nama'		=> $nama,
					'username'	=> $username,
					'password'	=> $password,
					'password2'	=> $password2
				);

				$this->Guzzle_model->createUser($data);
					
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
				redirect('datapengguna/v');
			}elseif ($aksi == 'e') {
				$id_user = $this->input->post('id_user');
				$cek_user = $this->Guzzle_model->getUserById($id_user);
				if ($cek_user == '') {redirect('404');} else {

				$nama = $this->input->post('nama');
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$password2 = $this->input->post('password2');
				
				$pesan = '';
				$simpan = 'y';
				
				if ($simpan == 'y') {
				$data = array(
					'nama'		=> $nama,
					'username'	=> $username,
					'password'	=> $password,
					'password2'	=> $password2
				);


				$this->Guzzle_model->updateUser($id_user, $data);
					
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
				redirect('datapengguna/v');
				}
			}
			elseif ($aksi == 'h') {
				$id_user = $this->input->post('id_user');
				$cek_data = $this->Guzzle_model->getUserById($id_user);

				if ($cek_data == null) {redirect('404');} else {
					$this->Guzzle_model->deleteUser($id_user);
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
				redirect('datapengguna/v');
			} else {
				$p = "index";
				$data['judul_web'] 	  = "Pengguna";
			}

			$this->load->view('header', $data);
			$this->load->view("datapengguna/$p", $data);
			$this->load->view('footer');

			date_default_timezone_set('Asia/Jakarta');
			$tgl = date('Y-m-d H:i:s');

			if (isset($_POST['btnsimpan'])) {
				$nama 	 = htmlentities(strip_tags($this->input->post('nama')));
				$whatsapp 	 = htmlentities(strip_tags($this->input->post('whatsapp')));
				$role  = htmlentities(strip_tags($this->input->post('role')));
				$username = htmlentities(strip_tags($this->input->post('username')));
				$password  = htmlentities(strip_tags($this->input->post('password')));
				$password2 = htmlentities(strip_tags($this->input->post('password2')));

				$cek_username = array_search($username, array_column($user_list, 'username', 'id'));

				$pesan  = '';
				$simpan = 'y';
				
				if ($cek_username != null) {
					$simpan = 'n';
					$pesan  = "Username '<b>$username</b>' sudah ada";
				} else {
					if ($password!=$password2) {
						$simpan = 'n';
						$pesan  = "Password tidak cocok!";
					}
				}

				if ($simpan=='y') {
					$data = array(
						'nama'			 => $nama,
						'whatsapp'			 => $whatsapp,
						'username' 		 => $username,
						'password' 		 => $password,
						'role' 			 => $role
					);
					$this->Guzzle_model->createUser($data);
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
					 redirect("datapengguna/v/t");
				}
				 redirect("datapengguna/v");
			}

			if (isset($_POST['btnupdate'])) {
				$nama 	 = htmlentities(strip_tags($this->input->post('nama')));
				$whatsapp 	 = htmlentities(strip_tags($this->input->post('whatsapp')));
				$role  = htmlentities(strip_tags($this->input->post('role')));
				$username = htmlentities(strip_tags($this->input->post('username')));
				$password  = htmlentities(strip_tags($this->input->post('password')));
				$password2 = htmlentities(strip_tags($this->input->post('password2')));
				$data_lama = $data['pengguna'];
				
				if ($username != $data_lama['username']) {
					$cek_username = array_search($username, array_column($user_list, 'username', 'id'));
				}

				$pesan  = '';
				$simpan = 'y';
				
				if ($cek_username != null) {
					$simpan = 'n';
					$pesan  = "Username '<b>$username</b>' sudah ada";
				} else {
					$pass_lama = $data_lama['password'];
					if ($password=='') {
						$password = $pass_lama;
					} else {
						if ($password!=$password2) {
							$simpan = 'n';
							$pesan  = "Password tidak cocok!";
						}
					}
					
				}

				if ($simpan=='y') {
					$data = array(
						'nama'			=> $nama,
						'whatsapp'		=> $whatsapp,
						'username' 		=> $username,
						'password' 		=> $password,
						'role' 			=> $role
					);
					$this->Guzzle_model->updateUser($id, $data);

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
					redirect("datapengguna/v/e/".hashids_encrypt($id));
				}
				redirect("datapengguna/v");
			}
		}
	}

}
				

