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
        $id    = encode_php_tags($getId);
        $this->_validasi();
        // pprintd($id);

        if ($this->form_validation->run() == false) {
            $data['title']      = "Piutang";
            $data['piutang']    = $this->admin->getPiutang(['id' => $id]);
            $this->template->load('templates/dashboard', 'piutang/bayar', $data);
        } else {
            $input = $this->input->post(null, true);
            $input['paid_utang'] = (int)str_replace(',', '', str_replace('.', '', $input['paid_utang']));

            // ada kembalian atau engga
            if ($input['paid_utang'] > $input['total_utang'])
            {
                // hitung kembalian
                $kembalian = $input['paid_utang'] - $input['total_utang'];
                // validasi untuk jumlah yg dibayarkan
                $input['paid_utang'] = $input['total_utang'];
            }
            // hitung sisa yg harus diabayar (hutang)
            $input['total_utang']  = $input['total_utang'] - $input['paid_utang'];
            $input['last_utang_paid'] = unix_to_human(now(), true, 'europe');
            // $input['paid_amount']   = $input['paid_amount'] + $input['paid_utang'];

            // unset paid_amount karena gaakan dimasukin ke db, hanya untuk proses di controller ini
            unset($input['paid_utang']);

            // pprintd(price_format($kembalian));
            // pprintd($input);
            
            $update = $this->admin->update('customer', 'id', $id, $input);

            if ($update) {
                if (isset($kembalian)) {
                    set_pesan('data berhasil disimpan. <br>TOTAL KEMBALIAN: Rp.' . price_format($kembalian));
                } else {
                    set_pesan('data berhasil disimpan.');
                }
                redirect('piutang');
            } else {
                set_pesan('data gagal diedit.');
                redirect('piutang/bayar/' . $id);
            }
        }
    }
}
