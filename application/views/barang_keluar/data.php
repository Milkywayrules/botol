<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Riwayat Data Barang Keluar
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('barangkeluar/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Input Barang Keluar
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>No Transaksi</th>
                    <th>Tgl Keluar</th>
                    <!-- <th>Nama Barang</th> -->
                    <th>Nama Penerima</th>
                    <th>Alamat</th>
                    <!-- <th>Jumlah Keluar</th> -->
                    <th>User</th>
                    <th>Total Awal</th>
                    <th>Diskon</th>
                    <th>Total Akhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($barangkeluar) :
                    foreach ($barangkeluar as $bk) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $bk['id_barang_keluar']; ?></td>
                            <td><?= $bk['tanggal_keluar']; ?></td>
                            <!-- <td><?= $bk['nama_barang']; ?></td> -->
                            <td><?= $bk['nama_penerima']; ?></td>
                            <td><?= $bk['alamat']; ?></td>
                            <!-- <td><?= $bk['jumlah_keluar'] . ' ' . $bk['nama_satuan']; ?></td> -->
                            <td><?= $bk['nama_user']; ?></td>
                            <td><?= price_format($bk['total_nominal']) ?></td>
                            <td><?= price_format($bk['diskon']) ?></td>
                            <td><?= price_format($bk['grand_total']) ?></td>
                            <td>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('barangkeluar/delete/') . $bk['id_barang_keluar'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
                                <a onclick="return confirm('Cetak surat jalan?')" href="<?= base_url('barangkeluar/faktur_surat_jalan/') . $bk['id_barang_keluar'] ?>" class="btn btn-success btn-circle btn-sm"><i class="fa fa-car"></i></a>
                                <a onclick="return confirm('Cetak surat tagihan?')" href="<?= base_url('barangkeluar/faktur_surat_tagihan/') . $bk['id_barang_keluar'] ?>" class="btn btn-success btn-circle btn-sm"><i class="fa fa-book"></i></a>
                            </td>
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

<script language="javascript">
function pilihsemua()
{
    var id_barang_keluar = document.getElementsByName("id_barang_keluar[]");
    var jml=id_barang_keluar.length;
    var b=0;
    for (b=0;b<jml;b++)
    {
        id_barang_keluar[b].checked=true;
        
    }
     var checkboxes = document.getElementsByName("id_barang_keluar[]");
      var selected = [];
      for (var i = 0; i < checkboxes.length; ++i) {
        if(checkboxes[i].checked){
            selected.push(checkboxes[i].value);
        }
        }
      document.getElementById("get_id").value = selected.join();
}

function bersihkan()
{
    var id_barang_keluar = document.getElementsByName("id_barang_keluar[]");
    var jml=id_barang_keluar.length;
    var b=0;
    for (b=0;b<jml;b++)
    {
        id_barang_keluar[b].checked=false;
        
    }
    var checkboxes = document.getElementsByName("id_barang_keluar[]");
      var selected = [];
      for (var i = 0; i < checkboxes.length; ++i) {
        if(checkboxes[i].checked){
            selected.push(checkboxes[i].value);
        }
        }
      document.getElementById("get_id").value = selected.join();
}
</script>

<script type="text/javascript">
    $('button').on('click', function() {
  var checked = $('#dataTable').find(':checked').length;

  if (!checked){
    alert('Silahkan pilih checkbox terlebih dahulu!');
    return false;
  }else{
    return true;
    }
});
</script>

<script type="text/javascript">
    function checkCount(elm) {
      var checkboxes = document.getElementsByClassName("checkbox-btn");
      var selected = [];
      for (var i = 0; i < checkboxes.length; ++i) {
        if(checkboxes[i].checked){
            selected.push(checkboxes[i].value);
        }
        }
      document.getElementById("get_id").value = selected.join();
      // document.getElementById("total").innerHTML = selected.length;
    }
</script>