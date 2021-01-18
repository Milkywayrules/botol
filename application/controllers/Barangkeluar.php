<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barangkeluar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = "Barang keluar";
        $data['barangkeluar'] = $this->admin->getBarangkeluar();
        $data['id_barang_keluar'] = "";
        // pprintd($data);
        $this->template->load('templates/dashboard', 'barang_keluar/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('id_customer', 'Nama Penerima', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('diskon', 'Diskon', "trim|less_than_equal_to[{$this->input->post('total_nominal')}]");
    }

    private function _validasi_cart()
    {   
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');

        $input = $this->input->post('barang_id', true);
        $stok = $this->admin->get('barang', ['id_barang' => $input])['stok'];
        $stok_valid = $stok + 1;
       
        $this->form_validation->set_rules(
            'jumlah_keluar',
            'Jumlah Keluar',
            "required|trim|numeric|greater_than[0]|less_than[{$stok_valid}]",
            [
                'less_than' => "Jumlah Keluar tidak boleh lebih dari {$stok}"
            ]
        );
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang Keluar";
            $data['barang'] = $this->admin->get('barang', null, ['stok >' => 0]);

            $data['data_customer'] = $this->admin->get('customer');

            // Mendapatkan dan men-generate kode transaksi barang keluar
            $kode = 'T-BK-' . date('ymd');
            $kode_terakhir = $this->admin->getMax('barang_keluar', 'id_barang_keluar', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['id_barang_keluar'] = $kode . $number;


            $this->template->load('templates/dashboard', 'barang_keluar/add', $data);
        } else {
            // $input = $this->input->post(null, true);
            $input = array(
                'id_barang_keluar'  => $this->input->post('id_barang_keluar'),
                'user_id'           => $this->input->post('user_id'),
                'id_customer'       => $this->input->post('id_customer'),
                'nama_penerima'     => $this->input->post('nama_penerima'),
                'alamat'            => $this->input->post('alamat'),
                'tanggal_keluar'    => $this->input->post('tanggal_keluar'),
                'total_nominal'     => $this->input->post('total_nominal'),
                'diskon'            => $this->input->post('diskon'),
                'payment'           => $this->input->post('payment'),
            );

            if ($this->input->post('grand_total')=="") 
            {
                $input['grand_total'] = $this->input->post('grand_total_hidden');
            } 
            else 
            {
                $input['grand_total'] = $this->input->post('grand_total');
            }

            $input['paid_amount'] = (int)str_replace(',', '', str_replace('.', '', $this->input->post('paid_amount')));

            if ( ($this->input->post('payment') == 'kontrabon') OR ($this->input->post('payment') == 'transfer') ) 
            {
                $input['paid_amount']   = 0;
                $input['left_to_paid']  = $input['grand_total'];
            } 
            else 
            {
                // ada kembalian atau engga
                if ($input['paid_amount'] > $input['grand_total'])
                {
                    // hitung kembalian
                    $kembalian     = $input['paid_amount'] - $input['grand_total'];
                    // validasi untuk jumlah yg dibayarkan
                    $input['paid_amount']   = $input['grand_total'];
                }
                // hitung sisa yg harus diabayar (hutang)
                $input['left_to_paid']  = $input['grand_total'] - $input['paid_amount'];
            }
            // pprintd($input);

            // ambil data utang si customer
            $totalUtang = $this->admin->get('customer', ['id' => $input['id_customer']])['total_utang'];
            // hitung sisa yg harus dibayar (hutang)
            $utang['total_utang'] = $totalUtang + $input['left_to_paid'];
            $utang['last_utang_paid'] = unix_to_human(now(), true, 'europe');

            // unset paid_amount karena gaakan dimasukin ke db, hanya untuk proses di controller ini
            unset($input['left_to_paid']);
            // pprint($input);
            // pprintd($utang);

            $this->db->trans_start();

            $insert  = $this->admin->insert('barang_keluar', $input);
            $insert2 = $this->admin->update('customer', 'id', $input['id_customer'], $utang);
            
            $id_barang_keluar = $this->input->post('id_barang_keluar');
            $this->admin->simpan_cart($id_barang_keluar);
            $this->cart->destroy();

            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE)
            {
                log_message('error', 'Data masukkan error pada controller Barangkeluar/add.');
                set_pesan('Opps ada kesalahan!');
                redirect('barangkeluar/add');
            } else {
                if (isset($kembalian)) {
                    set_pesan('data berhasil disimpan. <br>TOTAL KEMBALIAN: Rp.' . number_format($kembalian, 0, ',', '.'));
                } else {
                    set_pesan('data berhasil disimpan.');
                }
                redirect('barangkeluar');
            }
        }
    }

    public function add_to_cart(){
        $this->_validasi_cart();
        if ($this->form_validation->run() == false) {
        $data['title'] = "Barang Keluar";
        $data['barang'] = $this->admin->get('barang', null, ['stok >' => 0]);

        // Mendapatkan dan men-generate kode transaksi barang keluar
        $kode = 'T-BK-' . date('ymd');
        $kode_terakhir = $this->admin->getMax('barang_keluar', 'id_barang_keluar', $kode);
        $kode_tambah = substr($kode_terakhir, -5, 5);
        $kode_tambah++;
        $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
        $data['id_barang_keluar'] = $kode . $number;

        $this->template->load('templates/dashboard', 'barang_keluar/add', $data);
        } else {
        $barang_id=$this->input->post('barang_id');
        $barang=$this->admin->get_barang($barang_id);
        $i=$barang->row_array();
        $data = array(
           'id'       => $i['id_barang'],
           'name'     => $i['nama_barang'],
           'price'    => str_replace(",", "", $this->input->post('harga')),
           'qty'      => $this->input->post('jumlah_keluar'),
           'amount'   => str_replace(",", "", $this->input->post('harga'))
        );
        // var_dump($data);
        $this->cart->insert($data);
        redirect('barangkeluar/add');
        }
    }

    public function remove(){
        $row_id=$this->uri->segment(3);
        $this->cart->update(array(
               'rowid'      => $row_id,
               'qty'     => 0
            ));
        redirect('barangkeluar/add');
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        //Tambah stok jika hit hapus data
        if ($id) {
        $get = $this->admin->getIDBarangKeluar2($id)->result_array();
        foreach ($get as $i) {
        $data['stok'] = $i['jumlah_keluar'] + $i['stok'];
        $this->admin->update_stok($i['barang_id'], $data);
        // var_dump($data);
        }
        }

        if ($this->admin->delete('barang_keluar', 'id_barang_keluar', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('barangkeluar');
    }

    public function faktur_surat_jalan($id){
        $x['title'] = "Faktur Surat Jalan";
        $x['data'] = $this->admin->getIDBarangKeluar2($id);
        $this->load->view('faktur/surat_jalan', $x);
    }

    public function faktur_surat_tagihan($id){
        $x['title'] = "Faktur Surat Tagihan";
        $x['data'] = $this->admin->getIDBarangKeluar2($id);
        $this->load->view('faktur/surat_tagihan', $x);
    }

    public function surat_jalan($id){
        $x['title'] = "Faktur Surat Jalan";
        $x['data'] = $this->admin->getIDBarangKeluar($id);
        $this->load->view('faktur/surat_jalan', $x);
    }
}
