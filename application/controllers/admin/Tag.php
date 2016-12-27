<?php
/**
 * Created by PhpStorm.
 * User: pnpeng
 * Date: 2016/12/27
 * Time: 16:08
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Tag extends MY_Controller
{

    const PER_PAGE = 5;
    const NUM_LINKS = 3;
    const LAST_LINK = '末页';
    const FIRST_LINK = '首页';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('tag_model');
        $this->load->model('articles_model');
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
        $data['data'] = $this->tag_model->getTagDuring($row,self::PER_PAGE);

        $data['cur_title'] = array('','','','','active','','');
        $this->load->view('admin/header');
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/tag_index', $data);
        $this->load->view('admin/footer');

    }

    public function add()
    {
        $color_array=array("primary", "success", "info", "warning", "danger");
        $tagName = $this->input->post('tag_name', TRUE);
        if (!empty($tagName)) {
            $tagType = $color_array[array_rand($color_array)];
            $this->tag_model->addTag($tagName,$tagType);
        }
        redirect('admin/tag/index');
    }

    public function delete($id)
    {
        $this->tag_model->delTag($id);
        redirect('admin/tag/index');
    }

    public function edit($tag_id)
    {
        $data['tag_info'] = $this->tag_model->getTagByTagid($tag_id);
        $data['articles_by_tag'] = $this->articles_model->getArticlesTag($tag_id);
        $data['all_category'] =  $this->category_model->getAllCategory();

        //当前标题（首页，分类，标签，关于我）
        $data['cur_title'] = array('','','','','active','','');
        $this->load->view('admin/header');
        $this->load->view('admin/menu',$data);
        $this->load->view('admin/tag_edit',$data);
        $this->load->view('admin/footer');
    }


    private function getPaginationConfig()
    {

        $config['base_url'] = site_url('admin/tag/index');
        $config['total_rows'] = $this->db->count_all('tag');
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