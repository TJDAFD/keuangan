<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Masterdata extends REST_Controller{
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
    
    function penerbangs_get() {
        if(!$this->get('page')){
            $this->response(NULL, 400);
        }

        $search = array(
            'nama' => get_safe('nama'),
            'kode' => get_safe('kode'),
            'pangkat' => get_safe('pangkat'),
            'id' => $this->get('id')
        );

        $start = $this->start($this->get('page'));

        $data = $this->m_masterdata->get_list_penerbang($this->limit, $start, $search);
        $data['page'] = (int)$this->get('page');
        $data['limit'] = $this->limit;
        
        if ($data) {
            $this->response($data, 200); // 200 being the HTTP response code
        } else {
            $this->response(array('error' => 'Data tidak ditemukan'), 404);
        }
    }
    
    function penerbang_post() {
        $data = $this->m_masterdata->save_penerbang();
        $this->response($data, 200);
    }
    
    function penerbang_delete() {
        $this->db->delete('tb_penerbang', array('id' => $this->get('id')));
    }
    
    function jenis_latihans_get() {
        if (!$this->get('page')) {
            $this->response(NULL, 400);
        }

        $search = array(
            'nama' => get_safe('nama'),
            'kode' => get_safe('kode'),
            'pangkat' => get_safe('pangkat'),
            'id' => $this->get('id')
        );

        $start = $this->start($this->get('page'));

        $data = $this->m_masterdata->get_list_jenis_latihans($this->limit, $start, $search);
        $data['page'] = (int)$this->get('page');
        $data['limit'] = $this->limit;
        
        if ($data) {
            $this->response($data, 200); // 200 being the HTTP response code
        } else {
            $this->response(array('error' => 'Data tidak ditemukan'), 404);
        }
    }
    
    function jenis_latihan_post() {
        $data = $this->m_masterdata->save_jenis_latihan();
        $this->response($data, 200);
    }
    
    function jenis_latihan_delete() {
        $this->db->delete('tb_jenis_latihan', array('id' => $this->get('id')));
    }
    
    function kode_latihans_get() {
        if (!$this->get('page')) {
            $this->response(NULL, 400);
        }

        $search = array(
            'nama' => get_safe('nama'),
            'kode' => get_safe('kode'),
            'pangkat' => get_safe('pangkat'),
            'kegiatan' => get_safe('status'),
            'id' => $this->get('id')
        );

        $start = $this->start($this->get('page'));

        $data = $this->m_masterdata->get_list_kode_latihans($this->limit, $start, $search);
        $data['page'] = (int)$this->get('page');
        $data['limit'] = $this->limit;
        
        if ($data) {
            $this->response($data, 200); // 200 being the HTTP response code
        } else {
            $this->response(array('error' => 'Data tidak ditemukan'), 404);
        }
    }
    
    function kode_latihan_post() {
        $data = $this->m_masterdata->save_kode_latihan();
        $this->response($data, 200);
    }
    
    function kode_latihan_delete() {
        $this->db->delete('tb_kode_latihan', array('id' => $this->get('id')));
    }
    
    function bulan_rencana_terbangs_get() {
        if (!$this->get('page')) {
            $this->response(NULL, 400);
        }

        $search = array(
            'id' => $this->get('id')
        );

        $start = $this->start($this->get('page'));

        $data = $this->m_masterdata->get_list_bulan_rencana_terbang($this->limit, $start, $search);
        $data['page'] = (int)$this->get('page');
        $data['limit'] = $this->limit;
        
        if ($data) {
            $this->response($data, 200); // 200 being the HTTP response code
        } else {
            $this->response(array('error' => 'Data tidak ditemukan'), 404);
        }
    }
    
    function bulan_rencana_terbang_post() {
        $data = $this->m_masterdata->save_bulan_rencana_terbang();
        $this->response($data, 200);
    }
    
    function bulan_rencana_terbang_delete() {
        $this->db->delete('tb_rencana_jam_lat_ops', array('bulan' => $this->get('bulan')));
    }
    
    function pesawats_get() {
        if(!$this->get('page')){
            $this->response(NULL, 400);
        }

        $search = array(
            'nama' => get_safe('nama'),
            'kode' => get_safe('kode'),
            'id' => $this->get('id')
        );

        $start = $this->start($this->get('page'));

        $data = $this->m_masterdata->get_list_pesawat($this->limit, $start, $search);
        $data['page'] = (int)$this->get('page');
        $data['limit'] = $this->limit;
        
        if ($data) {
            $this->response($data, 200); // 200 being the HTTP response code
        } else {
            $this->response(array('error' => 'Data tidak ditemukan'), 404);
        }
    }
    
    function pesawat_post() {
        $data = $this->m_masterdata->save_pesawat();
        $this->response($data, 200);
    }
    
    function pesawat_delete() {
        $this->db->delete('tb_pesawat', array('id' => $this->get('id')));
    }
    
    function pangkats_get() {
        if(!$this->get('page')){
            $this->response(NULL, 400);
        }

        $search = array(
            'id' => $this->get('id')
        );

        $start = $this->start($this->get('page'));

        $data = $this->m_masterdata->get_list_pangkat($this->limit, $start, $search);
        $data['page'] = (int)$this->get('page');
        $data['limit'] = $this->limit;
        
        if ($data) {
            $this->response($data, 200); // 200 being the HTTP response code
        } else {
            $this->response(array('error' => 'Data tidak ditemukan'), 404);
        }
    }
    
    function pangkat_post() {
        $data = $this->m_masterdata->save_pangkat();
        $this->response($data, 200);
    }
    
    function pangkat_delete() {
        $this->db->delete('tb_pangkat', array('id' => $this->get('id')));
    }
    
    /*jabatan*/
    function jabatans_get() {
        if(!$this->get('page')){
            $this->response(NULL, 400);
        }

        $search = array(
            'id' => $this->get('id')
        );

        $start = $this->start($this->get('page'));

        $data = $this->m_masterdata->get_list_jabatan($this->limit, $start, $search);
        $data['page'] = (int)$this->get('page');
        $data['limit'] = $this->limit;
        
        if ($data) {
            $this->response($data, 200); // 200 being the HTTP response code
        } else {
            $this->response(array('error' => 'Data tidak ditemukan'), 404);
        }
    }
    
    function jabatan_post() {
        $data = $this->m_masterdata->save_jabatan();
        $this->response($data, 200);
    }
    
    function jabatan_delete() {
        $this->db->delete('tb_jabatan', array('id' => $this->get('id')));
    }
    
    function kualifikasis_get() {
        if (!$this->get('page')) {
            $this->response(NULL, 400);
        }

        $search = array(
            'nama' => get_safe('nama'),
            'kode' => get_safe('kode'),
            'id' => $this->get('id')
        );

        $start = $this->start($this->get('page'));

        $data = $this->m_masterdata->get_list_kualifikasis($this->limit, $start, $search);
        $data['page'] = (int)$this->get('page');
        $data['limit'] = $this->limit;
        
        if ($data) {
            $this->response($data, 200); // 200 being the HTTP response code
        } else {
            $this->response(array('error' => 'Data tidak ditemukan'), 404);
        }
    }
    
    function kualifikasi_post() {
        $data = $this->m_masterdata->save_kualifikasi();
        $this->response($data, 200);
    }
    
    function kualifikasi_delete() {
        $this->db->delete('tb_kualifikasi', array('id' => $this->get('id')));
    }
    
    function kemampuans_get() {
        if (!$this->get('page')) {
            $this->response(NULL, 400);
        }

        $search = array(
            'nama' => get_safe('nama'),
            'kode' => get_safe('kode'),
            'id' => $this->get('id')
        );

        $start = $this->start($this->get('page'));

        $data = $this->m_masterdata->get_list_kemampuans($this->limit, $start, $search);
        $data['page'] = (int)$this->get('page');
        $data['limit'] = $this->limit;
        
        if ($data) {
            $this->response($data, 200); // 200 being the HTTP response code
        } else {
            $this->response(array('error' => 'Data tidak ditemukan'), 404);
        }
    }
    
    function kemampuan_post() {
        $data = $this->m_masterdata->save_kemampuan();
        $this->response($data, 200);
    }
    
    function kemampuan_delete() {
        $this->db->delete('tb_kemampuan', array('id' => $this->get('id')));
    }
    
}