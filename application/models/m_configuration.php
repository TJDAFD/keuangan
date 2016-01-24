<?php

class M_configuration extends CI_Model {
    
    function get_data_instansi() {
        $sql = "select count(*) as jumlah, id, nama, alamat,telp, fax, kabikeu, kaakuntansi from instansi";
        return $this->db->query($sql)->row();
    }
    
    function save_instansi($data) {
        if ($data['id'] === '') {
            $this->db->insert('instansi', $data);
            $result['act'] = 'add';
        } else {
            $this->db->where('id', $data['id']);
            $this->db->update('instansi', $data);
            $result['act'] = 'edit';
        }
        
        return $result;
    }
    
}