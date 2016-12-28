<?php
/**
 * Created by PhpStorm.
 * User: pnpeng
 * Date: 2016/12/28
 * Time: 10:38
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Friendship extends MY_Controller
{
    const PER_PAGE = 5;
    const NUM_LINKS = 3;
    const LAST_LINK = '末页';
    const FIRST_LINK = '首页';
    public function index()
    {
        //加载分页类库
        $this->load->library('pagination');
        //获取分页类配置
        $config = $this->getPaginationConfig();
        $this->pagination->initialize($config);

        //uri中分段函数，从控制器开始数，起始数字是1
        $row = $this->uri->segment(4,0);//第二个参数表示所请求的段不存在时的返回值，返回数字0

        $this->load->model('friendship_model');
        $data['data'] = $this->friendship_model->getFriendshipDuring($row,self::PER_PAGE);

        $data['cur_title'] = array('','','','','','active','');
        $this->load->view('admin/header');
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/friendship_index', $data);
        $this->load->view('admin/footer');
    }

    public function addpage(){
        //加载分页类库

        $data['cur_title'] = array('','','','','','active','');
        $this->load->view('admin/header');
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/friendship_add');
        $this->load->view('admin/footer');
    }

    public function editpage($id){
        //加载分页类库
        if($id != 0){
            $this->load->model('friendship_model');
            $data['data'] = $this->friendship_model->getFriendship($id);
        }
        $data['cur_title'] = array('','','','','','active','');
        $this->load->view('admin/header');
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/friendship_edit',$data);
        $this->load->view('admin/footer');
    }

    public function add(){
        $link = $this->input->post('link', TRUE);
        $linkName = $this->input->post('link_name', TRUE);
        $linkOrder = $this->input->post('link_order', TRUE);
        $this->load->model('friendship_model');
        if (!empty($link)) {
            $this->friendship_model->addFriendship($link,$linkName,$linkOrder);
        }
        redirect('admin/Friendship/index');
    }

    public function edit($id)
    {
        $link = $this->input->post('link', TRUE);
        $linkName = $this->input->post('link_name', TRUE);
        $linkOrder = $this->input->post('link_order', TRUE);
        $this->load->model('friendship_model');
        if (!empty($link)) {
            $this->friendship_model->editFriendship($link,$linkName,$linkOrder,$id);
        }
        redirect('admin/Friendship/index');
    }

    public function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('friendship');

        redirect('/admin/Friendship/index');

    }

    private function getPaginationConfig()
    {

        $config['base_url'] = site_url('admin/Friendship/index');
        $config['total_rows'] = $this->db->count_all('friendship');
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