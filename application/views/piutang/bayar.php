<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Form Edit Piutang
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('piutang') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">
                                Kembali
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <?= form_open('', [], [ 
                        'id_barang_keluar' => $piutang['id_barang_keluar'], 
                        'paid_amount' => $piutang['paid_amount'], 
                        'left_to_paid' => $piutang['left_to_paid'] 
                    ]); ?>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="id_barang_keluar">No Transaksi</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input value="<?= set_value('id_barang_keluar', $piutang['id_barang_keluar']); ?>" name="id_barang_keluar" id="id_barang_keluar" type="text" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="tanggal_keluar">Tanggal Keluar</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input value="<?= set_value('tanggal_keluar', $piutang['tanggal_keluar']); ?>" name="tanggal_keluar" id="tanggal_keluar" type="text" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="nama">Nama User</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input value="<?= set_value('nama', $piutang['nama']); ?>" name="nama" id="nama" type="text" class="form-control" disabled>
                        </div>
                    </div>
                </div>

                <div class="border-bottom my-4 w-75 mx-auto"></div>
                
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="fullname">Nama Customer/Toko</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input value="<?= set_value('fullname', $piutang['fullname']); ?>" name="fullname" id="fullname" type="text" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="phone">No Telp Customer/Toko</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input value="<?= set_value('phone', $piutang['phone']); ?>" name="phone" id="phone" type="text" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="address">Alamat Customer/Toko</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input value="<?= set_value('address', $piutang['address']); ?>" name="address" id="address" type="text" class="form-control" disabled>
                        </div>
                    </div>
                </div>

                <div class="border-bottom my-4 w-75 mx-auto"></div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="nama_penerima">Nama Penerima</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input value="<?= set_value('nama_penerima', $piutang['nama_penerima']); ?>" name="nama_penerima" id="nama_penerima" type="text" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="alamat">Alamat Penerima</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input value="<?= set_value('alamat', $piutang['alamat']); ?>" name="alamat" id="alamat" type="text" class="form-control" disabled>
                        </div>
                    </div>
                </div>

                <div class="border-bottom my-4 w-75 mx-auto"></div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="grand_total">Grand Total</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input value="<?= set_value('grand_total', price_format($piutang['grand_total']), TRUE, TRUE); ?>" name="grand_total" id="grand_total" type="text" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="paid_amount">Jumlah Yang Sudah Dibayarkan</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input value="<?= set_value('paid_amount', price_format($piutang['paid_amount']), TRUE, TRUE); ?>" name="paid_amount" id="paid_amount" type="text" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="payment">Tipe Pembayaran Terakhir</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input value="<?= set_value('payment', $piutang['payment']); ?>" name="payment" id="payment" type="text" class="form-control" disabled>
                        </div>
                    </div>
                </div>

                <div class="border-bottom my-4 w-75 mx-auto"></div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="left_to_paid">Sisa Yang Harus Dibayar (Utang)</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input value="<?= set_value('left_to_paid', price_format($piutang['left_to_paid']), TRUE, TRUE); ?>" name="left_to_paid" id="left_to_paid" type="text" class="form-control" disabled>
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="paid_utang">Masukkan Nominal Pembayaran</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input value="<?= set_value('paid_utang'); ?>" name="paid_utang" id="paid_utang" type="tel" class="form-control" maxlength=12 required autofocus>
                        </div>
                        <?= form_error('paid_utang', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-9 offset-md-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-outline-danger">Reset</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>