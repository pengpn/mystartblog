<?php
/**
 * Created by PhpStorm.
 * User: pnpeng
 * Date: 2016/12/29
 * Time: 14:58
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Feed extends CI_Controller
{
    public function index()
    {
        $this->load->helper('xml');
        $this->load->helper('text');
        $this->load->model('articles_model');
        $data['articles'] =  $this->articles_model->getFeeds(5);

        $data['page_language'] = 'zh-CN'; // the language
        $data['feed_name'] = 'pengpn.cc';
        $data['encoding'] = 'utf-8';
        $data['feed_url'] = 'http://pengpn.xxxxx.cc/feed';
        $data['page_description'] = 'startblog是一个基于codeigniter 3.x开发的简洁，易用的Markdown博客系统';
        header("Content-Type: text/xml; charset=UTF-8");
        $this->load->view('feed', $data);
    }
}