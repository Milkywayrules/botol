<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Piutang extends CI_Controller
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
        $data['title'] = "Piutang";
        $data['piutang'] = $this->admin->getPiutang();
        // pprintd($data);
        $this->template->load('templates/dashboard', 'piutang/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('paid_utang', 'Nominal Pembayaran', 'required|trim');
    }


    public function bayar($getId)
    {
        $getId = base64_decode($getId);
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title']      = "Piutang";
            $data['piutang']    = $this->admin->getPiutang(['bk.id_barang_keluar' => $id]);
            $this->template->load('templates/dashboard', 'piutang/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $input['paid_utang'] = (int)str_replace(',', '', str_replace('.', '', $input['paid_utang']));

            // ada kembalian atau engga
            if ($input['paid_utang'] > $input['left_to_paid'])
            {
                // hitung kembalian
                $kembalian = $input['paid_utang'] - $input['left_to_paid'];
                // validasi untuk jumlah yg dibayarkan
                $input['paid_utang'] = $input['left_to_paid'];
            }
            // hitung sisa yg harus diabayar (hutang)
            $input['left_to_paid']  = $input['left_to_paid'] - $input['paid_utang'];
            $input['paid_amount']   = $input['paid_amount'] + $input['paid_utang'];

            // unset paid_amount karena gaakan dimasukin ke db, hanya untuk proses di controller ini
            unset($input['paid_utang']);

            // pprintd($kembalian);
            
            $update = $this->admin->update('barang_keluar', 'id_barang_keluar', $id, $input);

            if ($update) {
                if (isset($kembalian)) {
                    set_pesan('data berhasil disimpan. <br>TOTAL KEMBALIAN: Rp.' . number_format($kembalian, 0, ',', '.'));
                } else {
                    set_pesan('data berhasil disimpan.');
                }
                redirect('piutang');
            } else {
                set_pesan('data gagal diedit.');
                redirect('piutang/edit/' . $id);
            }
        }
    }
}
