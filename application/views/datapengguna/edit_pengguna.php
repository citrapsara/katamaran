<?php foreach ($user_list as $row):  ?>

  <div class="modal fade" id="edit_pengguna<?php echo $row['id']; ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="bd p-15"><h5 class="m-0">Ubah Data Pengguna</h5></div>
        <div class="modal-body">
          <form method="POST" action="datapengguna/v/e">
            <input type="hidden" value="<?php echo $row['id']; ?>" name="id_user" />
            <div class="form-group">
              <label class="fw-500" for="nama">Nama Pengguna</label>
              <input class="form-control border-grey" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required />
            </div>
            <div class="form-group">
              <label class="fw-500" for="tempat">Username</label>
              <input class="form-control border-grey" id="username" name="username" value="<?php echo $row['username']; ?>" required />
            </div>
            <div class="form-group">
              <label class="fw-500" for="password">Password</label>
              <input class="form-control border-grey" id="password" type="password" name="password" value="<?php echo $row['password']; ?>" required />
            </div>
            <div class="form-group">
              <label class="fw-500" for="konfirmasi password">Konfirmasi Password</label>
              <input class="form-control border-grey" id="password2" type="password" name="password2" value="<?php echo $row['password2']; ?>" required />
            </div>
            
              <div class="text-right">
              <button
                class="btn btn-secondary cur-p float-left"
                data-dismiss="modal"
                name=""
              >
                Kembali
              </button>
              <button
                class="btn btn-success cur-p"
                name=""
              >
                Simpan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>
    


<script type="text/javascript">
    $('.clockpicker').clockpicker();
</script>