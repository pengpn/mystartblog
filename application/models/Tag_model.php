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
        $sql="select b.tag_name from article_tag as a join tag as b where a.tag_id = b.id and a.article_id = {$id}";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function getTagByTagid($tag_id)
    {
        $query = $this->db->get_where('tag',array('id'=>$tag_id));
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
        $this->db->insert('tag',array('tag_name'=>$tag_name,'tag_button_type'=>$tag_type));
    }

    public function delTag($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('tag');
    }

    public function getTagDuring($offset,$perpage)
    {
        $sql = "SELECT * FROM tag ORDER BY id DESC LIMIT $offset,$perpage";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

}