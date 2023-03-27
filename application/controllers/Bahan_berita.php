<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bahan_berita extends CI_Controller
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
        $ceks = $this->session->userdata('username');
        $id_user = $this->session->userdata('id_user');
//        redirect('laporan/v');
        if (!isset($ceks)) {
            redirect('web/login');
        } else {
            $data['judul_web'] = "Laporan";
            date_default_timezone_set('Asia/Singapore');
//            $p = "laporan_data";

            $p = "bahan_berita";
            $data['tgl_awal_sql'] = "kosong";
            $data['tgl_akhir_sql'] = "kosong";
            $data['id_divisi_selected'] = "kosong";
            $hari_ini = date("Y-m-d");
            $data["tgl_now"] = $this->Mcrud->tgl_id_new($hari_ini, 'full');
            //uncomment
            if($_SESSION['session_filter_date_dari']=='' || $_SESSION['session_filter_date_dari'] == null){
                $data['agenda_data'] = $this->Guzzle_model->getAgendaByRangeTanggal($hari_ini, $hari_ini);

            } else if ($_SESSION['session_filter_date_dari']!='' || $_SESSION['session_filter_date_dari'] != null){
                $data['agenda_data'] = $this->Guzzle_model->getAgendaByRangeTanggal($this->Mcrud->tgl_sql($_SESSION['session_filter_date_dari']),$this->Mcrud->tgl_sql($_SESSION['session_filter_date_dari']));
                $data['filter_date_dari'] = $_SESSION['session_filter_date_dari'];
            }
//            $data['agenda_data'] = $this->Guzzle_model->getAgendaByRangeTanggal($hari_ini, $hari_ini);
            $this->load->view('header', $data);
            $this->load->view("bahan_berita/$p", $data);
            $this->load->view('footer');
        }
    }


    public function v($aksi = '', $tanggal = '', $tanggal2 = '')
    {
        $ceks = $this->session->userdata('username');
        $id_user = $this->session->userdata('id_user');
        $level = $this->session->userdata('level');

        date_default_timezone_set('Asia/Singapore');
        $data['time_now'] = date('H:i');
        $today = date('Y-m-d');

//        $data['tgl_filter_edit'] = null;

        $max_size = 1024*5;
        $lokasi = 'file/bahan_berita';
        $this->upload->initialize(array(
            "upload_path" => "./$lokasi",
            "allowed_types" => "*",
            "max_size" => $max_size
        ));

        if ($aksi == 't') {
            if (!isset($ceks)) {
                redirect('web/login');
            }

            $what = $this->input->post('what');
            $where = $this->input->post('where');
            $when = $this->input->post('when');
            $who = $this->input->post('who');
            $why = $this->input->post('why');
            $how = $this->input->post('how');

//            echo $when; exit;
            // penentuan tentukan session filter_date_dari
            $_SESSION['session_filter_date_dari'] = $this->input->post('when');

//            echo $what."<br>";
//            echo $where."<br>";
//            echo $when."<br>";
//            echo $who."<br>";
//            echo $why."<br>";
//            echo $how."<br>"; exit;

            $tanggal_convert = date('Y-m-d', strtotime($when));

            $pesan = '';

            if (!is_dir($lokasi)) {
                # jika tidak maka folder harus dibuat terlebih dahulu
                mkdir($lokasi, 0777, $rekursif = true);
            }

//            echo '<pre>'; print_r($_FILES['url_files']); exit;


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
//                            var_dump($filename); exit;
                        }
                    }
                }
            } else {
                $simpan = 'y';
            }

            if ($simpan == 'y') {
                $data = array(
                    'id_user' => $id_user,
                    'nama' => $what,
                    'tempat' => $where,
                    'tanggal' => $tanggal_convert,
                    'peserta' => $who,
                    'why' => $why,
                    'deskripsi' => $how,
                    'url_data_dukung' => json_encode($url_file),
                    'status' => 'x',


                );

//                var_dump($data); exit;

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
//            redirect("agenda/v/harian/" . $tanggal_convert);
            redirect("bahan_berita");

        } else if ($aksi == 'f') {
            $data['filter_date_dari'] = $this->input->post('dari_tgl');
            $_SESSION['session_filter_date_dari'] = $this->input->post('dari_tgl');
//            echo $this->Mcrud->tgl_sql($_SESSION['session_filter_date_dari']).'tez';
//            echo ($_SESSION['session_filter_date_dari']).'tez';
//            echo $data['filter_date_dari']; exit;
            $data['tgl_awal_sql'] = $this->Mcrud->tgl_sql($data['filter_date_dari']);
//            echo $data['tgl_awal_sql']; exit;

            $data['agenda_data'] = $this->Guzzle_model->getAgendaByRangeTanggal($data['tgl_awal_sql'], $data['tgl_awal_sql']);

//            echo $data['filter_date_dari']."<br>";
//            echo $data['tgl_awal_sql'];

            $p = "bahan_berita";
            $this->load->view('header', $data);
            $this->load->view("bahan_berita/$p", $data);
            $this->load->view('footer');
        } else if ($aksi == 'e') {
            if (!isset($ceks)) {
                redirect('web/login');
            }
            //taruh
            $id_agenda = $this->input->post('id_agenda');
            $what = $this->input->post('what');
            $where = $this->input->post('where');
            $when = $this->input->post('when');
            $who = $this->input->post('who');
            $why = $this->input->post('why');
            $how = $this->input->post('how');

            //            echo $when; exit;
            // penentuan tentukan session filter_date_dari
            $_SESSION['session_filter_date_dari'] = $this->input->post('when');

            //disini convert tanggal jadi tanggal sql
//            $data['tgl_filter_edit'] = $this->Mcrud->tgl_sql($when);
//            echo $data['tgl_filter_edit']; exit;

//            echo $when; exit;

            $data_lama = $this->Guzzle_model->getAgendaById($id_agenda);

//            print_r($data_lama) ; exit;

            $tanggal_convert = date('Y-m-d', strtotime($when));

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
                $file_lama = json_decode($data_lama['url_data_dukung']=='null'?"[]":$data_lama['url_data_dukung']);
                $url_data_dukung =  json_encode(array_merge($file_lama, $url_file));
            } else {
                $url_data_dukung = $data_lama['url_data_dukung'];
                $simpan = 'y';
            }


            if ($simpan == 'y') {
                $data = array(
                    'nama' => $what,
                    'tempat' => $where,
                    'tanggal' => $tanggal_convert,
                    'peserta' => $who,
                    'why' => $why,
                    'deskripsi' => $how,
                    'url_data_dukung' => $url_data_dukung
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
            //ori redirect
//            redirect("agenda/v/harian/" . $tanggal_convert);
            redirect("bahan_berita");


        } else if ($aksi == 'h') {
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
//            redirect("agenda/v/harian/" . $cek_data['tanggal']);
            redirect("bahan_berita");
        } else if ($aksi == 'df') {
//            $ceks = $this->session->userdata('username');

            $id_agenda = $this->input->post('id');
            $cek_data = $this->Guzzle_model->getAgendaById($id_agenda);
            if (!isset($ceks)) {
                redirect('web/login');
            }

            try {
                $path = $this->input->post('path');


                if (unlink($path)) {
                    $file = json_decode($cek_data['url_data_dukung']);
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
        }
    }

    public function v_old($aksi = '', $tanggal = '', $tanggal2 = '')
    {
        $ceks = $this->session->userdata('username');
        $id_user = $this->session->userdata('id_user');
        $level = $this->session->userdata('level');
        $link1 = $this->uri->segment(1);
        $link2 = $this->uri->segment(2);
        $link3 = $this->uri->segment(3);
        $link4 = $this->uri->segment(4);
        $link5 = $this->uri->segment(5);
        $data['laporan_agenda_data'] = [];

        if (!isset($ceks)) {
            redirect('web/login');
        } else {
            $data['tgl_awal_sql'] = "kosong";
            $data['tgl_akhir_sql'] = "kosong";
            $data['id_divisi'] = "kosong";
            if ($aksi == 'f') {

                $data['filter_date_dari'] = $this->input->post('dari_tgl');
                $data['filter_date_sampai'] = $this->input->post('sampai_tgl');

                //ubah format tgl indo ke tgl sql
                $data['tgl_awal_sql'] = $this->Mcrud->tgl_sql($data['filter_date_dari']);
//                echo $data['tgl_awal_sql'];
                $data['tgl_akhir_sql'] = $this->Mcrud->tgl_sql($data['filter_date_sampai']);
                //nanti cek disini , value untuk id dan name divisi masih static di laporan_data.php (view)
                $data['id_divisi_selected'] = $this->input->post('id_divisi');
                $data['agenda_data'] = $this->Guzzle_model->getAgendaByRangeTanggal($data['tgl_awal_sql'], $data['tgl_akhir_sql']);
                $data['laporan_agenda_data'] = $this->Guzzle_model->getAgendaByRangeTanggal($data['tgl_awal_sql'], $data['tgl_akhir_sql']);


                //awal set tanggal sql
                if ($this->session->has_userdata("tgl_awal_sql")) {
                    $this->session->unset_userdata("tgl_awal_sql");
                }
                $this->session->set_userdata("tgl_awal_sql", $data['tgl_awal_sql']);

                if ($this->session->has_userdata("tgl_akhir_sql")) {
                    $this->session->unset_userdata("tgl_akhir_sql");
                }
                $this->session->set_userdata("tgl_akhir_sql", $data['tgl_akhir_sql']);
                //akhir set tanggal sql

                if ($this->session->has_userdata("tgl_awal_idn")) {
                    $this->session->unset_userdata("tgl_awal_idn");
                }
                $test = $this->Mcrud->tgl_idn($data['tgl_awal_sql'], 'full');
                $this->session->set_userdata("tgl_awal_idn", $test);

                if ($this->session->has_userdata("tgl_akhir_idn")) {
                    $this->session->unset_userdata("tgl_akhir_idn");
                }
                $test = $this->Mcrud->tgl_idn($data['tgl_akhir_sql'], 'full');
                $this->session->set_userdata("tgl_akhir_idn", $test);


                $firstTgl = strtotime($data['tgl_awal_sql']);
                $endTgl = strtotime($data['tgl_akhir_sql']);

                $jarakWaktu = abs($endTgl - $firstTgl);
                $numberDays = $jarakWaktu / 86400;
                $numberDays = intval($numberDays) + 1;
//                var_dump($numberDays);
                $data['laporan_status_agenda'] = [];

                for ($i = 0; $i < $numberDays; $i++) {
                    $getTgl = date('Y-m-d', strtotime("+" . $i . "day", strtotime($data['tgl_awal_sql'])));
                    //nanti lock agar bisa menentukan pekan ke sekian
                    array_push($data['laporan_status_agenda'], (object)[
                        'tanggal' => $getTgl,
                    ]);
//                    var_dump($getTgl);


//                    echo $this->Mcrud->weekOfMonth(strtotime($getTgl)) . " "; // 2
                }
                $p = "laporan_data";
                $this->load->view('header', $data);
                $this->load->view("laporan/$p", $data);
                $this->load->view('footer');
            } else if ($aksi == 'c') {

//                echo $this->weekOfMonth(strtotime("2022-07-31")) . " ";

                $firstTgl = strtotime($this->session->userdata("tgl_awal_sql"));
                $endTgl = strtotime($this->session->userdata("tgl_akhir_sql"));

                $jarakWaktu = abs($endTgl - $firstTgl);
                $numberDays = $jarakWaktu / 86400;
                $numberDays = intval($numberDays) + 1;
                $data['laporan_status_ruangan'] = [];

//                echo $numberDays;
                $data['a'] = array();
                $data['b'] = array();
                for ($i = 0; $i < $numberDays; $i++) {
                    $getTgl = date('Y-m-d', strtotime("+" . $i . "day", strtotime($this->session->userdata("tgl_awal_sql"))));
                    $bulan = date("Y-m", strtotime($getTgl));

//                    if(!array_key_exists($bulan,$data['a'])){
//                        array_push($data['a'], $bulan);
//                    }
                    array_push($data['a'], $bulan);
                }

                for ($i = 0; $i < count($data['a']); $i++) {
                    if (!in_array($data['a'][$i], $data['b'])) {
                        array_push($data['b'], $data['a'][$i]);
                    }
                }

                foreach ($data['b'] as $id => $dt) {
                    //berhasil disini
//                    echo $id."=>".$dt.",";
                }
//                echo $b;

                $this->session->userdata("tgl_akhir_sql");
                $data['dt_session_akhir'] = $this->session->userdata('tgl_akhir_sql');
                $data['laporan_agenda_data'] = $this->Guzzle_model->getAgendaByRangeTanggal($this->session->userdata("tgl_awal_sql"), $this->session->userdata("tgl_akhir_sql"));
                $data['test'] = "tes bro";


//                var_dump( $data['laporan_agenda_data'] );
//                $this->load->view('laporan/v_report',$data);
//                $this->load->view('laporan/test_view_pdf',$data);
                $this->load->view('laporan/test_view_new', $data);
            } else {
                $data['tgl_awal_sql'] = "kosong";
                $data['tgl_akhir_sql'] = "kosong";
                $data['id_divisi'] = "kosong";
                $p = 'laporan_data';
                $this->load->view('header', $data);
                $this->load->view("laporan/$p", $data);
                $this->load->view('footer');
            }

        }
    }

//    public function deleteFile(){
//        $ceks = $this->session->userdata('username');
//        if (!isset($ceks)) {
//            redirect('web/login');
//        }
//
//        try{
//            unset($this->input->path);
//            return "success";
//        } catch (Exception $e){
//            return $e;
//        }
//
//    }

}