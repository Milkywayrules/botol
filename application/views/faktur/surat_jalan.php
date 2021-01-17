<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title; ?> | Aplikasi Pengadaan Barang</title>

  <!-- Custom fonts for this template-->
    <link href="<?= base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/fonts.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Datepicker -->
    <link href="<?= base_url(); ?>assets/vendor/daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="<?= base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/vendor/datatables/buttons/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/vendor/datatables/responsive/css/responsive.bootstrap4.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/vendor/gijgo/css/gijgo.min.css" rel="stylesheet">
</head>
<body class="text-sm">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <?php 
        $b=$data->row_array();
        ?>
    <!-- title row -->
    <div class="row">
      <div class="col-10">
        <h2 class="page-header">
          <i class="fas fa-car"></i> Surat Jalan
          <small class="float-right"><b>Invoice #<?php echo $b['id_barang_keluar'];?></b></small>
        </h2>
      </div>
      <!-- /.col -->
    </div><br/>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        <table align="left" style="border:none;">
            <tr>
                <th>Nomor </th>
                <th>: <?php echo $b['id_barang_keluar'];?></th>
            </tr>
            <tr>
                <th>Tanggal Keluar </th>
                <th>: <?php echo date('d F Y',strtotime($b['tanggal_keluar']));?></th>
            </tr>
            <tr>
                <th>Kepada Yth </th>
                <th>: <?php echo $b['nama_penerima'];?></th>
            </tr>
            <tr>
                <th>Dikirim Ke </th>
                <th>: <?php echo $b['nama_penerima'];?></th>
            </tr>
            <tr>
                <th></th>
                <th>&nbsp;&nbsp;<?php echo $b['alamat'];?></th>
            </tr>
        </table>
      </div>
      <!-- /.col -->
<!--       <div class="col-sm-6 invoice-col">
        <table align="left" style="border:none;">
            <tr>
                <th>Kepada Yth </th>
                <th>: <?php echo $b['nama_penerima'];?></th>
            </tr>
            <tr>
                <th>Dikirim Ke </th>
                <th>: <?php echo $b['nama_penerima'];?></th>
            </tr>
            <tr>
                <th></th>
                <th>&nbsp;<?php echo $b['alamat'];?></th>
            </tr>
        </table>
      </div> -->
    </div><br/><br/>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-11 table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th width="250px">Nama Barang</th>
                <th width="150px">Jenis Barang</th>
                <th width="150px">Satuan</th>
                <th width="150px">Jumlah Keluar</th>
                <!--<th>Total</th>-->
            </tr>
            </thead>
            <tbody>
                <?php 
                $no=0;
                $qtyw = 0;
                    foreach ($data->result_array() as $i) {
                        $barang=$i['nama_barang'];
                        $jenis=$i['nama_jenis'];
                        $satuan=$i['nama_satuan'];
                        $keluar=$i['jumlah_keluar'].' '.$i['nama_satuan'];
                        $total=$i['total_nominal_dtl'];
                ?>
            <tr>
                <td style="text-align:left;"><?php echo $barang;?></td>
                <td style="text-align:left;"><?php echo $jenis;?></td>
                <td style="text-align:left;"><?php echo $satuan;?></td>
                <td style="text-align:left;"><?php echo $keluar;?></td>
                <!--<td style="text-align:left;"><?php echo 'Rp '.number_format($total);?></td>-->
            </tr>
            <?php }?>
          </tbody>
         <!-- <thead>
            <tr>
                <th colspan="4">Grand Total</th>
                <th><?php echo 'Rp '.number_format($b['total_nominal']);?></th>
            </tr>
          </thead>
          <?php if ($b['diskon'] > 0) : ?>
          <thead>
            <tr>
                <th colspan="4">Grand Total Setelah Diskon</th>
                <th><?php echo 'Rp '.number_format($b['grand_total']);?> (<?php echo $b['diskon']?>% Discount)</th>
            </tr>
          </thead>-->
          <?php endif ?>
        </table><br/><br/>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <!-- <div class="col-6">
        <br/>
        ** Barang yang diterima sudah dilekatkan Pita Cukai.<br/>
        ** Dilarang menyimpan barang tanpa dilekatkan Pita Cukai.<br/>
        ** Pembayaran dengan cek giro dianggap sah setelah cair.<br/>
        ** SURAT JALAN DAN FAKTUR ASLI ADALAH BUKTI PENAGIHAN/PEMBAYARAN SAH.<br/>
        ** PENAGIHAN TANPA SURAT JALAN ASLI (ada tanda tangan toko) DAN FAKTUR ASLI TOKO TIDAK BOLEH BAYAR<br/>
      </div> -->
      <!-- /.col -->
      <br/><br/><br/><br/>
      <div class="col-6">

        <div class="table-responsive">
          <table border='0' align="center">
                <tr></br></br></br>
                    <td align="center" style="width:300px">Penerima</td>
                    <td align="center" style="width:300px">Supir</td>
                    <td align="center" style="width:300px">SF</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><br/><br/><br/><br/></td>
                    <td></td>
                    <td></td>
                </tr>    
                <tr>
                    <td align="center">(.........................................)</td>
                    <td align="center">(.........................................)</td>
                    <td align="center">(.........................................)</td>
                </tr>
            </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<style type="text/css">
  @media print{
  @page {
    size: auto;   /* auto is the initial value */
    size: A4 portrait;
    margin: 1;  /* this affects the margin in the printer settings */
    border: 1px solid red;  /* set a border for all printed pages */
  }
}
</style>
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>