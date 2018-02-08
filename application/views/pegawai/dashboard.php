<div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-mail-forward fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $jumlah_disposisi['disposisi_keluar'] ?></div>
                        <div>Daftar Disposisi Keluar</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo base_url('home/disposisi_keluar') ?>">
                <div class="panel-footer">
                    <span class="pull-left">Daftar Disposisi Keluar</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-mail-reply fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $jumlah_disposisi['disposisi_masuk'] ?></div>
                        <div>Daftar Disposisi Masuk</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo base_url('home/disposisi_masuk') ?>">
                <div class="panel-footer">
                    <span class="pull-left">Daftar Disposisi Masuk</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- /.row -->