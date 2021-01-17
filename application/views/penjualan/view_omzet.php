<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Detail Penjualan - (<?= $date['tanggal'] ?>)
                </h4>
            </div>
            <a href="<?= base_url('penjualan') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                <span class="icon">
                    <i class="fa fa-arrow-left"></i>
                </span>
                <span class="text">
                    Kembali
                </span>
            </a>
            <div class="col-auto">
                <?= form_open('penjualan/pdf/omzet'); ?>
                    <button type="submit" class="btn btn-sm btn-danger btn-icon-split">
                        <span class="icon">
                            <i class="fa fa-file-pdf"></i>
                        </span>
                        <span class="text">
                            Export PDF
                        </span>
                    </button>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Total Omzet</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($master) :
                    foreach ($master as $row) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['fullname']; ?></td>
                            <td><?= price_format($row['total_omzet']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
