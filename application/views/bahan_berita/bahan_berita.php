<?php
$link1 = strtolower($this->uri->segment(1));
$link2 = strtolower($this->uri->segment(2));
$link3 = strtolower($this->uri->segment(3));
$link4 = strtolower($this->uri->segment(4));

//$today = date('Y-m-d');
?>




<main class="main-content">

    <div id="mainContent" class="" >

        <form action="<?php echo $link1; ?>/v/f.html"
              class="col-lg-12 justify-content-center" method="post" >

            <div class="row justify-content-center p-15">
                <h2 class="m-0 font-weight-bold">Bahan Berita</h2>
                <div class="" style="height: 70px">

                </div>
<!--                --><?php //echo $link1; ?><!-- <br>-->
<!--                --><?php //echo $link2; ?><!-- <br>-->
<!--                --><?php //echo $link3; ?>
            </div>
            <div class="row text-end " >
                <div class="col-md-2 " >
                    <div style="height: 7px">

                    </div>
                    <label class="ml-5 fw-500 float-left " style="vertical-align: middle"
                           for="tanggal">Pilih Tanggal</label>
                </div>
                <div class="col-md-2">

                    <?php if($filter_date_dari==null){ ?>
                        <div class="timepicker-input input-icon form-group">
                            <div class="input-group">
                                <div
                                    class="icon-agenda bgc-white bd bdwR-0"
                                >
                                    <i class="ti-calendar"></i>
                                </div>
                                <!--disini ifnya-->
                                <input
                                    type="text"
                                    class="form-control border-grey start-date"
                                    data-provide="datepicker"

                                    value="<?php echo $tgl_now?>"
                                    data-date-format="d-M-yyyy"
                                    name="dari_tgl"
                                    id="dari_tgl"
                                    required
                                />
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="timepicker-input input-icon form-group">
                            <div class="input-group">
                                <div
                                    class="icon-agenda bgc-white bd bdwR-0"
                                >
                                    <i class="ti-calendar"></i>
                                </div>
                                <input
                                    type="text"
                                    class="form-control border-grey start-date"
                                    data-provide="datepicker"

                                    value="<?php echo $filter_date_dari;?>"
                                    data-date-format="d-M-yyyy"
                                    name="dari_tgl"
                                    id="dari_tgl"
                                    required
                                />
                            </div>
                        </div>
                    <?php } ?>

                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">
                        <span class="bg-float"></span>
                        <span class="text">Filter</span>
                    </button>
                </div>
                <div class="col-md-6 " style="">
<!--                    <button hidden type="submit" class="float-right btn btn-success">-->
<!--                        <span class="bg-float"></span>-->
<!--                        <span class="text">Tambah Bahan Berita</span>-->
<!--                    </button>-->

                    <button type="button"
                            class="float-right btn btn-success"
                            data-toggle="modal"
                            data-target="#add_bahan_berita">
                        <span class="bg-float"></span>
                        <span class="text">Tambah Bahan Berita</span>
                    </button>
                </div>
<!--                <div hidden class="col-md-2">-->
<!--                    <label class="fw-500 ml-5" for="tanggal">Tanggal Akhir</label>-->
<!--                    --><?php //if($filter_date_sampai==null){ ?>
<!--                        <div class="timepicker-input input-icon form-group">-->
<!--                            <div class="input-group">-->
<!--                                <div-->
<!--                                    class="icon-agenda bgc-white bd bdwR-0"-->
<!--                                >-->
<!--                                    <i class="ti-calendar"></i>-->
<!--                                </div>-->
<!--                                <input-->
<!--                                    type="text"-->
<!--                                    class="form-control border-grey start-date"-->
<!--                                    data-provide="datepicker"-->
<!---->
<!--                                    value="--><?php //echo $tgl_now?><!--"-->
<!--                                    data-date-format="d-M-yyyy"-->
<!--                                    name="sampai_tgl"-->
<!--                                    id="sampai_tgl"-->
<!--                                    required-->
<!--                                />-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    --><?php //} else { ?>
<!--                        <div class="timepicker-input input-icon form-group">-->
<!--                            <div class="input-group">-->
<!--                                <div-->
<!--                                    class="icon-agenda bgc-white bd bdwR-0"-->
<!--                                >-->
<!--                                    <i class="ti-calendar"></i>-->
<!--                                </div>-->
<!--                                <input-->
<!--                                    type="text"-->
<!--                                    class="form-control border-grey start-date"-->
<!--                                    data-provide="datepicker"-->
<!---->
<!--                                    value="--><?php //echo $filter_date_sampai; ?><!--"-->
<!--                                    data-date-format="d-M-yyyy"-->
<!--                                    name="sampai_tgl"-->
<!--                                    id="sampai_tgl"-->
<!--                                    required-->
<!--                                />-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    --><?php //} ?>
<!--                </div>-->

            </div>


<!--            <div hidden class="row justify-content-center">-->
<!--                <div class="mb-3 mr-3 ml-4">-->
<!--                    <button type="submit" class="btn btn-primary">-->
<!--                        <span class="bg-float"></span>-->
<!--                        <span class="text">Filterz</span>-->
<!--                    </button>-->
<!--                </div>-->
<!--            </div>-->
        </form>



        <!--taruh cuys disini-->


        <!--table beginning-->
        <div class="container-fluid">
<!--            <div class="row">-->
<!--                <div class="col-md-7">-->
<!--                    <h4 class="c-grey-900 mT-10">Data Pengguna</h4>-->
<!--                </div>-->
<!--                <div class="col-md-5 fc-rtl">-->
<!--                    <button type="button" class="btn cur-p btn-success mT-10 mB-10" data-toggle="modal" data-target="#add_pengguna"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Pengguna Baru</button>-->
<!--                </div>-->
<!--            </div>-->
            <div class="row">
                <!-- <div class="col-md-12">
                </div> -->
                <div class="col-md-12">
                    <!-- <div class="bgc-white bd bdrs-3 p-20 mB-20"> -->
                    <!-- <h4 class="c-grey-900 mB-20">Bootstrap Data Table</h4> -->
                    <hr>
                    <table
                        id="dataTable"
                        class="table table-striped table-bordered"
                        cellspacing="0"
                        width="100%">
                        <thead class="thead-dark">
                        <tr>
                            <th width="1%" style="text-align: center">No.</th>
<!--                            <th style="text-align: center">Divisi</th>-->
<!--                            <th style="text-align: center">Pekan</th>-->

                            <th style="text-align: center">Hari / Tgl </th>
<!--                            <th style="text-align: center">Jam</th>-->
                            <th style="text-align: center">Kegiatan</th>
                            <th style="text-align: center">Tempat</th>
                            <th width="15%" style="text-align: center" >Aksi</th>


<!--                            <th width="2%">No.</th>-->
<!--                            <th width="40%">Nama</th>-->
<!--                            <th width="22%">Username</th>-->
<!--                            <th width="18%">Level</th>-->
<!--                            <th width="18%">Aksi</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($agenda_data as $index=>$dt) { ?>
                            <tr>
                                <td style="text-align: center"><?php echo $index+1?></td>
<!--                                <td style="text-align: center">-</td>-->
<!--                                <td style="text-align: center">Pekan --><?php //echo $this->Mcrud->weekOfMonth(strtotime($dt['tanggal'])) . " ";?><!--</td>-->
                                <td style="text-align: center">
                                    <?php echo $this->Mcrud->hari_id($dt['tanggal']); ?> / <?php echo $this->Mcrud->tgl_id($dt['tanggal'], 'full'); ?>
                                </td>
<!--                                <td style="text-align: center">-->
<!--                                    --><?php //echo substr($dt['jam_mulai'],0,5) ."-". substr($dt['jam_selesai'],0,5) ; ?>
<!--                                </td>-->
                                <td style="text-align: center">
                                    <?php echo $dt['deskripsi']; ?>
                                </td>
                                <td style="text-align: center">
                                    <?php echo $dt['tempat']; ?>
                                </td>
<!--                                <td style="text-align: center">-->
<!--                                    --><?php //echo $dt['peserta']; ?>
<!--                                </td>-->

                                <td style="text-align: center">
                                    <div class="peers" >
                                        <div class="peer" style="text-align: center; margin-left: 22px">
                                            <a
                                                    href=""
                                                    class="td-n c-blue-500 cH-blue-500 fsz-md p-5"
                                                    data-toggle="modal"
                                                    data-target="#detail_bahan_berita<?php echo $dt['id']; ?>">
                                                <i class="ti-search"></i></a>
                                        </div>
                                        <div class="peer">
                                            <a
                                                    href=""
                                                    class="td-n c-deep-purple-500 cH-blue-500 fsz-md p-5"
                                                    data-toggle="modal"
                                                    data-target="#edit_bahan_berita<?php echo $dt['id']; ?>"
                                            ><i class="ti-pencil"></i
                                                ></a>
                                        </div>
                                        <div class="peer">
                                            <a
                                                    href=""
                                                    class="td-n c-red-500 cH-blue-500 fsz-md p-5"
                                                    data-toggle="modal"
                                                    data-target="#delete_bahan_berita<?php echo $dt['id']; ?>"
                                            ><i class="ti-trash"></i
                                                ></a>
                                        </div>
                                    </div>
                                </td>
<!--                                <td style="text-align: center">-->
<!--                                    --><?php //if($dt["url_data_dukung"]=="null") { ?>
<!--                                        <div>-</div>-->
<!--                                    --><?php //} else if($dt["url_data_dukung"]!="null") { ?>
<!--                                        <div>Ada Dokumen Data Dukung</div>-->
<!--                                    --><?php //} ?>
<!---->
<!--                                </td>-->
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                    <div style="text-align: center; font-weight: bold" hidden>
                        <a href="<?php echo $link1; ?>/<?php echo $link2; ?>/c.html"
                           class="" title="Download"
                           onclick="" target="_blank">
                            <i class="fa fa-print btn btn-danger" style="padding: 10px"> Download PDF </i>
                            <!--                            dibawah tombol cetak tes muncul id ruangan-->
                            <!--                            <h1>--><?php //echo $this->session->userdata("id_ruangan_selected"); ?><!--</h1>-->
                            <!--                            <h1>--><?php //echo $this->session->userdata("tgl_awal"); ?><!--</h1>-->
                            <!--                            <h1>--><?php //echo $this->session->userdata("tgl_akhir"); ?><!--</h1>-->
                            <!--                            <h1>--><?php //echo $this->session->userdata("tgl_awal_sql"); ?><!--</h1>-->
                            <!--                            <h1>--><?php //echo $this->session->userdata("tgl_akhir_sql"); ?><!--</h1>-->
                        </a>

                    </div>
                    <!-- </div> -->
                </div>
            </div>

            <!-- Add, Detail, Edit, Delete Pengguna  -->
            <?php
            // Add Pengguna
//            $this->load->view('datapengguna/add_pengguna');

            // Add Bahan Berita
            $this->load->view('bahan_berita/add_bahan_berita');

            // Detail Bahan Berita
            $this->load->view('bahan_berita/detail_bahan_berita');

            // Edit Bahan Berita
            $this->load->view('bahan_berita/edit_bahan_berita');

            // Delete Bahan Berita
            $this->load->view('bahan_berita/delete_bahan_berita');

            ?>
        </div>
        <!--table ending-->
    </div>
</main>
