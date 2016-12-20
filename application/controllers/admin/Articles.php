<?php
/**
 * Created by PhpStorm.
 * User: pnpeng
 * Date: 2016/12/19
 * Time: 11:27
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Articles extends CI_Controller{
    const PER_PAGE = 5;
    const NUM_LINKS = 3;
    const LAST_LINK = '末页';
    const FIRST_LINK = '首页';

    public function __construct(){
        parent::__construct();
        $this->load->model('articles_model');
        $this->load->model('category_model');
    }

    public function index(){
        //加载分页类库
        $this->load->library('pagination');
        //获取分页类配置
        $config = $this->getPaginationConfig();
        $this->pagination->initialize($config);

        //uri中分段函数，从控制器开始数，起始数字是1
        $row = $this->uri->segment(4,0);//第二个参数表示所请求的段不存在时的返回值，返回数字0
        $data['data'] = $this->articles_model->getArticlesDuring($row,self::PER_PAGE);
        $data['all_category'] = $this->category_model->getAllCategory();
        $data['cur_title'] = array('','','active','','','','');

        $this->load->view('admin/header');
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/articles_index', $data);
        $this->load->view('admin/footer');

    }

    public function edit($id=0){
        $data['cur_title'] = array('','','active','','','','');
        $data['all_category'] =  $this->category_model->getAllCategory();
        if($id != 0){
            $data['article'] = $this->articles_model->getArticle($id);
        }

        $this->load->view('admin/header');
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/articles_edit', $data);
        $this->load->view('admin/footer');

    }
    private function getPaginationConfig(){
        $config['base_url'] = site_url('admin/Articles/index');
        $config['total_rows'] = $this->db->count_all('articles');
        $config['per_page'] = self::PER_PAGE;
        $config['num_links'] = self::NUM_LINKS;
        $config['last_link'] = self::LAST_LINK;
        $config['first_link'] = self::FIRST_LINK;
        $config['prev_link'] = false;
        $config['next_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li><li><a>...</a></li>';
        $config['last_tag_open'] = '<li><a>...</a></li><li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</li></a>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        return $config;
    }
}