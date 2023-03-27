<div class="modal fade" id="add_bahan_berita">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="bd p-15"><h5 class="m-0">Tambah Bahan Berita</h5></div>
            <div class="modal-body">
<!--                <form method="POST" action="agenda/v/t" enctype="multipart/form-data">-->
                <form method="POST" action="bahan_berita/v/t" enctype="multipart/form-data">
                    <div class="form-group" for="what">
                        <label class="fw-500" style="font-weight: bold">What (Apa)</label>
                        <br>

                        <label class="fw-400">Apa nama kegiatan yang diselenggarakan di UPT.
                            Contoh: Pembinaan Rohani Warga Binaan di Lapas Mataram</label>
                        <textarea
                                class="form-control border-grey"
                                rows="5"
                                name="what"
                                id="what"
                                required
                        ></textarea>
                    </div>
                    <br>

                    <div class="form-group" for="where">
                        <label class="fw-500" style="font-weight: bold">Where (Di mana)</label>
                        <br>

                        <label class="fw-400">Di mana kegiatan tersebut diselenggarakan.
                            Contoh: Ruang Legal Drafter Kanwil Kemenkumham NTB
                        </label>
                        <textarea
                                class="form-control border-grey"
                                rows="5"
                                name="where"
                                id="where"
                                required
                        ></textarea>
                    </div>
                    <br>

                    <div class="form-group">

                        <label class="fw-500" style="font-weight: bold">When (Kapan)</label>
                        <br>

                        <label class="fw-400">Kapan kegiatan tersebut diselenggarakan.
                        </label>
<!--                        <label class="fw-500" for="tanggal">Tanggal</label>-->
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
                                        name="when"
                                        id="when"
                                        required
                                />
                            </div>
                        </div>
                    </div>
                    <br>
<!--                    <div class="form-group" for="when">-->
<!--                        <label class="fw-500" style="font-weight: bold">When (Kapan)</label>-->
<!--                        <br>-->
<!---->
<!--                        <label class="fw-400">Kapan kegiatan tersebut diselenggarakan.-->
<!--                            Contoh: Kegiatan monitoring dan evaluasi diselenggarakan di Aula Kantor Imigrasi Kelas III Non TPI Bima, Senin (14/2).-->
<!--                        </label>-->
<!--                        <textarea-->
<!--                                class="form-control border-grey"-->
<!--                                rows="5"-->
<!--                                name="when"-->
<!--                                id="when"-->
<!--                                required-->
<!--                        ></textarea>-->
<!--                    </div>-->

                    <div class="form-group" for="who">
                        <label class="fw-500" style="font-weight: bold">Who (Siapa)</label>
                        <br>

                        <label class="fw-400">Siapa tokoh/pejabat/tamu yang hadir pada kegiatan tersebut.
                            Contoh: Kepala Kantor Wilayah Kemenkumham NTB Romi Yudianto mengunjungi Kantor Imigrasi Kelas I TPI Mataram, Senin (13/2).
                        </label>
                        <textarea
                                class="form-control border-grey"
                                rows="5"
                                name="who"
                                id="who"
                                required
                        ></textarea>
                    </div>
                    <br>
                    <div class="form-group" for="why">
                        <label class="fw-500" style="font-weight: bold">Why (Mengapa)</label>
                        <br>

                        <label class="fw-400">Siapa tokoh/pejabat/tamu yang hadir pada kegiatan tersebut.
                            Contoh: Kepala Kantor Wilayah Kemenkumham NTB Romi Yudianto mengunjungi Kantor Imigrasi Kelas I TPI Mataram, Senin (13/2).
                        </label>
                        <textarea
                                class="form-control border-grey"
                                rows="5"
                                name="why"
                                id="why"
                                required
                        ></textarea>
                    </div>
                    <br>
                    <div class="form-group" for="how">
                        <label class="fw-500" style="font-weight: bold">How (Bagaimana)</label>
                        <br>

                        <label class="fw-400">Bagaimana acara tersebut berjalan dan pernyataan (statement) narasumber/pejabat.
                            Contoh: Romi Yudianto dalam sambutan meminta agar para pegawai meningkatkan displin dan terus meningkatkan kualitas pelayanan publik.
                        </label>
                        <textarea
                                class="form-control border-grey"
                                rows="5"
                                name="how"
                                id="how"
                                required
                        ></textarea>
                    </div>
                    <br>
<!--                    <div class="form-group">-->
<!--                        <label class="fw-500" for="nama">Nama Kegiatan</label>-->
<!--                        <input class="form-control border-grey" id="nama" name="nama" required />-->
<!--                    </div>-->
<!--                    <div class="form-group">-->
<!--                        <label class="fw-500" for="tanggal">Tanggal</label>-->
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
<!--                                    placeholder="Pilih tanggal"-->
<!--                                    data-provide="datepicker"-->
<!--                                    data-date-format="d-M-yyyy"-->
<!--                                    name="tanggal"-->
<!--                                    id="tanggal"-->
<!--                                    required-->
<!--                                />-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="row">-->
<!--                        <div class="col-md-6">-->
<!--                            <label class="fw-500" for="jam_mulai">Jam Mulai</label>-->
<!--                            <div class="clockpicker input-icon form-group" data-autoclose="true">-->
<!--                                <div class="input-group">-->
<!--                                    <div-->
<!--                                        class="icon-agenda bgc-white bd bdwR-0"-->
<!--                                    >-->
<!--                                        <i class="ti-time"></i>-->
<!--                                    </div>-->
<!--                                    <input-->
<!--                                        type="text"-->
<!--                                        class="form-control border-grey"-->
<!--                                        placeholder="Pilih jam"-->
<!--                                        name="jam_mulai"-->
<!--                                        id="jam_mulai"-->
<!--                                        required-->
<!--                                    />-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-md-6">-->
<!--                            <label class="fw-500" for="jam_selesai">Jam Selesai</label>-->
<!--                            <div class="clockpicker input-icon form-group" data-autoclose="true">-->
<!--                                <div class="input-group">-->
<!--                                    <div-->
<!--                                        class="icon-agenda bgc-white bd bdwR-0"-->
<!--                                    >-->
<!--                                        <i class="ti-time"></i>-->
<!--                                    </div>-->
<!--                                    <input-->
<!--                                        type="text"-->
<!--                                        class="form-control border-grey"-->
<!--                                        placeholder="Pilih jam"-->
<!--                                        name="jam_selesai"-->
<!--                                        id="jam_selesai"-->
<!--                                        required-->
<!--                                    />-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="form-group">-->
<!--                        <label class="fw-500" for="tempat">Tempat Kegiatan</label>-->
<!--                        <input class="form-control border-grey" id="tempat" name="tempat" required />-->
<!--                    </div>-->
<!--                    <div hidden class="form-group">-->
<!--                        <label class="fw-500" for="pakaian">Pakaian</label>-->
<!--                        <input class="form-control border-grey" id="pakaian" name="pakaian" required />-->
<!--                    </div>-->
<!--                    <div class="form-group">-->
<!--                        <label class="fw-500" for="peserta">Peserta Kegiatan</label>-->
<!--                        <input class="form-control border-grey" id="peserta" name="peserta" required />-->
<!--                    </div>-->
<!--                    <div class="form-group" for="deskripsi">-->
<!--                        <label class="fw-500">Deskripsi Kegiatan</label>-->
<!--                        <textarea-->
<!--                            class="form-control border-grey"-->
<!--                            rows="5"-->
<!--                            name="deskripsi"-->
<!--                            id="deskripsi"-->
<!--                            required-->
<!--                        ></textarea>-->
<!--                    </div>-->
                    <div class="form-group">
                        <label class="fw-500">Upload File SK / SP / Nodin / Undangan / Paparan / data pendukung lainnya</label>
                        <button class="btn btn-success mB-10" id="add-more" type="button">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Foto
                        </button>
                        <div id="auth-rows"></div>
                    </div>

                    <div class="text-right">
                        <button
                            class="btn btn-secondary cur-p float-left"
                            data-dismiss="modal"
                            name="">
                            Kembali
                        </button>
                        <button
                            class="btn btn-success cur-p"
                            name="">
                            Simpanz
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $('.clockpicker').clockpicker();

    $("#add-more").click(function(e){

        var html3 = '<div class="form-group input-dinamis"><div class="row"><div class="col-input-dinamis col-lg-10"><input type="file" name="url_files[]" class="form-control border-grey" id="peserta" placeholder="Upload file" required></div><div class="col-input-dinamis col-lg-2"><button class="btn btn-danger remove" type="button"><i class="fa fa-minus-circle"></i></button></div></div></div>';

        $('#auth-rows').append(html3);
    });

    $('#auth-rows').on('click', '.remove', function(e){
        e.preventDefault();
        $(this).parents('.input-dinamis').remove();
    });

</script>