<?php

class Configuration extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
    }
    
    function instansi() {
        $data['title'] = 'Konfigurasi Nama Instansi';
        $this->load->view('konfigurasi/instansi', $data);
    }
}