<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-red">
            <div class="panel-heading">
                <?php echo 'Daftar ' . $judul ?>&nbsp;&nbsp;
                <button class="btn btn-warning" data-toggle="modal" data-target="#tambah_surat_keluar">
                    <i class="fa fa-envelope"></i> Tambah <?php echo $judul ?>
                </button>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>Nomor Surat</th>
                        <th>Tanggal Kirim</th>
                        <th>Tujuan</th>
                        <th>Perihal</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($data_surat_keluar)) {
                        foreach ($data_surat_keluar as $surat_keluar) {
                            echo '
                            <tr>
                                <td class="text-center" style="vertical-align: middle;">' . $surat_keluar->nomor_surat . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $surat_keluar->tgl_kirim . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $surat_keluar->tujuan . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $surat_keluar->perihal . '</td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <a href="' . base_url('uploads/' . $surat_keluar->file_surat) . '" class="btn btn-info btn-sm">Lihat</a>
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#ubah_surat_keluar" onclick="ubah_surat(' . $surat_keluar->id_surat . ')">Ubah</button>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubah_file_surat_keluar" onclick="ubah_surat(' . $surat_keluar->id_surat . ')">Ubah Surat</button>
                                    <a href="' . base_url('home/hapus_surat_keluar/' . $surat_keluar->id_surat) . '" class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            </tr>
                            ';
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="modal fade" id="tambah_surat_keluar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" action="<?php echo base_url('home/tambah_surat_keluar') ?>" method="post"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Tambah <?php echo $judul ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nomor Surat</label>
                        <input class="form-control" type="text" name="nomor_surat" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Kirim</label>
                        <input class="form-control" type="date" name="tgl_kirim" required>
                    </div>
                    <div class="form-group">
                        <label>Tujuan</label>
                        <input class="form-control" type="text" name="tujuan" required>
                    </div>
                    <div class="form-group">
                        <label>Perihal</label>
                        <textarea class="form-control" rows="1" name="perihal" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>File Surat</label>
                        <input class="form-control" type="file" accept="application/pdf" name="file_surat" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Tutup</button>
                    <input type="submit" value="Tambah <?php echo $judul ?>" name="submit" class="btn btn-success">
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="ubah_surat_keluar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" action="<?php echo base_url('home/ubah_surat_keluar') ?>" method="post"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Ubah <?php echo $judul ?></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="ubah_id_surat" id="ubah_id_surat">
                    <div class="form-group">
                        <label>Nomor Surat</label>
                        <input class="form-control" type="text" name="ubah_nomor_surat" id="ubah_nomor_surat" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Kirim</label>
                        <input class="form-control" type="date" name="ubah_tgl_kirim" id="ubah_tgl_kirim" required>
                    </div>
                    <div class="form-group">
                        <label>Tujuan</label>
                        <input class="form-control" type="text" name="ubah_tujuan" id="ubah_tujuan" required>
                    </div>
                    <div class="form-group">
                        <label>Perihal</label>
                        <textarea class="form-control" rows="1" name="ubah_perihal" id="ubah_perihal"
                                  required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Tutup</button>
                    <input type="submit" value="Ubah <?php echo $judul ?>" name="submit" class="btn btn-success">
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="ubah_file_surat_keluar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" action="<?php echo base_url('home/ubah_file_surat_keluar') ?>" method="post"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Ubah File <?php echo $judul ?></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="ubah_file_surat" id="ubah_file_surat">
                    <div class="form-group">
                        <label>File Surat</label>
                        <input class="form-control" type="file" accept="application/pdf" name="ubah_file_surat"
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Tutup</button>
                    <input type="submit" value="Ubah File <?php echo $judul ?>" name="submit" class="btn btn-success">
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    function ubah_surat(id_surat) {
        $('#ubah_id_surat').empty();
        $('#ubah_nomor_surat').empty();
        $('#ubah_tgl_kirim').empty();
        $('#ubah_tujuan').empty();
        $('#ubah_perihal').empty();
        $('#ubah_file_surat').empty();

        $.getJSON('<?php echo base_url('home/get_surat_keluar_by_id/')?>' + id_surat, function (data) {
            $('#ubah_id_surat').val(data.id_surat);
            $('#ubah_nomor_surat').val(data.nomor_surat);
            $('#ubah_tgl_kirim').val(data.tgl_kirim);
            $('#ubah_tujuan').val(data.tujuan);
            $('#ubah_perihal').val(data.perihal);
            $('#ubah_file_surat').val(data.id_surat);
        })
    }
</script>