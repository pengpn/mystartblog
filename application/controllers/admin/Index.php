<?php
/**
 * Created by PhpStorm.
 * User: pnpeng
 * Date: 2016/12/16
 * Time: 10:33
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller{
    private $user_info;
    public function __construct() {
        parent::__construct ();
        $this->load->model('User_model');
        $this->load->helper(array('form', 'url'));
    }

    public function index(){
        $data['cur_title'] = array('active','','','','','','');
        $this->load->view('admin/header');
        $this->load->view('admin/menu',$data);
        $this->load->view('admin/index');
        $this->load->view('admin/footer');
    }

    public function login(){
        $this->load->library('form_validation');
        $username = trim($this->input->post('username'));
        $password = trim($this->input->post('password'));
        $this->user_info = $this->User_model->checkUserByUsername($username);

        $this->form_validation->set_rules('username','Username','trim|callback_username_check');
        $this->form_validation->set_rules('password','Password','trim|callback_password_check');
        if($this->form_validation->run() == false){
            $this->load->view('admin/index_login');
        }else{
            $userdata = array(
                'username' => $username,
                'password' => $password,
            );
            $this->session->set_userdata($userdata);
            redirect('admin/Index/index');
        }
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('admin/Index/login');
    }

    public function username_check($str){
        if ($str == '')
        {
            $this->form_validation->set_message('username_check', '用户名不能为空');
            return FALSE;
        }
        elseif( $this->user_info == null ){
            $this->form_validation->set_message('username_check', '用户不存在');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function password_check($str){

        $password = isset($this->user_info[0]['password'])?$this->user_info[0]['password']:0;
        if(password_verify($str,$password)){
            $this->form_validation->set_message('password_check', '密码错误');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
}