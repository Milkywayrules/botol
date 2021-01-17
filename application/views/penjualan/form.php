<div class="row justify-content-center">
    <div class="col-lg-10">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="omzet-tab" data-toggle="tab" href="#omzet" role="tab" aria-controls="omzet" aria-selected="true">Menu Omzet</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="perproduk-tab" data-toggle="tab" href="#perproduk" role="tab" aria-controls="perproduk" aria-selected="false">Menu Per Produk</a>
            </li>
        </ul>
        
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="omzet" role="tabpanel" aria-labelledby="omzet-tab">

                <div class="card shadow-sm border-bottom-primary">
                    <div class="card-body">
                        <?= $this->session->flashdata('pesan'); ?>
                        <?= form_open('', '', ['menu' => 'omzet']); ?>
                        <div class="row form-group mx-5">
                            <label class="col-md-12 text-md-left font-weight-bold mb-0" for="penjualan">Pilih Mode</label>
                            <div class="col-md-12">
                                <div class="custom-control custom-checkbox">
                                    <input value="all" type="checkbox" id="all" name="all" class="custom-control-input" checked>
                                    <label class="custom-control-label" for="all">Tampilkan omzet keseluruhan? <small class="text-danger ml-2">Jika opsi ini dipilih, tidak usah memilih satu pun customer di bawah</small></label>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group mx-5">
                            <label class="col-md-12 text-md-left font-weight-bold mb-0" for="penjualan">Pilih Nama Customer</label>
                            <?php 
                            $i = 0;
                            foreach($customer as $row) : ?>
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input value="<?= $row['id'] ?>" type="checkbox" id="<?= $i ?>" name="customer[<?= $i ?>]" class="custom-control-input">
                                    <label class="custom-control-label" for="<?= $i ?>"><?= $row['fullname'] ?></label>
                                </div>
                            </div>
                            <?php $i++; endforeach; ?>
                        </div>
                        
                        <div class="row form-group mx-5 mt-4">
                            <label class="col-lg-12 text-lg-left font-weight-bold mb-0" for="tanggal">Pilih Rentang Tanggal</label>
                            <div class="col-lg-5">
                                <div class="input-group">
                                    <input value="<?= set_value('tanggal'); ?>" name="tanggal" id="tanggal" type="text" class="form-control" placeholder="Periode Tanggal">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-fw fa-calendar"></i></span>
                                    </div>
                                </div>
                                <?= form_error('tanggal', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="row form-group mx-5 mt-4">
                            <div class="col-lg-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <span class="text">
                                        Tampilkan
                                    </span>
                                </button>
                            </div>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="perproduk" role="tabpanel" aria-labelledby="perproduk-tab">

                <div class="card shadow-sm border-bottom-primary">
                    <div class="card-body">
                        <?= $this->session->flashdata('pesan'); ?>
                        <?= form_open('', '', ['menu' => 'perproduk']); ?>
                        
                        <div class="row form-group mx-5 mt-4">
                            <label class="col-lg-12 text-lg-left font-weight-bold mb-0" for="tanggal-2">Pilih Rentang Tanggal</label>
                            <div class="col-lg-5">
                                <div class="input-group">
                                    <input value="<?= set_value('tanggal-2'); ?>" name="tanggal-2" id="tanggal-2" type="text" class="form-control" placeholder="Periode Tanggal">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-fw fa-calendar"></i></span>
                                    </div>
                                </div>
                                <?= form_error('tanggal-2', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="row form-group mx-5 mt-4">
                            <div class="col-lg-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <span class="text">
                                        Tampilkan
                                    </span>
                                </button>
                            </div>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>

            </div>
        </div>
        
    </div>
</div>