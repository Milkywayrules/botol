<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Multiple Input Barang Keluar
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('barangkeluar') ?>" class="btn btn-sm btn-secondary btn-icon-split">
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
                <form action="<?php echo base_url('barangkeluar/add_to_cart'); ?>" method="post">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="barang_id">Barang</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <select name="barang_id" id="barang_id" class="custom-select">
                                <option value="" selected disabled>Pilih Barang</option>
                                <?php foreach ($barang as $b) : ?>
                                    <option value="<?= $b['id_barang'] ?>"><?= $b['id_barang'] . ' | ' . $b['nama_barang'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <a class="btn btn-primary" href="<?= base_url('barang/add'); ?>"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <?= form_error('barang_id', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="harga">Harga</label>
                    <div class="col-md-5">
                        <input readonly="readonly" id="harga" name="harga" type="number" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="stok">Stok</label>
                    <div class="col-md-5">
                        <input readonly="readonly" id="stok" name="stok" type="number" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="jumlah_keluar">Jumlah Keluar</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <input value="<?= set_value('jumlah_keluar'); ?>" name="jumlah_keluar" id="jumlah_keluar" type="number" class="form-control" placeholder="Jumlah Keluar...">
                            <div class="input-group-append">
                                <span class="input-group-text" id="satuan">Satuan</span>
                            </div>
                        </div>
                        <?= form_error('jumlah_keluar', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="total_stok">Total Stok</label>
                    <div class="col-md-5">
                        <input readonly="readonly" id="total_stok" type="number" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="total_nominal">Total Nominal</label>
                    <div class="col-md-5">
                        <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input readonly="readonly" name="total_nominal" id="total_nominal" type="number" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col offset-md-4">
                        <button type="submit" class="btn btn-info btn-sm btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-shopping-cart"></i>
                            </span>
                            <span class="text">
                                Simpan
                            </span>
                        </button>
                    </div>
                </div>
                <table class="table table-hover table-bordered" style="font-size:12px;margin-top:10px;">
                <thead>
                    <tr>
                        <th style="text-align:center;">Barang</th>
                        <th style="text-align:center;">Harga(Rp)</th>
                        <th style="text-align:center;">Jumlah Keluar</th>
                        <th style="text-align:center;">Sub Total</th>
                        <th style="width:100px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($this->cart->contents() as $items): ?>
                    <?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
                    <tr>
                         <td style="text-align:center;"><?=$items['id'];?> | <?=$items['name'];?></td>
                         <td style="text-align:center;"><?php echo number_format($items['amount']);?></td>
                         <td style="text-align:center;"><?php echo number_format($items['qty']);?></td>
                         <td style="text-align:center;"><?php echo number_format($items['subtotal']);?></td>
                        
                         <td style="text-align:center;"><a href="<?php echo base_url().'Barangkeluar/remove/'.$items['rowid'];?>" class="btn btn-danger btn-sm"><span class="fa fa-window-close text-warning"></span> Batal</a></td>
                    </tr>
                    
                    <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
                </table>
                </form>
            </div>

            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Form Input Barang Keluar
                        </h4>
                    </div>
                    <div class="col-auto">
                    </div>
                </div>
            </div>
            <div class="card-body">
            <!-- <?= form_open('', [], ['id_barang_keluar' => $id_barang_keluar, 'user_id' => $this->session->userdata('login_session')['user']]); ?> -->
            <form action="<?php echo base_url('barangkeluar/add'); ?>" method="post">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" name="id_barang_keluar" value="<?php echo $id_barang_keluar; ?>">
            <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('login_session')['user']; ?>">
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="id_barang_keluar">ID Transaksi Barang Keluar</label>
                    <div class="col-md-4">
                        <input value="<?= $id_barang_keluar; ?>" type="text" readonly="readonly" class="form-control">
                        <?= form_error('id_barang_keluar', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="tanggal_keluar">Tanggal Keluar</label>
                    <div class="col-md-4">
                        <input value="<?= set_value('tanggal_keluar', date('Y-m-d')); ?>" name="tanggal_keluar" id="tanggal_keluar" type="text" class="form-control date" placeholder="Tanggal Keluar...">
                        <?= form_error('tanggal_keluar', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="id_customer">Nama Customer / Toko</label>
                    <div class="col-md-5">
                        <select class="form-control" id="id_customer" name="id_customer" onchange='changeValue(this.value)' required>
                            <option selected disabled>-Pilih Pelanggan-</option>
                            <?php
                            $jsArray = "var prdName = new Array();\n";
                            foreach ($data_customer as $row) : ?>
                                <option name="id_customer" value="<?= $row['id']; ?>"><?= "{$row['fullname']} - {$row['phone']}"; ?></option>
                                <?php
                                $jsArray .= "prdName['" . $row['id'] . "'] = {alamat_pelanggan:'" . addslashes($row['address']) . "',phone:'" . addslashes($row['phone']) . "',nama_penerima:'" . addslashes($row['fullname']) . "'};\n";
                                ?>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="nama_penerima">Nama Penerima</label>
                    <div class="col-md-5">
                        <input id="nama_penerima" name="nama_penerima" type="text" class="form-control" onchange='changeValue(this.value)' required>
                        <?= form_error('nama_penerima', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="alamat">Alamat Penerima</label>
                    <div class="col-md-5">
                        <input id="alamat" name="alamat" type="text" class="form-control" required>
                        <?= form_error('alamat', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <script>
                    <?php echo $jsArray; ?>
                    function changeValue(id) {
                        var sel = document.getElementById('id_customer');
                        document.getElementById('nama_penerima').value = prdName[id].nama_penerima;
                        document.getElementById('alamat').value = prdName[id].alamat_pelanggan;
                    };
                </script>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="diskon">Diskon</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input name="diskon" id="diskon" type="number" class="form-control" min="1" max="999999999" maxlength="9" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            <?= form_error('diskon', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="total_nominal">Total</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input readonly="readonly" name="total_nominal" id="total_nominal_cart" value="<?php echo $this->cart->total();?>" type="number" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="grand_total">Total Setelah Diskon</label>
                    <div class="col-md-5">
                        <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input readonly="readonly" name="grand_total" id="grand_total" placeholder="<?php echo $this->cart->total();?>" type="number" class="form-control">
                        <input name="grand_total_hidden" value="<?php echo $this->cart->total();?>" type="hidden" class="form-control">
                        </div>
                    </div>

                </div>
                 
                <div class="row form-group">
                    <div class="col offset-md-4">
                        <button type="button" class="btn btn-primary px-5 open-modal-kasir" data-toggle="modal" data-target="#modal"> Konfirmasi </button>
                        <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h3 class="modal-title font-weight-bold h4" id="exampleModalLongTitle">Konfirmasi Checkout</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body" id="modal-body">
                                <div class="form-group">
                                    <!-- <label class="form-label font-weight-normal h5" id="total_bayars"><p> Total Belanjaan adalah: <input readonly="readonly" name="modal_total_bayar" id="modal_total_bayar" placeholder="<?php echo number_format($this->cart->total(), 0, ',', '.') ?>" type="number" class="form-control"> </p></label> -->
                                    <label class="form-label font-weight-normal h5" id="total_bayars">
                                        <p> Total Belanjaan adalah: <?= number_format($this->cart->total(), 0, ',', '.') ?> </p>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Jenis pembayaran</label>
                                    <div class="form-check mx-auto">
                                        <label class="form-check-label font-weight-normal">
                                            <input class="form-check form-check-inline" type="radio" name="payment" id="kontrabon" value="kontrabon" checked>
                                            Kontrabon
                                        </label>

                                        <label class="form-check-label font-weight-normal mx-5">
                                            <input class="form-check form-check-inline" type="radio" name="payment" id="transfer" value="transfer">
                                            Transfer
                                        </label>

                                        <label class="form-check-label font-weight-normal">
                                            <input class="form-check form-check-inline" type="radio" name="payment" id="cash" value="cash">
                                            Cash
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group payment_cash" style="display:none;">
                                    <label class="form-label">Yang Dibayarkan</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input required autofocus type="tel" name="paid_amount" id="paid_amount" class="form-control" aria-label="Pembayaran" maxlength=12 value=0>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-danger px-5" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary px-5">Checkout</button>
                            </div>

                        </div>
                    </div>
                </div>

                </form>
                <!-- <?= form_close(); ?> -->
            </div>

        </div>
    </div>
</div>



<!-- Menghilangkan panah di form type number -->
<style type="text/css">
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }
    /* Firefox */
    input[type=number] {
    -moz-appearance: textfield;
    }
</style>