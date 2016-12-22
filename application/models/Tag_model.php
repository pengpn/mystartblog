<?php
/**
 * Created by PhpStorm.
 * User: pnpeng
 * Date: 2016/12/22
 * Time: 11:05
 */
class Tag_model extends CI_Model
{
    public function getTagById($id)
    {
        $query = $this->db->get_where('tag',array('id' => $id));
        $data = $query->result_array();
        return $data;
    }

    public function getAllTags()
    {
        $query = $this->db->get('tag');
        $data = $query->result_array();
        return $data;
    }

    public function addTag($tag_name,$tag_type)
    {
        $this->db->insert('tag',array('tag_name'=>$tag_name,'tag_buttom_type'=>$tag_type));
    }
}