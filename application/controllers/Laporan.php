<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('pdf_report');
        $this->load->library('session');
//        $this->load->model('Guzzle_model');
        $this->load->helper('security');

    }
    public function index()
    {
        $ceks = $this->session->userdata('username');
        $id_user = $this->session->userdata('id_user');
//        redirect('laporan/v');
        if(!isset($ceks)){
            redirect('web/login');
        } else {
            $data['judul_web'] = "Laporan";
            date_default_timezone_set('Asia/Singapore');
            $p = "laporan_data";
            $data['tgl_awal_sql']="kosong";
            $data['tgl_akhir_sql']="kosong";
            $data['id_divisi_selected']="kosong";
            $hari_ini = date("Y-m-d");
            $data["tgl_now"] = $this->Mcrud->tgl_id_new($hari_ini, 'full');
            $data['agenda_data'] = $this->Guzzle_model->getAgendaByRangeTanggal($hari_ini, $hari_ini);
            $this->load->view('header', $data);
            $this->load->view("laporan/$p", $data);
            $this->load->view('footer');
        }
    }



    public function v($aksi='',$tanggal='',$tanggal2=''){
        $ceks 	 = $this->session->userdata('username');
        $id_user = $this->session->userdata('id_user');
        $level 	 = $this->session->userdata('level');
        $link1 = $this->uri->segment(1);
        $link2 = $this->uri->segment(2);
        $link3 = $this->uri->segment(3);
        $link4 = $this->uri->segment(4);
        $link5 = $this->uri->segment(5);
        $data['laporan_agenda_data'] =[];

        if(!isset($ceks)) {
            redirect('web/login');
        } else {
            $data['tgl_awal_sql']="kosong";
            $data['tgl_akhir_sql']="kosong";
            $data['id_divisi']="kosong";
            if($aksi == 'f'){

                $data['filter_date_dari'] = $this->input->post('dari_tgl');
                $data['filter_date_sampai'] = $this->input->post('sampai_tgl');

                //ubah format tgl indo ke tgl sql
                $data['tgl_awal_sql']=$this->Mcrud->tgl_sql($data['filter_date_dari']);
//                echo $data['tgl_awal_sql'];
                $data['tgl_akhir_sql']=$this->Mcrud->tgl_sql($data['filter_date_sampai']);
                //nanti cek disini , value untuk id dan name divisi masih static di laporan_data.php (view)
                $data['id_divisi_selected']=$this->input->post('id_divisi');
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
                $numberDays = intval($numberDays)+1;
//                var_dump($numberDays);
                $data['laporan_status_agenda'] = [];

                for($i=0; $i<$numberDays; $i++){
                    $getTgl = date('Y-m-d',strtotime("+" . $i . "day",strtotime($data['tgl_awal_sql'])));
                    //nanti lock agar bisa menentukan pekan ke sekian
                    array_push($data['laporan_status_agenda'],(object)[
                        'tanggal'=>$getTgl,
                    ]);
//                    var_dump($getTgl);


//                    echo $this->Mcrud->weekOfMonth(strtotime($getTgl)) . " "; // 2
                }
                $p = "laporan_data";
                $this->load->view('header',$data);
                $this->load->view("laporan/$p",$data    );
                $this->load->view('footer');
            } else if($aksi == 'c'){

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
                for($i=0; $i<$numberDays; $i++){
                    $getTgl = date('Y-m-d',strtotime("+" . $i . "day",strtotime($this->session->userdata("tgl_awal_sql"))));
                    $bulan = date("Y-m",strtotime($getTgl));

//                    if(!array_key_exists($bulan,$data['a'])){
//                        array_push($data['a'], $bulan);
//                    }
                    array_push($data['a'], $bulan);
                }

                for($i=0; $i<count($data['a']); $i++){
                    if(!in_array($data['a'][$i],$data['b'])){
                        array_push($data['b'],$data['a'][$i]);
                    }
                }

                foreach ($data['b'] as $id=>$dt){
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
                $this->load->view('laporan/test_view_new',$data);
            }else {
                $data['tgl_awal_sql']="kosong";
                $data['tgl_akhir_sql']="kosong";
                $data['id_divisi']="kosong";
                $p = 'laporan_data';
                $this->load->view('header',$data);
                $this->load->view("laporan/$p",$data);
                $this->load->view('footer');
            }

        }
    }





}