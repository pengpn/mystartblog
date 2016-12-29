<?php
/**
 * Created by PhpStorm.
 * User: pnpeng
 * Date: 2016/12/28
 * Time: 14:24
 */
class Test extends CI_Controller
{
    public function get_code()
    {
        $this->load->library('mycaptcha');
        $code = $this->mycaptcha->getCaptcha();
//        var_dump($code);
        $this->mycaptcha->showImg();
    }
}