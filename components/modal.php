<!-- Modal Peserta Baru -->
<div class="modal fade" id="addPeserta" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="../database/controller.php" method="post" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold"> Peserta Baru</span>
                    </h5>
                    <button type="button closeModal" class="close" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="small">
                        Pastikan data yang anda masukkan benar
                    </p>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group form-group-default">
                                <label for="nama" class="form-label">Nama</label>
                                <input id="nama" name="nama" type="text" class="form-control" placeholder="isikan nama" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status" type="text" class="form-control" placeholder="isikan status" required>
                                    <option value="" disabled selected hidden>--pilih status rumah</option>
                                    <option value="Kost">Kost</option>
                                    <option value="Kontrak">Kontrak</option>
                                    <option value="Menumpang">Menumpang</option>
                                    <option value="Milik Sendiri">Milik Sendiri</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label for="luasBangunan" class="form-label">Luas Bangunan (meter persegi)</label>
                                <input id="luasBangunan" name="luasBangunan" type="number" class="form-control" placeholder="isikan luas bangunan">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label for="jenisLantai" class="form-label">Jenis Lantai</label>
                                <select id="jenisLantai" name="jenisLantai" type="text" class="form-control" placeholder="isikan jenis lantai" required>
                                    <option value="" disabled selected hidden>--pilih jenis lantai</option>
                                    <option value="Tanah">Tanah</option>
                                    <option value="Semen">Semen</option>
                                    <option value="Keramik">Keramik</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label for="jenisDinding" class="form-label">Jenis Dinding</label>
                                <select id="jenisDinding" name="jenisDinding" type="text" class="form-control" required>
                                    <option value="" disabled selected hidden>--pilih jenis dinding</option>
                                    <option value="Plesteran Anyaman Bambu">Plesteran Anyaman Bambu</option>
                                    <option value="Anyaman Bambu">Anyaman Bambu</option>
                                    <option value="Tembok">Tembok</option>
                                    <option value="Kayu">Kayu</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label for="tingkatPendidikan" class="form-label">Pendidikan</label>
                                <select id="tingkatPendidikan" name="tingkatPendidikan" type="text" class="form-control" required>
                                    <option value="" disabled selected hidden>--pilih pendidikan</option>
                                    <option value="Belum/Tidak/Sederajat">Belum/Tidak/Sederajat</option>
                                    <option value="SD/MI/Sederajat">SD/MI/Sederajat</option>
                                    <option value="SLTP/MTS/Sederajat">SLTP/MTS/Sederajat</option>
                                    <option value="SLTA/MA/Sederajat">SLTA/MA/Sederajat</option>
                                    <option value="Diploma/S1/S2/S3">Diploma/S1/S2/S3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <select id="pekerjaan" name="pekerjaan" type="text" class="form-control" required>
                                    <option value="" disabled selected hidden>--pilih pekerjaan</option>
                                    <option value="Tidak/Belum Bekerja">Tidak/Belum Bekerja</option>
                                    <option value="Usaha dengan buruh tetap/tidak tetap">Usaha dengan buruh tetap/tidak tetap</option>
                                    <option value="Usaha sendiri">Usaha sendiri</option>
                                    <option value="Petani">Petani</option>
                                    <option value="Buruh tidak tetap non pertanian">Buruh tidak tetap non pertanian</option>
                                    <option value="Buruh pertanian tidak tetap">Buruh pertanian tidak tetap</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label for="tanggungan" class="form-label">Tanggungan</label>
                                <input id="tanggungan" name="tanggungan" type="number" class="form-control" placeholder="isikan tanggungan" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <input type="hidden" name="action" value="addPeserta">
                    <button type="submit" class="btn btn-primary">
                        Tambah
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Peserta Baru-->

<!-- Modal Edit Peserta -->
<div class="modal fade" id="editPeserta<?php echo $id ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="../database/controller.php" method="post" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">Edit Peserta</span>
                    </h5>
                    <button type="button closeModal" class="close" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="small">
                        Pastikan data yang anda masukkan sesuai
                    </p>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group form-group-default">
                                <label for="nama" class="form-label">Nama</label>
                                <input id="nama" name="nama" type="text" class="form-control" value="<?php echo $nama; ?>" hidden><?php echo ucwords(str_replace('_', ' ', $nama)); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status" type="text" class="form-control" required>
                                    <option value="<?php echo $statusrumah; ?>" hidden><?php echo ucwords(str_replace('_', ' ', $statusrumah)); ?></option>
                                    <option value="Kost">Kost</option>
                                    <option value="Kontrak">Kontrak</option>
                                    <option value="Menumpang">Menumpang</option>
                                    <option value="Milik Sendiri">Milik Sendiri</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label for="luasBangunan" class="form-label">Luas Bangunan (meter persegi)</label>
                                <input id="luasBangunan" name="luasBangunan" type="number" class="form-control" value=<?php echo $luasbangunan; ?> placeholder=<?php echo $luasbangunan; ?> required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label for="jenisLantai" class="form-label">Jenis Lantai</label>
                                <select id="jenisLantai" name="jenisLantai" type="text" class="form-control">
                                    <option value="<?php echo $jenislantai; ?>" hidden><?php echo $jenislantai; ?></option>
                                    <option value="Tanah">Tanah</option>
                                    <option value="Semen">Semen</option>
                                    <option value="Keramik">Keramik</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label for="jenisDinding" class="form-label">Jenis Dinding</label>
                                <select id="jenisDinding" name="jenisDinding" type="text" class="form-control" required>
                                    <option value="<?php echo $jenisdinding; ?>" hidden><?php echo $jenisdinding; ?></option>
                                    <option value="Plesteran Anyaman Bambu">Plesteran Anyaman Bambu</option>
                                    <option value="Anyaman Bambu">Anyaman Bambu</option>
                                    <option value="Tembok">Tembok</option>
                                    <option value="Kayu">Kayu</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label for="tingkatPendidikan" class="form-label">Pendidikan</label>
                                <select id="tingkatPendidikan" name="tingkatPendidikan" type="text" class="form-control" required>
                                    <option value="<?php echo $pendidikan; ?>" hidden><?php echo $pendidikan; ?></option>
                                    <option value="Belum/Tidak/Sederajat">Belum/Tidak/Sederajat</option>
                                    <option value="SD/MI/Sederajat">SD/MI/Sederajat</option>
                                    <option value="SLTP/MTS/Sederajat">SLTP/MTS/Sederajat</option>
                                    <option value="SLTA/MA/Sederajat">SLTA/MA/Sederajat</option>
                                    <option value="Diploma/S1/S2/S3">Diploma/S1/S2/S3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <select id="pekerjaan" name="pekerjaan" type="text" class="form-control" required>
                                    <option value="<?php echo $pekerjaan; ?>" hidden><?php echo $pekerjaan; ?></option>
                                    <option value="Tidak/Belum Bekerja">Tidak/Belum Bekerja</option>
                                    <option value="Usaha dengan buruh tetap/tidak tetap">Usaha dengan buruh tetap/tidak tetap</option>
                                    <option value="Usaha sendiri">Usaha sendiri</option>
                                    <option value="Petani">Petani</option>
                                    <option value="Buruh tidak tetap non pertanian">Buruh tidak tetap non pertanian</option>
                                    <option value="Buruh pertanian tidak tetap">Buruh pertanian tidak tetap</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label for="tanggungan" class="form-label">Tanggungan</label>
                                <input id="tanggungan" name="tanggungan" type="number" class="form-control" placeholder="<?php echo $tanggungan; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <input type="hidden" name="action" value="editPeserta">
                    <button type="submit" class="btn btn-primary">
                        Edit
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Edit Peserta -->

<!-- ----------------------------------------------------- -->

<!-- Modal Add Kriteria -->
<div class="modal fade" id="addKriteria" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="../database/controller.php" method="post" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">Tambah Kriteria</span>
                    </h5>
                    <button type="button closeModal" class="close" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="small">
                        Pastikan data yang anda masukkan sesuai
                    </p>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group form-group-default">
                                <label for="namaKriteria" class="form-label">Nama Kriteria</label>
                                <input id="namaKriteria" name="namaKriteria" type="text" class="form-control" placeholder="isikan nama kriteria" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label for="nilai" class="form-label">Nilai</label>
                                <select id="nilai" name="nilai" type="number" class="form-control" required>
                                    <option value="" disabled selected hidden>--pilih nilai kriteria</option>
                                    <option value="1">Sama</option>
                                    <option value="3">Sedikit Lebih Penting</option>
                                    <option value="5">Cukup Penting</option>
                                    <option value="7">Sangat Penting</option>
                                    <option value="9">Mutlak Penting</option>
                                    <option value="2">Sama, namun Sedikit Lebih penting</option>
                                    <option value="4">Sedikit Lebih Penting, namun Cukup Penting</option>
                                    <option value="6">Cukup Penting, namun Sangat Penting</option>
                                    <option value="8">Sangat Penting, namun Mutlak Penting</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <input type="hidden" name="action" value="addKriteria">
                    <button type="submit" class="btn btn-primary">
                        Tambah
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Add Kriteria -->

<!-- Modal Edit Kriteria -->
<div class="modal fade" id="editKriteria<?php echo $id ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="../database/controller.php" method="post" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">Edit Kriteria</span>
                    </h5>
                    <button type="button closeModal" class="close" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="small">
                        Pastikan data yang anda masukkan sesuai
                    </p>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group form-group-default">
                                <label for="namaKriteria" class="form-label">Nama Kriteria</label>
                                <input id="namaKriteria" name="namaKriteria" type="text" class="form-control" value="<?php echo $nama; ?>" disabled selected hidden><?php echo ucwords(str_replace('_', ' ', $nama)); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label for="nilai" class="form-label">Nilai</label>
                                <select id="nilai" name="nilai" type="number" class="form-control" required>
                                    <option value="<?php echo $nilai; ?>" hidden><?php echo $nilai; ?></option>
                                    <option value="1">Sama</option>
                                    <option value="3">Sedikit Lebih Penting</option>
                                    <option value="5">Cukup Penting</option>
                                    <option value="7">Sangat Penting</option>
                                    <option value="9">Mutlak Penting</option>
                                    <option value="2">Sama, namun Sedikit Lebih penting</option>
                                    <option value="4">Sedikit Lebih Penting, namun Cukup Penting</option>
                                    <option value="6">Cukup Penting, namun Sangat Penting</option>
                                    <option value="8">Sangat Penting, namun Mutlak Penting</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <input type="hidden" name="action" value="editKriteria">
                    <button type="submit" class="btn btn-primary">
                        Edit
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Edit Kriteria -->

<!-- ------------------------------------------- -->

<!-- Modal Add SubKriteria -->
<div class="modal fade" id="addSubKriteria" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="../database/controller.php" method="post" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">Tambah SubKriteria</span>
                    </h5>
                    <button type="button closeModal" class="close" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="small">
                        Pastikan data yang anda masukkan sesuai
                    </p>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group form-group-default">
                                <label for="namaKriteria" class="form-label">Nama SubKriteria</label>
                                <input id="namaKriteria" name="namaKriteria" type="text" class="form-control" placeholder="isikan sub kriteria" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <input type="hidden" name="action" value="addSubKriteria">
                    <button type="submit" class="btn btn-primary">
                        Tambah
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Add Kriteria -->