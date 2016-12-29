<?php
/**
 * Created by PhpStorm.
 * User: pnpeng
 * Date: 2016/12/20
 * Time: 17:14
 */
class Category_model extends CI_Model{
    public function getAllCategory(){
        $query = $this->db->order_by('category_order')->get('category');
        $data_tmp = $query->result_array();
        foreach ($data_tmp as $value){
            $category_id = $value['id'];
            $data[$category_id]['id'] = $value['id'];
            $data[$category_id]['category'] = $value['category'];
            $data[$category_id]['category_order'] = $value['category_order'];
        }
        return $data;
    }

    public function getCategoryDuring($offset,$perpage)
    {
        $sql = "select * from category order by id desc limit $offset,$perpage";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function addCategory($category)
    {
        $data = array(
            'category' => $category,
        );
        $this->db->insert('category',$data);
    }

    public function delCategory($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('category');
    }

    public function getAllArticles($category_id)
    {
        $sql="select * from articles where category={$category_id}";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function getCategory($category_id){
        $sql="select * from category where id={$category_id}";
        $data =$this->db->query($sql)->result_array();
        return $data;
    }
}