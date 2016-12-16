<?php
/**
 * Created by PhpStorm.
 * User: pnpeng
 * Date: 2016/12/16
 * Time: 11:34
 */
class Siteinfo_model extends CI_Model{
    public function getSiteInfo($id=1){
        $_sql = "select * from siteinfo where id = $id";
        $data = $this->db->query($_sql)->result_array();
        return $data;
    }

    public function updateSiteInfo($id=1){
        $data = array(
            'url' => $this->security->xss_clean($this->input->post('url')),
            'email'=>$this->input->post('email',TRUE),
            'title'=>$this->security->xss_clean($this->input->post('title')),
            'keywords'=>$this->security->xss_clean($this->input->post('keywords')),
            'description'=>$this->input->post('description',TRUE),
            'statistic'=>$this->input->post('statistic',TRUE),
        );

        $this->db->where('id', $id);
        $this->db->update('siteinfo', $data);
    }

}