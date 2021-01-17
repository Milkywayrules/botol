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
        $container = [];
        $custId = '';
        $temp['total'] = 0;
        $i = 0;
        foreach ($dataOmzet as $row) {
            if ($custId == '') {
                $custId = $row['cust_id'];
                $temp['id']    = $row['cust_id'];
            }
            
            if ($custId == $row['cust_id']) {
                $temp['total'] = $temp['total'] + $row['paid_amount'];
            } else {
                $i++;
                $custId = $row['cust_id'];
                $temp['id']    = $row['cust_id'];
                $temp['total'] = $temp['total'] + $row['paid_amount'];
            }
            $container[$i] = $temp;
        }
        // SELESAI : kembalikan dari $container ke variabel awal
        $dataOmzet = $container;

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
        $this->form_validation->set_rules('tanggal', 'Periode Tanggal', 'required');

        if ($this->form_validation->run() == false) 
        {
            $data['title'] = "Laporan Penjualan";
            $data['customer'] = $this->admin->get('customer');
            $this->template->load('templates/dashboard', 'penjualan/form', $data);
        } 
        else 
        {
            $input = $this->input->post(null, true);
            pprintd($input);

            if (isset($input['customer'])) {
                if (isset($input['all'])) {
                    $listCust = null;
                } else {
                    $listCust = '';
                    foreach ($input['customer'] as $row) {
                        if ($listCust!='') $listCust .= ' OR ';
                        $listCust .= 'id_customer='.$row;
                    }
                }
            } else {
                $listCust = null;
            }

            // pprintd($listCust);

            $tanggal = $input['tanggal'];
            $pecah   = explode(' - ', $tanggal);
            $mulai   = date('Y-m-d', strtotime($pecah[0]));
            $akhir   = date('Y-m-d', strtotime(end($pecah)));

            $dataOmzet = $this->admin->getOmzet($listCust, ['mulai' => $mulai, 'akhir' => $akhir]);

            $dataMerge = $this->_hitungOmzetCustomer($dataOmzet);


            pprintd($dataMerge);

            $data['title']     = "Detail";
            $data['penjualan'] = $dataOmzet;
            // $data['customer'] = $this->admin->get('customer');
            $this->template->load('templates/dashboard', 'penjualan/view', $data);
        }
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_penjualan', 'Nama Penjualan', 'required|trim');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Penjualan";
            $this->template->load('templates/dashboard', 'penjualan/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $save = $this->admin->insert('penjualan', $input);
            if ($save) {
                set_pesan('data berhasil disimpan.');
                redirect('penjualan');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('penjualan/add');
            }
        }
    }


    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Penjualan";
            $data['penjualan'] = $this->admin->get('penjualan', ['id_penjualan' => $id]);
            $this->template->load('templates/dashboard', 'penjualan/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->admin->update('penjualan', 'id_penjualan', $id, $input);

            if ($update) {
                set_pesan('data berhasil diedit.');
                redirect('penjualan');
            } else {
                set_pesan('data gagal diedit.');
                redirect('penjualan/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('penjualan', 'id_penjualan', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('penjualan');
    }
}
