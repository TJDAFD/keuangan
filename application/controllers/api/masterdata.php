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
    
    function grant_privileges_post() {
        $add = array(
            'privileges' => post_safe('data'),
            'id_group' => post_safe('id_group')
        );
        $data = $this->m_masterdata->privileges_edit_data($add);
        $this->response($data, 200);
    }
    
    function user_account_post() {
        $param = array(
            'id' => post_safe('id_user_account'),
            'username' => post_safe('username'),
            'nama' => post_safe('nama'),
            'id_user_group' => post_safe('group'),
        );
        $data = $this->m_masterdata->save_data_user($param);
        $this->response($data, 200);
    }
    
    function user_account_delete() {
        $this->m_masterdata->user_delete_data($this->get('id'));
    }
    
}