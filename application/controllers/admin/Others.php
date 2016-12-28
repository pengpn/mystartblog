<?php
/**
 * Created by PhpStorm.
 * User: pnpeng
 * Date: 2016/12/16
 * Time: 11:32
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Others extends MY_Controller
{
    const PER_PAGE = 5;
    const NUM_LINKS = 3;
    const LAST_LINK = '末页';
    const FIRST_LINK = '首页';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Siteinfo_model');
        $this->load->model('articles_model');

    }

    public function show_siteinfo()
    {
        $data['data'] = $this->Siteinfo_model->getSiteInfo();

        $data['cur_title'] = array('', 'active', '', '', '', '', '');
        $this->load->view('admin/header', $data);
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/others_setinfo', $data);
        $this->load->view('admin/footer');
    }

    public function set_siteinfo()
    {
        if ($_POST['title'] != '') {
            $site_info = $this->Siteinfo_model->updateSiteInfo();
        }
        $data['cur_title'] = array('', 'active', '', '', '', '', '');

        $this->load->view('admin/header');
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/others_setsiteinfo_success', $data);
        $this->load->view('admin/footer');
    }

    public function change_password()
    {
        $this->load->library('form_validation');
        $username = $this->session->userdata('username');
        $this->db->where('username', $username);
        $this->user_info = $this->db->get('user')->result_array();

        $this->form_validation->set_rules('old_password', 'old_password', 'trim|callback_password_check');
        $this->form_validation->set_rules('new_password', 'new_password', 'trim');
        $this->form_validation->set_rules('new_password_conf', 'new_password_conf', 'trim|matches[new_password]');
        $this->form_validation->set_message('matches', '两次输入不一致');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        $data['cur_title'] = array('', '', '', '', '', '', '');
        if ($this->form_validation->run() == false) {
            $this->load->view('admin/header');
            $this->load->view('admin/menu', $data);
            $this->load->view('admin/others_change_password');
            $this->load->view('admin/footer');
        } else {
            $new_password = array(
                'password' => password_hash($this->input->post('new_password', true), PASSWORD_DEFAULT),
            );
            $this->db->where('username', $username);
            $this->db->update('user', $new_password);

            $this->load->view('admin/header');
            $this->load->view('admin/menu', $data);
            $this->load->view('admin/others_change_password_success');
            $this->load->view('admin/footer');
        }
    }

    public function password_check($str)
    {
        $password = isset($this->user_info[0]['password']) ? $this->user_info[0]['password'] : 0;
        if (!password_verify($str, $password)) {
            $this->form_validation->set_message('password_check', '原密码错误');
            return false;
        }
        return true;
    }

    public function back_up()
    {
        $this->load->library('pagination');
        $config = $this->getPaginationConfig();
        $this->pagination->initialize($config);

        //uri中分段函数，从控制器开始数，起始数字是1
        $row = $this->uri->segment(4, 0);//第二个参数表示所请求的段不存在时的返回值，返回数字0

        $data['path'] = dirname(dirname(dirname(dirname(__FILE__)))).'\\article\\';
        $data['cur_title'] = array('','','','','','active','');
        $this->load->view('admin/header');
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/others_backup', $data);
        $this->load->view('admin/footer');
    }

    public function backup()
    {
        $data = $this->articles_model->getAllArticles();
        $path = $this->input->post('backup_path', TRUE);
        foreach ($data as $key => $value) {
            $str = 'title:'.$value['title']."\r\ncategory:".$value['category']."\r\ntag:".$value['tag']."\r\npublished_at:".$value['published_at']."\r\n\r\n============================\r\n\r\n".$value['content'];
            $file = $path.$value['title'].'.txt';
            $file=iconv("utf-8","gb2312",$file);
            $fp = fopen($file, 'w');
            if ($fp) {
                fwrite($fp, $str);
                fclose($fp);
            }
            $data['cur_title'] = array('','','','','','active','');
            $this->load->view('admin/header');
            $this->load->view('admin/menu', $data);
            $this->load->view('admin/others_backup_success');
            $this->load->view('admin/footer');
        }
    }

    public function about()
    {
        $this->load->model('about_model');
        $data['data'] = $this->about_model->getAboutInfo();

        $data['cur_title'] = array('','','','','','active','');
        $this->load->view('admin/header',$data);
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/others_about', $data);
        $this->load->view('admin/footer');
    }

    public function edit_about()
    {
        $this->load->model('about_model');
        $data['data']= $this->about_model->updateAboutInfo();

        $data['cur_title'] = array('','','','','','active','');
        $this->load->view('admin/header',$data);
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/others_about_success', $data);
        $this->load->view('admin/footer');
    }

    public function feedback()
    {

        $data['cur_title'] = array('','','','','','','active');
        $this->load->view('admin/header');
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/others_feedback');
        $this->load->view('admin/footer');
    }

    private function getPaginationConfig()
    {

        $config['base_url'] = site_url('Others/output');
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