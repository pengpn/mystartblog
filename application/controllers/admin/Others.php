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
}