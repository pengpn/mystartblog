<?php
/**
 * Created by PhpStorm.
 * User: pnpeng
 * Date: 2016/12/16
 * Time: 11:32
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Others extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Siteinfo_model');

    }

    public function show_siteinfo(){
        $data['data'] = $this->Siteinfo_model->getSiteInfo();

        $data['cur_title'] = array('','active','','','','','');
        $this->load->view('admin/header',$data);
        $this->load->view('admin/menu',$data);
        $this->load->view('admin/others_setinfo',$data);
        $this->load->view('admin/footer');
    }

    public function set_siteinfo(){
        if($_POST['title'] != ''){
            $site_info = $this->Siteinfo_model->updateSiteInfo();
        }
        $data['cur_title'] = array('','active','','','','','');

        $this->load->view('admin/header');
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/others_setsiteinfo_success', $data);
        $this->load->view('admin/footer');
    }

    public function change_password(){
        $this->load->library('form_validation');
        $username = $this->session->userdata('username');
        $this->db->where('username',$username);
        $this->user_info = $this->db->get('user')->result_array();

        $this->form_validation->set_rules('old_password','old_password','trim|callback_password_check');
        $this->form_validation->set_rules('new_password','new_password','trim');
        $this->form_validation->set_rules('new_password_conf','new_password_conf','trim|matches[new_password]');
        $this->form_validation->set_message('matches','两次输入不一致');
        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        $data['cur_title'] = array('','','','','','','');
        if($this->form_validation->run() == false){
            $this->load->view('admin/header');
            $this->load->view('admin/menu',$data);
            $this->load->view('admin/others_change_password');
            $this->load->view('admin/footer');
        }else{
            $new_password = array(
                'password' => password_hash($this->input->post('new_password',true),PASSWORD_DEFAULT),
            );
            $this->db->where('username',$username);
            $this->db->update('user',$new_password);

            $this->load->view('admin/header');
            $this->load->view('admin/menu', $data);
            $this->load->view('admin/others_change_password_success');
            $this->load->view('admin/footer');
        }
    }

    public function password_check($str){
        $password = isset($this->user_info[0]['password'])?$this->user_info[0]['password']:0;
        if(!password_verify($str,$password)){
            $this->form_validation->set_message('password_check','原密码错误');
            return false;
        }
        return true;
    }
}