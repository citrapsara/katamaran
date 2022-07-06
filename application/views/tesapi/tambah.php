<!-- Main content -->
<div class="content-wrapper">
  <!-- Content area -->
  <div class="content">

    <!-- Dashboard content -->
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title"><?php echo $judul_web; ?></h4>
            </div>
            <div class="panel-body">
                <?php
                echo $this->session->flashdata('msg');
                ?>
                <form class="form-horizontal" action="" data-parsley-validate="true" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label class="control-label col-lg-3">Nama</label>
                    <div class="col-lg-9">
                      <input type="text" name="nama" class="form-control" value="" placeholder="Nama" required autofocus onfocus="this.value = this.value;">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-3">Tanggal</label>
                    <div class="col-lg-9">
                      <div class="input-group">
                        <input type="date" name="tanggaljam" class="form-control daterange-single" value="" maxlength="10" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
              <div class="col-md-6">
                <label class="fw-500" for="tanggal">Tanggal</label>
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
                      placeholder="Pilih tanggal"
                      data-provide="datepicker"
                      data-date-format="d-M-yyyy"
                      name="tanggal"
                      id="tanggal"
                      required
                    />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <label class="fw-500" for="waktu">Jam</label>
                <div class="clockpicker input-icon form-group" data-autoclose="true">
                  <div class="input-group">
                    <div
                      class="icon-agenda bgc-white bd bdwR-0"
                    >
                      <i class="ti-time"></i>
                    </div>
                    <input
                      type="text"
                      class="form-control border-grey"
                      placeholder="Pilih jam"
                      name="jam"
                      id="jam"
                      required
                    />
                  </div>
                </div>
              </div>
            </div>
                  <hr>
                  
                  <button type="submit" name="btnsimpan" class="btn btn-primary" style="float:right;">Simpan</button>
                </form>
            </div>

        </div>
      </div>
    </div>
    <!-- /dashboard content -->

    <script type="text/javascript">
    $('.clockpicker').clockpicker();
    </script>
