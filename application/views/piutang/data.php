<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Riwayat Data Piutang
                </h4>
            </div>
            <!-- <div class="col-auto">
                <a href="<?= base_url('customer/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Tambah Customer
                    </span>
                </a>
            </div> -->
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Cust/Toko</th>
                    <th>Alamat</th>
                    <th>No. Telp</th>
                    <th>Total Utang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($piutang) :
                    $no = 1;
                    foreach ($piutang as $row) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['fullname']; ?></td>
                            <td><?= $row['address']; ?></td>
                            <td><?= $row['phone']; ?></td>
                            <td class="<?= ($row['total_utang'] > 0) ? 'text-danger':'' ?>"><?= price_format($row['total_utang']); ?></td>
                            <td>
                                <a href="<?= base_url('piutang/bayar/') . base64url_encode($row['id']) ?>" class="btn btn-success btn-sm">Bayar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>