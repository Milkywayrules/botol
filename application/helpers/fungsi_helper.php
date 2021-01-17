<?php

function cek_login()
{
    $ci = get_instance();
    if (!$ci->session->has_userdata('login_session')) {
        set_pesan('silahkan login.');
        redirect('auth');
    }
}

function is_admin()
{
    $ci = get_instance();
    $role = $ci->session->userdata('login_session')['role'];

    $status = true;

    if ($role != 'admin') {
        $status = false;
    }

    return $status;
}

function set_pesan($pesan, $tipe = true)
{
    $ci = get_instance();
    if ($tipe) {
        $ci->session->set_flashdata('pesan', "<div class='alert alert-success'><strong>SUCCESS!</strong> {$pesan} <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
    } else {
        $ci->session->set_flashdata('pesan', "<div class='alert alert-danger'><strong>ERROR!</strong> {$pesan} <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
    }
}

function userdata($field)
{
    $ci = get_instance();
    $ci->load->model('Admin_model', 'admin');

    $userId = $ci->session->userdata('login_session')['user'];
    return $ci->admin->get('user', ['id_user' => $userId])[$field];
}

function output_json($data)
{
    $ci = get_instance();
    $data = json_encode($data);
    $ci->output->set_content_type('application/json')->set_output($data);
}

// 

function pprint($input)
{
    echo "<pre>";
    print_r($input);
}

function pprintd($input)
{
    echo "<pre>";
    print_r($input);
    die;
}

function price_format($int = 0, $nbsp = TRUE, $echo = NULL)
{
    if ($nbsp == TRUE) $x = "Rp.".number_format($int, 0, '', '.');
    if ($nbsp == FALSE) $x = "Rp.".number_format($int, 0, '', '.');

    if ($echo != NULL) echo $x;
    if ($echo == NULL) return $x;
}

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
  }
  
function base64url_decode($data) {
return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

function getLastSegment()
{
    $ci     = get_instance();
    $last   = $ci->uri->total_segments();
    return $ci->uri->segment($last);
}