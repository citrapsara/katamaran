<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('pdf_report');
        $this->load->library('session');
//        $this->load->model('Guzzle_model');
        $this->load->helper('security');
        $this->load->helper('file');

    }

    public function index()
    {
        $ceks = $this->session->userdata('token_katamaran');

        if (!isset($ceks)) {
            redirect('web/login');
        } else {
            redirect('dashboard');
        }

    }

    public function v($aksi = '', $tanggal = '', $tanggal2 = '')
    {
        $ceks = $this->session->userdata('token_katamaran');
        $id_user = $this->session->userdata('id_user');
        $level = $this->session->userdata('level');

        // if(!isset($ceks)) {
        // 	redirect('web/login');
        // }

        date_default_timezone_set('Asia/Singapore');
        $data['time_now'] = date('H:i');
        $today = date('Y-m-d');

        $lokasi = 'file/daduk';
        $max_size = 1024*5;
        $this->upload->initialize(array(
            "upload_path" => "./$lokasi",
            "allowed_types" => "*",
            "max_size" => $max_size
        ));

        if ($aksi == 't') {
            if (!isset($ceks)) {
                redirect('web/login');
            }

            $nama = $this->input->post('nama');
            $tanggal = $this->input->post('tanggal');
            $jam_mulai = $this->input->post('jam_mulai');
            $jam_selesai = $this->input->post('jam_selesai');
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

            //NAH INI TADI PENYEBABNYA, SEHINGGA YANG MUNCUL PRINT_R DARI ARRAY VARIABLE
//            echo '<pre>';
//            print_r($_FILES['url_files']);
//            exit;

            if ($_FILES['url_files']['name'][0] == null) {
                $count = 0;
            } else {
                $count = count($_FILES['url_files']['name']);
            }

            if ($count != 0) {
                for ($i = 0; $i < $count; $i++) {

                    if (!empty($_FILES['url_files']['name'][$i])) {

                        $_FILES['file']['name'] = $_FILES['url_files']['name'][$i];
                        $_FILES['file']['type'] = $_FILES['url_files']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['url_files']['tmp_name'][$i];
                        $_FILES['file']['error'] = $_FILES['url_files']['error'][$i];
                        $_FILES['file']['size'] = $_FILES['url_files']['size'][$i];

                        if (!$this->upload->do_upload('file')) {
                            $simpan = 'n';
                            $pesan = htmlentities(strip_tags($this->upload->display_errors('<p>', '</p>')));
                        } else {
                            $gbr = $this->upload->data();
                            $filename = "$lokasi/" . $gbr['file_name'];
                            $url_file[$i] = preg_replace('/ /', '_', $filename);
                            $simpan = 'y';
                        }
                    }
                }
            } else {
                $simpan = 'y';
            }

            if ($simpan == 'y') {
                $data = array(
                    'id_user' => $id_user,
                    'nama' => $nama,
                    'tanggal' => $tanggal_convert,
                    'jam_mulai' => $jam_mulai,
                    'jam_selesai' => $jam_selesai,
                    'tempat' => $tempat,
                    'peserta' => $peserta,
                    'pakaian' => $pakaian,
                    'deskripsi' => $deskripsi,
                    'url_data_dukung' => json_encode($url_file),
                    'status' => 'x'
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
            } else {
                $this->session->set_flashdata('msg',
                    '
					<div class="alert alert-warning alert-dismissible" role="alert">
						 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							 <span aria-hidden="true">&times;</span>
						 </button>
						 <strong>Gagal!</strong> ' . $pesan . '.
					</div>
				 <br>'
                );
            }
            redirect("agenda/v/harian/" . $tanggal_convert);

        } elseif ($aksi == 'e') {
            if (!isset($ceks)) {
                redirect('web/login');
            }

            $id_agenda = $this->input->post('id_agenda');
            $nama = $this->input->post('nama');
            $tanggal = $this->input->post('tanggal');
            $jam_mulai = $this->input->post('jam_mulai');
            $jam_selesai = $this->input->post('jam_selesai');
            $tempat = $this->input->post('tempat');
            $peserta = $this->input->post('peserta');
            $pakaian = $this->input->post('pakaian');
            $deskripsi = $this->input->post('deskripsi');

            $data_lama = $this->Guzzle_model->getAgendaById($id_agenda);

            $tanggal_convert = date('Y-m-d', strtotime($tanggal));

            $pesan = '';

            if (!is_dir($lokasi)) {
                # jika tidak maka folder harus dibuat terlebih dahulu
                mkdir($lokasi, 0777, $rekursif = true);
            }

            // echo '<pre>'; print_r($_FILES['url_files']['name'][0]); exit;

            if ($_FILES['url_files_edit']['name'][0] == null) {
                $count = 0;
            } else {
                $count = count($_FILES['url_files_edit']['name']);
            }

            if ($count != 0) {
                for ($i = 0; $i < $count; $i++) {

                    if (!empty($_FILES['url_files_edit']['name'][$i])) {

                        $_FILES['file']['name'] = $_FILES['url_files_edit']['name'][$i];
                        $_FILES['file']['type'] = $_FILES['url_files_edit']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['url_files_edit']['tmp_name'][$i];
                        $_FILES['file']['error'] = $_FILES['url_files_edit']['error'][$i];
                        $_FILES['file']['size'] = $_FILES['url_files_edit']['size'][$i];

                        if (!$this->upload->do_upload('file')) {
                            $simpan = 'n';
                            $pesan = htmlentities(strip_tags($this->upload->display_errors('<p>', '</p>')));
                        } else {
                            $gbr = $this->upload->data();
                            $filename = "$lokasi/" . $gbr['file_name'];
                            $url_file[$i] = preg_replace('/ /', '_', $filename);
                            $simpan = 'y';
                        }
                    }
                }
//				$url_data_dukung = json_encode($url_file);
                $file_lama = json_decode($data_lama['url_data_dukung'] == 'null' ? "[]" : $data_lama['url_data_dukung']);
                $url_data_dukung = json_encode(array_merge($file_lama, $url_file));
            } else {
                $url_data_dukung = $data_lama['url_data_dukung'];
                $simpan = 'y';
            }


            if ($simpan == 'y') {
                $data = array(
                    'nama' => $nama,
                    'tanggal' => $tanggal_convert,
                    'jam_mulai' => $jam_mulai,
                    'jam_selesai' => $jam_selesai,
                    'tempat' => $tempat,
                    'peserta' => $peserta,
                    'pakaian' => $pakaian,
                    'deskripsi' => $deskripsi,
                    'url_data_dukung' => $url_data_dukung
                );

//			$this->Guzzle_model->updateAgenda($id_agenda, $data);
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
            } else {
                $this->session->set_flashdata('msg',
                    '
					<div class="alert alert-warning alert-dismissible" role="alert">
						 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							 <span aria-hidden="true">&times;</span>
						 </button>
						 <strong>Gagal!</strong> ' . $pesan . '.
					</div>
				 <br>'
                );
            }
//			redirect("agenda/v/harian/" . $tanggal_convert);
            redirect("agenda/v/harian/" . $tanggal_convert);
        } elseif ($aksi == 'h') {
            if (!isset($ceks)) {
                redirect('web/login');
            }

            $id_agenda = $this->input->post('id_agenda');
            $cek_data = $this->Guzzle_model->getAgendaById($id_agenda);

            if ($cek_data == null) {
                redirect('404');
            } else {
                foreach ($this->Mcrud->url_data_dukung($cek_data['url_data_dukung']) as $row) {
                    if ($row != '') {
                        unlink($row);
                    }
                }
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
            redirect("agenda/v/harian/" . $cek_data['tanggal']);
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
        } else if ($aksi == 'df') {
//            echo "idnya: ".$this->input->post('file_id'); exit;
//            $data['agenda'] = $this->Guzzle_model->getAgendaByTanggal($data['header_hari']);

            $id_agenda = $this->input->post('id');
            $cek_data = $this->Guzzle_model->getAgendaById($id_agenda);
//            echo print_r($cek_data); exit;
//            echo ($cek_data['url_data_dukung']); exit;
//            echo "pathnya : ".($this->input->post('path'));
//            echo "file_id nya : ".($this->input->post('file_id')); exit;
//            echo "id agendanya :".$id_agenda; exit;
//            print_r (json_decode($cek_data['url_data_dukung'])[1]); exit;

//            $file = json_decode($cek_data['url_data_dukung']);
//            print_r ($file); exit;
            if (!isset($ceks)) {
                redirect('web/login');
            }

            try {
                //kiriman dari jquery pada edit_agenda.php
                //path == "file" => nama lengkap file
                // pahami disini
//                print_r($this->input->post('path')); exit; BERHASIL DITANGKAP
//                print_r (unlink($this->input->post('path'))); exit; BERHASIL TERHAPUS
                $path = $this->input->post('path');

                if (unlink($path)) {
//                    $file = json_decode($cek_data['url_data_dukung']);
                    //dibawah ini hanya mencari nomor index dari array data dukung yg ada di database
                    //yg sudah otomatis mengacu dari file data dukung url '$cek_data';
//                    unset($file[$this->input->post('file_id')]);

                    //mengacu pada 1 file_id yg sama,  antara $this->>input->post('file_id'),
                    // dgn function jquery deleteFileAgenda

                    $file = json_decode($cek_data['url_data_dukung']);
//                    echo $file[0]; exit;
//                    print_r($this->input->post('file_id')) ; exit;
                    unset($file[$this->input->post('file_id')]);

                    $data = array(
                        'nama' => $cek_data['nama'],
                        'tempat' => $cek_data['tempat'],
                        'tanggal' => $cek_data['tanggal'],
                        'peserta' => $cek_data['peserta'],
                        'why' => $cek_data['why'],
                        'deskripsi' => $cek_data['deskripsi'],
                        'url_data_dukung' => json_encode(count($file)>0?$file:null)
                    );

                    $this->Guzzle_model->updateAgenda($id_agenda, $data);
                }
                echo "success : " . json_encode($file);
            } catch (Exception $e) {
                echo json_encode($e);
            }
            //ini adalah kunci kesuksesan
            return 0;
        } else {
            $p = "list_jadwal";
        }

        $this->load->view('header', $data);
        $this->load->view("agenda/$p", $data);
        $this->load->view('footer');


    }

}