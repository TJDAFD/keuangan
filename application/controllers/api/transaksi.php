<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Transaksi extends REST_Controller{
    function __construct(){
        parent::__construct();
        $this->limit = 15;

        $id_user = $this->session->userdata('id_user');
        if (empty($id_user)) {
            $this->response(array('error' => 'Anda belum login'), 401);
        }
    }

    private function start($page){
        return (($page - 1) * $this->limit);
    }
    
    function perwabkus_get() {
        
        if(!$this->get('page')){
            $this->response(NULL, 400);
        }
        $search = array(
            'id' => $this->get('id'),
            'awal' => date2mysql(get_safe('awal')),
            'akhir' => date2mysql(get_safe('akhir')),
            'nomorpwk' => get_safe('nomorpwk'),
            'nomorbkk' => get_safe('nomorbkk')
        );

        $start = $this->start($this->get('page'));
        $data = $this->m_transaksi->get_data_perwabku($this->limit, $start, $search);
        
        $data['page'] = (int)$this->get('page');
        $data['limit'] = $this->limit;
        
        if ($data) {
            $this->response($data, 200); // 200 being the HTTP response code
        } else {
            $this->response(array('error' => 'Data tidak ditemukan'), 404);
        }
    }
    
}