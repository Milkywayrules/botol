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
                <a href="<?= base_url('barangkeluar/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Input Piutang
                    </span>
                </a>
            </div> -->
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>No Transaksi</th>
                    <th>Tgl Keluar</th>
                    <th>Nama Cust/Toko</th>
                    <!-- <th>No. Telp</th> -->
                    <th>Tipe Bayar</th>
                    <th>Grand Total</th>
                    <th>Sisa Utang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($piutang) :
                    foreach ($piutang as $row) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['id_barang_keluar']; ?></td>
                            <td><?= $row['tanggal_keluar']; ?></td>
                            <td><?= $row['fullname']; ?></td>
                            <!-- <td><?= $row['phone']; ?></td> -->
                            <td><?= $row['payment']; ?></td>
                            <td><?= price_format($row['grand_total']) ?></td>
                            <td><?= price_format($row['left_to_paid']) ?></td>
                            <td>
                                <a href="<?= base_url('piutang/bayar/') . base64url_encode($row['id_barang_keluar']) ?>" class="btn btn-success btn-sm">Bayar</a>
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