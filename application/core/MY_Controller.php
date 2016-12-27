<?php
/**
 * Created by PhpStorm.
 * User: pnpeng
 * Date: 2016/12/27
 * Time: 15:12
 */
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->checkLogin();
    }

    private function checkLogin()
    {
        $ci =& get_instance();
        $d = trim($ci->router->directory,'/');
        $c = strtolower($ci->router->class);
        $m = $ci->router->method;

        $username = $ci->session->userdata('username');
        if ($d == 'admin' && $c != 'index' && $m != 'login') {
            if (empty($username)) {
                redirect('admin/index/login?back_url='.uri_string());
            }
        }

    }
}