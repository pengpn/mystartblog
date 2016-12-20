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
}