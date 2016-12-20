<?php
/**
 * Created by PhpStorm.
 * User: pnpeng
 * Date: 2016/12/20
 * Time: 17:04
 */
class Articles_model extends CI_Model{
    public function getArticlesDuring($offset,$perpage){
        $sql = "select * from articles order by published_at desc limit $offset,$perpage";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function getArticle($id){
        $query = $this->db->get_where('articles',array('id'=>$id));
        $data = $query->result_array();
        return $data;
    }
}