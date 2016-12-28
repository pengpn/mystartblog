<?php
/**
 * Created by PhpStorm.
 * 站点about页面信息设置
 * User: pnpeng
 * Date: 2016/12/28
 * Time: 10:31
 */
class About_model extends CI_Model
{
    public function getAboutInfo($id=1)
    {
        $query = $this->db->get_where('about',array('id' => $id));
        $data = $query->result_array();
        return $data;
    }

    public function updateAboutInfo($id=1)
    {
        $data = array(
            'title' => $this->security->xss_clean($this->input->post('title')),
            'tag' => $this->input->post('tag',true),
            'content'=>$this->security->xss_clean($this->input->post('content')),
        );
        $this->db->where('id',$id);
        $this->db->update('about',$data);
    }
}