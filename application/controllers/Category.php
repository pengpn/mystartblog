<?php
/**
 * Created by PhpStorm.
 * User: pnpeng
 * Date: 2016/12/29
 * Time: 13:44
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends CI_Controller
{
    public function show($id)
    {
        $this->load->model('category_model');
        $data['data'] = $this->category_model->getAllArticles($id);
        $data['cur_category'] = $this->category_model->getCategory($id);
        $data['all_category'] =  $this->category_model->getAllCategory();
        //当前标题（首页，分类，标签，关于我）
        $data['cur_title'] = array('','am-active','','');

        $this->load->model('siteinfo_model');
        $data['siteinfo']= $this->siteinfo_model->getSiteInfo();

        $this->load->view('header',$data);
        $this->load->view('menu',$data);
        $this->load->view('category_show', $data);
        $this->load->view('footer');
    }
}