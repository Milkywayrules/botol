<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
    }

    private function _hitungOmzetCustomer($dataOmzet)
    {
        // MULAI : reset kembali $container agar kosong untuk digunakan
        // proses di bawah sama seperti di atas, bedanya ini untuk total harga per item
        // pprintd($dataOmzet);
        $container = [];
        $custId = '';
        $temp['total_omzet'] = 0;
        $i = 0;
        foreach ($dataOmzet as $row) {
            // masuk ke sini pasti cuma iterasi pertama
            if ($custId == '') {
                $custId     = $row['cust_id'];
                $temp['id'] = $row['cust_id'];
                // set utang dari db, hanya dipake sekali dari seluruh iterasi
                $lastUtang = $row['total_utang'];
            }
            
            // sisanya masuk ke sini
            if ($custId == $row['cust_id']) {
                // perhitungan total omzet diambil dari grand total transaksi
                $temp['total_omzet'] = ($temp['total_omzet'] + $row['grand_total']) - $lastUtang;
                $temp['total_omzet_formatted'] = price_format($temp['total_omzet'], FALSE);
            } else {
                $i++;
                // reset total omzet jika ganti id customer
                $temp['total_omzet'] = 0;
                // reset lastUtang dengan yg terkait jika ganti id customer
                $lastUtang  = $row['total_utang'];
                // reset customer id
                $custId     = $row['cust_id'];
                $temp['id'] = $row['cust_id'];
                // perhitungan total omzet diambil dari grand total transaksi
                $temp['total_omzet'] = ($temp['total_omzet'] + $row['grand_total']) - $lastUtang;
                $temp['total_omzet_formatted'] = price_format($temp['total_omzet'], FALSE);
            }
            // set last utang jadi 0, karena setiap id customer hanya pake sekali
            $lastUtang = 0;
            $container[$i] = $temp;
        }
        // SELESAI : kembalikan dari $container ke variabel awal
        $dataOmzet = $container;
        // pprintd($dataOmzet);

        $whereIdCust = '';
        foreach ($dataOmzet as $row) {
            if ($whereIdCust!='') $whereIdCust .= ' OR ';
            $whereIdCust .= 'id='.$row['id'];
        }

        $dataCust = $this->admin->get('customer', null, $whereIdCust);

        // gabungin data omzet dan customer
        $container = [];
        $dataMerge = [];
        foreach ($dataOmzet as $row) {
            foreach ($dataCust as $row2) {
                // bandingkan 'id' dari $dataOmzet dengan $dataCust untuk dimodifikasi isinya
                if ($row['id'] == $row2['id']) {
                    // loop setiap array di dalam array $dataOmzet
                    foreach ($row as $key => $val) {
                        $dataMerge[$key] = $val;
                    }
                    // loop setiap array di dalam array $dataCust
                    foreach ($row2 as $key => $val) {
                        $dataMerge[$key] = $val;
                    }
                    // dua set array yg sudah diloop dan menjadi satu,
                    // dipindah ke dalam container agar terisolasi
                    // dari looping2 selanjutnya
                    $container[] = $dataMerge;
                    break;
                }
            }
        }
        // masukkin gabungan tadi ke variabel $dataMerge
        $dataMerge = $container;

        return $dataMerge;
    }

    public function index()
    {
        if ($this->input->post('menu') == 'omzet') {
            $this->form_validation->set_rules('tanggal', 'Periode Tanggal', 'required');
        } else {
            $this->form_validation->set_rules('tanggal-2', 'Periode Tanggal', 'required');
        }

        if ($this->form_validation->run() == false) 
        {
            $data['title'] = "Laporan Penjualan";
            $data['customer'] = $this->admin->get('customer');
            $this->template->load('templates/dashboard', 'penjualan/form', $data);
        } 
        else 
        {
            $input = $this->input->post(null, true);
            // pprintd($input);

            // jika ada customer yg dipilih
            if (isset($input['customer'])) {
                // jika ada customer yg dipilih, tapi opsi all juga dipilih
                if (isset($input['all'])) {
                    $listCust = null;
                // jika hanya customer yg dipilih
                } else {
                    $listCust = '';
                    foreach ($input['customer'] as $row) {
                        if ($listCust!='') $listCust .= ' OR ';
                        $listCust .= 'id_customer='.$row;
                    }
                }
            // jika customer gaada yg dipilih (atau bahkan gaada satupun yg dipilih)
            } else {
                $input['all'] = 'all';
                $listCust = null;
            }

            // pprintd($input);
            // pprintd($listCust);

            if ($input['menu'] == 'omzet') 
            {
                $tanggal = $input['tanggal'];
                $pecah   = explode(' - ', $tanggal);
                $mulai   = date('Y-m-d', strtotime($pecah[0]));
                $akhir   = date('Y-m-d', strtotime(end($pecah)));

                if (isset($input['all'])) {
                    $data['master'][0]['total_omzet'] = $this->admin->getOmzet(null, ['mulai'=>$mulai, 'akhir'=>$akhir], null, ['mode' => 'omzet']);
                    $data['master'][0]['fullname']    = '[ Data Keseluruhan ]';
                    // pprintd($data);

                    $data['date']['tanggal']    = $tanggal;
                    $data['date']['tgl_mulai']  = $mulai;
                    $data['date']['tgl_akhir']  = $akhir;

                    $data['master'][0]['total_omzet_formatted'] = price_format($data['master'][0]['total_omzet'], FALSE);
        
                    $data['title'] = "Laporan Omzet Penjualan - Keseluruhan";
                    $this->session->set_flashdata('cetak', $data);
                    $this->template->load('templates/dashboard', 'penjualan/view_omzet', $data);
                } else {
                    $dataOmzet = $this->admin->getOmzet($listCust, ['mulai' => $mulai, 'akhir' => $akhir]);
                    $dataMerge = $this->_hitungOmzetCustomer($dataOmzet);

                    $data['master']            = $dataMerge;
                    $data['date']['tanggal']   = $tanggal;
                    $data['date']['tgl_mulai'] = $mulai;
                    $data['date']['tgl_akhir'] = $akhir;
    
                    $data['title']     = "Laporan Omzet Penjualan - Per Customer";
                    $this->session->set_flashdata('cetak', $data);
                    $this->template->load('templates/dashboard', 'penjualan/view_omzet', $data);
                }
            } 
            else 
            {
                // per produk
                $tanggal = $input['tanggal-2'];
                $pecah   = explode(' - ', $tanggal);
                $mulai   = date('Y-m-d', strtotime($pecah[0]));
                $akhir   = date('Y-m-d', strtotime(end($pecah)));

                $data['master'] = $this->admin->getOmzet(null, ['mulai'=>$mulai, 'akhir'=>$akhir], null, ['mode' => 'perproduk']);
                $data['date']['tanggal']    = $tanggal;
                $data['date']['tgl_mulai']  = $mulai;
                $data['date']['tgl_akhir']  = $akhir;

                $container = [];
                foreach ($data['master'] as $row) {
                    $row['total_omzet_formatted'] = price_format($row['total_omzet'], FALSE);
                    $container[] = $row;
                }
                $data['master'] = $container;

    
                $data['title'] = "Laporan Omzet Penjualan - Per Produk";
                $this->session->set_flashdata('cetak', $data);
                $this->template->load('templates/dashboard', 'penjualan/view_perproduk', $data);
            }


        }
    }

    public function pdf($mode = 'omzet')
    {
        $data = $this->session->cetak;
        if ($data) {
            $data['mode'] = $mode;
            $this->session->keep_flashdata('cetak');
        } else {
            redirect(base_url('penjualan'));
        }
        // pprintd($data);
        $this->index();
        $this->_cetak($data);
    }
    
    private function _cetak($data)
    {
        if ($data['mode'] == 'omzet')
        {
            $this->load->library('CustomPDF');
            $pdf = new FPDF();
            $pdf->AddPage('P', 'A4');
            $pdf->SetFont('Times', 'B', 16);
            $pdf->Cell(190, 7, $data['title'], 0, 1, 'C');
            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(190, 4, 'Tanggal : ' . $data['date']['tanggal'], 0, 1, 'C');
            $pdf->Ln(10);

            $pdf->SetFont('Arial', 'B', 9);

            $pdf->Cell(15, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(80, 7, 'Nama', 1, 0, 'C');
            $pdf->Cell(60, 7, 'Total Omzet', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data['master'] as $row) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(15, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(80, 7, $row['fullname'], 1, 0, 'L');
                $pdf->Cell(60, 7, $row['total_omzet_formatted'], 1, 0, 'C');
                $pdf->Ln();
            }

            $file_name = $data['title'] . ' ' . $data['date']['tanggal'];
            // ob_end_clean(); 
            $pdf->Output('I', $file_name);
        }
        else
        {
            $this->load->library('CustomPDF');
            $pdf = new FPDF();
            $pdf->AddPage('P', 'A4');
            $pdf->SetFont('Times', 'B', 16);
            $pdf->Cell(190, 7, $data['title'], 0, 1, 'C');
            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(190, 4, 'Tanggal : ' . $data['date']['tanggal'], 0, 1, 'C');
            $pdf->Ln(10);

            $pdf->SetFont('Arial', 'B', 9);

            $pdf->Cell(7, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(25, 7, 'ID Barang', 1, 0, 'C');
            $pdf->Cell(75, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(35, 7, 'Jumlah Barang', 1, 0, 'C');
            $pdf->Cell(45, 7, 'Total Omzet', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data['master'] as $row) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(7, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(25, 7, $row['barang_id'], 1, 0, 'L');
                $pdf->Cell(75, 7, $row['nama_barang'], 1, 0, 'L');
                $pdf->Cell(35, 7, "{$row['total_qty']} {$row['nama_satuan']}", 1, 0, 'C');
                $pdf->Cell(45, 7, $row['total_omzet_formatted'], 1, 0, 'C');
                $pdf->Ln();
            }

            $file_name = $data['title'] . ' ' . $data['date']['tanggal'];
            // ob_end_clean(); 
            $pdf->Output('I', $file_name);
        }
    }
}
?>