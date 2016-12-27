<?php
/**
 * Created by PhpStorm.
 * User: pnpeng
 * Date: 2016/12/27
 * Time: 14:01
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends MY_Controller
{
    const PER_PAGE = 5;
    const NUM_LINKS = 3;
    const LAST_LINK = '末页';
    const FIRST_LINK = '首页';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
    }

    public function index()
    {
        //加载分页类库
        $this->load->library('pagination');
        //获取分页类配置
        $config = $this->getPaginationConfig();
        $this->pagination->initialize($config);

        //uri中分段函数，从控制器开始数，起始数字是1
        $row = $this->uri->segment(4,0);//第二个参数表示所请求的段不存在时的返回值，返回数字0
        $data['data'] = $this->category_model->getCategoryDuring($row,self::PER_PAGE);

        $data['cur_title'] = array('','','','active','','','');
        $this->load->view('admin/header');
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/category_index', $data);
        $this->load->view('admin/footer');
    }

    public function add()
    {
        $category = $this->input->post('category',true);
        if (!empty($category)) {
            $this->category_model->addCategory($category);
        }
        redirect('admin/category/index');
    }

    public function delete($id)
    {
        $this->category_model->delCategory($id);
        redirect('admin/category/index');
    }

    private function getPaginationConfig()
    {
        $config['base_url'] = site_url('admin/Category/index');
        $config['total_rows'] = $this->db->count_all('category');
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