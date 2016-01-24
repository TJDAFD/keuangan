<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Configuration extends REST_Controller{
    function __construct(){
        parent::__construct();
        $this->limit = 15;
        $this->load->model(array('m_configuration'));
        $id_user = $this->session->userdata('id_user');
        if (empty($id_user)) {
            $this->response(array('error' => 'Anda belum login'), 401);
        }
    }
    
    function instansi_get() {
        $data = $this->m_configuration->get_data_instansi();
        $this->response($data, 200);
    }
    
    function instansi_post() {
        $param = array(
            'id' => post_safe('id'),
            'nama' => post_safe('nama_instansi'),
            'alamat' => post_safe('alamat'),
            'telp' => post_safe('telp'),
            'fax' => post_safe('fax'),
            'kabikeu' => post_safe('kabikeu'),
            'kaakuntansi' => post_safe('kaakuntansi')
        );
        $data = $this->m_configuration->save_instansi($param);
        $this->response($data, 200);
    }
    
}